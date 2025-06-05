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

        // Prepare data for storage
        $processed_data_string = $usrData['name'] . ',' . $usrData['email'] . ',' . md5($usrData['pass']) . PHP_EOL;

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
        $user_email_body = "Hi " . $usrData['name'] . ",\n\nWelcome! We are glad to have you.";
        // Simulate sending email
        // mail($usrData['email'], $user_email_subject, $user_email_body);
        error_log("EMAIL_SENT: Welcome email to " . $usrData['email'] . " with subject: " . $user_email_subject);


        // 2. Notification to admin
        $admin_email = "admin@ourplatform.com";
        $admin_email_subject = "New User Registration";
        $admin_email_body = "A new user has registered:\nName: " . $usrData['name'] . "\nEmail: " . $usrData['email'];
        // Simulate sending email
        // mail($admin_email, $admin_email_subject, $admin_email_body);
        error_log("EMAIL_SENT: Admin notification for " . $usrData['email'] . " to " . $admin_email);

        return true; // Indicate success
    }
}

// --- How the class might be used (for context only, not part of refactoring task itself) ---
/*
$manager = new UserManager();
$userData = [
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'pass' => 'password123'
];

if ($manager->registerUserAndNotify($userData)) {
    echo "User registration process completed successfully.\n";
} else {
    echo "User registration process failed.\n";
}

$invalidUserData = [
    'name' => 'Jane Doe',
    'email' => 'jane.doe', // Invalid email
    'pass' => 'password123'
];
if ($manager->registerUserAndNotify($invalidUserData)) {
    echo "User registration process completed successfully.\n";
} else {
    echo "User registration process failed.\n";
}
*/
?>
