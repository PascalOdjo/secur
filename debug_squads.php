try {
    echo "Creating Squads...\n";
    $m = require 'database/migrations/2026_01_06_003521_create_squads_table.php';
    $m->up();
    echo "Squads Created Successfully.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "TRACE: " . $e->getTraceAsString() . "\n";
}
exit();
