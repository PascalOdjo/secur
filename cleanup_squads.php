if (Schema::hasTable('squads')) {
    echo "Squads Exists. Dropping...\n";
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('squads');
    Schema::enableForeignKeyConstraints();
    echo "Squads Dropped.\n";
} else {
    echo "Squads Missing.\n";
}

if (Schema::hasColumn('agents', 'squad_id')) {
     echo "Agent Column Exists. Dropping...\n";
     Schema::table('agents', function($t) { 
        $t->dropForeign(['squad_id']); 
        $t->dropColumn('squad_id'); 
     });
     echo "Agent Column Dropped.\n";
}
exit();
