if (!Schema::hasTable('demandes')) {
    echo "Creating Demandes...\n";
    $m = require 'database/migrations/2024_09_27_013545_create_demandes_table.php';
    $m->up();
    echo "Demandes Created.\n";
} else {
    echo "Demandes Exists.\n";
}
exit();
