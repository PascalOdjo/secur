<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Invoice;

$invoice = Invoice::find(1);
if ($invoice) {
    echo "Invoice 1:\n";
    echo "  Total: " . $invoice->total_amount . "\n";
    echo "  Agent Payment: " . $invoice->agent_payment . "\n";
    echo "  Agency Payment: " . $invoice->agency_payment . "\n";
}
