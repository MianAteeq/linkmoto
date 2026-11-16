<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\VehicleDocument;
use Modules\ClientHub\Services\DvsaMotHistoryService;
use Modules\Vender\Entities\Vehicle;
use Tests\TestCase;

class VehicleDocumentsTest extends TestCase
{
    private Client $client;
    private Vehicle $vehicle;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true, 'cache.default' => 'array']);
        DB::purge('sqlite');
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); $table->softDeletes(); $table->timestamps();
        });
        (require base_path('Modules/Vender/Database/Migrations/2022_09_19_091551_create_vehicles_table.php'))->up();
        Schema::table('vehicles', function (Blueprint $table) { $table->string('type')->nullable(); });
        (require database_path('migrations/2026_11_16_000002_create_vehicle_documents_table.php'))->up();
        Storage::fake('vehicle_documents');
        $this->client = Client::create([]);
        $this->vehicle = Vehicle::create(['vender_id' => $this->client->id, 'type' => 'Client', 'vrm' => 'TEST123']);
    }

    private function path(?int $document = null): string
    {
        return "/api/client/vehicles/{$this->vehicle->id}/documents" . ($document ? "/{$document}" : '');
    }

    private function payload(): array
    {
        return ['label' => 'Insurance certificate', 'description' => 'Policy reference ABC123',
            'expiryDate' => '2027-11-16', 'status' => 'Valid',
            'file' => UploadedFile::fake()->create('insurance.pdf', 100, 'application/pdf')];
    }

    private function upload(): VehicleDocument
    {
        Sanctum::actingAs($this->client);
        $this->postJson($this->path(), $this->payload())->assertCreated()->assertJsonPath('status', true);
        return VehicleDocument::firstOrFail();
    }

    public function test_authentication_is_required(): void
    {
        $this->getJson($this->path())->assertUnauthorized();
        $this->postJson($this->path(), $this->payload())->assertUnauthorized();
    }

    public function test_pdf_upload_persists_all_metadata_and_uses_private_storage(): void
    {
        $document = $this->upload();
        Storage::disk('vehicle_documents')->assertExists($document->path);
        $this->assertStringStartsWith("{$this->client->id}/{$this->vehicle->id}/", $document->path);
        $this->assertSame('application/pdf', $document->mime_type);
        $this->getJson($this->path())->assertOk()->assertJsonCount(1, 'documents')
            ->assertJsonPath('documents.0.label', 'Insurance certificate')
            ->assertJsonPath('documents.0.description', 'Policy reference ABC123')
            ->assertJsonPath('documents.0.expiryDate', '2027-11-16')
            ->assertJsonPath('documents.0.status', 'Valid')
            ->assertJsonMissingPath('documents.0.path')->assertJsonMissingPath('documents.0.url');
    }

    public function test_images_and_optional_metadata_are_supported(): void
    {
        Sanctum::actingAs($this->client);
        $this->postJson($this->path(), ['label' => 'Vehicle log book', 'file' => UploadedFile::fake()->image('logbook.png')])
            ->assertCreated()->assertJsonPath('document.type', 'Image')
            ->assertJsonPath('document.expiryDate', null)->assertJsonPath('document.status', null);
    }

    public function test_metadata_can_be_edited_and_cleared_without_replacing_the_file(): void
    {
        $document = $this->upload();
        $this->putJson($this->path($document->id), ['label' => 'Penalty charge notice', 'description' => '', 'expiryDate' => null, 'status' => 'Disputed'])
            ->assertOk()->assertJsonPath('document.label', 'Penalty charge notice')
            ->assertJsonPath('document.expiryDate', null)->assertJsonPath('document.status', 'Disputed');
        $this->assertSame($document->path, $document->fresh()->path);
        Storage::disk('vehicle_documents')->assertExists($document->path);
    }

    public function test_invalid_files_size_metadata_and_impossible_dates_are_rejected(): void
    {
        Sanctum::actingAs($this->client);
        foreach ([
            ['file' => UploadedFile::fake()->create('page.svg', 1, 'image/svg+xml')],
            ['file' => UploadedFile::fake()->create('script.html', 1, 'text/html')],
            ['file' => UploadedFile::fake()->create('large.pdf', 20481, 'application/pdf')],
            ['label' => ''], ['label' => str_repeat('x', 121)], ['expiryDate' => '2027-02-30'],
            ['status' => str_repeat('x', 81)], ['description' => str_repeat('x', 5001)],
        ] as $invalid) {
            $this->postJson($this->path(), array_merge($this->payload(), $invalid))->assertUnprocessable();
        }
        $this->postJson($this->path(), ['label' => 'Missing file'])->assertUnprocessable();
        $this->assertSame(0, VehicleDocument::count());
        $this->assertCount(0, Storage::disk('vehicle_documents')->allFiles());
    }

    public function test_other_clients_cannot_list_upload_edit_delete_or_get_links(): void
    {
        $document = $this->upload();
        Sanctum::actingAs(Client::create([]));
        $this->getJson($this->path())->assertNotFound();
        $this->postJson($this->path(), $this->payload())->assertNotFound();
        $this->putJson($this->path($document->id), ['label' => 'Stolen'])->assertNotFound();
        $this->deleteJson($this->path($document->id))->assertNotFound();
        $this->postJson($this->path($document->id) . '/access')->assertNotFound();
        $this->assertSame('Insurance certificate', $document->fresh()->label);
    }

    public function test_document_must_belong_to_the_vehicle_in_the_route(): void
    {
        $document = $this->upload();
        $this->vehicle = Vehicle::create(['vender_id' => $this->client->id, 'type' => 'Client']);
        $this->putJson($this->path($document->id), ['label' => 'Wrong vehicle'])->assertNotFound();
        $this->postJson($this->path($document->id) . '/access')->assertNotFound();
    }

    public function test_vendor_tokens_cannot_access_client_documents(): void
    {
        $vendor = new User(); $vendor->id = $this->client->id;
        Sanctum::actingAs($vendor);
        $this->getJson($this->path())->assertForbidden();
        $this->postJson($this->path(), $this->payload())->assertForbidden();
    }

    public function test_file_access_requires_a_valid_unexpired_signature(): void
    {
        $document = $this->upload();
        $url = $this->postJson($this->path($document->id) . '/access')->assertOk()->json('url');
        $response = $this->get($url)->assertOk()->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertStringContainsString('private', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->getJson($this->path($document->id) . '/file')->assertForbidden();
        $this->getJson($url . '&tampered=true')->assertForbidden();
        $this->travel(6)->minutes();
        $this->getJson($url)->assertForbidden();
        $this->travelBack();
    }

    public function test_deleting_a_document_removes_its_file_and_invalidates_old_links(): void
    {
        $document = $this->upload();
        $url = $this->postJson($this->path($document->id) . '/access')->json('url');
        $this->deleteJson($this->path($document->id))->assertOk();
        Storage::disk('vehicle_documents')->assertMissing($document->path);
        $this->getJson($this->path())->assertJsonCount(0, 'documents');
        $this->getJson($url)->assertNotFound();
    }

    public function test_deleting_a_vehicle_removes_its_documents_and_files(): void
    {
        $document = $this->upload();
        $this->postJson('/api/client/vehicles/delete', ['vehicle_id' => $this->vehicle->id])->assertOk();
        $this->assertSame(0, VehicleDocument::count());
        Storage::disk('vehicle_documents')->assertMissing($document->path);
    }

    public function test_vehicle_response_contains_the_saved_document_metadata(): void
    {
        (require database_path('migrations/2026_11_16_000001_add_default_vehicle_id_to_clients_table.php'))->up();
        foreach (['car_makers', 'car_models', 'engine_sizes', 'transmission_types', 'fuel_types', 'vehicle_colors'] as $name) {
            Schema::create($name, function (Blueprint $table) { $table->id(); });
        }
        $this->mock(DvsaMotHistoryService::class)->shouldReceive('computeDynamicChecksForVrm')->andReturn([]);
        $this->upload();
        $this->getJson("/api/client/vehicles/{$this->vehicle->id}")->assertOk()
            ->assertJsonPath('vehicle.documents.0.label', 'Insurance certificate')
            ->assertJsonMissingPath('vehicle.documents.0.path');
    }
}
