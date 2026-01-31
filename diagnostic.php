<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Check agent payments
$paymentCount = DB::table('agent_payments')->count();
echo "Total agent payments: $paymentCount\n\n";

// Check invoices
$invoices = DB::table('invoices')->select('id', 'demande_id', 'total_amount', 'agent_payment', 'agency_payment')->get();
foreach ($invoices as $invoice) {
    echo "Invoice {$invoice->id}: total={$invoice->total_amount}, agent={$invoice->agent_payment}, agency={$invoice->agency_payment}\n";
}
