# Logique de Paiement des Agents - Documentation Complète

## Table des matières
1. [Vue d'ensemble](#vue-densemble)
2. [Principes fondamentaux](#principes-fondamentaux)
3. [Architecture du système](#architecture-du-système)
4. [Flux de traitement des paiements](#flux-de-traitement-des-paiements)
5. [Calcul des montants](#calcul-des-montants)
6. [Génération des codes de vacation](#génération-des-codes-de-vacation)
7. [Paiements journaliers](#paiements-journaliers)
8. [Structure de la base de données](#structure-de-la-base-de-données)
9. [Exemples concrets](#exemples-concrets)
10. [Commandes et processus automatisés](#commandes-et-processus-automatisés)

---

## Vue d'ensemble

Le système de paiement des agents est conçu pour gérer de manière précise et automatisée la rémunération des agents de sécurité basée sur un modèle mathématique complexe. Le système divise les montants en unités abstraites, les répartit entre exploitation et trésorerie, puis crée des contrats réels et virtuels pour chaque vacation.

### Caractéristiques principales
- **Calcul automatique** des montants basé sur le nombre d'agents
- **Répartition 50/50** entre exploitation et trésorerie
- **Génération automatique** de codes de vacation uniques
- **Paiements journaliers** calculés et enregistrés automatiquement
- **Suivi en temps réel** des paiements en attente et payés

---

## Principes fondamentaux

### 1. Valeur de base d'un agent

```
1 agent = 128 unités abstraites = 105 000 CFA francs
```

**Conversion unité → CFA :**
- 1 unité = 105 000 / 128 = **820,3125 CFA**

### 2. Minimum d'agents par demande

- **Minimum requis : 4 agents**
- Calcul du montant total : `4 × 128 = 512 unités`
- Montant total en CFA : `512 × 820,3125 = 420 000 CFA`

### 3. Division Exploitation/Trésorerie (50/50)

Le montant total est divisé en deux parts égales :

```
Montant total : 512 unités
├── Exploitation : 256 unités (50%)
└── Trésorerie : 256 unités (50%)
```

**En CFA :**
- Exploitation : `256 × 820,3125 = 210 000 CFA`
- Trésorerie : `256 × 820,3125 = 210 000 CFA`

### 4. Logique de calcul pour l'exploitation

L'exploitation (256 unités) suit une cascade de divisions pour créer les contrats réels et virtuels :

```
256 (Exploitation)
  ↓ ÷ 2
128
  ↓ ÷ 2
64 (nombre de contrats abstraits)
  ↓ ÷ 4
16
  ↓ ÷ 16
1 (contrat de base)
  ↓ ÷ 4
0,25 = 1 RÉEL + 3 VIRTUELS
```

**Résultat final pour 1 demande (4 agents) :**
- **1 contrat réel** (1/4 de 1 unité)
- **3 contrats virtuels** (1/4 chacun de 1 unité)
- **Prix par contrat** = 0,25 unité = **205,078125 CFA** ≈ **205 CFA**

### 5. Structure des vacations

- **16 vacations par agent par mois**
- **4 groupes** : K, L, M, N
- Chaque groupe contient **4 vacations** :
  - 1 vacation réelle (type A)
  - 3 vacations virtuelles (types B, C, D)

---

## Architecture du système

### Services principaux

#### 1. PaymentCalculatorService
**Rôle :** Calcule tous les montants et validations nécessaires

**Méthodes principales :**
- `isValidNumberOfAgents(int $nombreAgents)` : Valide le nombre minimum d'agents
- `calculateTotalValue(int $nombreAgents)` : Calcule la valeur totale en unités
- `splitValue(float $totalValue)` : Divise en exploitation/trésorerie (50/50)
- `calculateContractBreakdown(float $exploitationValue)` : Calcule la répartition contrats réels/virtuels
- `calculateCompletePayment(int $nombreAgents, ?float $montantFourni)` : Calcul complet avec toutes les valeurs

**Constantes importantes :**
```php
const AGENT_VALUE = 128;                    // Unités par agent
const MIN_AGENTS = 4;                       // Minimum d'agents requis
const AGENT_VALUE_IN_CFA = 105000;          // Valeur CFA par agent
const VACATIONS_PER_MONTH = 16;             // Vacations par agent par mois
```

#### 2. VacationCodeGenerator
**Rôle :** Génère les codes de vacation uniques selon le format CSV

**Format du code :**
```
[SITE_CODE]VAC[GROUPE][SUBPAIRE][SHIFT][TYPE_PREFIX]
```

**Exemple :**
```
0331OIFVACKAPJLION
├── 0331OIF : Code du site
├── VAC : Littéral
├── K : Groupe (K, L, M, N)
├── A : Sub-paire (A = réel, B/C/D = virtuel)
├── P : Shift (P = jour, S = nuit)
└── JLION : Type (JLION = jour, NLIONNE = nuit)
```

**Méthodes principales :**
- `generateSingleCode($site, string $group, string $subPair, bool $isNight)` : Génère un code unique
- `getGroups()` : Retourne ['K', 'L', 'M', 'N']
- `getSubPairs()` : Retourne ['A', 'B', 'C', 'D']
- `getContractCounts()` : Retourne ['real' => 1, 'virtual' => 3, 'total' => 4]

#### 3. AgentPaymentService
**Rôle :** Service principal pour gérer les paiements et les codes de vacation

**Méthodes principales :**
- `processDemande(Demande $demande)` : Traite une demande complète
- `assignVacationCodes(Demande $demande)` : Assigne les codes aux vacations
- `generatePaymentsForDemande(Demande $demande)` : Génère les paiements journaliers
- `getPaymentBreakdown(Demande $demande)` : Retourne le détail des calculs
- `getVacationSummary(Demande $demande)` : Retourne le résumé des vacations

---

## Flux de traitement des paiements

### Étape 1 : Création/Mise à jour d'une demande

Lorsqu'une demande est créée ou mise à jour avec le nombre d'agents :

```php
// Dans AgentPaymentController::processDemandPayment()
$demande->update([
    'nombre_agents' => $request->nombre_agents,
    'montant' => $request->montant ?? null,
]);
```

### Étape 2 : Calcul des montants

```php
// AgentPaymentService::processDemande()
$payment = $this->paymentCalculator->calculateCompletePayment(
    $nombreAgents, 
    $montantFourni
);
```

**Ce qui est calculé :**
- Valeur totale en unités et CFA
- Montant exploitation (50%)
- Montant trésorerie (50%)
- Prix par contrat
- Répartition contrats réels/virtuels

### Étape 3 : Mise à jour de la demande

```php
$demande->update([
    'montant_brut' => $payment['total_cfa'],
    'montant_exploitation' => $payment['exploitation_cfa'],
    'montant_tresorerie' => $payment['tresorerie_cfa'],
    'valeur_base' => $montantFourni ?? $payment['total_value'],
    'prix_par_agent' => $payment['price_per_contract_cfa'],
]);
```

### Étape 4 : Attribution des codes de vacation

```php
// AgentPaymentService::assignVacationCodes()
foreach ($vacations as $index => $vacation) {
    // Détermine le groupe (K, L, M, N) basé sur l'index
    $groupIndex = $index % 4;
    $group = $groups[$groupIndex];
    
    // Détermine si réel ou virtuel (position dans le groupe de 4)
    $positionInGroup = ($index % 4);
    $isReal = ($positionInGroup === 0);
    
    // Génère le code
    $code = $this->codeGenerator->generateSingleCode(
        $demande->site,
        $group,
        $subPair, // A, B, C, ou D
        $isNight
    );
    
    // Met à jour la vacation
    $vacation->update([
        'code_vacation' => $code,
        'vacation_type' => $isReal ? 'reel' : 'virtuel',
    ]);
}
```

### Étape 5 : Génération des paiements journaliers

```php
// AgentPaymentService::generatePaymentsForDemande()
// Pour chaque vacation de la demande
foreach ($vacations as $vacation) {
    // Récupère les agents assignés
    $agentIds = array_filter([$vacation->agent_1_id, $vacation->agent_2_id]);
    
    // Calcule le montant par vacation
    $montantPerVacation = $demande->montant_exploitation / $totalVacationsForDemande;
    
    // Calcule le paiement journalier par agent
    $daysToUse = $contractStart->diffInDays($targetEndDate) + 1;
    $dailyPaymentPerAgent = $montantPerVacation / $daysToUse / $numberOfAgents;
    
    // Crée un paiement pour chaque jour du contrat
    foreach ($agentIds as $agentId) {
        for ($date = $contractStart; $date <= $targetEndDate; $date->addDay()) {
            AgentPayment::create([
                'agent_id' => $agentId,
                'vacation_id' => $vacation->id,
                'date' => $date->toDateString(),
                'amount' => $dailyPaymentPerAgent,
                'status' => 'pending',
            ]);
        }
    }
}
```

---

## Calcul des montants

### Formule complète pour une demande

**Données d'entrée :**
- Nombre d'agents : `N` (minimum 4)
- Montant fourni (optionnel) : `M` en CFA

**Calcul si montant fourni :**
```php
$totalValue = calculateUnitFromCFA($M);
// 1 unité = 105000 / 128 = 820,3125 CFA
// Donc : $totalValue = $M / 820,3125
```

**Calcul si pas de montant fourni :**
```php
$totalValue = $N × 128;
```

**Répartition :**
```php
$exploitation = $totalValue / 2;
$tresorerie = $totalValue / 2;
```

**Conversion en CFA :**
```php
$exploitationCFA = $exploitation × 820,3125;
$tresorerieCFA = $tresorerie × 820,3125;
```

**Prix par contrat :**
```php
// Cascade de divisions
$step1 = $exploitation / 2;           // 256 / 2 = 128
$step2 = $step1 / 2;                  // 128 / 2 = 64
$step3 = $step2 / 4;                  // 64 / 4 = 16
$step4 = $step3 / 16;                 // 16 / 16 = 1
$pricePerContract = $step4 / 4;       // 1 / 4 = 0,25 unité
$pricePerContractCFA = $pricePerContract × 820,3125; // ≈ 205 CFA
```

---

## Génération des codes de vacation

### Algorithme d'attribution

1. **Détermination du groupe** : Basé sur l'index de la vacation modulo 4
   ```php
   $groupIndex = $index % 4;  // 0=K, 1=L, 2=M, 3=N
   ```

2. **Détermination du type** : Basé sur la position dans le groupe de 4
   ```php
   $positionInGroup = $index % 4;
   $isReal = ($positionInGroup === 0);  // Première = réel
   ```

3. **Détermination de la sub-paire** :
   - Position 0 → A (réel)
   - Position 1 → B (virtuel)
   - Position 2 → C (virtuel)
   - Position 3 → D (virtuel)

4. **Génération du code** :
   ```php
   $code = $siteCode . 'VAC' . $group . $subPair . $shift . $typePrefix;
   ```

### Exemples de codes générés

| Index | Groupe | Sub-paire | Type | Shift | Code exemple |
|-------|--------|-----------|------|-------|--------------|
| 0 | K | A | Réel | Jour | 0331OIFVACKAPJLION |
| 1 | L | B | Virtuel | Jour | 0331OIFVACLBPJLION |
| 2 | M | C | Virtuel | Jour | 0331OIFVACMCPJLION |
| 3 | N | D | Virtuel | Jour | 0331OIFVACNDPJLION |
| 4 | K | A | Réel | Nuit | 0331OIFVACKASNLIONNE |
| 5 | L | B | Virtuel | Nuit | 0331OIFVACLBSNLIONNE |

---

## Paiements journaliers

### Logique de calcul

Le système génère des paiements journaliers pour chaque agent assigné à une vacation, pour chaque jour de la période du contrat.

**Formule :**
```php
$montantPerVacation = $demande->montant_exploitation / $totalVacationsForDemande;
$daysToUse = $contractStart->diffInDays($targetEndDate) + 1;
$dailyPaymentPerAgent = $montantPerVacation / $daysToUse / $numberOfAgents;
```

**Exemple :**
- Montant exploitation : 210 000 CFA
- Nombre de vacations : 64 (4 agents × 16 vacations)
- Montant par vacation : 210 000 / 64 = 3 281,25 CFA
- Durée du contrat : 30 jours
- Nombre d'agents par vacation : 2
- Paiement journalier par agent : 3 281,25 / 30 / 2 = **54,69 CFA/jour**

### Processus automatisé

#### Commande : `payments:process-daily`

Cette commande s'exécute quotidiennement (via cron) pour créer les paiements des jours écoulés.

**Logique :**
1. Récupère toutes les vacations qui ont commencé
2. Pour chaque vacation :
   - Trouve la dernière date de paiement enregistrée
   - Crée les paiements manquants jusqu'à aujourd'hui (ou jusqu'à la fin du contrat)
   - Évite les doublons

**Code clé :**
```php
// Trouve la dernière date de paiement
$lastPaymentDate = AgentPayment::where('vacation_id', $vacation->id)
    ->where('agent_id', $agentId)
    ->max('date');

// Détermine la date de début
if ($lastPaymentDate) {
    $startDate = Carbon::parse($lastPaymentDate)->addDay();
} else {
    $startDate = $contractStart;
}

// Crée les paiements jusqu'à aujourd'hui ou fin du contrat
$targetEndDate = min(Carbon::now(), $contractEnd);
```

### Génération immédiate lors de la création

Lorsqu'une nouvelle demande est traitée, `generatePaymentsForDemande()` crée immédiatement tous les paiements jusqu'à aujourd'hui pour que le tableau de bord reflète immédiatement la nouvelle demande.

---

## Structure de la base de données

### Table `demandes`

**Colonnes importantes :**
- `nombre_agents` : Nombre d'agents (minimum 4)
- `montant` : Montant fourni (optionnel, en CFA)
- `montant_brut` : Montant total calculé (CFA)
- `montant_exploitation` : Part exploitation (50%, CFA)
- `montant_tresorerie` : Part trésorerie (50%, CFA)
- `valeur_base` : Valeur totale en unités abstraites
- `prix_par_agent` : Prix par contrat (CFA)
- `start_date` : Date de début du contrat
- `end_date` : Date de fin du contrat

### Table `vacations`

**Colonnes importantes :**
- `code_vacation` : Code unique généré (ex: 0331OIFVACKAPJLION)
- `vacation_type` : 'reel' ou 'virtuel'
- `shift` : 'jour' ou 'nuit'
- `agent_1_id` : Premier agent assigné
- `agent_2_id` : Deuxième agent assigné (optionnel)
- `demande_id` : Référence à la demande
- `start_time` : Heure de début
- `end_time` : Heure de fin

### Table `agent_payments`

**Colonnes importantes :**
- `agent_id` : ID de l'agent
- `vacation_id` : ID de la vacation
- `date` : Date du paiement
- `amount` : Montant en CFA
- `status` : 'pending' ou 'paid'

**Relations :**
- `agent_payments.agent_id` → `agents.id`
- `agent_payments.vacation_id` → `vacations.id`
- `vacations.demande_id` → `demandes.id`

---

## Exemples concrets

### Exemple 1 : Demande avec 4 agents

**Données d'entrée :**
- Nombre d'agents : 4
- Montant fourni : null (calcul automatique)

**Calculs :**

1. **Valeur totale :**
   ```
   4 × 128 = 512 unités
   512 × 820,3125 = 420 000 CFA
   ```

2. **Répartition :**
   ```
   Exploitation : 256 unités = 210 000 CFA
   Trésorerie : 256 unités = 210 000 CFA
   ```

3. **Prix par contrat :**
   ```
   256 / 2 = 128
   128 / 2 = 64
   64 / 4 = 16
   16 / 16 = 1
   1 / 4 = 0,25 unité = 205,078125 CFA ≈ 205 CFA
   ```

4. **Vacations :**
   - Total : 64 vacations (4 agents × 16 vacations)
   - Réelles : 16 vacations (1 par groupe de 4)
   - Virtuelles : 48 vacations (3 par groupe de 4)

5. **Paiements journaliers (exemple pour 30 jours) :**
   ```
   Montant par vacation : 210 000 / 64 = 3 281,25 CFA
   Paiement journalier par agent (2 agents) : 3 281,25 / 30 / 2 = 54,69 CFA/jour
   ```

### Exemple 2 : Demande avec montant personnalisé

**Données d'entrée :**
- Nombre d'agents : 6
- Montant fourni : 600 000 CFA

**Calculs :**

1. **Valeur totale :**
   ```
   600 000 / 820,3125 = 731,43 unités
   ```

2. **Répartition :**
   ```
   Exploitation : 365,715 unités = 300 000 CFA
   Trésorerie : 365,715 unités = 300 000 CFA
   ```

3. **Prix par contrat :**
   ```
   365,715 / 2 = 182,8575
   182,8575 / 2 = 91,42875
   91,42875 / 4 = 22,8571875
   22,8571875 / 16 = 1,42857421875
   1,42857421875 / 4 = 0,3571435546875 unité = 293,06 CFA
   ```

### Exemple 3 : Génération de codes

**Demande :**
- Site : OIFLION (code: 0331OIF)
- 4 vacations de jour

**Codes générés :**
```
Vacation 0 : 0331OIFVACKAPJLION (Groupe K, Réel, Jour)
Vacation 1 : 0331OIFVACLBPJLION (Groupe L, Virtuel B, Jour)
Vacation 2 : 0331OIFVACMCPJLION (Groupe M, Virtuel C, Jour)
Vacation 3 : 0331OIFVACNDPJLION (Groupe N, Virtuel D, Jour)
```

---

## Commandes et processus automatisés

### Commandes Artisan

#### 1. `payments:process-daily`
**Rôle :** Traite les paiements journaliers pour toutes les vacations actives

**Fréquence recommandée :** Quotidienne (via cron)

**Logique :**
- Récupère toutes les vacations qui ont commencé
- Pour chaque vacation, crée les paiements manquants jusqu'à aujourd'hui
- Met à jour les factures associées

**Utilisation :**
```bash
php artisan payments:process-daily
```

#### 2. `demande:process-payment`
**Rôle :** Traite les paiements pour toutes les demandes ou une demande spécifique

**Utilisation :**
```bash
# Toutes les demandes
php artisan demande:process-payment

# Une demande spécifique
php artisan demande:process-payment --demande-id=5
```

### Contrôleurs

#### AgentPaymentController

**Méthodes principales :**

1. **`processDemandPayment()`**
   - Traite une demande complète
   - Calcule les montants
   - Assigne les codes de vacation
   - Génère les paiements initiaux

2. **`dashboard()`**
   - Affiche le tableau de bord des paiements
   - Liste tous les agents avec leurs paiements

3. **`show($agentId)`**
   - Affiche les détails des paiements d'un agent
   - Filtre par période de contrat
   - Groupe par vacation

4. **`requestWithdrawal($agentId)`**
   - Permet à un agent de demander un retrait
   - Vérifie que tous les contrats sont terminés
   - Marque les paiements comme payés

### Flux utilisateur

#### Pour l'administrateur

1. Créer/mettre à jour une demande avec nombre d'agents
2. Le système calcule automatiquement tous les montants
3. Les codes de vacation sont générés automatiquement
4. Les paiements journaliers sont créés automatiquement
5. Visualisation dans le tableau de bord

#### Pour l'agent

1. Consulter son tableau de bord de paiements
2. Voir les paiements en attente et payés
3. Filtrer par période de contrat
4. Demander un retrait lorsque tous les contrats sont terminés

---

## Points importants à retenir

### Validations

- **Minimum 4 agents** requis par demande
- Les paiements ne sont créés que pour les jours **dans la période du contrat** (start_date à end_date)
- Les doublons sont évités grâce à une vérification avant création

### Calculs

- Tous les calculs sont basés sur des **unités abstraites** puis convertis en CFA
- La conversion est : **1 unité = 820,3125 CFA**
- Le montant d'exploitation est **distribué équitablement** entre toutes les vacations de la demande

### Paiements

- Les paiements sont créés **journalièrement** pour chaque agent
- Le montant journalier dépend de :
  - Le montant d'exploitation total
  - Le nombre de vacations
  - La durée du contrat
  - Le nombre d'agents par vacation

### Codes de vacation

- Les codes sont **uniques** et suivent un format strict
- Le type (réel/virtuel) est déterminé automatiquement
- Les codes sont générés lors du traitement de la demande

---

## Conclusion

Ce système de paiement des agents offre une solution complète et automatisée pour gérer la rémunération basée sur un modèle mathématique précis. Il garantit :

- **Précision** : Calculs mathématiques rigoureux
- **Automatisation** : Génération automatique des codes et paiements
- **Traçabilité** : Suivi détaillé de tous les paiements
- **Flexibilité** : Support de montants personnalisés
- **Sécurité** : Validation des données et prévention des doublons

Le système est conçu pour être évolutif et maintenable, avec une séparation claire des responsabilités entre les différents services.
