67319010092 — Full ready for XAMPP (PHP + MySQL)

Instructions:
1. Copy the folder `67319010092` into XAMPP htdocs: e.g. C:\xampp\htdocs\67319010092
2. Start Apache and MySQL in XAMPP Control Panel.
3. Create database `ohmza_db` in phpMyAdmin or let install_seed.php create tables.
   Recommended: import sql/schema.sql first (it creates DB and tables), then run install_seed.php once.
4. Open in browser: http://localhost/67319010092/
5. To populate sample data, open: http://localhost/67319010092/install_seed.php

Default credentials (after running install_seed.php):
- Admin: admin@example.com / 1234
- User: user@example.com / 1234

If you see "Seed already ran (users exist).", you can either clear tables in phpMyAdmin or delete users to rerun seed.
