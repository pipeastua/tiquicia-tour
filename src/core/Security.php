<?php

class Security
{
    public static function generateCSRFToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken(string $token): bool
    {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        return true;
    }

    public static function sanitizeOutput(string $output): string
    {
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeInput(string $input): string
    {
        return trim(strip_tags($input));
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword(string $password): bool
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password);
    }

    public static function checkRateLimit(string $action, int $maxAttempts = 5, int $timeWindow = 300): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
        $key = $action . '_' . $ip;

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'time' => time()];
        }

        // Reset si ha pasado el tiempo
        if (time() - $_SESSION[$key]['time'] > $timeWindow) {
            $_SESSION[$key] = ['count' => 0, 'time' => time()];
        }

        $_SESSION[$key]['count']++;

        return $_SESSION[$key]['count'] <= $maxAttempts;
    }
}
