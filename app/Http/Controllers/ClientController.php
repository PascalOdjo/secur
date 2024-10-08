<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\site;

class ClientController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->get('search'); // Récupérer la valeur de la recherche

        // Rechercher les clients selon le nom, prénom, etc.
        $clients = Client::when($search, function ($query) use ($search) {
            $query->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('prenom', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('telephone', 'like', '%' . $search . '%')
                  ->orWhere('adresse', 'like', '%' . $search . '%')
                  ->orWhere('entreprise', 'like', '%' . $search . '%');
        })->get();

        // Vérifiez si des clients ont été trouvés
        if ($clients->isEmpty()) {
            return view('admin.clients.index', compact('clients'))->with('message', 'Aucun résultat trouvé pour cette recherche.');
        }

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'adresse' => 'required',
            'entreprise' => 'required',
            'passport_photo' => 'nullable|image|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Enregistrer le site
        try{
            $site = Site::create([
                'name' =>$request->entreprise,
                'address' =>$request->adresse,
            ]);
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du Site :' .$e->getMessage());
        }

        $client = new Client();
        $client->nom = $request->nom;
        $client->prenom = $request->prenom;
        $client->email = $request->email;
        $client->telephone = $request->telephone;
        $client->adresse = $request->adresse;
        $client->entreprise = $request->entreprise;
        $client->site_id = $site->id;

        // gestion du telechrgement de l'image
        if($request->hasFile('passport_photo')){
            $path = $request->file('passport_photo')->store('public/documents');
            $client->passport_photo = $path;  // enregistrement dans la base de donnée
        }
        $client->save();
        return redirect()->route('admin.clients.index')->with('succes', ' !');
    }

    public function edit($id)
    {
        $clients = Client::findOrFail($id);
        return view('admin.clients.edit', compact('clients'));
    }

    public function update(Request $request, $id)
    {
        $clients = Client::findOrFail($id);
        $clients->nom = $request->nom;
        $clients->prenom = $request->prenom;
        $clients->email = $request->email;
        $clients->telephone = $request->telephone;
        $clients->adresse = $request->adresse;
        $clients->entreprise = $request->entreprise;
        if($request->hasFile('passport_photo')){
            $path = $request->file('passport_photo')->store('public/documents');
            $clients->passport_photo = $path;  // enregistrement dans la base de donnée
        }
        $clients->save();
        return redirect()->route('admin.clients.index')->with('success', 'Informations modifiées avec succès !');
    }
    public function show($id){
        $clients = Client::findOrFail($id);
        return view('admin.clients.show', compact('clients'));
    }

    public function destroy($id)
    {
        $clients = Client::findOrFail($id);
        $clients->delete();
        return redirect()->route('admin.clients.index');
    }
}
