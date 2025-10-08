# Mini Billing Dashboard (Laravel Sail)

A simple administrative dashboard built with Laravel (latest) and styled using Tailwind CSS (CDN), allowing for management of Customers and Invoices.

## 🚀 Getting Started

This project is delivered using Laravel Sail (Docker), ensuring zero environment setup issues.

### Prerequisites

You only need **Docker** installed and running on your system.

### Installation & Run

**Clone the repository:**

```bash
git clone [YOUR-REPOSITORY-LINK] mini-billing-dashboard
cd mini-billing-dashboard
```

**Start Sail & Install Dependencies:**

This sequence handles environment files, starts Docker containers, runs Composer, and generates the application key.

```bash
cp .env.example .env
composer install
./vendor/bin/sail up -d
```

**Database Initialization (Migrate & Seed):**

This command wipes the default database, runs migrations (creating customers and invoices tables), and populates them with test data.

```bash
./vendor/bin/sail artisan migrate
```

> **Note:** If the command fails with "Connection refused," wait 5-10 seconds for the MariaDB container to fully start, then try again.

### Access the Application

The application will be available at:

**URL:** http://localhost/
