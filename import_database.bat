@echo off
echo Importing aimpact.sql to Railway MySQL database...
echo.
echo Make sure you have MySQL client installed (you can use XAMPP's MySQL)
echo.
echo Running command:
echo mysql -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP railway < aimpact.sql
echo.

REM If you have XAMPP, use this path (adjust if needed):
"C:\xampp\mysql\bin\mysql.exe" -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP railway < aimpact.sql

REM If the above doesn't work, try the system MySQL:
REM mysql -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP railway < aimpact.sql

echo.
echo Import completed!
pause