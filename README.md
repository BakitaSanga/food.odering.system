# Food Ordering System

A complete web-based food ordering system built with PHP, MySQL, and Vanilla JavaScript.

## Features

- **User Authentication**: Separate login for customers and administrators
- **Product Management**: Full CRUD operations for menu items
- **Shopping Cart**: Add, update, and remove items
- **Order Processing**: Complete checkout and order management
- **Admin Dashboard**: Analytics, order management, and system settings
- **Role-Based Access**: Different permissions for admin and customers
- **Responsive Design**: Works on desktop and mobile devices

## Technology Stack

- **Frontend**: HTML5, CSS3, Vanilla JavaScript (No frameworks)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache (XAMPP/LAMP/WAMP)

## Database Schema

The system uses 8 normalized tables (3NF compliant):

1. **users** - Admin user accounts
2. **user_info** - Customer accounts
3. **product_list** - Menu items
4. **category_list** - Product categories
5. **orders** - Order headers
6. **order_list** - Order line items
7. **cart** - Shopping cart items
8. **system_settings** - Application configuration

## 🛠️ Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- XAMPP/LAMP/WAMP (recommended)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/food-ordering-system.git
   cd food-ordering-system
   ```

2. **Set up the database**
   - Open phpMyAdmin
   - Create a new database named `fos_db`
   - Import `database/fos_db_clean.sql`

3. **Configure database connection**
   - Edit `admin/db_connect.php`
   - Update credentials if needed:
   ```php
   $conn = new mysqli('localhost','root','','fos_db');
   ```

4. **Start the server**
   - Place project in `htdocs` (XAMPP) or `www` (WAMP)
   - Start Apache and MySQL
   - Access: `http://localhost/fos/`

5. **Default Login Credentials**
   - **Admin**: username: `admin`, password: `password`
   - **Customer**: Register a new account

## 📁 Project Structure

```
fos/
├── admin/              # Admin panel
│   ├── assets/        # Admin CSS/JS
│   ├── ajax.php       # AJAX handler
│   ├── admin_class.php # Backend logic
│   └── *.php          # Admin pages
├── api/               # REST API endpoints
│   ├── cart.php
│   ├── products.php
│   └── settings.php
├── assets/            # Public assets
│   ├── css/
│   ├── js/
│   └── img/
├── database/          # Database files
│   └── fos_db_clean.sql
├── index.html         # Homepage
├── cart.html          # Shopping cart
├── checkout.html      # Checkout page
└── login.html         # User login
```

## 🔒 Security Features

- Password hashing using bcrypt
- Prepared statements for SQL queries
- Input sanitization and validation
- Session management
- Role-based access control

## Screenshots

[Add screenshots here]

## Key Functionalities

### Customer Features
- Browse menu items by category
- Search and filter products
- Add items to cart
- Update cart quantities
- Place orders
- View order history

### Admin Features
- Dashboard with analytics
- Manage products (Add/Edit/Delete)
- Manage categories
- View and process orders
- Manage users
- System settings

## Testing

1. **Customer Flow**
   - Register → Login → Browse → Add to Cart → Checkout

2. **Admin Flow**
   - Login → Dashboard → Manage Products → Process Orders

## Database Normalization

All tables are normalized to Third Normal Form (3NF):
- **1NF**: All attributes contain atomic values
- **2NF**: No partial dependencies
- **3NF**: No transitive dependencies

See `documentation/er_diagram.png` for visual representation.

## Deployment

### AWS Deployment
Currently am facing Difficulties in AWS account creation with fail to fetch Error

## 👥 Contributors

-  - Developer

## 📄 License

This project is developed as part of academic coursework in Bachelor Degree of Information Technology, Second Year Student
College of Business Education (CBE) Dar es Salaam Campus.

## Contact

For questions or support, contact: [your-email@example.com]

---

**Note**: This is an academic project demonstrating web development skills including database design, backend logic, and frontend integration using vanilla JavaScript.
