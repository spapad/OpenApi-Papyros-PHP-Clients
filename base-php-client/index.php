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

/**
 * Λήψη παραμέτρων καθορισμού λειτουργίας από τη γραμμή εντολών 
 * v = verbose output
 * i = incoming file type
 * o = outgoing file type
 */
$options = getopt('vio', ['send:', 'list', 'listshow', 'show:', 'get:', 'save:']);

$send = isset($options['send']);
$list = isset($options['list']) || isset($options['listshow']);
$listdetails = isset($options['listshow']);
$show = isset($options['show']);
$get = isset($options['get']) || isset($options['save']);
$save = isset($options['save']);
$incoming_only = isset($options['i']);
$outgoing_only = isset($options['o']);

/**
 * Αρχικοποίηση εφαρμογής 
 */
$app = new App($settings);
$app->setDebug(isset($options['v']));

/**
 * Έλεγχος παραμέτρων
 */
if (!$send && !$list && !$show && !$get) {
    echo "Χρήση: {$argv[0]} [-v] [--list] [--listshow] [-i|-o] [--send <file>] [--show <hashid>] [--get <hashid>] [--save <hashid>]", PHP_EOL,
    "            v: παραγωγή μηνυμάτων παρακολούθησης εκτέλεσης", PHP_EOL,
    "         list: λίστα hashids των εγγράφων (των τελευταίων 5 ημερών)", PHP_EOL,
    "     listshow: λίστα αρχείων (των τελευταίων 5 ημερών)", PHP_EOL,
    "            i: να συμπεριληφθούν μόνο τα εισερχόμενα στη λίστα αρχείων", PHP_EOL,
    "            ο: να συμπεριληφθούν μόνο τα εξερχόμενα στη λίστα αρχείων", PHP_EOL,
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

/**
 * Αποστολή αρχείου για πρωτοκόλληση
 */
if ($send) {
    echo "Αποστολή εγγράφου...", PHP_EOL;
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

    try {
        // καθορισμός παραμέτρων σε πίνακα για απλοποίηση 
        $submission_data = [
            'theme' => 'ΔΟΚΙΜΗ: Αυτοματοποιημένο κείμενο της ' . date('c'),
            'description' => 'ΔΟΚΙΜΗ: Αυτοματοποιημένο κείμενο περιγραφής ' . date('Ymdhmi'),
            'docCategory' => 20,
            'mainDoc' => [
                'document' => [
                    "base64" => $file
                ],
                'fileName' => $options['send'],
                'description' => "ΔΟΚΙΜΗ: Αποστολή δοκιμαστικού αρχείου {$options['send']}"
            ]
            // το παράδειγμα δεν περιλαμβάνει συνημμένα αρχεία 
            // και ορισμένες επιπλέον παραμέτρους 
            // senderId, senderProtocol, senderProtocolDate, ada, attachedDoc[]
        ];

        $doc_info = $app->postProtocol($submission_data, $apikey);
        echo "Η αποστολή ολοκληρώθηκε με ΑΡ.Π.: ", $doc_info["protocolNumber"], PHP_EOL;
        echo "Αναλυτικά: ", print_r($doc_info, true), PHP_EOL;
    } catch (\Exception $e) {
        echo 'ΛΑΘΟΣ: Αδυναμία αποστολής εγγράφου. ', PHP_EOL, $e->getMessage(), PHP_EOL;
        exit(1);
    }
}

/**
 * Λειτουργία λήψης λίστας των καταχωρημένων πρωτοκόλλων.
 * Εάν έχει ζητηθεί επιστρέφονται και οι αναλυτικές πληροφορίες των εγγράφων. 
 */
if ($list) {
    echo "Ανάκτηση λίστας εγγράφων...", PHP_EOL;
    try {
        $now = date(DATE_W3C);
        $fivedaysbefore = date(DATE_W3C, mktime(0, 0, 0, date("m"), date("d") - 5, date("Y")));
        $doc_type = ($incoming_only ? App::DOCUMENT_INCOMING : null);
        $doc_type = ($incoming_only ? App::DOCUMENT_OUTGOING : $doc_type);

        $doc_hash_ids = $app->searchDocuments(null, $fivedaysbefore, $now, $doc_type, $apikey);
        if ($listdetails) {
            $doc_details = array_map(function ($hashid) use ($app, $apikey) {
                try {
                    $details = $app->getDocData($hashid, $apikey);
                } catch (Exception $ex) {
                    return [
                        'id' => $hashid,
                        'error' => $ex->getCode()
                    ];
                }
                return $details;
            }, $doc_hash_ids);
            echo "Λεπτομέρειες εγγράφων: ", PHP_EOL, print_r($doc_details, true), PHP_EOL;
        } else {
            echo "Λίστα εγγράφων: ", PHP_EOL, implode(PHP_EOL, $doc_hash_ids), PHP_EOL;
        }
    } catch (\Exception $e) {
        echo 'ΛΑΘΟΣ: Αδυναμία ανάκτησης λίστας εγγράφων. ', PHP_EOL, $e->getMessage(), PHP_EOL;
        exit(1);
    }
}

/**
 * Λειτουργία ανάκτησης πληροφοριών αρχείου με δεδομένο hash id $options['show']
 */
if ($show) {
    try {
        $doc_details = $app->getDocData($options['show'], $apikey);
        echo "Λεπτομέρειες εγγράφου: ", PHP_EOL, print_r($doc_details, true), PHP_EOL;
    } catch (\Exception $e) {
        echo 'ΛΑΘΟΣ: Αδυναμία ανάκτησης λεπτομερειών εγγράφων. ', PHP_EOL, $e->getMessage(), PHP_EOL;
        exit(1);
    }
}

/**
 * Λειτουργία λήψης αρχείου με δεδομένο hash id $options['save'] ή $options['get']
 */
if ($get) {
    if ($save) {
        $doc_details = $app->savePdf($options['save'], $apikey);
        echo "Λεπτομέρειες αποθήκευσης εγγράφου: ", PHP_EOL, print_r($doc_details, true), PHP_EOL;
    } else {
        $doc_details = $app->getPdf($options['get'], $apikey);
        echo "Λεπτομέρειες εγγράφου: ", PHP_EOL, print_r($doc_details, true), PHP_EOL;
    }
}

echo "Done.", PHP_EOL;
exit(0);
