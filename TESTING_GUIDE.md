# Guide de Vérification et Tests - Nouveau Système de Paiement

## Checklist de validation

### Phase 1: Configuration et initialisation

- [ ] Vérifier que les fichiers services sont en place:
    - `app/Services/PaymentCalculatorService.php`
    - `app/Services/VacationCodeGenerator.php`
    - `app/Services/AgentPaymentService.php`

- [ ] Vérifier que les contrôleurs sont mises à jour:
    - `app/Http/Controllers/VacationListController.php`
    - `app/Http/Controllers/AgentPaymentController.php`

- [ ] Vérifier que la commande existe:
    - `app/Console/Commands/ProcessDemandesPayment.php`

- [ ] Vérifier la documentation:
    - `PAYMENT_SYSTEM_DOCUMENTATION.md`
    - `IMPLEMENTATION_SUMMARY.md`
    - `QUICK_REFERENCE.md`
    - `BLADE_EXAMPLES.md`

### Phase 2: Configuration des modèles

- [ ] Vérifier que la table `vacations` a les colonnes:
    - `code_vacation` (string) - Pour stocker le code généré
    - `vacation_type` (enum: 'reel', 'virtuel') - Pour distinguer les types
    - `shift` (string) - Pour jour/nuit

- [ ] Vérifier que la table `demandes` a les colonnes:
    - `nombre_agents` (integer) - Nombre d'agents
    - `montant` (decimal) - Montant en CFA
    - `montant_brut` (decimal) - Total calculé
    - `montant_exploitation` (decimal) - Exploitation calculée
    - `montant_tresorerie` (decimal) - Trésorerie calculée
    - `valeur_base` (decimal) - Unités totales
    - `prix_par_agent` (decimal) - Prix par contrat

### Phase 3: Tests unitaires

#### Test 1: Validation du nombre d'agents

```php
$calc = new PaymentCalculatorService();

// Doit être valide (4 agents)
assert($calc->isValidNumberOfAgents(4) === true);

// Doit être invalide (3 agents)
assert($calc->isValidNumberOfAgents(3) === false);

// Doit être valide (5+ agents)
assert($calc->isValidNumberOfAgents(5) === true);
```

#### Test 2: Calcul du total

```php
$calc = new PaymentCalculatorService();

// 4 agents × 128 = 512 unités
$total = $calc->calculateTotalValue(4);
assert($total === 512.0);

// 8 agents × 128 = 1024 unités
$total = $calc->calculateTotalValue(8);
assert($total === 1024.0);
```

#### Test 3: Répartition exploitation/trésorerie

```php
$calc = new PaymentCalculatorService();

$split = $calc->splitValue(512);
assert($split['exploitation'] === 256.0);
assert($split['tresorerie'] === 256.0);

// Vérifier que la somme = total
assert(($split['exploitation'] + $split['tresorerie']) === 512.0);
```

#### Test 4: Calcul des contrats

```php
$calc = new PaymentCalculatorService();

$breakdown = $calc->calculateContractBreakdown(256);

// Vérifier la cascade des divisions
assert($breakdown['step1'] === 128.0);  // 256 / 2
assert($breakdown['step2'] === 64.0);   // 128 / 2
assert($breakdown['step3'] === 16.0);   // 64 / 4
assert($breakdown['step4'] === 1.0);    // 16 / 16

// Vérifier les contrats
assert($breakdown['real_contracts'] === 1);
assert($breakdown['virtual_contracts'] === 3);
assert($breakdown['total_contracts'] === 4);

// Vérifier le prix par contrat
assert($breakdown['price_per_contract'] === 0.25);
```

#### Test 5: Conversion CFA/unités

```php
$calc = new PaymentCalculatorService();

// 128 unités = 105,000 CFA
$cfa = $calc->calculateCFAFromUnit(128);
assert($cfa === 105000.0);

// 1 agent = 105,000 CFA
$cfa = $calc->calculateCFAFromUnit(128);
assert($cfa === 105000.0);

// Conversion inverse
$units = $calc->calculateUnitFromCFA(105000);
assert($units === 128.0);
```

#### Test 6: Calcul complet

```php
$calc = new PaymentCalculatorService();

$payment = $calc->calculateCompletePayment(4, null);

// Vérifier la validité
assert($payment['valid'] === true);

// Vérifier les montants
assert($payment['nombre_agents'] === 4);
assert($payment['total_value'] === 512.0);
assert($payment['total_cfa'] === 420000.0);
assert($payment['exploitation_cfa'] === 210000.0);
assert($payment['tresorerie_cfa'] === 210000.0);

// Vérifier le prix par contrat
assert($payment['price_per_contract_cfa'] === 205.0);
```

#### Test 7: Génération des codes

```php
$gen = new VacationCodeGenerator();

// Obtenir les groupes
$groups = $gen->getGroups();
assert($groups === ['K', 'L', 'M', 'N']);

// Obtenir les sous-paires
$subPairs = $gen->getSubPairs();
assert($subPairs === ['A', 'B', 'C', 'D']);

// Obtenir les comptages
$counts = $gen->getContractCounts();
assert($counts['real'] === 1);
assert($counts['virtual'] === 3);
assert($counts['total'] === 4);

// Vérifier les contrats réels/virtuels
assert($gen->isRealContract('A') === true);
assert($gen->isRealContract('B') === false);
assert($gen->isRealContract('C') === false);
assert($gen->isRealContract('D') === false);
```

### Phase 4: Tests d'intégration

#### Test 1: Créer une demande et traiter le paiement

```php
// Créer une demande avec 4 agents
$demande = Demande::create([
    'client_id' => 1,
    'site_id' => 1,
    'nombre_agents' => 4,
    'description' => 'Test',
]);

// Traiter le paiement
$service = new AgentPaymentService();
$result = $service->processDemande($demande);

// Vérifier le résultat
assert($result['success'] === true);
assert($result['demande']->montant_brut === 420000.0);
assert($result['demande']->montant_exploitation === 210000.0);
assert($result['demande']->prix_par_agent === 205.0);
```

#### Test 2: Créer des vacations et assigner les codes

```php
// Créer 4 vacations
for ($i = 0; $i < 4; $i++) {
    Vacation::create([
        'demande_id' => $demande->id,
        'shift' => 'jour',
        'vacation_type' => null,
        'code_vacation' => null,
    ]);
}

// Assigner les codes
$service = new AgentPaymentService();
$result = $service->assignVacationCodes($demande);

// Vérifier les codes
assert($result['success'] === true);
assert($result['updated_count'] === 4);

// Vérifier que les vacations ont des codes
$vacations = $demande->vacations;
foreach ($vacations as $v) {
    assert($v->code_vacation !== null);
    assert(str_contains($v->code_vacation, 'VAC'));
}
```

#### Test 3: Afficher la liste des vacations

```php
// Appel du contrôleur
$controller = new VacationListController();
$view = $controller->index();

// Vérifier que les données sont présentes
$data = $view->getData();
assert(isset($data['vacationsList']));
assert(count($data['vacationsList']) > 0);
```

### Phase 5: Tests manuels interface

#### Test 1: Accès à la calculatrice

1. Aller à `http://votre-site/admin/payments-calculator`
2. Entrer 4 agents
3. Vérifier que le montant total = 420,000 CFA
4. Vérifier que le prix par contrat = 205 CFA
5. Entrer 8 agents
6. Vérifier que le montant total = 840,000 CFA

#### Test 2: Affichage des vacations

1. Aller à `http://votre-site/admin/vacations`
2. Vérifier que les codes de vacation s'affichent
3. Vérifier que les montants s'affichent correctement
4. Vérifier que le type (Réel/Virtuel) s'affiche

#### Test 3: Détails d'une demande

1. Cliquer sur une demande
2. Vérifier l'affichage des montants exploitation/trésorerie
3. Vérifier le séparation réelles/virtuelles
4. Vérifier les codes de vacation

### Phase 6: Tests de cas limites

#### Test 1: Demande sans agents

```php
$demande = Demande::create([
    'nombre_agents' => null,
]);

$service = new AgentPaymentService();
$result = $service->processDemande($demande);

assert($result['success'] === false);
```

#### Test 2: Demande avec trop peu d'agents

```php
$demande = Demande::create([
    'nombre_agents' => 3,
]);

$service = new AgentPaymentService();
$result = $service->processDemande($demande);

assert($result['success'] === false);
```

#### Test 3: Demande sans site

```php
$demande = Demande::create([
    'nombre_agents' => 4,
    'site_id' => null,
]);

$service = new AgentPaymentService();
$result = $service->assignVacationCodes($demande);

assert($result['success'] === false);
```

#### Test 4: Demande sans vacations

```php
$demande = Demande::create([
    'nombre_agents' => 4,
    'site_id' => 1,
]);

$service = new AgentPaymentService();
$result = $service->assignVacationCodes($demande);

assert($result['success'] === false);
```

### Phase 7: Tests de la commande Artisan

#### Test 1: Exécuter sur une demande

```bash
# Traiter la demande #1
php artisan demande:process-payment --demande-id=1
```

Vérifier que:

- La demande est mise à jour
- Les codes sont assignés
- Les montants sont corrects

#### Test 2: Exécuter sur toutes les demandes

```bash
php artisan demande:process-payment
```

Vérifier que:

- Toutes les demandes valides sont traitées
- Les demandes invalides sont signalées
- Le résumé final est correct

### Phase 8: Vérifications de performance

- [ ] Les requêtes DB utilisent eager loading (with)
- [ ] Les calculs sont rapides (<100ms)
- [ ] Pas de requête N+1
- [ ] Les exports CSV se complètent (<5s pour 1000 demandes)

### Phase 9: Vérifications de sécurité

- [ ] Les montants sont validés (min 0)
- [ ] Le nombre d'agents est validé (min 4)
- [ ] Les codes ne contiennent que des caractères alphanumériques
- [ ] Les entrées utilisateur sont échappées

### Phase 10: Checklist avant production

- [ ] Tous les tests passent
- [ ] La documentation est complète
- [ ] Les vues sont mises à jour
- [ ] Les routes sont configurées
- [ ] Les migrations sont appliquées
- [ ] Les backups BD sont faits
- [ ] Les tests de compatibilité avec anciens données sont OK
- [ ] Les performances sont acceptables

## Script de test complet

```php
// Créer un fichier test_payment_system.php dans le répertoire root

<?php

require_once 'vendor/autoload.php';

use App\Services\PaymentCalculatorService;
use App\Services\VacationCodeGenerator;

$calc = new PaymentCalculatorService();
$gen = new VacationCodeGenerator();

echo "=== Test du Système de Paiement ===\n\n";

// Test 1
echo "Test 1: Validation des agents\n";
echo "  4 agents: " . ($calc->isValidNumberOfAgents(4) ? '✓' : '✗') . "\n";
echo "  3 agents: " . (!$calc->isValidNumberOfAgents(3) ? '✓' : '✗') . "\n\n";

// Test 2
echo "Test 2: Calcul du total\n";
$total = $calc->calculateTotalValue(4);
echo "  4 × 128 = $total: " . ($total === 512.0 ? '✓' : '✗') . "\n\n";

// Test 3
echo "Test 3: Répartition\n";
$split = $calc->splitValue(512);
echo "  Exploitation = " . $split['exploitation'] . ": " . ($split['exploitation'] === 256.0 ? '✓' : '✗') . "\n";
echo "  Trésorerie = " . $split['tresorerie'] . ": " . ($split['tresorerie'] === 256.0 ? '✓' : '✗') . "\n\n";

// Test 4
echo "Test 4: Contrats\n";
$breakdown = $calc->calculateContractBreakdown(256);
echo "  Réels: " . $breakdown['real_contracts'] . ": " . ($breakdown['real_contracts'] === 1 ? '✓' : '✗') . "\n";
echo "  Virtuels: " . $breakdown['virtual_contracts'] . ": " . ($breakdown['virtual_contracts'] === 3 ? '✓' : '✗') . "\n";
echo "  Prix contrat: " . $breakdown['price_per_contract'] . " = 205 CFA: " . ($breakdown['price_per_contract'] === 0.25 ? '✓' : '✗') . "\n\n";

// Test 5
echo "Test 5: CFA\n";
$cfa = $calc->calculateCFAFromUnit(128);
echo "  128 unités = $cfa CFA: " . ($cfa === 105000.0 ? '✓' : '✗') . "\n\n";

// Test 6
echo "Test 6: Calcul complet\n";
$payment = $calc->calculateCompletePayment(4);
echo "  Valide: " . ($payment['valid'] ? '✓' : '✗') . "\n";
echo "  Total CFA: " . $payment['total_cfa'] . ": " . ($payment['total_cfa'] === 420000.0 ? '✓' : '✗') . "\n";
echo "  Prix/contrat: " . $payment['price_per_contract_cfa'] . ": " . ($payment['price_per_contract_cfa'] === 205.0 ? '✓' : '✗') . "\n\n";

// Test 7
echo "Test 7: Groupes et codes\n";
echo "  Groupes: " . implode(', ', $gen->getGroups()) . " ✓\n";
echo "  Sous-paires: " . implode(', ', $gen->getSubPairs()) . " ✓\n\n";

echo "=== Tous les tests complétés ===\n";
?>
```

Exécuter avec:

```bash
php test_payment_system.php
```

## Logs à surveiller

Pendant l'exécution, surveiller:

- `storage/logs/laravel.log` pour les erreurs
- Les montants dans la base de données
- Les codes générés dans les vacations
- Les exports CSV
