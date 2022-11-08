@ECHO OFF
ECHO UBAH DATABASE
ECHO ================
ECHO.
SET /p newdb=Masukan Nama Database Baru : 
ECHO.
FOR /f %%i in ('FINDSTR DB_DATABASE .env') DO SET vartmp=%%i
SET olddb=%vartmp:~12%
ECHO Mengganti Database %olddb% ke %newdb%
powershell -Command "(gc .env) -replace '%olddb%', '%newdb%' | Out-File -encoding ASCII .env"
ECHO.
SET PATH=%PATH%;C:\xampp\php;C:\xampp\mysql\bin
ECHO Configure Database
ECHO ==========================
mysql -uroot -e "CREATE DATABASE IF NOT EXISTS %newdb%;"
ECHO.
ECHO MIGRATE TABLE TO DATABASE
php artisan migrate:fresh --seed
ECHO.
ECHO Configure Database Selesai
PAUSE
