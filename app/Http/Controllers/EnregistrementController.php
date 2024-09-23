<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Enregistrement;

class EnregistrementController extends Controller
{
    public function index(){
        $enregistrements = Enregistrement::with('client', 'site')->get();
        return view('admin.enregistrements.index', compact('enregistrements'));
    }

    public function create(){
        $clients = Client::all();
        $sites = Site::all();
        return view('admin.enregistrements.create');
    }

    public function store(){
    $validatedData = request()->validate([
        'prenom' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:clients,email',
        'telephone' => 'required|string|max:20',
        'adresse' => 'required|string|max:255',
        'entreprise' => 'required|string|max:255',
        'photo_passport' => 'required|file|image|max:1024',
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'nombre_contrat' => 'required|integer|min:1|max:10',
        'type_vacation' => 'required|string|max:10',
        'shift' => 'required|string|max:20',
    ]);

    $client = Client::create([
        'prenom' => $validatedData['prenom'],
        'email' => $validatedData['email'],
        'telephone' => $validatedData['telephone'],
        'adresse' => $validatedData['adresse'],
        'entreprise' => $validatedData['entreprise'],
        'photo_passport' => $validatedData['photo_passport']->store('public/clients'),
    ]);

    $site = Site::create([
        'name' => $validatedData['name'],
        'address' => $validatedData['address'],
    ]);

    // Assuming there's a model for Enregistrement that has a method to create a new record
    // This is a placeholder for the actual logic to create an Enregistrement record
    Enregistrement::create([
        'client_id' => $client->id,
        'site_id' => $site->id,
        'nombre_contrat' => $validatedData['nombre_contrat'],
        'type_vacation' => $validatedData['type_vacation'],
        'shift' => $validatedData['shift'],
    ]);

    return redirect()->route('admin.enregistrements.index')->with('status', 'Enregistrement créé avec succès!');
    }
}
