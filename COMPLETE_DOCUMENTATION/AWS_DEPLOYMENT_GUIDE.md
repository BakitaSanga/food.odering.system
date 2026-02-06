# AWS Deployment Guide: Food Ordering System (FOS)

This guide provides step-by-step instructions for deploying the Food Ordering System project to an AWS EC2 instance.

## Prerequisites
- An active AWS Account.
- EC2 Instance (Recommended: Ubuntu 22.04 LTS or Amazon Linux 2023).
- Basic knowledge of the Linux command line.
- SSH client (like PuTTY or the built-in Terminal).

---

## Step 1: Launch an EC2 Instance

1. Log in to the [AWS Management Console](https://console.awcoms.amazon.C/).
2. Navigate to **EC2 Dashboard** > **Launch Instance**.
3. **Name:** `Food-Ordering-System-Server`.
4. **AMI:** Choose **Ubuntu 22.04 LTS**.
5. **Instance Type:** `t2.micro` (Free Tier Eligible).
6. **Key Pair:** Create a new key pair or select an existing one to SSH into your server.
7. **Network Settings:**
   - Allow SSH traffic from (Your IP).
   - Allow **HTTP** traffic from the internet.
   - Allow **HTTPS** traffic from the internet.
8. Click **Launch Instance**.

---

## Step 2: Connect to Your Instance

1. Go to the EC2 Instances page.
2. Select your instance and click **Connect**.
3. Use the **SSH client** tab to get the connection command:
   ```bash
   ssh -i "your-key.pem" ubuntu@ec2-your-instance-ip.compute-1.amazonaws.com
   ```

---

## Step 3: Install LAMP Stack

Once connected, update your server and install Apache, MySQL, and PHP:

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Apache
sudo apt install apache2 -y

# Install MySQL
sudo apt install mysql-server -y

# Install PHP and common extensions
sudo apt install php libapache2-mod-php php-mysql php-gd php-curl php-json php-zip -y
```

---

## Step 4: Configure the Database

1. Log into MySQL:
   ```bash
   sudo mysql
   ```
2. Create the database and user:
   ```sql
   CREATE DATABASE fos_db;
   CREATE USER 'fos_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';
   GRANT ALL PRIVILEGES ON fos_db.* TO 'fos_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```
3. Import your schema:
   Upload `fos_db_clean.sql` to your server (using SCP or FileZilla), then run:
   ```bash
   mysql -u fos_user -p fos_db < /path/to/fos_db_clean.sql
   ```

---

## Step 5: Upload Project Files

1. Navigate to the web root:
   ```bash
   cd /var/www/html/
   ```
2. Remove any default `index.html`:
   ```bash
   sudo rm index.html
   ```
3. Upload your project files (zipped or via Git) to `/var/www/html/fos`.
4. Set permissions:
   ```bash
   sudo chown -R www-data:www-data /var/www/html/
   sudo chmod -R 755 /var/www/html/
   ```

---

## Step 6: Configure Application Connection

Update `api/db_connect.php` (or equivalent) with your production credentials:

```php
<?php
$conn = new mysqli('localhost', 'fos_user', 'YourStrongPassword123!', 'fos_db');
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>
```

---

## Step 7: Final Check

1. Restart Apache:
   ```bash
   sudo systemctl restart apache2
   ```
2. Open your browser and navigate to your **EC2 Public IP Address**.
3. Verify that the login and ordering systems are working correctly.

---

## (Optional) Step 8: Domain & SSL

To protect your users, consider:
- Mapping an Elastic IP to your instance.
- Using **Route 53** to link a domain.
- Using **Certbot** (Let's Encrypt) for free SSL:
  ```bash
  sudo apt install certbot python3-certbot-apache
  sudo certbot --apache
  ```
