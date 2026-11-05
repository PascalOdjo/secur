<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Demande;

$demandes = Demande::all();
foreach ($demandes as $demande) {
    $invoice = $demande->invoice;
    if ($invoice) {
        $agentPaymentTotal = $demande->vacations()->get()->sum(function ($v) {
            return $v->agentPayments->sum('amount');
        });
        $invoice->agent_payment = $agentPaymentTotal;
        $invoice->agency_payment = max(0, $invoice->total_amount - $agentPaymentTotal);
        $invoice->save();
        echo "Updated invoice {$invoice->id} for demande {$demande->id}: agent_payment={$agentPaymentTotal}\n";
    }
}
echo "Done!\n";
