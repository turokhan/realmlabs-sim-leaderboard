# Windows / XAMPP — complete beginner workflow

**Purpose:** private/local Windows hosting, tested on Windows with XAMPP, PHP and MariaDB. No NAS needed. Internet-facing XAMPP deployments are **not** recommended.

## 1. Install and start XAMPP

1. Download the Windows installer from https://www.apachefriends.org/download.html (PHP 8.x).
2. Install to `C:\xampp` where practical.
3. Start the **Apache** and **MySQL** services in XAMPP Control Panel. Both should show running.
4. Verify `http://localhost/` opens and `http://localhost/phpmyadmin/` loads.

If installation is slow, allow several minutes for small-file extraction and antivirus checks. If Apache cannot bind port 80, check for another web server using it.

## 2. Put the PHP files in the right place

Extract the release ZIP somewhere temporary (e.g. Downloads). Create `C:\xampp\htdocs\sim-racing\`. Copy **everything inside `app/`** into this directory, *not* the whole release directory. `index.php` must be at:

```text
C:\xampp\htdocs\sim-racing\index.php
```

Keep the ZIP’s `database/`, `docs/`, `compose.yaml`, `.env.example` and Docker files **outside** `htdocs`. If `http://localhost/sim-racing/` displays “Index of /sim-racing”, you copied the parent folder instead of the contents of `app/`.

## 3. Create and import the database

1. Open `http://localhost/phpmyadmin/` and choose **New**.
2. Create database **`sim_racing`** (collation `utf8mb4_unicode_ci` is suitable).
3. Select `sim_racing`, open **Import**, select the ZIP’s `database/schema.sql` and click **Import/Go**.
4. You should see the GT7 and F1 tables and reference tracks. This must be done **only once for a new install**. It is intentionally free of private user lap data.

If importing fails, stop and check that you are importing the `schema.sql` from **v1.0.0**, not an earlier RC1 file. Do not delete a database containing laps.

## 4. Create a restricted database user

In phpMyAdmin **SQL** tab execute (substitute a long, unique password; no literal placeholder):

```sql
CREATE USER 'leaderboard'@'localhost' IDENTIFIED BY 'CHOOSE_A_LONG_DB_PASSWORD';
GRANT SELECT, INSERT ON sim_racing.* TO 'leaderboard'@'localhost';
```

The built-in PHP connection supports the same hostname (`localhost`) as this user. `root` with an empty password may work for **initial localhost diagnosis** but is **not** the recommended final configuration. If the user already exists, don't run `CREATE USER` again; use phpMyAdmin's user management to update it as needed.

## 5. Supply configuration to Apache (not to public PHP files)

XAMPP Control Panel → Apache → **Config** → `httpd.conf`. Add the following at the bottom, substituting two **different** strong passwords:

```apache
SetEnv DB_HOST localhost
SetEnv DB_NAME sim_racing
SetEnv DB_USER leaderboard
SetEnv DB_PASSWORD "CHOOSE_A_LONG_DB_PASSWORD"
SetEnv ADMIN_USER admin
SetEnv ADMIN_PASSWORD "CHOOSE_A_DIFFERENT_LONG_ADMIN_PASSWORD"
```

Save the file, then **stop and start Apache** to pick up the settings. If you changed PHP files earlier to use `root` or a hardcoded administrator password during RC testing, replace them with the clean release files before the test. `httpd.conf` contains secrets: never publish, attach or screenshot those lines with real passwords. Choose passwords avoiding quotes/backslashes if unfamiliar with Apache quoting.

## 6. Log in and record a lap

1. Open `http://localhost/sim-racing/`.
2. Select GT7 or F1 and choose a circuit.
3. Click **Login** and enter the configured `ADMIN_USER`/`ADMIN_PASSWORD`.
4. Enter a driver and lap time (`1:30.600`, for example) and submit.
5. Check the “lap saved” message and **Latest 10** entry.
6. Enter a **slower** lap for the same driver and circuit. It should appear under Latest 10 but the personal best at the top must remain unchanged.
7. Refresh to confirm entries persist.

The GT7/PS5 itself does not submit laps; players enter times manually using the browser.

## 7. Access from a phone on the same Wi-Fi (optional)

Find your Windows PC’s IPv4 address with `ipconfig`, then from a device on the same **trusted** LAN browse to `http://YOUR_PC_LAN_IP/sim-racing/`. Allow Apache on private networks in Windows Firewall if necessary. Do **not** configure router port-forwarding, expose phpMyAdmin, or use this installation as a public server.

## Troubleshooting

| What you see | Likely cause / fix |
|---|---|
| `Index of /sim-racing` | `index.php` is nested inside `app/`; copy the **contents** into `sim-racing/`. |
| `Database unavailable` | MariaDB not started; wrong DB host/user/password, or Apache was not restarted. |
| Login rejected | `ADMIN_*` environment values missing, changed, or Apache not restarted. |
| Database import SQL syntax error | Use **v1.0.0** `database/schema.sql`, not the malformed RC1 export. |
| Lap doesn't appear | Check for a success/error notice and that time fields are valid; use milliseconds `000`–`999`. |
| Apache won't start | Check port 80 and existing IIS/other server use. |

## Updating or backing up

Back up your database via phpMyAdmin **Export** and store it privately. Back up your app files and Apache config. For RC4 → v1.0.0 update, replace only files from `app/` and **do not re-import the SQL** or overwrite your local Apache configuration.
