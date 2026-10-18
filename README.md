# RealmLabs Sim Racing Leaderboard v1.0.0

A free, self-hosted lap-time leaderboard for **Gran Turismo 7** and **F1**, built with PHP 8.x and MariaDB. Friends can take turns entering lap times on a phone or computer; an admin signs in to submit results. No direct PS5 integration is required.

## Features

- Circuit-based leaderboards showing each driver’s **fastest personal best**, sorted quickest first.
- **Latest 10** submissions remain visible independently of rankings; slower laps do not overwrite personal bests.
- GT7 circuit reference list and the 2024 F1 calendar/tracks included.
- Simple single-administrator account; public read-only leaderboard.
- Database stores all attempts. No real people’s lap results are shipped.

## Choose a hosting method

| Option | Best for | Instructions |
|---|---|---|
| **Windows + XAMPP** | Beginners and local Windows PC hosting | [Windows/XAMPP step-by-step](docs/WINDOWS-XAMPP.md) |
| **Docker Compose** | Repeatable install on Windows, Linux, NAS, or a VPS | [Docker Compose guide](docs/DOCKER.md) |
| **Linux / Raspberry Pi** | Always-on small home server | [Linux / Raspberry Pi guide](docs/LINUX.md) |
| **Synology NAS** | Existing Synology owners | [Synology guide](docs/SYNOLOGY.md) |

**Test status:** Windows/XAMPP was manually tested with schema import, login and GT7 submissions, persistence and personal-best ranking. F1 submission was also reported working. The other deployment paths are provided for evaluation and have not been end-to-end tested on their respective hosts.

## Download layout

```text
app/                    PHP site; only the contents go inside the web root
database/schema.sql     Empty tables plus circuit reference data
docs/                   Hosting guides and troubleshooting
Dockerfile              Apache and PHP web image
compose.yaml            Web service plus MariaDB
.env.example            Example settings, not real passwords
LICENSE                 MIT licence for original project code
```

## Start here

**New to web hosting?** Follow [Windows/XAMPP](docs/WINDOWS-XAMPP.md). Do not extract the entire downloaded folder inside `htdocs`; copy the **contents** of `app/` to `C:\xampp\htdocs\sim-racing\`.

**Docker?** Follow [Docker Compose](docs/DOCKER.md). Clone/download this repository, copy `.env.example` to `.env`, set three different strong passwords, then run `docker compose up -d --build`.

**Existing RC2–RC4 Windows install?** Back up the web files and database, then replace only the application files with the new `app/` contents. Keep your own external Apache configuration and **do not import the schema again**. No migrations are needed between RC4 and v1.0.0.

## Safety and scope

- **Never distribute real passwords, database dumps of personal data, or Apache `httpd.conf`.** This release contains placeholders only.
- Use a restricted `leaderboard` database user; the app needs `SELECT` and `INSERT` permissions, not root.
- XAMPP is suitable for local/trusted LAN use, **not** a public internet-facing installation in its default configuration.
- A single administrator login is supplied. No self-service registration, password reset, audit log or login throttling is included. Do not expose the app on the public internet without further hardening (HTTPS, rate limiting, backups, monitoring and review).
- Real driver/track artwork, copyrighted fonts and original private records are **not** included. Game and product names are used for identification only. RealmLabs is independent of the relevant game publishers.
- Before publishing under the MIT licence, the project owner should verify they hold rights to every included source and asset.

Project home: https://realmlabs.uk/
