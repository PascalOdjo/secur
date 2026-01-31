# Système de Paiement des Agents - Documentation Complète

## Vue d'ensemble

Le nouveau système de paiement des agents repose sur une logique mathématique précise qui divise les montants en contrats réels et virtuels. Ce document explique le calcul détaillé et l'implémentation.

## Principes de base

### 1. Valeur de base d'un agent

- **1 agent = 128 unités = 105 000 CFA francs**

### 2. Minimum d'agents par demande

- **Minimum requis = 4 agents**
- Calcul du montant total: `4 × 128 = 512 unités`

### 3. Division Exploitation/Trésorerie

- Montant total divisé en 2 parts égales (50/50):
    - **256 unités en exploitation**
    - **256 unités en trésorerie**

## Logique de calcul pour l'exploitation

L'exploitation (256 unités) suit une cascade de divisions pour créer les contrats réels et virtuels:

```
256 (Exploitation)
  ↓ / 2
128
  ↓ / 2
64 (nombre de contrats abstraits)
  ↓ / 4
16
  ↓ / 16
1 (contrat de base)
  ↓ / 4
0.25 = 1 RÉEL + 3 VIRTUELS
```

### Résultat final pour 1 demande (4 agents)

- **1 contrat réel** (1/4 de 1 unité)
- **3 contrats virtuels** (1/4 chacun de 1 unité)
- **Prix par contrat** = 1 unité / 4 contrats = 0.25 unité = **205 CFA francs**

## Codes de vacation

Chaque vacation reçoit un code basé sur le format CSV de planification:

### Format du code

```
[SITE_CODE]VAC[GROUPE][SUBPAIRE][SHIFT][TYPE_PREFIX]
```

### Composantes

1. **SITE_CODE**: Code du site (ex: 0331OIF, 0333OIF)
2. **VAC**: Littéral "VAC"
3. **GROUPE**: K, L, M, N (4 groupes)
4. **SUBPAIRE**:
    - **A** = Contrat réel
    - **B, C, D** = Contrats virtuels (3)
5. **SHIFT**:
    - **P** = Jour (Poste de jour)
    - **S** = Nuit (Shift nuit)
6. **TYPE_PREFIX**:
    - **JLION** = Jour sur site LION
    - **NLIONNE** = Nuit sur site LIONNE

### Exemples de codes

- `0331OIFVACKAPJLION` = Site OIFLION, jour, groupe K, contrat réel
- `0331OIFVACKBPJLION` = Site OIFLION, jour, groupe K, contrat virtuel 1
- `0331OIFVACKCPJLION` = Site OIFLION, jour, groupe K, contrat virtuel 2
- `0331OIFVACKDPJLION` = Site OIFLION, jour, groupe K, contrat virtuel 3
- `0333OIFVACKAPNLIONNE` = Site OIFLIONNE, nuit, groupe K, contrat réel

## Vacations par agent par mois

### Structure

- **16 vacations par agent par mois**
- **1 jour = 1 vacation jour + 1 vacation nuit** (potentiellement)
- **Un agent ne peut pas travailler jour ET nuit le même jour**
- Donc: un agent fait soit 16 vacations de jour, soit 16 vacations de nuit par mois

### Organisation en groupes

Les 16 vacations sont organisées en 4 groupes:

- Groupe K: 4 vacations (1 réelle + 3 virtuelles)
- Groupe L: 4 vacations (1 réelle + 3 virtuelles)
- Groupe M: 4 vacations (1 réelle + 3 virtuelles)
- Groupe N: 4 vacations (1 réelle + 3 virtuelles)

## Implémentation dans le code

### Services utilisés

#### 1. PaymentCalculatorService

Calcule les montants et validations:

```php
// Validation du nombre d'agents
$valid = $calculator->isValidNumberOfAgents(4); // true

// Calcul complet
$payment = $calculator->calculateCompletePayment(
    nombreAgents: 4,
    montantFourni: null // optionnel
);
// Retourne: total, exploitation, trésorerie, prix par contrat, etc.

// Conversion CFA/unités
$cfa = $calculator->calculateCFAFromUnit(128); // 105,000
```

#### 2. VacationCodeGenerator

Génère les codes de vacation:

```php
// Générer un code unique
$code = $generator->generateSingleCode(
    site: $site,
    group: 'K',
    subPair: 'A',
    isNight: false
);
// Retourne: "0331OIFVACKAPJLION"

// Obtenir tous les groupes et sous-paires
$groups = $generator->getGroups(); // ['K', 'L', 'M', 'N']
$subPairs = $generator->getSubPairs(); // ['A', 'B', 'C', 'D']
```

#### 3. AgentPaymentService

Service principal pour traiter les paiements:

```php
// Traiter une demande
$result = $service->processDemande($demande);
// Met à jour les montants dans la demande

// Assigner les codes de vacation
$result = $service->assignVacationCodes($demande);
// Assigne un code unique à chaque vacation

// Obtenir le résumé
$summary = $service->getVacationSummary($demande);
// Retourne: totaux réels/virtuels, montants, etc.
```

### VacationListController

Le contrôleur mis à jour utilise les nouveaux services pour:

1. Afficher les demandes avec les calculs de paiement
2. Générer les codes de vacation automatiquement
3. Différencier les contrats réels et virtuels
4. Afficher les montants par vacation

## Migration et mise à jour

### Utiliser la commande Artisan

```bash
php artisan demande:process-payment
```

Traite toutes les demandes avec le nouveau système.

Pour traiter une demande spécifique:

```bash
php artisan demande:process-payment --demande-id=5
```

### Colonnes de la table vacations requises

- `code_vacation` - Le code généré
- `vacation_type` - 'reel' ou 'virtuel'
- `shift` - 'jour' ou 'nuit'
- `demande_id` - Référence à la demande

## Exemples de calcul

### Exemple 1: Demande avec 4 agents

```
Nombre d'agents: 4
Valeur totale: 4 × 128 = 512 unités

Split exploitation/trésorerie:
- Exploitation: 256 unités
- Trésorerie: 256 unités

Contrats réels/virtuels:
- 256 / 2 = 128
- 128 / 2 = 64
- 64 / 4 = 16
- 16 / 16 = 1 unité
- 1 / 4 = 0.25 unité par contrat = 205 CFA par contrat

En CFA:
- Montant total: 512 × 820.3125 = 420,000 CFA
- Exploitation: 256 × 820.3125 = 210,000 CFA
- Trésorerie: 256 × 820.3125 = 210,000 CFA
- Prix par contrat: 0.25 × 820.3125 = 205 CFA
```

### Exemple 2: Vacation avec code généré

```
Site: OIFLION (code: 0331OIF)
Demande: Jour, Groupe K, Contrat réel, Agent 1

Code généré: 0331OIFVACKAPJLION
- 0331OIF: Code du site
- VAC: Littéral
- KA: Groupe K, Contrat réel (A)
- P: Jour
- JLION: Préfixe pour jour
```

## Notes importantes

1. **Montant d'enregistrement**: Chaque demande doit avoir au moins 4 agents pour être valide
2. **Codification vacations**: Les codes sont générés automatiquement lors de l'accès à la liste de vacations
3. **16 vacations/mois**: Cette constante représente 8 jours de travail (jour et nuit alternés)
4. **Contrats réels vs virtuels**: Importants pour le calcul du paiement effectif des agents
5. **CFA par unité**: 105,000 CFA / 128 unités = 820.3125 CFA par unité

## Dépannage

### Si les codes ne s'affichent pas

- Vérifier que le site a un `site_code` défini
- Vérifier que le site a un `site_type` défini (LION ou LIONNE)

### Si le calcul de paiement est incorrect

- Vérifier le nombre d'agents (minimum 4)
- Vérifier que `nombre_agents` et `montant` sont définis dans la demande
- Vérifier que les montants sont en CFA francs

### Si les vacation codes ne correspondent pas au CSV

- Consulter le fichier `public/PLANIFICATION-28-DECEMBRE-2025.csv` pour le format attendu
- Vérifier les codes de site (0331OIF vs 0333OIF)
- Vérifier les suffixes (JLION vs NLIONNE)
