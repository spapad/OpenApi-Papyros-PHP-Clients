<?php
// barebone app - autoload classes from src/ dir
spl_autoload_register(function ($class_name) {
    $class_name_parts = explode('\\', $class_name);
    $class_filename = __DIR__ . '/src/' . end($class_name_parts) . '.php';
    if (file_exists($class_filename)) {
        include $class_filename;
        if (class_exists($class_name)) {
            return true;
        }
    }
    return false;
});

use Gr\Gov\Minedu\Osteam\App;

$settings = require(__DIR__ . '/settings.php');

$app = new App($settings);
$app->setDebug(true);

/**
 * Λήψη παραμέτρων καθορισμού λειτουργίας από τη γραμμή εντολών 
 */
$options = getopt('', ['send:', 'list', 'listshow', 'show:', 'get:', 'save:']);

$send = isset($options['send']);
$list = isset($options['list']) || isset($options['listshow']);
$listdetails = isset($options['listshow']);
$show = isset($options['show']);
$get = isset($options['get']) || isset($options['save']);
$save = isset($options['save']);

/**
 * Έλεγχος παραμέτρων
 */
if (!$send && !$list && !$show && !$get) {
    echo "Χρήση: {$argv[0]} [--list] [--listshow] [--send <file>] [--show <hashid>] [--get <hashid>] [--save <hashid>]", PHP_EOL,
    "         list: λίστα hashids των εγγράφων", PHP_EOL,
    "     listshow: λίστα αρχείων", PHP_EOL,
    "  send <file>: καταχώρηση πρωτοκόλλου με αποστολή του αρχείου file", PHP_EOL,
    "  show <hash>: αναλυτικές πληροφορίες αρχείου με δεδομένο hashid", PHP_EOL,
    "   get <hash>: λήψη  αρχείου με δεδομένο hashid", PHP_EOL,
    "  save <hash>: λήψη και αποθήκευση αρχείου με δεδομένο hashid", PHP_EOL,
    "               στον τρέχοντα φάκελο και με το όνομα αρχείου που επιστρέφεται", PHP_EOL,
    exit(0);
}
if ($send) {
    echo "Έλεγχος για το αρχείο {$options['send']}... ";
    if (is_readable($options['send'])) {
        $file = base64_encode(file_get_contents($options['send']));
        if ($file === false) {
            echo PHP_EOL, "ΛΑΘΟΣ: Αδυναμία κωδικοποίησης του αρχείου.", PHP_EOL;
        }
        echo "OK", PHP_EOL;
    } else {
        echo PHP_EOL, "ΛΑΘΟΣ: Το αρχείο δεν είναι αναγνώσιμο.", PHP_EOL;
        exit(-1);
    }
}

/**
 * If any work is to be done, an api key is required 
 */
echo "Ανάκτηση API key...", PHP_EOL;
try {
    $apikey = $app->getApiKey();
    echo "Το API key είναι: ", $apikey, PHP_EOL;
} catch (\Exception $e) {
    echo 'ΛΑΘΟΣ: Αδυναμία ανάκτησης API key. ', PHP_EOL, $e->getMessage(), PHP_EOL;
    exit(-1);
}

echo "Done.", PHP_EOL;
exit(0);
