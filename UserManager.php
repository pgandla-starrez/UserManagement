<?php

class UserManager
{

    public function registerUserAndNotify($usrData)
    {

        if (empty($usrData['email']) || empty($usrData['name']) || empty($usrData['pass'])) {
            error_log("REG_FAIL: Missing user data.");
            return false;
        }

        if (!filter_var($usrData['email'], FILTER_VALIDATE_EMAIL)) {
            error_log("REG_FAIL: Invalid email format for " . $usrData['email']);
            return false;
        }

        if (strlen($usrData['pass']) < 6) {
            error_log("REG_FAIL: Password too short for " . $usrData['email']);
            return false;
        }

        $processed_data_string = $usrData['name'] . ',' . $usrData['email'] . ',' . md5($usrData['pass']) . ',' . date('Y-m-d H:i:s') . PHP_EOL;

        $file = 'users.txt';
        $fHandle = fopen($file, 'a');
        if ($fHandle) {
            fwrite($fHandle, $processed_data_string);
            fclose($fHandle);

            error_log("REG_SUCCESS: User registered - " . $usrData['email']);
        } else {
            error_log("REG_FAIL: Could not open users file for writing.");
            return false;
        }

        $user_email_subject = "Welcome to OurPlatform!";
        $user_email_body = "Hi " . $usrData['name'] . ",\n\nWelcome! We are glad to have you.\n\nYour account details:\nEmail: " . $usrData['email'] . "\nRegistered: " . date('Y-m-d H:i:s');

        error_log("EMAIL_SENT: Welcome email to " . $usrData['email'] . " with subject: " . $user_email_subject);

        $admin_email = "admin@ourplatform.com";
        $admin_email_subject = "New User Registration";
        $admin_email_body = "A new user has registered:\nName: " . $usrData['name'] . "\nEmail: " . $usrData['email'] . "\nTime: " . date('Y-m-d H:i:s');

        error_log("EMAIL_SENT: Admin notification for " . $usrData['email'] . " to " . $admin_email);

        $analytics_data = "USER_REG," . $usrData['email'] . "," . date('Y-m-d H:i:s');
        error_log("ANALYTICS: " . $analytics_data);

        return true;
    }


    public function checkUserExists($email)
    {
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
