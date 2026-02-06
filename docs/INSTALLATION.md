# Installation Guide
## Food Ordering System

This guide will help you set up and run the Food Ordering System on your local machine.

### Prerequisites

Before starting, ensure you have the following installed:
- **XAMPP** (or any bundle with PHP 7.4+ and MySQL 5.7+)
- **Web Browser** (Chrome, Firefox, or Edge)

### Step-by-Step Setup

#### 1. Project Deployment
1. Download or clone the project repository.
2. Move the project folder (e.g., `fos`) to your web server's root directory:
   - For XAMPP: `C:\xampp\htdocs\fos`
   - For WAMP: `C:\wamp64\www\fos`

#### 2. Database Configuration
1. Start the **Apache** and **MySQL** modules in your XAMPP Control Panel.
2. Open your browser and navigate to `http://localhost/phpmyadmin/`.
3. Create a new database named **`fos_db`**.
4. Select the `fos_db` database and click the **Import** tab.
5. Choose the SQL file located at `database/fos_db_clean.sql` and click **Go**.

#### 3. Connection Settings
1. Open `admin/db_connect.php` in a text editor.
2. Ensure the connection credentials match your environment:
   ```php
   $conn = new mysqli('localhost', 'root', '', 'fos_db');
   ```
   *(Note: By default, XAMPP uses 'root' with no password.)*

#### 4. Accessing the System
- **Customer Site**: `http://localhost/fos/`
- **Admin Panel**: `http://localhost/fos/admin/`

### Default Login Credentials

| Role | Username | Password |
|------|----------|----------|
| **Administrator** | admin | password |
| **Customer** | (Register a new account on the signup page) | |

### Troubleshooting
- **Database Connection Error**: Verify that MySQL is running and the credentials in `db_connect.php` are correct.
- **Images Not Loading**: Ensure the `assets/img/` and `admin/assets/img/` directories exist and have the correct permissions.

---
**BAKITA SANGA**  
College of Business Education (CBE)
