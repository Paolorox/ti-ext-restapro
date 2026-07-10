# 📦 Installation Guide — Restaurant Production Pro

**RestaPro** is a TastyIgniter extension for professional restaurant production management, food cost control, and inventory tracking.

---

## 📋 Requirements

| Requirement | Minimum Version |
|---|---|
| TastyIgniter | 4.0+ |
| PHP | 8.1+ |
| MySQL / MariaDB | 5.7+ / 10.3+ |
| Composer | 2.0+ |

> **Note**: RestaPro requires the **TastyIgniter Cart** extension (`igniter/cart`) to be installed and active for the menu item linking feature.

---

## 🚀 Installation

### Option A — Via Composer (Recommended)

1. Open a terminal in your TastyIgniter project root directory.

2. Run the following command:

```bash
composer require paolorox/ti-ext-restapro
```

3. Run the database migrations:

```bash
php artisan igniter:up
```

4. Clear the application cache:

```bash
php artisan cache:clear
```

5. Done! Navigate to **Admin → Production** in the TastyIgniter admin panel.

---

### Option B — Manual Installation

1. **Download** the latest release from [GitHub](https://github.com/Paolorox/ti-ext-restapro/releases) or clone the repository:

```bash
git clone https://github.com/Paolorox/ti-ext-restapro.git
```

2. **Copy** the extension folder to your TastyIgniter extensions directory:

```
your-tastyigniter/extensions/paolorox/restapro/
```

The final structure should be:

```
extensions/
└── paolorox/
    └── restapro/
        ├── composer.json
        ├── database/
        ├── language/
        ├── resources/
        └── src/
```

3. **Register** the extension in your TastyIgniter `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "Paolorox\\Restapro\\": "extensions/paolorox/restapro/src/"
        }
    }
}
```

4. **Regenerate** the autoloader:

```bash
composer dump-autoload
```

5. **Run migrations**:

```bash
php artisan igniter:up
```

6. **Clear cache**:

```bash
php artisan cache:clear
```

7. Done! Navigate to **Admin → Production** in the admin panel.

---

## ⚙️ Post-Installation Setup

After installation, follow these steps to configure RestaPro for your restaurant. This is the **recommended order**:

### Step 1 — Units of Measurement

Navigate to **Production → Units** and create your base measurement units:

| Unit | Abbreviation | Type | Conversion Factor |
|---|---|---|---|
| Kilogram | kg | Weight | 1 |
| Gram | g | Weight | 0.001 |
| Liter | L | Volume | 1 |
| Milliliter | mL | Volume | 0.001 |
| Piece | pz | Piece | 1 |

> **Important**: Base units (kg, L, piece) must have a conversion factor of **1**. Derived units are relative to the base (e.g., 1g = 0.001 kg).

### Step 2 — Categories

Navigate to **Production → Categories** and create ingredient categories:

Examples: `Dairy`, `Vegetables`, `Meat`, `Fish`, `Spices`, `Flour & Starches`, `Oils & Fats`

### Step 3 — Suppliers

Navigate to **Production → Suppliers** and register your food providers:

- Company name
- Contact person
- Email, phone, address
- Notes

### Step 4 — Ingredients

Navigate to **Production → Ingredients** and register your raw materials:

- **Name**: Ingredient name (e.g., "Mozzarella Fior di Latte")
- **SKU**: Optional product code for matching with supplier catalogs
- **Base Unit**: The unit this ingredient is stored in (e.g., kg)
- **Category**: For filtering and organization
- **Primary Supplier**: Default supplier for this ingredient
- **Minimum Stock**: Set an alert threshold (e.g., 2 kg)

### Step 5 — Recipes

Navigate to **Production → Recipes** and create your recipes:

1. Choose **Type**: "Menu Item" (linked to TI menu) or "Sub-Recipe" (semi-finished)
2. If "Menu Item", select the **Linked Menu Item** from TastyIgniter
3. Set **Yield Amount** and **Yield Unit** (e.g., 4 portions)
4. Set **Target Food Cost %** (industry standard: 28-35%)
5. In the **Ingredients** tab, add ingredients with quantities and units
6. Save — the cost is calculated automatically!

### Step 6 — First Purchase Order

Navigate to **Production → Purchase Orders**:

1. Create a new order with your supplier
2. Add items with quantities, unit costs, and units
3. Click **Mark as Received** → Stock is loaded automatically!

### Step 7 — Verify

Navigate to **Production → Dashboard** and check:

- ✅ Ingredient and recipe counts
- ✅ Inventory value
- ✅ Low stock alerts
- ✅ Food cost analysis

---

## 🌍 Multi-Language Support

RestaPro supports multiple languages out of the box:

| Language | Status |
|---|---|
| 🇬🇧 English | ✅ Complete |
| 🇮🇹 Italian | ✅ Complete |

### Adding a New Language

1. Copy the `language/en/` folder to `language/{locale}/` (e.g., `language/fr/`)
2. Copy the `resources/lang/en/` folder to `resources/lang/{locale}/`
3. Translate all strings in both `default.php` files
4. Both files must contain the **same set of keys**

---

## 💱 Multi-Currency

The currency symbol is configured via language files. To change it:

1. Open `language/{locale}/default.php`
2. Find the key `'currency_symbol'`
3. Change the value to your currency symbol (e.g., `$`, `£`, `¥`)
4. Repeat for `resources/lang/{locale}/default.php`

---

## 🔒 Permissions

RestaPro registers the following permissions for role-based access control:

| Permission | Description |
|---|---|
| `Paolorox.Restapro.Dashboard` | View production dashboard |
| `Paolorox.Restapro.ManageIngredients` | Create, edit and delete ingredients |
| `Paolorox.Restapro.ManageRecipes` | Create, edit and delete recipes |
| `Paolorox.Restapro.ManageSuppliers` | Create, edit and delete suppliers |
| `Paolorox.Restapro.ManagePurchaseOrders` | Create and manage purchase orders |
| `Paolorox.Restapro.ViewStockMovements` | View stock movement history |
| `Paolorox.Restapro.ManageCategories` | Manage ingredient categories |
| `Paolorox.Restapro.ManageUnits` | Manage units of measurement |
| `Paolorox.Restapro.ViewInfo` | View info and user guide |

Assign permissions in **Admin → Staff → Roles**.

---

## 🗄️ Database Tables

RestaPro creates the following tables (all prefixed with `fc_`):

| Table | Description |
|---|---|
| `fc_units` | Units of measurement with conversion factors |
| `fc_categories` | Ingredient categories |
| `fc_suppliers` | Supplier registry |
| `fc_ingredients` | Ingredients with stock, costs, and alerts |
| `fc_recipes` | Recipes linked to menu items |
| `fc_recipe_ingredients` | Recipe ingredient lines (supports sub-recipes) |
| `fc_stock_movements` | Full stock movement audit trail |
| `fc_purchase_orders` | Purchase orders with workflow status |
| `fc_purchase_order_items` | Purchase order line items |

---

## 🔄 Automatic Stock Deduction

RestaPro listens for the `admin.order.paymentProcessed` event. When a customer order is paid:

1. The system finds recipes linked to the ordered menu items
2. Sub-recipes are recursively "exploded" into base ingredients
3. Units are automatically converted as needed
4. Stock is deducted and sale-type movements are recorded
5. The process is **idempotent** — duplicate events are safely ignored

> **No configuration needed** — this feature works automatically once recipes are linked to menu items.

---

## 🛠️ Troubleshooting

### Extension doesn't appear in the admin menu

```bash
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Tables not created

```bash
php artisan igniter:up
```

If issues persist, check that all 9 migration files exist in `database/migrations/`.

### Stock not deducting on orders

1. Verify the recipe is **active** (`is_active = true`)
2. Verify the recipe **type** is "Menu Item"
3. Verify the recipe has a **linked menu item** (`menu_id` is set)
4. Check Laravel logs: `storage/logs/laravel.log` for `[RestaPro]` entries

### Food cost showing as "N/A"

- Ensure the recipe is linked to a menu item with a price > 0
- Ensure ingredients have an `average_cost` > 0 (created via purchase orders)

---

## 📝 Uninstalling

1. Remove the extension:

```bash
composer remove paolorox/ti-ext-restapro
```

2. Drop the database tables (optional):

```sql
DROP TABLE IF EXISTS fc_purchase_order_items;
DROP TABLE IF EXISTS fc_purchase_orders;
DROP TABLE IF EXISTS fc_stock_movements;
DROP TABLE IF EXISTS fc_recipe_ingredients;
DROP TABLE IF EXISTS fc_recipes;
DROP TABLE IF EXISTS fc_ingredients;
DROP TABLE IF EXISTS fc_suppliers;
DROP TABLE IF EXISTS fc_categories;
DROP TABLE IF EXISTS fc_units;
```

3. Clear cache:

```bash
php artisan cache:clear
```

---

## 📄 License

GPL-3.0-or-later — See [LICENSE](LICENSE) for details.

## 🤝 Contributing

Pull requests are welcome! Please open an issue first to discuss proposed changes.

## 📧 Support

- **Issues**: [GitHub Issues](https://github.com/Paolorox/ti-ext-restapro/issues)
- **Author**: [Paolorox](https://github.com/Paolorox)
