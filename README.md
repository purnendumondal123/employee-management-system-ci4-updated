
# Employee Management System (CodeIgniter 4)

A complete Employee Management System built with CodeIgniter 4. The application includes user authentication, email OTP verification, employee management, role-based access control, and AJAX-powered DataTables.

---

## Features

- User Registration
- Email OTP Verification
- User Login & Logout
- Forgot Password & Password Reset
- Employee CRUD (Create, Read, Update, Delete)
- AJAX DataTables with Server-side Processing
- Search, Sorting & Pagination
- Role-based Access Control (Admin/User)
- Profile Management
- Image Upload
- Password Hashing
- Session Management
- Form Validation

---

## Technologies Used

- PHP 8.2
- CodeIgniter 4
- MySQL
- Bootstrap 5
- jQuery
- AJAX
- DataTables

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/purnendumondal123/employee-management-system-ci4-updated.git
```

### 2. Install dependencies

```bash
composer install
```

### 3. Create the environment file

Copy the `env` file and rename it to `.env`.

### 4. Configure your database

Update the database credentials inside the `.env` file.

### 5. Run database migrations

```bash
php spark migrate
```

### 6. Create the default admin account

```bash
php spark db:seed AdminSeeder
```

### Default Admin Credentials

**Email**

```
admin@example.com
```

**Password**

```
Admin@123
```

> Running the `AdminSeeder` will create a default administrator account with full system access.

### 7. Start the development server

```bash
php spark serve
```

---

## Project Modules

- Authentication
- Email OTP Verification
- Employee Management
- AJAX DataTables
- Profile Management
- Role Management
- Dashboard

---

## Project Structure

```
app/
├── Controllers/
├── Models/
├── Views/
├── Database/
│   ├── Migrations/
│   └── Seeds/
└── Config/
```

---

## Latest Updates

This project has been updated to address the review feedback and improve the overall functionality.

### Fixed & Improved

- Added proper frontend and backend validation for Joining Date and Date of Birth.
- Fixed the photo upload logic to prevent false success messages when no image is selected.
- Removed the unnecessary "Action" column from CSV exports.
- Added Employee Edit functionality for Admin users.
- Added default Admin credentials in the README.
- Integrated jQuery DataTables with server-side processing.
- Improved project documentation and installation guide.
- Fixed validation issues and other minor bugs.

## Author

**Purnendu Mondal**
https://github.com/purnendumondal123

## project repository
GitHub: https://github.com/purnendumondal123/employee-management-system-ci4-updated