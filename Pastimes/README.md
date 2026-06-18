# Pastimes — Local Development

This project is a PHP/MySQL web app for a second-hand clothing marketplace.

Prerequisites
- XAMPP (Apache + MySQL + PHP) or similar LAMP/WAMP stack.
- PHP 8.x recommended.

Setup
1. Place the `Pastimes` folder inside your web server document root (e.g., `C:\xampp\htdocs\Pastimes`).
2. Import the database schema: open phpMyAdmin or use the MySQL CLI to import `database/ClothingStore.sql`.

   Using MySQL CLI (example):

```powershell
mysql -u root -p < database\ClothingStore.sql
```

3. Ensure file permissions allow Apache/PHP to read files.
4. Start Apache and MySQL services (via XAMPP control panel).
5. Open the app in your browser:

```
http://localhost/Pastimes/
```

- Notes
- Replace placeholder images in `images/design/` with your provided screenshots. Recommended filenames (place into `images/design/`):
   - `hero-1.jpg`, `hero-2.jpg`, `hero-3.jpg`, `hero-4.jpg` (homepage gallery)
   - `card-1.jpg`, `card-2.jpg`, `card-3.jpg` (product listing thumbnails)
   - `profile-default.jpg` (default avatar)
   If you place images with those names they will replace SVG placeholders automatically.
If you prefer to drop files in a staging folder and let the app import them, place your images into `assets_to_import/` (create in project root) and run:

```powershell
php scripts\import_images.php
```

The script will copy matching files into `images/design/` and print results.
- If you use a subdirectory other than `/Pastimes`, adjust absolute paths in `includes/header.php` and `includes/footer.php` or set up a virtual host.

Testing
- Manual: browse pages, create a test account, list an item via `sell.php`, add to cart, and test messages.
- Smoke test (CLI): a small smoke test is provided at `scripts/smokeTest.php` to verify DB connectivity and seeded accounts. Run from the project root with PHP:

```powershell
php scripts\smokeTest.php
```

- Automated: PHPUnit is not configured. If you want automated tests, I can add a basic PHPUnit scaffold.

Need help importing data or wiring the images? Tell me which images you want added and I will place them into `images/design/` with the correct names.

Admin Guide
-----------

This section describes the administrator workflows added to the app (manage listings and users) and how customers can edit their cart.

- Access the admin area: open `http://localhost/Pastimes/admin/login.php` and sign in with an admin account.
- Listing management (admin):
   - View listings: `admin/listings.php` — filter by status.
   - Add listing: `admin/add_listing.php` — create a new clothing item (uploads saved to `images/`).
   - Edit listing: `admin/edit_listing.php?clothingID=<id>` — change title, brand, price, status, or replace image.
   - Delete listing: use the Delete action in `admin/listings.php`.

- User management (admin):
   - View users: `admin/users.php`.
   - Add user: `admin/add_user.php` — create a user and set role (`customer`, `seller`, `admin`).
   - Edit user: `admin/edit_user.php?userID=<id>` — update name, email, username, role, status, and contact info.
   - Delete/suspend/verify: actions available in `admin/users.php`.

- Image uploads: use `admin/upload_images.php` to attach images to existing items; images are stored in the `images/` folder.

- Cart editing (customer):
   - Customers can increase/decrease quantities or remove items from `cart.php`.
   - Cart updates are handled via AJAX at `ajax/update-cart.php` and now update totals in-place without a full page reload (improved UX).

- Order communications (admin):
   - Admins can message buyers or sellers about specific orders from `admin/orders.php` using the "Message Buyer" and "Message Seller" actions.
   - Messages are composed in `admin/compose_message.php` and sent into the app's messaging system so recipients can reply.

   Additional notes
   ----------------
   - Admin-sent messages are currently stored with the app's messaging system; by design the admin sender is a system sender (default `0`). If you prefer messages to appear as coming from a real admin user account, I can create a seeded `admin` user and switch the sender to that `userID`.
   - Email/SMS notifications are not enabled by default. If you want notifications for new messages or orders, I can add SMTP-based email notifications (requires SMTP credentials).
   - Frontend: The cart now updates in-place; product listing `Add to Cart` buttons use AJAX in `js/main.js`.

   Final verification
   ------------------
   - I ran the provided smoke test (`scripts/smokeTest.php`) from the project root — it passed the checks for DB connectivity and seeded data.
   - Recommended manual checks after setup: login as admin, add/edit/delete listings and users, submit a seller listing via `sell.php`, add items to cart, update quantities/remove items in `cart.php`, and place a checkout to confirm orders are created and items marked sold.

Notes and troubleshooting
- The admin pages require a valid admin session (`$_SESSION['adminID']`). If you don't have an admin account, use `scripts/loadClothingStore.php` or import `database/ClothingStore.sql` which includes a seeded admin account.
- If you see permission or upload issues, ensure the web server user can write to the `images/` directory.

If you want, I can expand this into step-by-step screenshots, add role-based access controls, or add non-reloading cart UI updates.
