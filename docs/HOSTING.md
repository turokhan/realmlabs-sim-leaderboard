# Hosting options

Choose **one** way to run the app (not all four):

- [Windows with XAMPP](WINDOWS-XAMPP.md) — beginner walkthrough, manually tested
- [Docker Compose](DOCKER.md) — packaged Apache/PHP + MariaDB, not yet end-to-end tested
- [Linux / Raspberry Pi](LINUX.md) — manual deployment, not yet live-tested
- [Synology NAS](SYNOLOGY.md) — Container Manager or Web Station, not yet live-tested

All options run the same `app/` PHP code and `database/schema.sql`. Only the **contents** of `app/` belong under the web document root. Keep configuration and database backup files private.
