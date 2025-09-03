@echo off
echo Importing aimpact.sql to Railway MySQL database...
echo.
echo Trying different authentication methods to fix caching_sha2_password error...
echo.

REM Try with default-auth parameter to force older authentication
echo Attempting with mysql_native_password authentication...
"C:\xampp\mysql\bin\mysql.exe" -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP --default-auth=mysql_native_password railway < aimpact.sql

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo First method failed, trying with SSL disabled...
    "C:\xampp\mysql\bin\mysql.exe" -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP --ssl-mode=DISABLED --default-auth=mysql_native_password railway < aimpact.sql
)

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo Both methods failed. Please try the Railway Web Console method instead.
    echo Go to your Railway MySQL service dashboard and use the web console.
    echo.
) else (
    echo.
    echo Import completed successfully!
)
pause