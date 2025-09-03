# Import Database to Railway MySQL

## Option 1: Command Line (Recommended)

If you have MySQL client installed (through XAMPP or standalone), run:

```bash
mysql -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP railway < aimpact.sql
```

### For XAMPP users:
```bash
"C:\xampp\mysql\bin\mysql.exe" -h switchback.proxy.rlwy.net -u root -pKAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl --port 48332 --protocol=TCP railway < aimpact.sql
```

## Option 2: Railway Web Console

1. Go to your Railway MySQL service dashboard
2. Click "Connect" → "MySQL Console"
3. Copy and paste the entire contents of `aimpact.sql` file
4. Execute it

## Option 3: Using MySQL Workbench or phpMyAdmin

**Connection Details:**
- Host: `switchback.proxy.rlwy.net`
- Port: `48332`
- Username: `root`
- Password: `KAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl`
- Database: `railway`

Then import the `aimpact.sql` file through the GUI.

## Option 4: Railway CLI

If you have Railway CLI:
```bash
railway connect MySQL-vdF6
# Then paste the SQL content
```

## After Import

Update your Railway environment variables:
- Variable: `MYSQL_PUBLIC_URL`
- Value: `mysql://root:KAKDbDMyJqyiPWWikRtJCLdPHzyuBsXl@switchback.proxy.rlwy.net:48332/railway`

Or use the Railway template:
- Variable: `MYSQL_PUBLIC_URL`
- Value: `${{MySQL.MYSQL_PUBLIC_URL}}`