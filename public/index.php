<?php
require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
));

// Create monolog logger and store logger in container as singleton 
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
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

$app->get('/app', function () use ($app) {

    //consumer key for twitter api
    $consumerKey = "gtLtHSelqhVRiO7v7vkSiLTUE";

    $encodedConsumerKey = urlencode($consumerKey);

    //consumer secret for twitter api
    $consumerSecret = "AeAANUAAY90B2iKGPg7uR8ChP9BBPpZAoX2Vten7bqLHWELqaF";

    $encodedConsumerSecret = urlencode($consumerSecret);

    $connection = new TwitterOAuth($consumerKey, $consumerSecret);
    $request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => "/twitter"));
    //callback is set to where the rest of the script is

    $oauth_token=$request_token['oauth_token'];
    $token_secret=$request_token['oauth_token_secret'];

    $app->log->info("Oath token: " .$oauth_token ."\n token_secret: " . $token_secret ."\n");

});


// Run app
$app->run();
