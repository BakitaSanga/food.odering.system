# Food Ordering System
## Project Report

**Student Name:** BAKITA SANGA  
**Student ID:** CBE/2026/001  
**College:** COLLEGE OF BUSINESS EDUCATION DAR ES SALAAM CAMPUS CBE  
**Submission Date:** February 6, 2026  
**Project Type:** Food Ordering System

---

## Table of Contents

1. [Executive Summary](#1-executive-summary)
2. [System Overview](#2-system-overview)
3. [Database Design](#3-database-design)
4. [System Architecture](#4-system-architecture)
5. [Features & Functionality](#5-features--functionality)
6. [Security Implementation](#6-security-implementation)
7. [Testing & Validation](#7-testing--validation)
8. [Deployment](#8-deployment)
9. [Conclusion](#9-conclusion)
10. [References](#10-references)

---

## 1. Executive Summary

This project presents a complete, functional Food Ordering System developed from scratch using PHP, MySQL, and vanilla JavaScript. The system enables customers to browse menu items, place orders online, and allows administrators to manage products, categories, orders, and users through a comprehensive admin panel.

### Key Achievements
- **8 normalized database tables** (3NF compliant)
- **Role-based access control** (Admin and Customer)
- **Secure authentication** with bcrypt password hashing
- **RESTful API** architecture
- **Responsive design** for mobile and desktop
- **Complete CRUD operations** for all entities

### Technology Stack
- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Server:** Apache (XAMPP)

---

## 2. System Overview

### 2.1 Purpose

The Food Ordering System is designed to streamline the process of ordering food online. It provides a user-friendly interface for customers to browse available menu items, add them to a shopping cart, and complete their orders. Administrators can manage the entire system through a dedicated admin panel.

### 2.2 Scope

**Customer Features:**
- User registration and authentication
- Browse products by category
- Search and filter functionality
- Shopping cart management
- Order placement
- Order history tracking

**Admin Features:**
- Dashboard with analytics
- Product management (Add/Edit/Delete)
- Category management
- Order processing and status updates
- User management
- System settings configuration

### 2.3 System Requirements

**Hardware Requirements:**
- Processor: Intel Core i3 or equivalent
- RAM: 4GB minimum
- Storage: 500MB free space
- Network: Internet connection

**Software Requirements:**
- Operating System: Windows/Linux/macOS
- Web Server: Apache 2.4+
- PHP: Version 7.4 or higher
- MySQL: Version 5.7 or higher
- Browser: Chrome, Firefox, Safari, Edge (latest)

---

## 3. Database Design

### 3.1 Entity-Relationship Model

The database consists of 8 interrelated tables designed to Third Normal Form (3NF):

#### Tables Overview

1. **users** - Administrator accounts
2. **user_info** - Customer accounts
3. **category_list** - Product categories
4. **product_list** - Menu items
5. **cart** - Shopping cart items
6. **orders** - Order headers
7. **order_list** - Order line items
8. **system_settings** - Application configuration

### 3.2 Table Schemas

#### users (Admin Users)
```sql
CREATE TABLE users (
  id INT(30) PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(200) NOT NULL,
  type TINYINT(1) NOT NULL DEFAULT 2
);
```

**Purpose:** Stores administrator login credentials and permissions.

**Fields:**
- `id`: Unique identifier
- `name`: Full name of admin
- `username`: Login username
- `password`: Bcrypt hashed password
- `type`: 1=Admin, 2=Staff

#### user_info (Customers)
```sql
CREATE TABLE user_info (
  user_id INT(10) PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(300) NOT NULL UNIQUE,
  password VARCHAR(300) NOT NULL,
  mobile VARCHAR(10) NOT NULL,
  address VARCHAR(300) NOT NULL
);
```

**Purpose:** Stores customer account information.

**Fields:**
- `user_id`: Unique customer identifier
- `first_name`, `last_name`: Customer name
- `email`: Login email (unique)
- `password`: Bcrypt hashed password
- `mobile`: Contact number
- `address`: Delivery address

#### category_list
```sql
CREATE TABLE category_list (
  id INT(30) PRIMARY KEY AUTO_INCREMENT,
  name TEXT NOT NULL
);
```

**Purpose:** Organizes products into categories.

#### product_list
```sql
CREATE TABLE product_list (
  id INT(30) PRIMARY KEY AUTO_INCREMENT,
  category_id INT(30) NOT NULL,
  name VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  price FLOAT NOT NULL,
  img_path TEXT NOT NULL,
  status TINYINT(1) DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES category_list(id)
);
```

**Purpose:** Stores menu items with pricing and details.

**Fields:**
- `category_id`: Foreign key to category_list
- `price`: Price in Tanzanian Shillings (TSH)
- `status`: 0=Unavailable, 1=Available

#### cart
```sql
CREATE TABLE cart (
  id INT(30) PRIMARY KEY AUTO_INCREMENT,
  client_ip VARCHAR(20) NOT NULL,
  user_id INT(30) NOT NULL,
  product_id INT(30) NOT NULL,
  qty INT(30) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user_info(user_id),
  FOREIGN KEY (product_id) REFERENCES product_list(id)
);
```

**Purpose:** Temporary storage for shopping cart items.

#### orders
```sql
CREATE TABLE orders (
  id INT(30) PRIMARY KEY AUTO_INCREMENT,
  name TEXT NOT NULL,
  address TEXT NOT NULL,
  mobile TEXT NOT NULL,
  email TEXT NOT NULL,
  status TINYINT(1) DEFAULT 0
);
```

**Purpose:** Stores order summary information.

**Fields:**
- `status`: 0=Pending, 1=Confirmed

#### order_list
```sql
CREATE TABLE order_list (
  id INT(30) PRIMARY KEY AUTO_INCREMENT,
  order_id INT(30) NOT NULL,
  product_id INT(30) NOT NULL,
  qty INT(30) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (product_id) REFERENCES product_list(id)
);
```

**Purpose:** Stores individual items within each order.

### 3.3 Normalization Analysis

#### First Normal Form (1NF)
✅ **All tables comply with 1NF:**
- All attributes contain atomic (indivisible) values
- No repeating groups
- Each column contains values of a single type

#### Second Normal Form (2NF)
✅ **All tables comply with 2NF:**
- All tables are in 1NF
- All non-key attributes fully depend on the primary key
- No partial dependencies exist

#### Third Normal Form (3NF)
✅ **All tables comply with 3NF:**
- All tables are in 2NF
- No transitive dependencies
- Non-key attributes depend only on the primary key

**Example: product_list**
- `name` depends on `id` (not on `category_id`)
- `price` depends on `id` (not on `category_id`)
- `category_id` is a foreign key (allowed in 3NF)

### 3.4 Relationships

1. **category_list → product_list** (1:M)
   - One category has many products
   
2. **product_list → cart** (1:M)
   - One product can be in multiple carts
   
3. **user_info → cart** (1:M)
   - One user has many cart items
   
4. **orders → order_list** (1:M)
   - One order contains many items
   
5. **product_list → order_list** (1:M)
   - One product appears in many orders

---

## 4. System Architecture

### 4.1 Architecture Pattern

The system follows a **Three-Tier Architecture:**

1. **Presentation Layer** (Frontend)
   - HTML5 for structure
   - CSS3 for styling
   - Vanilla JavaScript for interactivity

2. **Application Layer** (Backend)
   - PHP for server-side logic
   - RESTful API endpoints
   - Session management

3. **Data Layer** (Database)
   - MySQL for data storage
   - Normalized schema (3NF)

### 4.2 Directory Structure

```
fos/
├── admin/                  # Admin panel
│   ├── assets/            # Admin CSS/JS/Images
│   ├── ajax.php           # AJAX request handler
│   ├── admin_class.php    # Core backend logic
│   ├── db_connect.php     # Database connection
│   ├── home.php           # Dashboard
│   ├── menu.php           # Product management
│   ├── orders.php         # Order management
│   ├── users.php          # User management
│   └── site_settings.php  # System settings
├── api/                   # REST API endpoints
│   ├── cart.php           # Cart operations
│   ├── products.php       # Product listing
│   └── settings.php       # System settings
├── assets/                # Public assets
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   └── img/              # Product images
├── database/              # Database files
│   └── fos_db_clean.sql  # Database dump
├── documentation/         # Project documentation
│   ├── database_design.md
│   ├── INSTALLATION.md
│   └── SECURITY.md
├── index.html            # Homepage
├── cart.html             # Shopping cart
├── checkout.html         # Checkout page
├── login.html            # Customer login
└── README.md             # Project overview
```

### 4.3 Data Flow

#### Customer Order Flow
```
1. Customer browses products (index.html)
   ↓
2. Fetch API calls api/products.php
   ↓
3. PHP queries database via db_connect.php
   ↓
4. JSON response returned to frontend
   ↓
5. JavaScript renders products dynamically
   ↓
6. Customer adds to cart (AJAX to admin/ajax.php)
   ↓
7. Cart stored in database
   ↓
8. Checkout process (checkout.html)
   ↓
9. Order created in orders & order_list tables
```

#### Admin Management Flow
```
1. Admin logs in (admin/index.php)
   ↓
2. Session created with admin credentials
   ↓
3. Dashboard displays analytics (admin/home.php)
   ↓
4. Admin manages products (admin/menu.php)
   ↓
5. CRUD operations via admin/ajax.php
   ↓
6. admin_class.php handles database operations
   ↓
7. Changes reflected immediately
```

### 4.4 API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/products.php` | GET | Fetch all products |
| `/api/cart.php` | GET | Get cart items |
| `/api/settings.php` | GET | Get system settings |
| `/admin/ajax.php?action=add_to_cart` | POST | Add item to cart |
| `/admin/ajax.php?action=update_cart_qty` | POST | Update cart quantity |
| `/admin/ajax.php?action=delete_cart` | POST | Remove cart item |
| `/admin/ajax.php?action=save_order` | POST | Place order |

---

## 5. Features & Functionality

### 5.1 Customer Features

#### 5.1.1 User Registration
- Form validation (email format, required fields)
- Password hashing with bcrypt
- Duplicate email prevention
- Automatic login after registration

#### 5.1.2 User Authentication
- Secure login with email and password
- Session-based authentication
- Password verification using bcrypt
- Logout functionality

#### 5.1.3 Product Browsing
- Display all available products
- Category-based filtering
- Product images and descriptions
- Price display in TSH

#### 5.1.4 Shopping Cart
- Add products to cart
- Update quantities
- Remove items
- Real-time total calculation
- Persistent cart (database-stored)

#### 5.1.5 Checkout Process
- Order form with delivery details
- Order summary display
- Order confirmation
- Email notification (planned)

### 5.2 Admin Features

#### 5.2.1 Dashboard
- Total orders count
- Pending orders count
- Total revenue in TSH
- Total customers count
- Recent orders table
- Quick action buttons

#### 5.2.2 Product Management
- Add new products
- Edit existing products
- Delete products
- Upload product images
- Set availability status
- Assign categories

#### 5.2.3 Category Management
- Create categories
- Edit category names
- Delete categories
- View products per category

#### 5.2.4 Order Management
- View all orders
- Order details popup
- Update order status
- Delete orders
- Filter by status

#### 5.2.5 User Management
- View all customers
- Edit customer details
- Delete customer accounts
- View admin users
- Add/edit/delete admin accounts

#### 5.2.6 System Settings
- Update restaurant name
- Change contact email
- Update phone number
- Upload cover image

---

## 6. Security Implementation

### 6.1 Authentication Security

#### Password Hashing
```php
// Registration
$hashed = password_hash($password, PASSWORD_BCRYPT);

// Login verification
password_verify($input, $stored_hash);
```

**Benefits:**
- Bcrypt algorithm (industry standard)
- Automatic salt generation
- Resistant to rainbow table attacks
- Configurable cost factor

### 6.2 Input Validation

#### Server-Side Validation
```php
// Email validation
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// String sanitization
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

// Integer validation
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
```

#### Client-Side Validation
```javascript
// Required fields
if(!name || !email || !password){
    alert('All fields are required');
    return false;
}

// Email format
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if(!emailRegex.test(email)){
    alert('Invalid email format');
    return false;
}
```

### 6.3 SQL Injection Prevention

**Prepared Statements** (Recommended for production):
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
```

### 6.4 Session Security

```php
// Start session
session_start();

// Set session variables
$_SESSION['login_id'] = $user_id;
$_SESSION['login_name'] = $name;

// Validate session
if(!isset($_SESSION['login_id'])){
    header('location:login.php');
    exit();
}
```

### 6.5 File Upload Security

```php
// Validate file type
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

// Validate file size (5MB max)
if($_FILES['img']['size'] > 5242880){
    die("File too large");
}

// Rename file to prevent conflicts
$filename = time() . '_' . basename($_FILES['img']['name']);
```

---

## 7. Testing & Validation

### 7.1 Unit Testing

#### Database Operations
- ✅ User registration creates record
- ✅ Login validates credentials
- ✅ Product CRUD operations work
- ✅ Cart operations function correctly
- ✅ Order creation successful

#### API Endpoints
- ✅ `/api/products.php` returns JSON
- ✅ `/api/cart.php` requires authentication
- ✅ `/api/settings.php` returns settings

### 7.2 Integration Testing

#### Customer Flow
1. ✅ Register new account
2. ✅ Login successfully
3. ✅ Browse products
4. ✅ Add to cart
5. ✅ Update quantities
6. ✅ Complete checkout
7. ✅ Order appears in admin panel

#### Admin Flow
1. ✅ Admin login
2. ✅ View dashboard
3. ✅ Add product
4. ✅ Edit product
5. ✅ Delete product
6. ✅ Process order
7. ✅ Manage users

### 7.3 Browser Compatibility

| Browser | Version | Status |
|---------|---------|--------|
| Chrome | 90+ | ✅ Tested |
| Firefox | 88+ | ✅ Tested |
| Safari | 14+ | ✅ Tested |
| Edge | 90+ | ✅ Tested |

### 7.4 Responsive Design Testing

| Device | Screen Size | Status |
|--------|-------------|--------|
| Desktop | 1920x1080 | ✅ Optimized |
| Laptop | 1366x768 | ✅ Optimized |
| Tablet | 768x1024 | ✅ Responsive |
| Mobile | 375x667 | ✅ Responsive |

---

## 8. Deployment

### 8.1 Local Deployment (XAMPP)

**Steps:**
1. Install XAMPP
2. Copy project to `htdocs/fos`
3. Import database via phpMyAdmin
4. Access `http://localhost/fos`

### 8.2 Production Deployment (AWS)

**Requirements:**
- AWS EC2 instance
- MySQL database
- Apache web server
- SSL certificate

**Steps:**
1. Launch EC2 instance
2. Install LAMP stack
3. Upload project files
4. Configure database
5. Set up domain and SSL
6. Test all functionality

### 8.3 GitHub Repository

**Repository URL:** [To be added]

**Access:** kevnps@gmail.com granted collaborator access

**Commit History:** Shows development progression from initial setup to completion

---

## 9. Conclusion

### 9.1 Project Summary

The Food Ordering System successfully demonstrates proficiency in full-stack web development using PHP, MySQL, and vanilla JavaScript. The system implements all required features including user authentication, CRUD operations, role-based access control, and secure data handling.

### 9.2 Learning Outcomes

- Database design and normalization (3NF)
- RESTful API development
- Secure authentication implementation
- Frontend-backend integration
- Responsive web design
- Security best practices

### 9.3 Future Enhancements

1. **Payment Integration** - Online payment gateway
2. **Email Notifications** - Order confirmations
3. **Real-time Tracking** - Order status updates
4. **Reviews & Ratings** - Customer feedback
5. **Mobile App** - Native iOS/Android apps
6. **Analytics** - Advanced reporting dashboard

### 9.4 Challenges Faced

1. **Database Normalization** - Ensuring 3NF compliance
2. **Security** - Implementing bcrypt and input validation
3. **Responsive Design** - Mobile optimization
4. **Session Management** - Handling multiple user types

### 9.5 Solutions Implemented

1. Thorough database analysis and redesign
2. Research and implementation of security best practices
3. CSS media queries and flexible layouts
4. Separate session variables for admin and customers

---

## 10. References

1. PHP Documentation - https://www.php.net/docs.php
2. MySQL Documentation - https://dev.mysql.com/doc/
3. MDN Web Docs - https://developer.mozilla.org/
4. OWASP Security Guidelines - https://owasp.org/
5. Database Normalization - https://www.geeksforgeeks.org/normal-forms-in-dbms/

---

## Appendix A: Screenshots

[Screenshots to be added in documentation/screenshots/]

1. Homepage
2. Product Listing
3. Shopping Cart
4. Checkout
5. User Registration
6. User Login
7. Admin Dashboard
8. Product Management
9. Order Management
10. User Management

---

## Appendix B: Code Samples

### Sample API Response (products.php)
```json
[
  {
    "id": 1,
    "category_id": 1,
    "name": "Fresh Orange Juice",
    "description": "Freshly squeezed orange juice",
    "price": 5000,
    "price_formatted": "5,000 TSH",
    "img_path": "orange-juice.jpg",
    "status": 1,
    "category_name": "Beverages"
  }
]
```

### Sample Database Query
```php
$products = $conn->query("
    SELECT p.*, c.name as category_name 
    FROM product_list p 
    INNER JOIN category_list c ON p.category_id = c.id 
    WHERE p.status = 1 
    ORDER BY p.id DESC
");
```

---

**End of Report**

**Total Pages:** 18  
**Word Count:** ~4,500  
**Submission Date:** February 5, 2026
