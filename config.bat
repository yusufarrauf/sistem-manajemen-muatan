@ECHO OFF
ECHO Auto Config Laravel
ECHO ================
ECHO.
PAUSE
CLS
ECHO GET DATABASE NAME SETTING
ECHO ================
ECHO.
FOR /f %%i in ('FINDSTR DB_DATABASE .env') DO SET vartmp=%%i
SET database=%vartmp:~12%
CLS
ECHO DATABASE NAME IS : %database%
ECHO.
ECHO ==========================
SET PATH=%PATH%;C:\xampp\php;C:\xampp\mysql\bin
ECHO Configure Database
ECHO ==========================
ECHO.
ECHO MAKE DATABASE '%database%' TO MYSQL
mysql -uroot -e "CREATE DATABASE IF NOT EXISTS %database%;"
ECHO.
ECHO MIGRATE TABLE TO DATABASE
php artisan migrate:fresh --seed
ECHO.
ECHO Configure Database Selesai
PAUSE
