<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;


class ClientController extends Controller
{

     public function index() {
        $clients = Auth::user()->clients;
        return view('clients.index', compact('clients'));
    }

    public function create() { return view('clients.create'); }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'phone' => 'required']);
        Auth::user()->clients()->create($request->all());
        return redirect()->route('clients.index')->with('success', 'Client created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // app/Http/Controllers/ClientController.php
public function invite(Client $client)
{
    $client->invitation_token = Str::random(32);
    $client->invitation_expires_at = now()->addDays(7);
    $client->save();

    // Send an email/notification with the invitation link
    // Notification::send($client, new ClientInvitationNotification($client->invitation_token));

    return back()->with('success', 'Invitation sent to ' . $client->name);
}
}
