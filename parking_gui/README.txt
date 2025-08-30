
# EWU Parking Space Management — PHP GUI

## How to run locally (XAMPP/WAMP/LAMP)

1. Start Apache + MySQL.
2. In phpMyAdmin, create database `ewu_parking_space_management` and import your schema.
3. Copy the `parking_gui` folder to your web root:
   - Windows (XAMPP): `C:\xampp\htdocs\parking_gui`
   - Linux (LAMP): `/var/www/html/parking_gui` or `/opt/lampp/htdocs/parking_gui`
4. Edit `db.php` only if your MySQL username/password differ.
5. Open your browser at: `http://localhost/parking_gui/index.php`

This GUI supports listing + creating + deleting for:
- user
- vehicle (with user/admin dropdowns)
- parkingslot (with admin dropdown)
- reservation (with user/vehicle/slot/admin dropdowns)
- admin (optional link to user, BCRYPT password hashing)
- adminlog

Security note: This is a minimal admin interface for local use. For production, add authentication and CSRF protection, validations, and more granular permissions.
