<?php
class Localization {
    private static $strings = [];

    public static function load() {
        $lang = 'en'; // Default language
        if (isset($_SESSION['lang'])) {
            $lang = $_SESSION['lang'];
        } else if (isset($_GET['lang'])) {
            $lang = $_GET['lang'] === 'fr' ? 'fr' : 'en';
            $_SESSION['lang'] = $lang;
        }

        $lang_file = __DIR__ . "/../../lang/{$lang}.php";

        if (file_exists($lang_file)) {
            self::$strings = require $lang_file;
        } else {
            // Fallback to English if the language file doesn't exist
            self::$strings = require __DIR__ . '/../../lang/en.php';
        }
    }

    public static function get($key) {
        return self::$strings[$key] ?? $key; // Return the key itself if not found
    }
}
