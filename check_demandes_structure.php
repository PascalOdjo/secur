<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Configuration de la base de données
$config = require 'config/database.php';
$mysql = $config['connections']['mysql'];

$db = new DB();
$db->addConnection([
    'driver' => 'mysql',
    'host' => $mysql['host'],
    'database' => $mysql['database'],
    'username' => $mysql['username'],
    'password' => $mysql['password'],
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);
$db->setAsGlobal();
$db->bootEloquent();

// Vérifier la structure de la table demandes
$result = DB::select("DESCRIBE demandes");

echo "=== Structure de la table 'demandes' ===\n\n";

foreach ($result as $column) {
    echo sprintf(
        "%-25s %-20s %s\n",
        $column->Field,
        $column->Type,
        $column->Null === 'YES' ? '(nullable)' : '(required)'
    );
}

echo "\n";
echo "Colonnes trouvées: " . count($result) . "\n";
