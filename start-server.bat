@echo off
title Nia Store - Start Server
color 0A
echo ================================================
echo   NIA STORE - STARTING SERVERS
echo ================================================
echo.
echo [1/3] Stopping existing MySQL...
taskkill /F /IM mysqld.exe >nul 2>&1
ping 127.0.0.1 -n 3 >nul
echo [2/3] Starting MySQL (Laragon)...
cd /d "C:\laragon\bin\mysql\mysql-8.0.30-winx64"
start "" /B "bin\mysqld.exe" --defaults-file="my.ini"
echo     Waiting for MySQL to initialize...
ping 127.0.0.1 -n 9 >nul
echo [3/3] Starting Laravel (http://127.0.0.1:8000)...
cd /d "D:\PROJEK DNTT\Projek-Magang-CMS-main\Projek-Magang-CMS-main"
start "Nia Store - Laravel Server" "C:\laragon\bin\php\php-8.3.0\php.exe" artisan serve
echo.
echo ================================================
echo   SEMUA SERVER BERJALAN!
echo   Web: http://127.0.0.1:8000
echo   DB:  MySQL niastore (port 3306)
echo ================================================
echo.
echo Jangan tutup window ini!
pause
