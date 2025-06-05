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

---

During the session, please explain your thought process as you refactor. Focus on the "why" behind your decisions, not just the "what." Good Luck!
