# Online Food Ordering System

**Course Project Submission**

## 👨‍💻 Developer Information
- **Name**: Bakita Sanga
- **Role**: Full Stack Developer
- **Project**: Food Ordering System (FOS)

## 📖 Project Overview
The **Online Food Ordering System** is a web-based application designed to streamline the process of ordering food from a restaurant. It provides a seamless interface for customers to browse menus, search for items, place orders, and track their cart. On the backend, it offers a robust admin panel for restaurant staff to manage products, categories, orders, and system settings.

This project demonstrates the implementation of a full-stack web application with a focus on **Database Normalization (3NF)**, **Security Best Practices**, and **Modern Vanilla JavaScript**.

## 🚀 Key Features

### 🛡️ Security & Performance
- **Secure Authentication**: Implemented `password_hash()` (Bcrypt) for robust password security.
- **Input Sanitization**: Protection against SQL Injection using prepared statements and escaping.
- **Optimized Frontend**: completely removed jQuery dependency in favor of lightweight, native **Vanilla JavaScript (ES6+)** and the **Fetch API**.

### 👤 Customer Module
- **Dynamic Menu**: Real-time product listing with category filtering and price range adjustments.
- **Smart Search**: Instant search functionality for food items.
- **Shopping Cart**: Full cart management (Add, Update, Remove items) with session persistence.
- **Checkout System**: Streamlined checkout process with user validation.
- **Responsive Design**: Fully responsive UI built with **Bootstrap 5**.

### 🔧 Admin Module
- **Dashboard**: Overview of orders and system status.
- **Menu Management**: CRUD operations for Categories and Products (with image upload).
- **Order Management**: View, Confirm, and Delete orders.
- **User Management**: Manage system users and customers.
- **System Settings**: Configure restaurant details.

## 🛠️ Technology Stack
- **Frontend**: HTML5, CSS3, Bootstrap 5, Vanilla JavaScript.
- **Backend**: PHP (Native).
- **Database**: MySQL (Relational Schema, 3NF).
- **Architecture**: MVC-inspired structure.

## 💾 Database Design
The database has been normalized to the **Third Normal Form (3NF)** to ensure data integrity and reduce redundancy.
- **`users`**: Admin/Staff accounts.
- **`user_info`**: Customer profiles.
- **`products`** & **`categories`**: Menu data.
- **`orders`** & **`order_list`**: Transactional data (Orders linked to Users).

## ⚙️ Installation & Setup Guide

### Prerequisites
- XAMPP / WAMP / MAMP (or any PHP/MySQL stack).
- Web Browser (Chrome/Edge/Firefox).

### Steps
1.  **Clone/Download**: Extract the project files to your server's root directory (e.g., `C:\xampp\htdocs\fos`).
2.  **Database Setup**:
    - Open phpMyAdmin (`http://localhost/phpmyadmin`).
    - Create a new database named `fos_db`.
    - Import the provided SQL file: `database/fos_db.sql`.
3.  **Configuration**:
    - Check `admin/db_connect.php` to ensure database credentials match your local setup:
      ```php
      $conn = new mysqli('localhost', 'root', '', 'fos_db');
      ```
4.  **Launch**:
    - **Frontend**: Access `http://localhost/fos/`
    - **Admin Panel**: Access `http://localhost/fos/admin/`

## 🔑 Admin Credentials
Use the following credentials to access the administrative dashboard:
- **Username**: `myrah@admin`
- **Password**: `myrahfos@2026`

## 🤝 Contributors
- **Bakita Sanga** - *Lead Developer*

## 📜 License
This project is for educational purposes.

---
*Generated for Final Project Submission*
