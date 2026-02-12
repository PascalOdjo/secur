<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agent;
use App\Models\Demande;
use App\Models\AgentPayment;
use App\Models\Vacation;
use App\Models\Contrat;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function addForm()
    {
        return view('admin.add');
    }
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Nouvel administrateur ajouté avec succès.');
    }

    public function list()
    {
        $users = User::where('role', 'agent')->get();
        return view('admin.list', compact('users'));
    }

    public function dashboard()
    {
        $totalAgents = Agent::count();
        $totalDemandes = Demande::count();

        $totalPending = AgentPayment::where('status', 'pending')->sum('amount');
        $totalPaid = AgentPayment::where('status', 'paid')->sum('amount');
        $totalPayments = $totalPending + $totalPaid;

        $totalVacations = Vacation::count();
        $totalContrats = Contrat::count();

        // Agents with pending payments
        $agentsWithPending = Agent::with(['agentPayments' => function ($query) {
            $query->where('status', 'pending');
        }])->get()->filter(function ($agent) {
            return $agent->agentPayments->isNotEmpty();
        })->take(5);

        // Recent demands with full workflow (demand → contrats → vacations → agents)
        $recentDemandes = Demande::with(['client', 'site', 'vacations.agent1', 'vacations.agent2'])
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($demande) {
                $vacations = $demande->vacations()->count();
                $agentsAssigned = $demande->vacations()
                    ->where(function ($query) {
                        $query->whereNotNull('agent_1_id')
                            ->orWhereNotNull('agent_2_id');
                    })->count();

                return [
                    'demande' => $demande,
                    'total_vacations' => $vacations,
                    'agents_assigned' => $agentsAssigned,
                ];
            });

        return view('admin.dashboard', compact(
            'totalAgents',
            'totalDemandes',
            'totalPending',
            'totalPaid',
            'totalPayments',
            'totalVacations',
            'totalContrats',
            'agentsWithPending',
            'recentDemandes'
        ));
    }
}
