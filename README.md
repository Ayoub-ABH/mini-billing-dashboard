Mini Billing Dashboard - Laravel Coding Challenge SubmissionThis is a simple administrative dashboard solution for managing customers and generating invoices, built using Laravel (latest version) and styled with Tailwind CSS (CDN).🚀 Quick Start: Running the ApplicationThis project is delivered using Laravel Sail, which provides a consistent, Dockerized environment. This approach eliminates local environment conflicts and ensures the application runs immediately on any system with Docker installed.PrerequisitesYou only need two things installed on your host machine:Docker: Required to run the Sail containers.Git: To clone the repository.Installation & Setup (Sail)Follow these steps to get the application running:1. Clone the Repositorygit clone [YOUR-REPOSITORY-LINK] mini-billing-dashboard
cd mini-billing-dashboard
2. Install Dependencies and Publish .envCopy the example environment file and run Composer to install dependencies using Sail.cp .env.example .env
./vendor/bin/sail pull
./vendor/bin/sail up -d
./vendor/bin/sail composer install
3. Generate Application Key./vendor/bin/sail artisan key:generate
🛠 Database Configuration & InitializationThe application uses a MariaDB/MySQL database managed by Sail.1. Configure CredentialsThe application is pre-configured to use the following settings in your .env file (these are tied directly to the mariadb service in docker-compose.yml):VariableValueNotesDB_CONNECTIONmysqlDB_HOSTmariadbCrucial for Docker networkingDB_DATABASEminibill_dbYour custom database nameDB_USERNAMEminibill_userDB_PASSWORDpassword2. Run Migrations & Seed DataThis step creates the customers and invoices tables and populates them with dummy data for immediate testing.Note: If you encounter a Connection refused error, the database may still be initializing. Wait 10 seconds for the database container to fully initialize and try again.# Run all migrations (creates tables)
./vendor/bin/sail artisan migrate

# Optional: Seed data for testing (creates customers and invoices)
./vendor/bin/sail artisan migrate:fresh --seed
🌐 Accessing the ApplicationOnce the setup is complete, you can access the Mini Billing Dashboard in your web browser:URL: http://localhost/ (or the port defined in your .env if different from 80)Application StructureThe application features three main views, accessible via the top navigation:Dashboard (/): Displays core statistics.Customers (/customers): CRUD for customer management.Invoices (/invoices): CRUD for invoice management.
