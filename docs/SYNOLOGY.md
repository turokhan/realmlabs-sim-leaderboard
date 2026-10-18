# Synology NAS installation options

**These Synology-specific instructions have not yet been live-tested with this release.**

## Option A: Container Manager (recommended)

On a supported Synology with Container Manager, set up a project using this release folder and the [Docker Compose guide](DOCKER.md). Copy `.env.example` to `.env` and choose unique passwords. Place persistent database storage on supported volumes and arrange backups. The container web process is independent of Web Station.

## Option B: Web Station + MariaDB

1. Install compatible Web Station, PHP 8.x with mysqli enabled, and MariaDB (using supported Synology packages).
2. Create `sim_racing` and import `database/schema.sql` once using phpMyAdmin or MariaDB client.
3. Create the least-privilege `leaderboard` MariaDB account; use DB host/port matching the installed MariaDB package (Synology configurations can differ).
4. Set the Web Station document root to the **contents** of `app/`, not the top-level ZIP folder.
5. Supply `DB_*` and `ADMIN_*` configuration privately through the correct Web Station/PHP runtime environment. Do not store secrets in served PHP or public configuration files.
6. Test GT7, F1, recent activity, ranking and login from a browser.

Neither option requires public internet access; use an internal URL on your home network for friends and family. Do not point a public tunnel at an unhardened instance. Maintain backups and DSM/package updates.
