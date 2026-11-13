# Eldra atmosphere CSS

This is a first styling pass, not a replacement website. It changes the public
MyAAC tibiacom and kathrine templates only. The admin panel, game login service,
account logic, database, imagery, and existing layouts are not modified.

The Dockerfile copies `eldra-atmosphere.css` into the public templates directory
and runs `apply-atmosphere.php` at image build time. The installer adds a body
attribute and a stylesheet link after the original styles. Every CSS rule is
scoped to that body attribute. Existing image-based button and menu labels remain
unchanged; this pass does not claim to replace the game's logo or artwork.

After updating the repository, from the `docker` directory:

```sh
docker compose build myaac
docker compose up -d --no-deps myaac
```

This recreates the website container; it does not delete database volumes.
The existing quickstart remains local/LAN-only, not a production deployment.
A deployment must account for any existing container-only customizations before
rebuilding, because such modifications are not versioned in this repository.

The installer fails the build if either supported upstream template cannot be
identified, rather than silently shipping an unstyled site. Custom templates are
not automatically changed. The active template is not switched.

Review news, login, registration, recovery, character searches, rankings and
validation errors with the actual active template. Also verify keyboard focus,
readability, inline colors, third-party widgets, and narrow-screen overflow.
There has been no Docker, PHP, browser or live-server validation in this change.
Only stylesheet parsing and installer fixture checks were performed locally.
This pass does not make the original fixed-width layouts responsive.

To revert the look, remove the three Eldra COPY/RUN lines from the Dockerfile
and rebuild/recreate only myaac. The upstream templates are downloaded afresh.
Do not use `docker compose down -v` for a theme change.
