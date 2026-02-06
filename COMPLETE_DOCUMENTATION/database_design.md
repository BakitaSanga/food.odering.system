# Database Design Documentation
## Food Ordering System

### Entity-Relationship Diagram

```
┌─────────────────┐         ┌──────────────────┐         ┌─────────────────┐
│     USERS       │         │    USER_INFO     │         │  CATEGORY_LIST  │
│  (Admin Users)  │         │   (Customers)    │         │  (Categories)   │
├─────────────────┤         ├──────────────────┤         ├─────────────────┤
│ PK: id          │         │ PK: user_id      │         │ PK: id          │
│    name         │         │    first_name    │         │    name         │
│    username     │         │    last_name     │         └────────┬────────┘
│    password     │         │    email         │                  │
│    type         │         │    password      │                  │ 1
└─────────────────┘         │    mobile        │                  │
                            │    address       │                  │
                            └──────────────────┘                  │
                                                                  │
┌─────────────────┐                                              │
│      CART       │                                              │
├─────────────────┤                                              │
│ PK: id          │         ┌──────────────────┐                 │
│ FK: user_id     │────┐    │  PRODUCT_LIST    │                 │
│ FK: product_id  │────┼───▶│   (Menu Items)   │                 │
│    client_ip    │    │    ├──────────────────┤                 │
│    qty          │    │    │ PK: id           │                 │
└─────────────────┘    │    │ FK: category_id  │◀────────────────┘
                       │    │    name          │              M
                       │    │    description   │
                       │    │    price         │
┌─────────────────┐    │    │    img_path      │
│     ORDERS      │    │    │    status        │
├─────────────────┤    │    └────────┬─────────┘
│ PK: id          │    │             │
│    name         │    │             │ 1
│    address      │    │             │
│    mobile       │    │             │
│    email        │    │             │ M
│    status       │    │    ┌────────▼─────────┐
└────────┬────────┘    │    │   ORDER_LIST     │
         │             │    │  (Order Items)   │
         │ 1           │    ├──────────────────┤
         │             └───▶│ PK: id           │
         │ M                │ FK: order_id     │
         │                  │ FK: product_id   │
         │                  │    qty           │
         │                  └──────────────────┘
         │
         │
┌────────▼────────┐
│ SYSTEM_SETTINGS │
├─────────────────┤
│ PK: id          │
│    hotel_name   │
│    email        │
│    contact      │
│    cover_img    │
│    about_content│
└─────────────────┘
```

### Relationships

1. **CATEGORY_LIST → PRODUCT_LIST** (1:M)
   - One category can have many products
   - Each product belongs to one category

2. **PRODUCT_LIST → CART** (1:M)
   - One product can be in many cart items
   - Each cart item references one product

3. **USER_INFO → CART** (1:M)
   - One customer can have many cart items
   - Each cart item belongs to one customer

4. **ORDERS → ORDER_LIST** (1:M)
   - One order can have many order items
   - Each order item belongs to one order

5. **PRODUCT_LIST → ORDER_LIST** (1:M)
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
- **Foreign Key**: category_id → category_list(id)
- **Purpose**: Product catalog management

#### 5. cart (Shopping Cart)
Temporary storage for items before checkout.
- **Primary Key**: id
- **Foreign Keys**: 
  - user_id → user_info(user_id)
  - product_id → product_list(id)
- **Purpose**: Session-based shopping cart

#### 6. orders (Order Headers)
Stores order summary and customer delivery information.
- **Primary Key**: id
- **Purpose**: Order tracking and fulfillment

#### 7. order_list (Order Line Items)
Details of products in each order with quantities.
- **Primary Key**: id
- **Foreign Keys**:
  - order_id → orders(id)
  - product_id → product_list(id)
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

#### ✅ users (3NF Compliant)
**Attributes**: id, name, username, password, type

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (id)
- **3NF**: ✓ No transitive dependencies
  - name depends only on id
  - username depends only on id
  - password depends only on id
  - type depends only on id

**Functional Dependencies**: id → {name, username, password, type}

---

#### ✅ user_info (3NF Compliant)
**Attributes**: user_id, first_name, last_name, email, password, mobile, address

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (user_id)
- **3NF**: ✓ No transitive dependencies
  - All attributes directly depend on user_id
  - No attribute depends on another non-key attribute

**Functional Dependencies**: user_id → {first_name, last_name, email, password, mobile, address}

---

#### ✅ category_list (3NF Compliant)
**Attributes**: id, name

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ name depends on entire primary key (id)
- **3NF**: ✓ No transitive dependencies (only one non-key attribute)

**Functional Dependencies**: id → name

---

#### ✅ product_list (3NF Compliant)
**Attributes**: id, category_id, name, description, price, img_path, status

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (id)
- **3NF**: ✓ No transitive dependencies
  - category_id is a foreign key (allowed)
  - All other attributes depend only on id
  - No attribute depends on category_id

**Functional Dependencies**: 
- id → {category_id, name, description, price, img_path, status}
- category_id → category_name (handled by JOIN, not stored)

---

#### ✅ cart (3NF Compliant)
**Attributes**: id, client_ip, user_id, product_id, qty

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (id)
- **3NF**: ✓ No transitive dependencies
  - user_id and product_id are foreign keys (allowed)
  - qty depends only on id
  - client_ip depends only on id

**Functional Dependencies**: id → {client_ip, user_id, product_id, qty}

---

#### ✅ orders (3NF Compliant)
**Attributes**: id, name, address, mobile, email, status

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (id)
- **3NF**: ✓ No transitive dependencies
  - All customer info depends only on order id
  - Denormalization for performance (order snapshot)

**Functional Dependencies**: id → {name, address, mobile, email, status}

**Note**: Customer information is intentionally duplicated to preserve order details even if customer account is deleted.

---

#### ✅ order_list (3NF Compliant)
**Attributes**: id, order_id, product_id, qty

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (id)
- **3NF**: ✓ No transitive dependencies
  - order_id and product_id are foreign keys (allowed)
  - qty depends only on id

**Functional Dependencies**: id → {order_id, product_id, qty}

---

#### ✅ system_settings (3NF Compliant)
**Attributes**: id, hotel_name, email, contact, cover_img, about_content

- **1NF**: ✓ All values are atomic
- **2NF**: ✓ All attributes depend on entire primary key (id)
- **3NF**: ✓ No transitive dependencies
  - All settings depend only on id
  - No setting depends on another setting

**Functional Dependencies**: id → {hotel_name, email, contact, cover_img, about_content}

---

## Summary

✅ **All 8 tables are in Third Normal Form (3NF)**

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
