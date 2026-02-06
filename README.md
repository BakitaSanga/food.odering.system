# Myrah Food Ordering System (FOS)

A robust, secure, and modern food ordering system compliant with 3NF database design and built using Vanilla JavaScript (ES6+), PHP, and MySQL.

## 🚀 Features
- **Frontend**: 100% Vanilla JavaScript (jQuery removed). Fetch API for async operations.
- **Database**: 3NF Normalized Logic (Orders are linked to Users).
- **Security**: 
  - Bcrypt Password Hashing.
  - SQL Injection Prevention (Prepared Statements/Escaping).
  - Secure Admin Authentication.
- **Search & Filter**: Dynamic product search by name, category, and price.
- **Responsive**: Mobile-first design using Bootstrap 5.

## 🔑 Admin Credentials
Use these credentials to access the admin panel at `/fos/admin/login.php`:
- **Username**: `myrah@admin`
- **Password**: `myrahfos@2026`

## 🛠️ Setup Instructions
1. **Database Setup**:
   - Create a database named `fos_db` in MySQL/phpMyAdmin.
   - Import `database/fos_db.sql` into the database.
2. **Configuration**:
   - Navigate to `admin/db_connect.php`.
   - Update the database credentials (`host`, `user`, `password`, `dbname`) if necessary.
   - For InfinityFree/Production, ensure these match your hosting provider's details.
3. **Run**:
   - Serve the project via XAMPP/Apache.
   - Access `http://localhost/fos/` for the customer view.
   - Access `http://localhost/fos/admin/` for the admin panel.

## 📂 Project Structure
- `/admin`: Backend logic, admin panel files, and API handlers (`ajax.php`, `admin_class.php`).
- `/api`: Public API endpoints (`products.php`, `settings.php`, `categories.php`).
- `/assets`: Images and static resources.
- `/database`: SQL dump file.
- `index.html`: Main landing page (Single Page Application feel).
