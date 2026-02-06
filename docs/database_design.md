# Database Design Documentation
## Food Ordering System

### Entity-Relationship Diagram

```
â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”         â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”         â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”
â”‚     USERS       â”‚         â”‚    USER_INFO     â”‚         â”‚  CATEGORY_LIST  â”‚
â”‚  (Admin Users)  â”‚         â”‚   (Customers)    â”‚         â”‚  (Categories)   â”‚
â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤         â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤         â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤
â”‚ PK: id          â”‚         â”‚ PK: user_id      â”‚         â”‚ PK: id          â”‚
â”‚    name         â”‚         â”‚    first_name    â”‚         â”‚    name         â”‚
â”‚    username     â”‚         â”‚    last_name     â”‚         â””â”€â”€â”€â”€â”€â”€â”€â”€â”¬â”€â”€â”€â”€â”€â”€â”€â”€â”˜
â”‚    password     â”‚         â”‚    email         â”‚                  â”‚
â”‚    type         â”‚         â”‚    password      â”‚                  â”‚ 1
â””â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜         â”‚    mobile        â”‚                  â”‚
                            â”‚    address       â”‚                  â”‚
                            â””â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜                  â”‚
                                                                  â”‚
â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”                                              â”‚
â”‚      CART       â”‚                                              â”‚
â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤                                              â”‚
â”‚ PK: id          â”‚         â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”                 â”‚
â”‚ FK: user_id     â”‚â”€â”€â”€â”€â”    â”‚  PRODUCT_LIST    â”‚                 â”‚
â”‚ FK: product_id  â”‚â”€â”€â”€â”€â”¼â”€â”€â”€â–¶â”‚   (Menu Items)   â”‚                 â”‚
â”‚    client_ip    â”‚    â”‚    â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤                 â”‚
â”‚    qty          â”‚    â”‚    â”‚ PK: id           â”‚                 â”‚
â””â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜    â”‚    â”‚ FK: category_id  â”‚â—€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜
                       â”‚    â”‚    name          â”‚              M
                       â”‚    â”‚    description   â”‚
                       â”‚    â”‚    price         â”‚
â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”    â”‚    â”‚    img_path      â”‚
â”‚     ORDERS      â”‚    â”‚    â”‚    status        â”‚
â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤    â”‚    â””â”€â”€â”€â”€â”€â”€â”€â”€â”¬â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜
â”‚ PK: id          â”‚    â”‚             â”‚
â”‚    name         â”‚    â”‚             â”‚ 1
â”‚    address      â”‚    â”‚             â”‚
â”‚    mobile       â”‚    â”‚             â”‚
â”‚    email        â”‚    â”‚             â”‚ M
â”‚    status       â”‚    â”‚    â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â–¼â”€â”€â”€â”€â”€â”€â”€â”€â”€â”
â””â”€â”€â”€â”€â”€â”€â”€â”€â”¬â”€â”€â”€â”€â”€â”€â”€â”€â”˜    â”‚    â”‚   ORDER_LIST     â”‚
         â”‚             â”‚    â”‚  (Order Items)   â”‚
         â”‚ 1           â”‚    â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤
         â”‚             â””â”€â”€â”€â–¶â”‚ PK: id           â”‚
         â”‚ M                â”‚ FK: order_id     â”‚
         â”‚                  â”‚ FK: product_id   â”‚
         â”‚                  â”‚    qty           â”‚
         â”‚                  â””â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜
         â”‚
         â”‚
â”Œâ”€â”€â”€â”€â”€â”€â”€â”€â–¼â”€â”€â”€â”€â”€â”€â”€â”€â”
â”‚ SYSTEM_SETTINGS â”‚
â”œâ”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”¤
â”‚ PK: id          â”‚
â”‚    hotel_name   â”‚
â”‚    email        â”‚
â”‚    contact      â”‚
â”‚    cover_img    â”‚
â”‚    about_contentâ”‚
â””â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”˜
```

### Relationships

1. **CATEGORY_LIST â†’ PRODUCT_LIST** (1:M)
   - One category can have many products
   - Each product belongs to one category

2. **PRODUCT_LIST â†’ CART** (1:M)
   - One product can be in many cart items
   - Each cart item references one product

3. **USER_INFO â†’ CART** (1:M)
   - One customer can have many cart items
   - Each cart item belongs to one customer

4. **ORDERS â†’ ORDER_LIST** (1:M)
   - One order can have many order items
   - Each order item belongs to one order

5. **PRODUCT_LIST â†’ ORDER_LIST** (1:M)
   - One product can appear in many orders
   - Each order item references one product

### Table Descriptions

#### 1. users (Admin Users)
Stores administrator account information for system management.
- **Primary Key**: id
- **Purpose**: Authentication and authorization for admin panel

#### 2. user_info (Customers)
Stores customer account information for placing orders.
- **Primary Key**: user_id
- **Purpose**: Customer authentication and profile management

#### 3. category_list (Product Categories)
Organizes products into logical groups.
- **Primary Key**: id
- **Purpose**: Product categorization and filtering

#### 4. product_list (Menu Items)
Contains all available food items with pricing and details.
- **Primary Key**: id
- **Foreign Key**: category_id â†’ category_list(id)
- **Purpose**: Product catalog management

#### 5. cart (Shopping Cart)
Temporary storage for items before checkout.
- **Primary Key**: id
- **Foreign Keys**: 
  - user_id â†’ user_info(user_id)
  - product_id â†’ product_list(id)
- **Purpose**: Session-based shopping cart

#### 6. orders (Order Headers)
Stores order summary and customer delivery information.
- **Primary Key**: id
- **Purpose**: Order tracking and fulfillment

#### 7. order_list (Order Line Items)
Details of products in each order with quantities.
- **Primary Key**: id
- **Foreign Keys**:
  - order_id â†’ orders(id)
  - product_id â†’ product_list(id)
- **Purpose**: Order details and inventory tracking

#### 8. system_settings (Configuration)
Application-wide settings and branding.
- **Primary Key**: id
- **Purpose**: System configuration management

---

## Third Normal Form (3NF) Compliance

### Normalization Rules
- **1NF**: All attributes contain atomic (indivisible) values
- **2NF**: No partial dependencies (all non-key attributes fully depend on primary key)
- **3NF**: No transitive dependencies (non-key attributes don't depend on other non-key attributes)

### Table Analysis

#### âœ… users (3NF Compliant)
**Attributes**: id, name, username, password, type

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies
  - name depends only on id
  - username depends only on id
  - password depends only on id
  - type depends only on id

**Functional Dependencies**: id â†’ {name, username, password, type}

---

#### âœ… user_info (3NF Compliant)
**Attributes**: user_id, first_name, last_name, email, password, mobile, address

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (user_id)
- **3NF**: âœ“ No transitive dependencies
  - All attributes directly depend on user_id
  - No attribute depends on another non-key attribute

**Functional Dependencies**: user_id â†’ {first_name, last_name, email, password, mobile, address}

---

#### âœ… category_list (3NF Compliant)
**Attributes**: id, name

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ name depends on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies (only one non-key attribute)

**Functional Dependencies**: id â†’ name

---

#### âœ… product_list (3NF Compliant)
**Attributes**: id, category_id, name, description, price, img_path, status

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies
  - category_id is a foreign key (allowed)
  - All other attributes depend only on id
  - No attribute depends on category_id

**Functional Dependencies**: 
- id â†’ {category_id, name, description, price, img_path, status}
- category_id â†’ category_name (handled by JOIN, not stored)

---

#### âœ… cart (3NF Compliant)
**Attributes**: id, client_ip, user_id, product_id, qty

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies
  - user_id and product_id are foreign keys (allowed)
  - qty depends only on id
  - client_ip depends only on id

**Functional Dependencies**: id â†’ {client_ip, user_id, product_id, qty}

---

#### âœ… orders (3NF Compliant)
**Attributes**: id, name, address, mobile, email, status

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies
  - All customer info depends only on order id
  - Denormalization for performance (order snapshot)

**Functional Dependencies**: id â†’ {name, address, mobile, email, status}

**Note**: Customer information is intentionally duplicated to preserve order details even if customer account is deleted.

---

#### âœ… order_list (3NF Compliant)
**Attributes**: id, order_id, product_id, qty

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies
  - order_id and product_id are foreign keys (allowed)
  - qty depends only on id

**Functional Dependencies**: id â†’ {order_id, product_id, qty}

---

#### âœ… system_settings (3NF Compliant)
**Attributes**: id, hotel_name, email, contact, cover_img, about_content

- **1NF**: âœ“ All values are atomic
- **2NF**: âœ“ All attributes depend on entire primary key (id)
- **3NF**: âœ“ No transitive dependencies
  - All settings depend only on id
  - No setting depends on another setting

**Functional Dependencies**: id â†’ {hotel_name, email, contact, cover_img, about_content}

---

## Summary

âœ… **All 8 tables are in Third Normal Form (3NF)**

### Key Points:
1. No repeating groups (1NF)
2. No partial dependencies (2NF)
3. No transitive dependencies (3NF)
4. Foreign keys properly defined
5. Referential integrity maintained
6. Efficient data storage with minimal redundancy

### Design Decisions:
- **orders table**: Denormalized to store customer snapshot (intentional for historical accuracy)
- **cart table**: Includes both user_id and client_ip for guest cart support
- **Separate user tables**: users (admin) and user_info (customers) for role separation
