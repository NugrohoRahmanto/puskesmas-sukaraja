# Puskesmas Sukaraja - Web Application

Aplikasi web untuk manajemen Puskesmas Sukaraja mencakup modul:

## Requirement

- PHP >= 8.1
- Composer
- Node.js & NPM / Yarn
- MySQL / MariaDB
- Git
- Web server (Apache / Nginx) atau Laravel Sail / Valet / Localhost

---

# Local Installation
- run `` git clone https://github.com/NugrohoRahmanto/puskesmas-sukaraja.git ``
- run `` composer install `` 
- run `` npm install ``
- run `` npm run dev ``
- copy .env.example to .env
- run `` php artisan key:generate ``
- set up your database in the .env
- run `` php artisan migrate --seed ``
- run `` php artisan storage:link ``
- run `` php artisan serve ``
- then visit `` http://localhost:8000 or http://127.0.0.1:8000 ``.

# dump user
- username : admin, pw : 12345678
- username : user1, pw : 12345678
