<?php
require '../vendor/autoload.php';
require '../classes/TwitterRequest.php';
require '../classes/HPESentimentWrapper.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
));

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('wildTweets');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("Slim-Skeleton '/' route");
    // Render index view
    $app->render('index.html');
});



$app->get('/twitterTest', function () use ($app) {


    $query = 'https://google.com';
    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, $query);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);
    echo json_encode($output);

});

$app->get('/sentimentTest', function () use ($app) {

    $HPE = new HPESentimentWrapper();

    $vala = $HPE->GetSentimentValue("I really fucking hate my mother");
    $valb = $HPE->GetSentimentValue("I really love my mother");
    echo $vala. " " . $valb . "<br>".($vala+$valb)/2;

});



// Run app
$app->run();
