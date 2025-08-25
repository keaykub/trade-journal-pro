# Trade Journal Platform

A web application for logging and analyzing trades.  
Built with **Laravel, Livewire, Tailwind CSS, MySQL**, and **Stripe Integration**.

## Features
- Trade logging with entry/exit, fees, tags, and notes
- Image upload with per-image notes
- P/L calculation and performance analytics
- Stripe subscription (Hosted Checkout)

## Tech Stack
Laravel, Livewire, Tailwind CSS, MySQL, Stripe

## Screenshots
![Dashboard-1](docs/dashboard-1.png)
![Dashboard-2](docs/dashboard-2.png)
![Dashboard-3](docs/dashboard-3.png)
![Homepage-1](docs/home-1.png)
![Homepage-2](docs/home-2.png)

## Quick Start
```bash
git clone https://github.com/keaykub/trade-journal-pro.git
cd trade-journal-pro
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
