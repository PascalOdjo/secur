<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\Client;
use App\Models\Site;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'adresse' => 'required',
            'telephone' => 'required',
            'entreprise' => 'required',
            'nombre_agents' => 'required',
            'description' => 'required',
        ]);
    
        $client = Client::firstOrCreate([
            'email' => $validatedData['email'],
        ], [
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'telephone' => $validatedData['telephone'],
            'entreprise' => $validatedData['entreprise'],
            'adresse' => $validatedData['adresse'],
        ]);
    
        $site = Site::firstOrCreate([
            'name' => $validatedData['entreprise'],
        ], [
            'address' => $validatedData['adresse'],
        ]);
    
        $demande = Demande::create([
            'client_id' => $client->id,
            'site_id' => $site->id,
            'nombre_agents' => $validatedData['nombre_agents'],
            'description' => $validatedData['description'],
        ]);
    
        return redirect()->back()->with('success', 'Votre Demande a été envoyée avec succès. Nous vous contacterons bientôt pour vous informer de la suite de votre demande.');
    }
}
