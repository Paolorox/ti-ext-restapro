# Restaurant Production Pro (TastyIgniter Extension)

**Extension Code:** `paolorox.restapro`  
**Namespace:** `Paolorox\Restapro`

`Restaurant Production Pro` is an extension for **TastyIgniter (v4.x)** that transforms the application into an ERP system for catering, introducing inventory management, automatic Food Cost calculation, recipe management (with support for sub-recipes), and automatic stock deduction upon order confirmation.

---

## System Requirements

* **TastyIgniter:** `^4.0`
* **PHP:** `^8.0`
* **Required PHP Extensions:** Default ones for TastyIgniter (PDO, OpenSSL, Mbstring, XML, etc.)

---

## Installation Instructions

Follow these steps to install the extension in your testing environment (including shared hosting):

### 1. File Upload
Upload the entire extension folder to the TastyIgniter extensions directory. The final folder structure must be exactly as follows:
```text
tastyigniter_root/
└── extensions/
    └── paolorox/
        └── restapro/
            ├── composer.json
            ├── src/
            ├── database/
            ├── resources/
            └── README.md
```

### 2. Registration and Database Migration
Access your server via SSH terminal (if available), navigate to the root directory of TastyIgniter, and run the following command to register the extension and execute database migrations:

```bash
php artisan igniter:up
```

#### Shared Hosting without SSH access:
If your shared hosting does not have SSH access, you can force TastyIgniter to register and migrate the extension in one of these ways:
1. **Admin Panel:** Go to **System** -> **Extensions**, locate **Restaurant Production Pro** in the list of local extensions, and click **Install/Activate**.
2. **Web Update:** When you access the admin dashboard and visit the updates section, TastyIgniter will automatically check for and run any pending migrations for registered local extensions.

---

## Configuration and Workflow

Once installed, the extension adds a main menu item named **Production** to the Admin Dashboard. Follow this logical order to configure the system:

### 1. Units of Measurement
Define basic units of measurement before entering ingredients (e.g., *Grams*, *Kilograms*, *Liters*, *Milliliters*, *Piece*).
* Associate derived units with their base unit by defining a **conversion factor** (e.g., for *Kilogram*, if the base unit is *Gram*, the conversion factor will be `1000.000000`).

### 2. Categories & Suppliers
* Configure category classifications for ingredients for better internal organization and filtering.
* Set up supplier profiles to associate with purchase invoices and orders.

### 3. Ingredients
Enter basic ingredients, specifying:
* The base unit of measurement (e.g., *Gram*).
* Last purchase cost and Weighted Average Cost (WAC / CMP).
* Minimum stock level to trigger visual alerts on the Dashboard.

### 4. Recipes
Create recipes and associate them with existing items in your TastyIgniter menu.
* It supports both **Menu Item** recipes (items orderable from the menu) and **Sub-Recipe** recipes (intermediate preparations, e.g., *pizza dough* or *seasoned tomato sauce*).
* Under the **Ingredients** tab, add basic ingredients or sub-recipes along with their respective quantities and units.
* The system automatically computes the actual Food Cost by aggregating individual ingredient costs based on their current WAC.

### 5. Purchase Orders
Log new stock arrivals by creating purchase orders.
* Add individual ingredients purchased, specifying the quantity, unit of purchase, and unit cost.
* When changing the status of the order to **Received**, the system automatically adds the items to the stock, recalculates the Weighted Average Cost (WAC) of the affected ingredients, and propagates cost updates to all related recipes.

---

## Automatic Stock Deduction

The extension hooks into the native TastyIgniter event:
`admin.order.paymentProcessed` (Order payment successfully completed).

1. When the event triggers, the module intercepts the order and retrieves the menu items purchased by the customer.
2. For each item that has an active recipe associated with it, it explodes the base ingredients (recursively resolving any sub-recipes).
3. It generates negative stock movements (`sale`) for each ingredient used, updating the inventory in real-time.
