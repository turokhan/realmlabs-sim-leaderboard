# Docker Compose — Windows, Linux, NAS or server

Requires Docker Engine + the Compose plugin (Docker Desktop on Windows). This is an alternative to XAMPP; **you do not need both**.

1. Extract the release to a folder **outside** any public web directory.
2. Copy `.env.example` to `.env` in the same folder as `compose.yaml`.
3. Set three **different, random, strong** values for `DB_PASSWORD`, `DB_ROOT_PASSWORD`, and `ADMIN_PASSWORD` in `.env`. Do not commit or share `.env`.
4. In that directory run:

```bash
docker compose up -d --build
docker compose ps
```

5. On the same machine open `http://localhost:8080/`; choose Login and use `ADMIN_USER` and `ADMIN_PASSWORD` from `.env`.
6. Test GT7 and F1 submissions, personal bests and Latest 10.

The MariaDB schema imports automatically **only on first startup with an empty database volume**. Do not remove the volume during normal upgrades or you will lose recorded laps. Back up the database before updating.

## Trusted home network

By default `HTTP_BIND=127.0.0.1`, meaning only the Docker host can reach the web service. To access from phones on the same **trusted** Wi-Fi, change `HTTP_BIND=0.0.0.0`, restart the stack, and browse to `http://HOST_LAN_IP:8080/` (firewall permitting). This is not internet-ready. Do not forward the port through your router.

## Operations

```bash
docker compose logs --tail=100 web
docker compose logs --tail=100 db
docker compose down               # containers stop; volume is preserved
docker compose up -d --build      # update/recreate containers
```

Do **not** use `docker compose down -v` unless you intentionally want to destroy the stored database. Changing DB passwords after the initial DB volume exists requires coordinated MariaDB account updates; merely editing `.env` does not change existing credentials in MariaDB.

**Security:** before internet exposure, use HTTPS behind a hardened reverse proxy with login rate limiting, host security updates and reliable off-host backups. The single-admin app has not been audited for public hosting.
