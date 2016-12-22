<?php
$autoloader = require(__DIR__ . '/swagger-generated-php-client/SwaggerClient-php/vendor/autoload.php');

$autoloader->addPsr4('Gr\\Gov\\Minedu\\Osteam\\', __DIR__ . '/src/');
$autoloader->addPsr4('Swagger\\Client\\', __DIR__ . '/swagger-generated-php-client/SwaggerClient-php/lib/');

use Gr\Gov\Minedu\Osteam\App;
use Swagger\Client\Model\DocumentDto;
use Swagger\Client\Model\Document;

$settings = require(__DIR__ . '/settings.php');

$app = new App($settings);
$app->setDebug(true);

/**
 * Λήψη παραμέτρων καθορισμού λειτουργίας από τη γραμμή εντολών 
 */
$options = getopt('', ['send:', 'list', 'listshow', 'show:', 'get:', 'save:']); // s for send file, l for list protocols

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

/**
 * Αποστολή αρχείου για πρωτοκόλληση
 */
if ($send) {
    echo "Αποστολή εγγράφου...", PHP_EOL;
    try {
        $submission_data = [
            'theme' => 'ΔΟΚΙΜΗ: Αυτοματοποιημένο κείμενο της ' . date('c'),
            'description' => 'ΔΟΚΙΜΗ: Αυτοματοποιημένο κείμενο περιγραφής ' . date('Ymdhmi'),
            'doc_category' => 20,
            'main_doc' => new DocumentDto([
                'document' => new Document([
                    "base64" => $file
                    ]
                ),
                'file_name' => $options['send'],
                'description' => "ΔΟΚΙΜΗ: Αποστολή δοκιμαστικού αρχείου {$options['send']}"
                ]
            )
            // το παράδειγμα δεν περιλαμβάνει συνημμένα αρχεία 
            // και ορισμένες επιπλέον παραμέτρους 
        ];

        $doc_info = $app->submit($submission_data, $apikey);
        echo "Η αποστολή ολοκληρώθηκε με ΑΡ.Π.: ", $doc_info->getProtocolNumber(), PHP_EOL;
        echo "Αναλυτικά: ", print_r($app->apiResultObjAsArray($doc_info), true), PHP_EOL;
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
        $doc_hash_ids = $app->searchDocuments($apikey);
        if ($listdetails) {
            $doc_details = array_map(function ($hashid) use ($app, $apikey) {
                return [
                    $app->apiResultObjAsArray($app->getDocData($hashid, $apikey))
                ];
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
    $doc_details = $app->apiResultObjAsArray($app->getDocData($options['show'], $apikey));
    echo "Λεπτομέρειες εγγράφου: ", PHP_EOL, print_r($doc_details, true), PHP_EOL;
}

/**
 * Λειτουργία λήψης αρχείου με δεδομένο hash id $options['get']
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
