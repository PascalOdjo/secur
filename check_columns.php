<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;

$columns = Schema::getColumnListing('vacations');
echo "Vacations columns:\n";
foreach ($columns as $col) {
    echo "  - $col\n";
}

if (in_array('demande_id', $columns)) {
    echo "\n✓ demande_id column exists\n";
} else {
    echo "\n✗ demande_id column missing - need to create migration\n";
}
