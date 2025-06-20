# User Registration

## 1. UserManager Overview

### High-Level Flow

The current `UserManager` class implements the following user registration flow:

User Registration Request

1. Input Validation

   - Check for required fields (email, name, password)
   - Validate email format using FILTER_VALIDATE_EMAIL
   - Ensure password length ≥ 6 characters

1. Data Processing & Storage

   - Hash password using MD5
   - Format user data: "name,email,hashed_password,timestamp"
   - Append data to 'users.txt' file

1. Notification System

   - Send welcome email to user (simulated via error_log)
   - Send admin notification email (simulated via error_log)
   - Log analytics data for tracking

1. Return Success/Failure Status

### Additional Functionality

- **User Existence Check**: `checkUserExists($email)` method reads the users.txt file to verify if an email is already registered

## 1. Setup

Please ensure you have the following installed and ready on your machine before the session:
**PHP**
**Composer**
**Laravel**
