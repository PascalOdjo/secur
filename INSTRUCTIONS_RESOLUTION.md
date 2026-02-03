# Résolution du problème Git index.lock

## Problème
Le fichier `.git/index.lock` bloque toutes les opérations Git.

## Causes possibles
1. Un processus Git a crashé sans nettoyer le fichier de verrouillage
2. Un autre processus Git est en cours d'exécution
3. Un IDE ou éditeur a verrouillé le fichier

## Solutions

### Solution 1 : Vérifier les processus Git
```powershell
Get-Process | Where-Object {$_.ProcessName -like "*git*"}
```
Si des processus apparaissent, les fermer.

### Solution 2 : Supprimer le fichier manuellement

**En PowerShell (en tant qu'administrateur) :**
```powershell
cd C:\laragon\www\secur
Stop-Process -Name "git*" -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 2
Remove-Item -Force .git\index.lock -ErrorAction SilentlyContinue
```

**En CMD (en tant qu'administrateur) :**
```cmd
cd C:\laragon\www\secur
taskkill /F /IM git.exe 2>nul
timeout /t 2 /nobreak >nul
del .git\index.lock
```

### Solution 3 : Redémarrer l'IDE/Éditeur
Si vous utilisez VS Code, Cursor ou un autre IDE, le fermer complètement puis réessayer.

### Solution 4 : Vérifier les permissions
Assurez-vous d'avoir les droits d'écriture sur le répertoire `.git`.

## Après résolution

Une fois le fichier supprimé, vous pouvez exécuter les commandes Git normalement.
