<?php

$app->get('/ping', '\Gr\Gov\Minedu\Osteam\Slim\App:ping');
$app->get('/apikey', '\Gr\Gov\Minedu\Osteam\Slim\App:apiKey');
$app->get('/docdata/{hashid}[/{apikey}]', '\Gr\Gov\Minedu\Osteam\Slim\App:docData');
$app->get('/search[/{doc_type}]', '\Gr\Gov\Minedu\Osteam\Slim\App:searchDocuments');
$app->get('/pdf/download/{hashid}[/{apikey}]', '\Gr\Gov\Minedu\Osteam\Slim\App:pdfDownload');
$app->get('/pdf/{hashid}[/{apikey}]', '\Gr\Gov\Minedu\Osteam\Slim\App:pdfData');
$app->post('/protocol[/{apikey}]', '\Gr\Gov\Minedu\Osteam\Slim\App:postProtocol');

$app->any('/[{anythingelse}]', function ($request, $response, $args) {
    $this->logger->info("Void response, no action route was enabled");
    return $response->withJson([
                'message' => 'Δεν αναγνωρίστηκε το αίτημα σας',
                'in' => var_export($args, true)
                    ], 404
    );
});

