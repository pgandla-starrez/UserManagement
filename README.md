# Refactor Legacy User Registration (30-40 Minutes)

## 1. Goal

In this 30-40 minute live coding session, you will be presented with a single PHP class (provided in a separate file, typically `UserManager.php` or similar) responsible for user registration and sending notifications. This class has several "code smells" and does not follow modern development best practices.

Your task is to refactor this class to improve its structure, readability, maintainability, and adherence to **SOLID** principles (especially the **Single Responsibility Principle**). If time permits, you should also consider how you would begin to add unit tests for the refactored components.

## 2. Prerequisites

Please ensure you have the following installed and ready on your machine before the session:

* **PHP:** A recent version (e.g., PHP 8.0+).
* **IDE:** Your preferred Integrated Development Environment (e.g., VS Code, PhpStorm).
* **Composer:** (Optional, but helpful if you decide to structure your solution with autoloading or pull in a testing framework snippet).
* **Laravel (Installation Tools):** (Optional, only if you plan to discuss or integrate within a Laravel context. For this exercise, a plain PHP solution is perfectly acceptable).
* **Basic Command Line / Terminal access.**

No specific framework (like a full Laravel installation) is strictly required to complete the core refactoring task for this exercise, but you can discuss how you might integrate your solution into a Laravel application if relevant.

## 3. Overview

The provided class, `UserManager`, handles user registration by saving user data to a file (simulating a database for simplicity) and then sending a welcome email and an admin notification. You will be given the PHP code for this class.

## 4. Your Task

1.  **Identify Code Smells:** Briefly discuss the issues you see in the `UserManager` class (e.g., SRP violations, mixed concerns, poor naming, magic strings, direct file manipulation, lack of dependency injection).
2.  **Refactor the Code:**
    * Apply **SOLID** principles (especially **Single Responsibility Principle**) and/or relevant design patterns to improve the class structure.
    * Separate concerns (e.g., validation, data persistence, notification sending).
    * Improve variable names and overall readability.
    * Consider how you would make dependencies (like email sending or data storage) more flexible and testable (e.g., through interfaces and dependency injection).
3.  **Maintain Functionality:** The core functionality (registering a user and attempting to send notifications) should remain the same.
4.  **Testing (If time permits):**
    * Discuss how you would write unit tests for the refactored components.
    * If you have time, write a simple unit test for one of the new classes you create (e.g., for the user data validation or the user creation logic). For this, you can assume a testing framework like PHPUnit is available, or just write a simple test assertion.

## 5. What to Focus On

* Your thought process and approach to refactoring.
* Clear separation of responsibilities.
* Improving code structure and readability.
* Making the code more testable.

## 6. What to Skip (Due to time constraints)

* Implementing actual database connections (the file-based simulation is fine).
* Implementing a full email sending library (simulated logging of email sending is fine).
* Building a complete application or UI around it.
* Perfecting every single line if it means not addressing the major structural issues.

---

During the session, please explain your thought process as you refactor. Good luck!
