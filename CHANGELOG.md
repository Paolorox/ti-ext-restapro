# Changelog

All notable changes to this extension are documented in this file.
The format is based on Keep a Changelog and this project adheres to Semantic Versioning.

## [1.1.0] 2026-07-12

### Added
- Ingredient expiry tracking with the `expiry_date` and `expiry_alert_days` fields, `expiringSoon` and `expired` Eloquent scopes, a dedicated dashboard widget and summary cards on the dashboard.
- Processing yield per ingredient (`yield_percentage`) applied to both automatic stock deduction on orders and the availability preview.
- Automatic stock restoration when an order is cancelled, recorded as a return movement and guarded for idempotency to avoid duplicate restores.
- Manual stock movements with a full create and edit form on the Stock Movements controller, plus quick waste and adjustment entry from the ingredient screen.
- CSV export for ingredients and stock movements.
- Real-time margin analysis tab on the recipe, comparing actual food cost against the target.
- New tabs on the ingredient screen: movement history with a cost trend chart, and linked recipes.
- Related tabs on categories, units and suppliers to view linked ingredients and purchase orders.
- In-app Changelog page in the admin area.

### Changed
- Reworked dashboard interface with a new layout and components.
- License reported consistently as GPL-3.0-or-later, including the Info page.

### Fixed
- Enabled timestamp recording on stock movements.
- Normalised movement unit cost to zero when left empty.
- Fixed primary key and ingredient attribute references in the related tabs, which returned empty tables.
- Fixed the query for recipes linked to an ingredient, which relied on a non-existent relation.
- Aligned missing translation keys in Italian and English.

## [1.0.0] 2026-07-10

### Added
- First release with the core entities: ingredients, recipes, suppliers, purchase orders, categories and units.
- Food cost calculation with weighted average cost and recursive propagation across sub-recipes.
- Automatic ingredient deduction on order confirmation through TastyIgniter core events.
- Low stock and food cost over-target alerts on the dashboard.

[1.1.0]: https://github.com/Paolorox/ti-ext-restapro/releases/tag/v1.1.0
[1.0.0]: https://github.com/Paolorox/ti-ext-restapro/releases/tag/v1.0.0
