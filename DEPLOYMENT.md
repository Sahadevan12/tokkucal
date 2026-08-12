# Deploying Tokkucal to Hostinger Shared Hosting

This guide walks through deploying Tokkucal to a Hostinger shared hosting plan
with SSH access (Premium/Business plans and above). A no-SSH fallback is
noted at the end.

## 1. Prerequisites

- Hostinger shared hosting plan with **PHP 8.2 or higher** and **MySQL**
- SSH access enabled (hPanel → Advanced → SSH Access)
- A domain pointed at the hosting account
- Composer and Node.js installed on your **local machine** (not needed on the server)

## 2. Build locally

From the project root on your machine:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
composer run test
```

Confirm all tests pass before deploying. `npm run build` produces the
`public/build/` directory with hashed, production-ready CSS/JS — this is
committed to the server, so you do **not** need Node.js installed on
Hostinger itself.

## 3. Upload the project

Upload the whole project (excluding `node_modules/`, and including the
`vendor/` folder — or run `composer install --no-dev` again after upload if
you prefer not to upload `vendor/`) to a directory **outside** `public_html`,
for example:

```
/home/youruser/tokkucal/          ← Laravel app (routes/, app/, vendor/, etc.)
/home/youruser/public_html/       ← should end up pointing at tokkucal/public
```

### Set the document root to `public/`

In hPanel → **Websites → Manage → Advanced → Document Root**, set the
document root for your domain to `tokkucal/public` (i.e. the project's
`public/` folder, not the project root). This is the supported way to run a
Laravel app on Hostinger without exposing `app/`, `routes/`, `.env`, etc. to
the web.

If your plan doesn't allow changing the document root, contact Hostinger
support and ask them to point the domain at the `public/` subfolder — do not
work around this by copying `public/*` into `public_html/`, since that
exposes the rest of the Laravel app.

## 4. Create the MySQL database

In hPanel → **Databases → MySQL Databases**, create a new database and a
user with full privileges on it. Note the database name, username, password
and host (usually `localhost`).

## 5. Configure `.env`

Copy `.env.example` to `.env` on the server and fill in:

```env
APP_NAME=Tokkucal
APP_ENV=production
APP_KEY=                    # generate in step 6 — leave blank for now
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_hostinger_db_name
DB_USERNAME=your_hostinger_db_user
DB_PASSWORD=your_hostinger_db_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_FROM_ADDRESS=hello@yourdomain.com

ADSENSE_ENABLED=false        # flip to true once your AdSense account is approved
ADSENSE_CLIENT_ID=           # ca-pub-XXXXXXXXXXXXXXXX from your AdSense account
GOOGLE_ANALYTICS_ID=         # G-XXXXXXXXXX from Google Analytics
GOOGLE_SITE_VERIFICATION=    # from Google Search Console
CONTACT_EMAIL=               # where contact form messages are sent
```

**Never commit `.env` to version control.**

## 6. SSH into the server and finish setup

```bash
ssh youruser@your-server-ip
cd ~/tokkucal

# If vendor/ wasn't uploaded:
composer install --no-dev --optimize-autoloader

php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=ToolSeeder --force
php artisan storage:link

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7. File permissions

Laravel needs `storage/` and `bootstrap/cache/` to be writable by the web
server:

```bash
chmod -R 775 storage bootstrap/cache
```

## 8. Enable HTTPS

In hPanel → **Security → SSL**, enable the free SSL certificate for your
domain. Once active, `APP_URL` in `.env` should use `https://`.

## 9. Verify everything works

- Visit `https://yourdomain.com` — homepage loads, tools are listed
- Visit `https://yourdomain.com/sitemap.xml` — valid XML with all pages listed
- Visit `https://yourdomain.com/robots.txt` — references the sitemap with your real domain
- Open a couple of calculators and confirm results compute correctly
- Submit the contact form and confirm you receive the email
- Check `storage/logs/laravel.log` if anything looks wrong

## 10. Submit to Search Console and enable AdSense

1. Add your property in [Google Search Console](https://search.google.com/search-console), verify using the HTML tag method (paste the code into `GOOGLE_SITE_VERIFICATION`), then submit `https://yourdomain.com/sitemap.xml`.
2. Apply for [Google AdSense](https://www.google.com/adsense/) with your live domain. Once approved, set `ADSENSE_ENABLED=true` and `ADSENSE_CLIENT_ID` in `.env`, then run `php artisan config:cache` again.
3. Once AdSense gives you an `ads.txt` snippet, create `public/ads.txt` on the server containing exactly that line — do not invent this content yourself.

## Deploying updates later

```bash
git pull   # or re-upload changed files
composer install --no-dev --optimize-autoloader
npm run build   # locally, then upload public/build/
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## No SSH access?

If your Hostinger plan doesn't include SSH:

- Use hPanel's **File Manager** or FTP to upload files (including a
  locally-generated `vendor/` folder, since you can't run `composer install`
  on the server without a terminal).
- Generate `APP_KEY` locally (`php artisan key:generate --show`) and paste
  the value into the server's `.env` directly.
- Run migrations by temporarily adding a one-off protected route or console
  command you trigger once via URL, then removing it immediately afterward —
  or ask Hostinger support to enable SSH access, which is available on
  Premium and Business shared hosting plans.
