@echo off
echo.
echo ================================================================
echo              TRANSCRIPT MANAGEMENT NAVIGATION TOOL
echo ================================================================
echo.
echo Select a directory to open:
echo.
echo  1. Controllers  (app\Http\Controllers)
echo  2. Models       (app\Models)
echo  3. Views        (resources\views)
echo  4. Routes       (routes)
echo  5. Public       (public)
echo  6. Images       (public\assets\images)
echo  7. CSS          (public\assets\css)
echo  8. JS           (public\assets\js)
echo  9. Migrations   (database\migrations)
echo 10. Seeders      (database\seeders)
echo.
echo ================================================================
echo.

set /p choice="Enter number (1-10) or folder path: "

if "%choice%"=="1" explorer "%~dp0app\Http\Controllers"
if "%choice%"=="2" explorer "%~dp0app\Models"
if "%choice%"=="3" explorer "%~dp0resources\views"
if "%choice%"=="4" explorer "%~dp0routes"
if "%choice%"=="5" explorer "%~dp0public"
if "%choice%"=="6" explorer "%~dp0public\assets\images"
if "%choice%"=="7" explorer "%~dp0public\assets\css"
if "%choice%"=="8" explorer "%~dp0public\assets\js"
if "%choice%"=="9" explorer "%~dp0database\migrations"
if "%choice%"=="10" explorer "%~dp0database\seeders"

if exist "%~dp0%choice%" explorer "%~dp0%choice%"

echo.
pause
