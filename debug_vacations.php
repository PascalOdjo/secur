<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$demandes = \App\Models\Demande::with('vacations')->whereHas('vacations')->limit(2)->get();

foreach ($demandes as $d) {
    echo 'Demande ' . $d->id . ': ' . $d->vacations->count() . ' vacations' . PHP_EOL;
    foreach ($d->vacations as $v) {
        echo '  - ' . $v->code_vacation . ' (' . ($v->vacation_type ?? 'null') . ')' . PHP_EOL;
    }
}
