# Guide Rapide - Nouveau Système de Paiement

## Les chiffres clés à mémoriser

| Concept                       | Valeur                   |
| ----------------------------- | ------------------------ |
| Valeur 1 agent                | 128 unités               |
| Valeur 1 agent en CFA         | 105 000 CFA              |
| Minimum agents/demande        | 4 agents                 |
| Montant minimum               | 512 unités = 420 000 CFA |
| Split Exploitation/Trésorerie | 50% / 50%                |
| Contrats réels par groupe     | 1                        |
| Contrats virtuels par groupe  | 3                        |
| Total contrats par groupe     | 4                        |
| Groupes de vacations          | K, L, M, N               |
| Vacations par agent/mois      | 16                       |
| Prix 1 contrat                | 205 CFA                  |

## Calcul rapide (4 agents)

```
4 agents × 128 unités = 512 unités

Split 50/50:
- Exploitation: 256 unités
- Trésorerie: 256 unités

En CFA:
- Montant total: 420 000 CFA
- Exploitation: 210 000 CFA
- Trésorerie: 210 000 CFA
- Par contrat: 205 CFA
```

## Format code vacation

**Structure:** `[SITE_CODE]VAC[GROUPE][SUBPAIRE][SHIFT][TYPE]`

**Exemple:** `0331OIFVACKAPJLION`

- `0331OIF` = Code du site (jour)
- `VAC` = Littéral
- `K` = Groupe
- `A` = Contrat réel
- `P` = Jour
- `JLION` = Type jour

**Variantes:**

- `0333OIF...SNLIONNE` = Site nuit, shift nuit
- `...KBP...` = Groupe K, contrat virtuel 1
- `...MCS...` = Groupe M, contrat virtuel 2

## Commandes utiles

### Traiter les demandes

```bash
# Tous les demandes
php artisan demande:process-payment

# Demande spécifique
php artisan demande:process-payment --demande-id=5
```

### Vérifier un calcul

Utiliser l'interface `http://votre-site/admin/payments-calculator`

### Exporter les données

`http://votre-site/admin/payments/export`

## Code PHP rapide

### Obtenir le paiement complet

```php
$service = new PaymentCalculatorService();
$payment = $service->calculateCompletePayment(
    nombreAgents: 4,
    montantFourni: null  // null = auto-calculé
);

echo $payment['total_cfa'];              // 420000
echo $payment['exploitation_cfa'];       // 210000
echo $payment['price_per_contract_cfa']; // 205
```

### Générer un code

```php
$generator = new VacationCodeGenerator();
$code = $generator->generateSingleCode(
    site: $demande->site,
    group: 'K',
    subPair: 'A',   // A=réel, B/C/D=virtual
    isNight: false
);

echo $code; // "0331OIFVACKAPJLION"
```

### Traiter une demande

```php
$service = new AgentPaymentService();

// Calculer les paiements
$result = $service->processDemande($demande);

// Assigner les codes
$codeResult = $service->assignVacationCodes($demande);

// Obtenir le résumé
$summary = $service->getVacationSummary($demande);
```

## Conversions utiles

### Unités ↔ CFA

```php
$calc = new PaymentCalculatorService();

// Unités → CFA
$cfa = $calc->calculateCFAFromUnit(128);  // 105000

// CFA → Unités
$units = $calc->calculateUnitFromCFA(105000);  // 128
```

## Validations

- ✅ Minimum 4 agents requis
- ✅ Site doit avoir un `site_code`
- ✅ Site doit avoir un `site_type` (LION ou LIONNE)
- ✅ Demande doit avoir des vacations
- ✅ Shift doit être défini (jour ou nuit)

## Colonnes BD requises

Table `vacations`:

- `code_vacation` - Code généré
- `vacation_type` - 'reel' ou 'virtuel'
- `shift` - 'jour' ou 'nuit'
- `demande_id` - Clé étrangère

Table `demandes`:

- `nombre_agents` - Nombre minimum 4
- `montant` - Montant en CFA (optionnel)
- `montant_brut` - Auto-calculé
- `montant_exploitation` - Auto-calculé
- `montant_tresorerie` - Auto-calculé
- `valeur_base` - Auto-calculé (unités)
- `prix_par_agent` - Auto-calculé

## Groupes et sous-pairs

### Groupes: K, L, M, N

```
Chaque groupe a 4 contrats:
- A = 1 réel
- B = 1 virtuel
- C = 1 virtuel
- D = 1 virtuel
```

### Organisation des 16 vacations

```
Agent A - Groupe K (4 vacations)
Agent A - Groupe L (4 vacations)
Agent A - Groupe M (4 vacations)
Agent A - Groupe N (4 vacations)
= 16 vacations total par agent
```

## Dépannage rapide

| Problème                    | Solution                              |
| --------------------------- | ------------------------------------- |
| Minimum agents non respecté | Ajouter au moins 4 agents             |
| Codes ne s'affichent pas    | Vérifier site_code et site_type       |
| Montant incorrect           | Vérifier nombre_agents                |
| Codes incorrects            | Vérifier format SITE_CODE dans la BD  |
| Shift pas reconnu           | Utiliser 'jour' ou 'nuit' (minuscule) |

## Fichiers essentiels

| Fichier                         | Purpose             |
| ------------------------------- | ------------------- |
| PaymentCalculatorService.php    | Calculs             |
| VacationCodeGenerator.php       | Génération codes    |
| AgentPaymentService.php         | Orchestration       |
| VacationListController.php      | Affichage vacations |
| AgentPaymentController.php      | Gestion paiements   |
| PAYMENT_SYSTEM_DOCUMENTATION.md | Doc complète        |

## Mise à jour rapide des vues

Pour afficher le montant exploitation:

```blade
{{ number_format($demande->montant_exploitation ?? 0, 0, ',', ' ') }} CFA
```

Pour afficher le type de contrat:

```blade
<span class="badge {{ $vacation->vacation_type === 'reel' ? 'success' : 'warning' }}">
    {{ $vacation->vacation_type === 'reel' ? 'Réel' : 'Virtuel' }}
</span>
```

Pour afficher le code:

```blade
<code>{{ $vacation->code_vacation }}</code>
```
