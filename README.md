Mini Billing Dashboard - Laravel Coding Challenge Submission
This is a simple administrative dashboard solution for managing customers and generating invoices, built using Laravel (latest version) and styled with Tailwind CSS.

🚀 Quick Start: Running the Application
This project is delivered using Laravel Sail, which provides a consistent, Dockerized environment. This approach eliminates local environment conflicts and ensures the application runs immediately on any system with Docker installed.

Prerequisites
You only need two things installed on your host machine:

Docker: Required to run the Sail containers.

Git: To clone the repository.

Installation & Setup (Sail)
Follow these steps to get the application running:

1. Clone the Repository
git clone [YOUR-REPOSITORY-LINK] mini-billing-dashboard
cd mini-billing-dashboard

2. Install Dependencies and Publish .env
Copy the example environment file and run Composer to install dependencies using Sail.

cp .env.example .env
./vendor/bin/sail pull
./vendor/bin/sail up -d
./vendor/bin/sail composer install

3. Generate Application Key
./vendor/bin/sail artisan key:generate

🛠 Database Configuration & Initialization
The application uses a MariaDB/MySQL database managed by Sail.

1. Configure Credentials
The application is pre-configured to use the following settings in your .env file (ensure they match the mysql service defined in docker-compose.yml):

Variable

Value

Notes

DB_CONNECTION

mysql



DB_HOST

mariadb

Crucial for Docker networking

DB_DATABASE

minibill_db

Your custom database name

DB_USERNAME

minibill_user



DB_PASSWORD

password



2. Run Migrations & Seed Data
This step creates the customers and invoices tables and populates them with dummy data for immediate testing.

Note: If you encounter a Connection refused error, wait 10 seconds for the database container to fully initialize and try again.

# Run all migrations (creates tables)
./vendor/bin/sail artisan migrate

# Optional: Seed data for testing (highly recommended)
./vendor/bin/sail artisan migrate:fresh --seed

🌐 Accessing the Application
Once the setup is complete, you can access the Mini Billing Dashboard in your web browser:

URL: http://localhost/ (or the port defined in your .env if different from 80)

Application Structure
The application features three main views, accessible via the top navigation:

Dashboard (/): Displays core statistics.

Customers (/customers): CRUD for customer management.

Invoices (/invoices): CRUD for invoice management.

