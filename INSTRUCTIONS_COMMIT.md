# Instructions pour commiter la documentation sur les deux branches

## Problème actuel
Un fichier `.git/index.lock` bloque les opérations Git. Ce fichier doit être supprimé manuellement.

## Solution

### Étape 1 : Supprimer le fichier de verrouillage

**Option A - Via PowerShell (en tant qu'administrateur) :**
```powershell
cd C:\laragon\www\secur
Remove-Item -Force .git\index.lock
```

**Option B - Via l'Explorateur Windows :**
1. Ouvrir l'Explorateur Windows
2. Aller dans `C:\laragon\www\secur\.git\`
3. Supprimer le fichier `index.lock` (il peut être caché, activer l'affichage des fichiers cachés)

**Option C - Via CMD (en tant qu'administrateur) :**
```cmd
cd C:\laragon\www\secur
del .git\index.lock
```

### Étape 2 : Vérifier que le fichier LOGIQUE_PAIEMENT_AGENTS.md existe

Le fichier `LOGIQUE_PAIEMENT_AGENTS.md` doit être présent dans le répertoire racine du projet.

### Étape 3 : Commiter sur la branche master

```powershell
cd C:\laragon\www\secur
git checkout master
git add LOGIQUE_PAIEMENT_AGENTS.md
git commit -m "docs: Ajout documentation complète de la logique de paiement des agents"
```

### Étape 4 : Commiter sur la branche version_1

```powershell
git checkout version_1
git add LOGIQUE_PAIEMENT_AGENTS.md
git commit -m "docs: Ajout documentation complète de la logique de paiement des agents"
```

### Étape 5 : Pousser vers GitHub

```powershell
# Pousser master
git checkout master
git push origin master

# Pousser version_1
git checkout version_1
git push origin version_1
```

## Alternative : Script automatisé

Si le problème de verrouillage est résolu, vous pouvez utiliser le script `commit_docs.ps1` :

```powershell
cd C:\laragon\www\secur
powershell -ExecutionPolicy Bypass -File commit_docs.ps1
```

Puis pousser manuellement :
```powershell
git push origin master
git push origin version_1
```

## Vérification

Après les commits, vérifier que tout est correct :

```powershell
git log --oneline --all --graph | Select-Object -First 5
```

Vous devriez voir les nouveaux commits sur les deux branches.
