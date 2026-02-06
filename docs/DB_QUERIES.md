# Database Queries Report - Bakita Sanga Food Ordering System

This document provides a comprehensive overview of the SQL queries used throughout the application, categorized by their primary functionality.

---

##  User Authentication & Account Management

Queries related to user login, signup, and profile management.

### User Login (Admin/Staff)
**Location:** `admin/admin_class.php:19`
```sql
SELECT * FROM users WHERE username = '[username]';
```

### Customer Login
**Location:** `admin/admin_class.php:35`
```sql
SELECT * FROM user_info WHERE email = '[email]';
```

### Customer Signup
**Location:** `admin/admin_class.php:94`
```sql
INSERT INTO user_info SET 
    first_name = '[first_name]', 
    last_name = '[last_name]', 
    mobile = '[mobile]', 
    address = '[address]', 
    email = '[email]', 
    password = '[hashed_password]';
```

### Password Reset (Token Management)
**Location:** `admin/admin_class.php:316-319`
```sql
DELETE FROM password_resets WHERE email = '[email]';
INSERT INTO password_resets (email, token, expires_at) VALUES ('[email]', '[token]', '[expiry]');
```

---

## Product & Menu Management

Queries for managing categories and food items.

### List Categories
**Location:** `api/categories.php:10`
```sql
SELECT * FROM category_list ORDER BY name ASC;
```

### Save/Update Category
**Location:** `admin/admin_class.php:137-139`
```sql
INSERT INTO category_list SET name = '[name]';
UPDATE category_list SET name = '[name]' WHERE id = [id];
```

### Fetch Menu Items
**Location:** `home.php:19`
```sql
SELECT * FROM product_list ORDER BY rand();
```

### Delete Product
**Location:** `admin/admin_class.php:178`
```sql
DELETE FROM product_list WHERE id = [id];
```

---

## 🛒 Shopping Cart & Order Processing

Queries for handling the ordering lifecycle.

### Add to Cart
**Location:** `admin/admin_class.php:195`
```sql
INSERT INTO cart SET 
    product_id = [pid], 
    qty = [qty], 
    user_id = '[user_id]' OR client_ip = '[ip]';
```

### Place Order
**Location:** `admin/admin_class.php:240-251`
```sql
-- Create Order Header
INSERT INTO orders SET 
    name = '[full_name]', 
    address = '[address]', 
    mobile = '[mobile]', 
    email = '[email]', 
    user_id = '[user_id]';

-- Move Cart Items to Order List
SELECT * FROM cart WHERE user_id = [user_id];
INSERT INTO order_list SET 
    order_id = '[order_id]', 
    product_id = '[product_id]', 
    qty = '[qty]';

-- Clear Cart
DELETE FROM cart WHERE id = [cart_id];
```

### Confirm Order (Admin)
**Location:** `admin/admin_class.php:259`
```sql
UPDATE orders SET status = 1 WHERE id = [id];
```

---

## ⚙️ System Settings

### Fetch Site Settings
**Location:** `api/settings.php:17`
```sql
SELECT * FROM system_settings LIMIT 1;
```

### Update System Settings
**Location:** `admin/admin_class.php:117-119`
```sql
UPDATE system_settings SET 
    name = '[name]', 
    email = '[email]', 
    contact = '[contact]', 
    about_content = '[content]', 
    cover_img = '[img]' 
WHERE id = [id];
```

---

> [!NOTE]
> All user-provided data is expected to be sanitized or handled via prepared statements (where supported) to prevent SQL injection.
