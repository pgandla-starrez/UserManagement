# Refactor Legacy User Registration (30-40 Minutes)

## 1. Goal

In this live coding session, you will refactor the `UserManager` class found in `UserManager.php`. This class is responsible for user registration and sending notifications, but it has several "code smells" and does not follow modern development best practices.

Your task is to refactor this class to improve its structure, readability, maintainability, and adherence to **SOLID** principles (especially the **Single Responsibility Principle**). You must also address security concerns and demonstrate how you would make the code testable.

## 2. Prerequisites

Please ensure you have the following installed and ready on your machine before the session:

* **PHP:** A recent version (e.g., PHP 8.0+).
* **IDE:** Your preferred Integrated Development Environment (e.g., VS Code, PhpStorm).
* **Composer:** (Optional, but helpful if you decide to structure your solution with autoloading or pull in a testing framework snippet).
* **Laravel (Installation Tools):** (Optional, only if you plan to discuss or integrate within a Laravel context. For this exercise, a plain PHP solution is perfectly acceptable).
* **Basic Command Line / Terminal access.**

No specific framework (like a full Laravel installation) is strictly required to complete the core refactoring task for this exercise, but you can discuss how you might integrate your solution into a Laravel application if relevant.

## 3. Overview

The `UserManager` class handles user registration by saving user data to a file (simulating a database for simplicity) and then sending a welcome email and an admin notification. The class contains multiple code smells and security vulnerabilities that need to be addressed.

## 4. Your Task

### Core Requirements (Must Complete):

1. **Identify Code Smells & Security Issues:**
   - Discuss the structural issues you see in the `UserManager` class (e.g., SRP violations, mixed concerns, poor naming, magic strings, direct file manipulation, lack of dependency injection)
   - **Identify and address critical security vulnerabilities** (password hashing, input validation, file handling security)

2. **Refactor the Code:**
   - Apply **SOLID** principles (especially **Single Responsibility Principle**) and/or relevant design patterns to improve the class structure
   - Separate concerns (e.g., validation, data persistence, notification sending)
   - Improve variable names and overall readability
   - Implement proper dependency injection for testability
   - **Address security vulnerabilities with modern PHP security practices**

3. **Make Code Testable:**
   - Design your refactored classes to be easily unit testable
   - Create interfaces where appropriate to enable mocking
   - Demonstrate dependency injection for external dependencies

4. **Write Unit Tests:**
   - Write at least **2-3 unit tests** for your refactored components
   - Show how you would test different scenarios (success, validation failures, etc.)
   - Use PHPUnit syntax (you can assume PHPUnit is available)

### Bonus Points (If Time Permits):

- Use modern PHP 8+ features (typed properties, constructor promotion, enums, etc.)
- Implement design patterns (Strategy, Observer, Factory, etc.)
- Discuss PSR compliance (PSR-4 autoloading, PSR-12 coding standards)
- Error handling improvements with custom exceptions
- Logging abstraction

## 5. Expected Deliverables

By the end of the session, you should have created:

1. **Multiple PHP classes** that separate concerns:
   - A User entity/data class
   - A validation class or service
   - A data persistence class/interface
   - A notification service class/interface
   - A main service class that orchestrates the workflow

2. **Interfaces** for external dependencies (storage, email, etc.)

3. **Unit tests** demonstrating how to test your refactored components

4. **Brief explanation** of your design decisions and how they address the original problems

## 6. What to Focus On

### High Priority:
* **Security improvements** (proper password hashing, input sanitization)
* Clear separation of responsibilities following SOLID principles
* **Testable code design** with proper dependency injection
* Code structure and readability improvements

### Medium Priority:
* Modern PHP practices and features
* Error handling and logging improvements
* Performance considerations

## 7. What to Skip (Due to time constraints)

* Implementing actual database connections (the file-based simulation is fine for storage interface implementation)
* Implementing a full email sending library (simulated logging of email sending is fine)
* Building a complete application or UI around it
* Perfecting every single line if it means not addressing the major structural and security issues

## 8. Evaluation Criteria for Interviewers

### Code Smell Identification (20 points)
- **Excellent (18-20):** Identifies all major issues including SRP violations, tight coupling, security vulnerabilities, poor naming, magic strings, and lack of testability
- **Good (14-17):** Identifies most structural issues and at least one security concern
- **Fair (10-13):** Identifies basic structural problems but misses security issues
- **Poor (0-9):** Fails to identify key problems or focuses only on minor issues

### Security Awareness (20 points)
- **Excellent (18-20):** Addresses MD5 vulnerability, implements proper password hashing (bcrypt/Argon2), improves input validation, addresses file handling security
- **Good (14-17):** Identifies and fixes password hashing issue, addresses some other security concerns
- **Fair (10-13):** Recognizes security issues but provides incomplete solutions
- **Poor (0-9):** Ignores or fails to identify critical security vulnerabilities

### SOLID Principles Application (25 points)
- **Excellent (23-25):** Clearly separates responsibilities, uses dependency injection, creates appropriate interfaces, demonstrates strong OOP design
- **Good (18-22):** Good separation of concerns with some dependency injection
- **Fair (13-17):** Basic separation but still some mixed responsibilities
- **Poor (0-12):** Minimal improvement in class structure

### Code Quality & Modern PHP Practices (15 points)
- **Excellent (14-15):** Uses modern PHP features, follows PSR standards, excellent naming conventions, proper error handling
- **Good (11-13):** Good naming and structure, some modern PHP features
- **Fair (8-10):** Improved naming but limited use of modern practices
- **Poor (0-7):** Poor naming conventions, outdated PHP practices

### Testability & Testing (20 points)
- **Excellent (18-20):** Creates testable design with interfaces, writes comprehensive unit tests, demonstrates mocking understanding
- **Good (14-17):** Creates testable design and writes basic unit tests
- **Fair (10-13):** Understands testing concepts but limited implementation
- **Poor (0-9):** No consideration for testing or fails to write tests

### Overall Score Interpretation:
- **90-100:** Exceptional senior-level performance
- **75-89:** Strong senior-level performance
- **60-74:** Adequate senior-level performance with some gaps
- **Below 60:** Does not meet senior-level expectations

### Red Flags for Interviewers:
- Ignoring security vulnerabilities (especially password hashing)
- No understanding of dependency injection
- Cannot explain SOLID principles
- No consideration for testing
- Overly complex solutions that don't address core problems
- Cannot articulate design decisions

---

**For Candidates:** During the session, please explain your thought process as you refactor. Focus on the "why" behind your decisions, not just the "what."

**For Interviewers:** Pay attention to the candidate's problem-solving approach, communication skills, and ability to prioritize improvements. The quality of their reasoning is often more important than perfect implementation.
