# Donor Darah

Website ini dibuat menggunakan **Laravel + Vue + Vite**.

## Requirements

Make sure you have installed it:

* PHP >= 8.1
* Composer
* Node.js >= 18
* NPM
* MySQL / MariaDB
* Git

---

# How to Run a Project on your local

## 1. Clone Repository

```bash
git clone https://github.com/nama-repo/project-name.git
cd project-name
```

---

## 2. Install Dependency Backend

```bash
composer install
```

---

## 3. Install Dependency Frontend

```bash
npm install
```

---

## 4. Copy File Environment

```bash
cp .env.example .env
```

---

## 5. Generate App Key

```bash
php artisan key:generate
```

---

## 6. Setup Database

Edit file `.env`

```
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

---

## 7. Migrasi Database

```bash
php artisan migrate
```

If using a seeder:

```bash
php artisan db:seed
```

or

```bash
php artisan migrate --seed
```

---

## 8. Run Laravel Server

```bash
php artisan serve
```

The server will run on:

```
http://127.0.0.1:8000
```

---

## 9. Run Frontend (Vite)

Open a new terminal and run:

```bash
npm run dev
```

---

# Default Login Account

If using a seeder:

```
Email : admin@example.com
Password : password
```

---

# Project Structure

```
app/            -> Backend logic (Controller, Model)
routes/         -> Routing Laravel
resources/js/   -> Vue components
resources/views -> Blade template
database/       -> Migration dan Seeder
```

---

# Build Production

```bash
npm run build
```

---
