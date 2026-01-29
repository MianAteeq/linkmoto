<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementAcceptance;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function index()
    {
        return Agreement::where('is_active', true)
            ->orderByRaw("FIELD(type,'NDA','TERMS','PRIVACY')")
            ->get(['id', 'type', 'version', 'content']);
    }

    public function accept(Request $request)
    {
        $request->validate([
            'types' => 'required|array'
        ]);

        $user = $request->user();

        $agreements = Agreement::whereIn('type', $request->types)
            ->where('is_active', true)
            ->get();

        foreach ($agreements as $agreement) {

            AgreementAcceptance::firstOrCreate([
                'user_id' => $user->id,
                'agreement_type' => $agreement->type,
                'agreement_version' => $agreement->version,
            ], [
                'user_full_name' => trim(
                    $user->name . ' ' .
                        ($user->middle_name ?? '') . ' ' .
                        ($user->last_name ?? '')
                ),
                'user_email' => $user->email,
                'user_role' => $user['provider_app']['group']['name'],
                'service_provider_name' => 'Motonos Provider App',
                'acceptance_method' => 'Service Provider App',
                'ip_address' => $request->ip(),
                'accepted_at' => now()->utc(),
            ]);
        }

        return response()->json([
            'status' => 'accepted',
        ]);
    }

    public function status(Request $request)
    {
        $user = $request->user();

        $accepted = AgreementAcceptance::where('user_id', $user->id)
            ->pluck('agreement_type')
            ->toArray();

        return response()->json([
            'nda' => in_array('NDA', $accepted),
            'terms' => in_array('TERMS', $accepted),
            'privacy' => in_array('PRIVACY', $accepted),
            'all_completed' => count(array_intersect(['NDA', 'TERMS', 'PRIVACY'], $accepted)) === 3
        ]);
    }
}
