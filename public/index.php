<?php
require '../vendor/autoload.php';
require '../public/TwitterRequest.php';
require '../public/HPESentimentWrapper.php';

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

$app->get('/callback', function () use ($app) {

    $app->log->info("here");

});


$app->get('/app', function () use ($app) {

    $HPE = new HPESentimentWrapper();
    $vala = $HPE->GetSentimentValue("I really fucking hate my mother");
    $valb = $HPE->GetSentimentValue("I really love my mother");
    echo $vala. " " . $valb . "<br>".($vala+$valb)/2;
//    $twitter = new TwitterRequest();
//    $app->log->info(json_encode($twitter));
//    $return = $twitter->requestTweet('search/tweets', array('q' => 'superbowl', 'result_type' => 'recent'));
//    $app->log->info(json_encode($return));
});



// Run app
$app->run();
