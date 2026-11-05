if (!Schema::hasTable('contrats')) {
    echo "Creating Contrats...\n";
    require_once 'database/migrations/2024_11_04_234447_create_contrats_table.php';
    $m = new CreateContratsTable();
    $m->up();
    echo "Contrats Created.\n";
} else {
    echo "Contrats Exists.\n";
}
exit();
