@echo off
REM ========================================
REM Script: run_payments.bat
REM Purpose: Execute Laravel payments command
REM Executes: php artisan payments:process-daily
REM ========================================

setlocal enabledelayedexpansion

REM Set variables
set PHP_PATH=C:\laragon\bin\php\php-8.3.4-nts-Win32-vs16-x64\php.exe
set PROJECT_DIR=C:\laragon\www\secur
set LOG_FILE=%PROJECT_DIR%\storage\logs\payments_task.log

REM Navigate to project directory
cd /d "%PROJECT_DIR%"

REM Log execution start
echo. >> "%LOG_FILE%"
echo ========================================== >> "%LOG_FILE%"
echo Execution started: %date% %time% >> "%LOG_FILE%"
echo ========================================== >> "%LOG_FILE%"

REM Execute the payment command
"%PHP_PATH%" "%PROJECT_DIR%\artisan" payments:process-daily >> "%LOG_FILE%" 2>&1

REM Log execution end
echo Execution completed: %date% %time% >> "%LOG_FILE%"
echo ========================================== >> "%LOG_FILE%"

endlocal
exit /b 0
