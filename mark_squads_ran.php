DB::table('migrations')->insertOrIgnore([
    'migration' => '2026_01_06_003521_create_squads_table',
    'batch' => 99
]);
echo "Marked squads as ran.\n";
echo "Agents Count: " . DB::table('agents')->count() . "\n";
exit();
