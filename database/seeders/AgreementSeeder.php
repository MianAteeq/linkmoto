<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agreement;

class AgreementSeeder extends Seeder
{
    public function run(): void
    {
        $agreements = [
            [
                'type' => 'NDA',
                'version' => '1.0',
                'content' => 'Motonos Closed Beta Non-Disclosure Agreement.

This NDA protects confidential features, data, and information you may see while using Motonos during the beta period.',
                'is_active' => true,
            ],
            [
                'type' => 'TERMS',
                'version' => '1.0',
                'content' => 'Motonos Closed Beta Terms & Conditions.

By using this service you agree to comply with all applicable rules and policies.',
                'is_active' => true,
            ],
            [
                'type' => 'PRIVACY',
                'version' => '1.0',
                'content' => 'Motonos Privacy Policy.

Personal data and customer data will be processed in accordance with the Motonos Privacy Policy.',
                'is_active' => true,
            ],
        ];

        foreach ($agreements as $agreement) {
            Agreement::updateOrCreate(
                [
                    'type' => $agreement['type'],
                    'version' => $agreement['version'],
                ],
                $agreement
            );
        }
    }
}
