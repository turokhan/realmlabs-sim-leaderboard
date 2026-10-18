# Linux / Raspberry Pi (manual web-server installation)

**Not yet live-tested** as a separate manual deployment. Prefer [Docker Compose](DOCKER.md) if available.

1. Install Apache (or Nginx), PHP 8.x with `mysqli` (and PHP support in your web server), and MariaDB 10.x or compatible.
2. Create a database named `sim_racing`, import `database/schema.sql` *once* into the empty database.
3. Create a dedicated database account with `SELECT` and `INSERT` on `sim_racing.*` only. Configure host and account consistently (`localhost` socket versus `127.0.0.1` TCP are different for MariaDB authentication).
4. Copy only the **contents** of `app/` into the configured web document root. Keep SQL, documentation and credentials outside webroot.
5. Define `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `ADMIN_USER`, `ADMIN_PASSWORD` for your Apache PHP worker or PHP-FPM pool. PHP-FPM frequently uses `clear_env=yes` by default, so configure explicit `env[]` entries if needed. Do not create an accessible `.env` in webroot.
6. Restart relevant services. Browse to your server URL, log in and submit a sample GT7 and F1 lap.

A small Raspberry Pi on your home network is fine for a friends-and-family leaderboard. Use HTTPS and a proper reverse proxy plus hardening before exposing a public site. Back up MariaDB regularly; the app ZIP does not hold lap times.
