# CampusMarket

🔗 **Live View:** https://campus-market.nfy.fyi/campus-market

📦 **GitHub Repository:** [https://github.com/RommJames/campus-market](https://github.com/RommJames/campus-market)

A web-based marketplace built exclusively for students within a school or university. CampusMarket lets students buy, sell, rent, and exchange academic materials, entertainment & media equipment, and creative services — all in one centralized, searchable platform instead of scattered social media posts and bulletin boards.

## Features

### Student

- Register / Login / Logout (secure password hashing)
- Manage profile (name, student ID, contact number)
- Post, edit, and delete product listings (for sale or for rent)
- Upload product images
- Browse and search products by keyword and category
- Save products to Favorites
- Offer creative services (photography, video editing, design, music production, etc.)
- Manage your own service listings
- Browse the Creative Services directory

### Administrator

- Login (separate from student accounts)
- Dashboard with marketplace statistics
- Manage users (search, view, delete)
- Manage all product listings (moderate/remove)
- Manage all service listings (moderate/remove)
- Manage categories (add/delete)
- View reports: products by category, products by status, sale vs. rental split, top sellers

## Tech Stack

- **Backend:** PHP (vanilla, PDO for database access)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3 (Bootstrap 5), vanilla JavaScript
- **Local server:** XAMPP (Apache + MySQL)

## Folder Structure

```
campus-market/
├── admin/              # Admin panel pages
├── auth/                # Register, login, logout
├── assets/css/          # Stylesheets
├── config/              # Database connection
├── includes/            # Shared header/footer/helpers, access guards
├── sql/                 # Database schema and sample data
├── student/             # Student-facing pages
├── uploads/              # Uploaded product images
└── index.php             # Landing page
```

## Deployment

This project can also be hosted online for free (e.g. on InfinityFree). See `DEPLOYMENT.md` for step-by-step instructions, including how to update `config/database.php` with your live database credentials.

## Notes

CampusMarket is a discovery and coordination platform — students place a listing or find one they want, and coordinate the actual exchange (payment, meetup, delivery) directly with each other. No in-app payment processing is included in this version.

## Team / Project Info

Final Project — Web Application using PHP and MySQL.
