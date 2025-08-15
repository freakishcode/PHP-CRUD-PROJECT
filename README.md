# PHP-CRUD-PROJECT

CRUD project using PHP only
PHP Login Page, and Registration Form (MySQL –Rest API)

This project is a full-stack authentication system built with **HTML, CSS & Javascript** (frontend) and **PHP** (backend), using **MySQL** for data storage. It demonstrates how to create a modern, secure login and registration flow with RESTful APIs.

---

## Features

- User registration and login with Vanilla Method
- Secure password hashing and validation
- Protected routes and user profile display
- RESTful API built with PHP and MySQL

---

## Dependencies

**Frontend:**

- HTML
- CSS
- Java Script

**Backend:**

- PHP
- MySQL

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/Login-Register-php.git
cd react-php-auth
```

### 2. Set up the MySQL database

```sql
CREATE DATABASE studentPortalDB;

USE studentPortalDB;

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `ProfilePicture` varchar(500) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `faculty_dept` varchar(400) NOT NULL,
  `JAMB_reg_no` varchar(100) NOT NULL,
  `phone_no` int(25) NOT NULL,
  `date_of_birth` varchar(200) NOT NULL,
  `state_of_origin` varchar(100) NOT NULL,
  `LGA` varchar(300) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course_of_choice` varchar(300) NOT NULL
)

```

### 3. Configure your PHP backend

Edit `PHP/DATABASE_configuration/Database_for_student.php` with your database credentials.

## 4. How It Works

- **Registration:** User signs up, password is hashed, and a JWT token is returned.
- **Login:** User logs in, credentials are verified, and a JWT token is returned.
- **Protected Routes:** JWT token is sent with requests to access protected data.
- **Logout:** JWT is removed from client storage.

---

## Security Notes

- Always use environment variables for secrets.
- Never commit sensitive credentials to version control.
- Use HTTPS in production.
