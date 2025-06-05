<?php

// LEGACY CODE - DO NOT USE IN PRODUCTION
// This class has intentional code smells for refactoring purposes.

class UserManager {

    // Simulates saving user to a database/file
    public function registerUserAndNotify($usrData) {
        // Validate user data (very basic)
        if (empty($usrData['email']) || empty($usrData['name']) || empty($usrData['pass'])) {
            error_log("REG_FAIL: Missing user data.");
            return false; // Indicate failure
        }

        if (!filter_var($usrData['email'], FILTER_VALIDATE_EMAIL)) {
            error_log("REG_FAIL: Invalid email format for " . $usrData['email']);
            return false; // Indicate failure
        }

        // Check password strength (weak validation)
        if (strlen($usrData['pass']) < 6) {
            error_log("REG_FAIL: Password too short for " . $usrData['email']);
            return false;
        }

        // Prepare data for storage (CSV format - potential injection risk)
        $processed_data_string = $usrData['name'] . ',' . $usrData['email'] . ',' . md5($usrData['pass']) . ',' . date('Y-m-d H:i:s') . PHP_EOL;

        // Simulate saving to a "database" (a text file)
        $file = 'users.txt';
        $fHandle = fopen($file, 'a');
        if ($fHandle) {
            fwrite($fHandle, $processed_data_string);
            fclose($fHandle);
            // Log success
            error_log("REG_SUCCESS: User registered - " . $usrData['email']);
        } else {
            error_log("REG_FAIL: Could not open users file for writing.");
            return false; // Indicate failure
        }

        // Send notifications
        // 1. Welcome email to user
        $user_email_subject = "Welcome to OurPlatform!";
        $user_email_body = "Hi " . $usrData['name'] . ",\n\nWelcome! We are glad to have you.\n\nYour account details:\nEmail: " . $usrData['email'] . "\nRegistered: " . date('Y-m-d H:i:s');
        // Simulate sending email
        // mail($usrData['email'], $user_email_subject, $user_email_body);
        error_log("EMAIL_SENT: Welcome email to " . $usrData['email'] . " with subject: " . $user_email_subject);

        // 2. Notification to admin
        $admin_email = "admin@ourplatform.com";
        $admin_email_subject = "New User Registration";
        $admin_email_body = "A new user has registered:\nName: " . $usrData['name'] . "\nEmail: " . $usrData['email'] . "\nTime: " . date('Y-m-d H:i:s');
        // Simulate sending email
        // mail($admin_email, $admin_email_subject, $admin_email_body);
        error_log("EMAIL_SENT: Admin notification for " . $usrData['email'] . " to " . $admin_email);

        // 3. Log to analytics (another responsibility)
        $analytics_data = "USER_REG," . $usrData['email'] . "," . date('Y-m-d H:i:s');
        error_log("ANALYTICS: " . $analytics_data);

        return true; // Indicate success
    }

    // Another method that also violates SRP
    public function checkUserExists($email) {
        $file = 'users.txt';
        if (!file_exists($file)) {
            return false;
        }

        $content = file_get_contents($file);
        $lines = explode(PHP_EOL, $content);

        foreach ($lines as $line) {
            $parts = explode(',', $line);
            if (isset($parts[1]) && $parts[1] === $email) {
                return true;
            }
        }

        return false;
    }
}

?>
