<?php
$app->get('/ping', '\Gr\Gov\Minedu\Osteam\App:ping');
$app->get('/apikey', '\Gr\Gov\Minedu\Osteam\App:apiKey');
$app->get('/docdata/{hashid}[/{apikey}]', '\Gr\Gov\Minedu\Osteam\App:docData');
$app->get('/search[/{doc_type}]', '\Gr\Gov\Minedu\Osteam\App:searchDocuments');
$app->get('/pdf/download/{hashid}[/{apikey}]', '\Gr\Gov\Minedu\Osteam\App:pdfDownload');
$app->get('/pdf/{hashid}[/{apikey}]', '\Gr\Gov\Minedu\Osteam\App:pdfData');

$app->any('/[{anythingelse}]', function ($request, $response, $args) {
    $this->logger->info("Void response, no action route was enabled");
    return $response->withJson([
            'message' => 'Δεν αναγνωρίστηκε το αίτημα σας',
            'in' => var_export($args, true)
            ], 404
    );
});

