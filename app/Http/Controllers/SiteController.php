<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\site;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // recuperation de tous les sites
        $sites = Site::all();
        return view('admin.sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Afficher le formulaire pour créer un nouveau site
        return view('admin.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // enregistrer le nouveau site dans la base de données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        // créer un nouveau site
        $site = new Site();
        $site->name = $validated['name'];
        $site->address = $validated['address'];

        $site->save();

        return redirect()->route('admin.sites.index')->with('success', 'Site enregistré avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $sites = Site::find($id);
        if (!$sites) {
            abort(404);
        }
        return view('admin.sites.show', compact('sites'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sites = Site::find($id);
        // Afficher le formulaire pour modifier le site
        return view('admin.sites.edit', compact('sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $sites)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
    ]);

    $sites->update($validated); // Mettre à jour le site

    return redirect()->route('admin.sites.index')->with('success', 'Site mis à jour avec succès !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Supprimer le site de la base de données
        $site = Site::find($id);
        $site->delete();
        return redirect()->route('admin.sites.index')->with('success', 'Site supprimé avec succès !');
    }
}
