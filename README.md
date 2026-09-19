# CampusMarket

📦 **GitHub Repository:** [https://github.com/RommJames/campus-market](https://github.com/RommJames/campus-market)

A web-based marketplace built exclusively for students within a school or university. CampusMarket lets students buy, sell, rent, and exchange academic materials, entertainment & media equipment, and creative services — all in one centralized, searchable platform instead of scattered social media posts and bulletin boards.

<img width="512" height="286" alt="admin reports" src="https://github.com/user-attachments/assets/986587a2-6c6e-44c1-90f2-efbf968bd04c" />
<img width="512" height="284" alt="admin manage user and products" src="https://github.com/user-attachments/assets/a24f4e1e-6145-406a-b793-50f821594d32" />
<img width="512" height="288" alt="admin dashboard" src="https://github.com/user-attachments/assets/b709b2f3-b509-4dd2-864f-f36a5ea6ef13" />
<img width="512" height="285" alt="student dashboard" src="https://github.com/user-attachments/assets/ed13925a-d993-472f-8fbe-187bb635ee43" />
<img width="512" height="284" alt="login_registration_page" src="https://github.com/user-attachments/assets/39ee7541-61eb-4421-8f8b-c035c237edf3" />
<img width="512" height="286" alt="creative and services directory" src="https://github.com/user-attachments/assets/139e8ceb-9390-4d51-895f-92abf6d130d8" />
<img width="512" height="287" alt="browse and search bar" src="https://github.com/user-attachments/assets/9cf9ce90-501d-4154-b958-747544d128c4" />
<img width="512" height="284" alt="product listing age" src="https://github.com/user-attachments/assets/59d65641-9492-4749-95c0-41d026ba4d16" />
<img width="512" height="284" alt="product details page" src="https://github.com/user-attachments/assets/a2cbf2dc-8826-4bff-a834-642e827a317c" />
<img width="512" height="285" alt="Favourite Page" src="https://github.com/user-attachments/assets/63260cd3-087b-4a36-845c-ecc6db3120c6" />

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

## Notes

CampusMarket is a discovery and coordination platform — students place a listing or find one they want, and coordinate the actual exchange (payment, meetup, delivery) directly with each other. No in-app payment processing is included in this version.

## Team / Project Info

Final Project — Web Application using PHP and MySQL.
