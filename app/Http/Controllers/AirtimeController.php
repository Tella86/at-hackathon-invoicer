<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;

class AirtimeController extends Controller
{
    public function send(Request $request, Client $client)
    {
        $request->validate([
            'amount' => 'required|integer|min:10|max:100', // e.g., KES 10-100
        ]);

        $AT = new AfricasTalking(env('AFRICASTALKING_USERNAME'), env('AFRICASTALKING_API_KEY'));
        $airtime = $AT->airtime();

        try {
            $response = $airtime->send([
                'recipients' => [[
                    'phoneNumber' => $client->phone,
                    'currencyCode' => 'KES',
                    'amount' => $request->input('amount')
                ]]
            ]);

            return back()->with('success', 'Airtime sent successfully to ' . $client->name);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send airtime: ' . $e->getMessage());
        }
    }
}
