<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AgentPayment;

$payments = AgentPayment::latest()->take(20)->get()->toArray();
echo json_encode($payments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
