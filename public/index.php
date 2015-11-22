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


$app->get('/process/:keyword', function ($keyword) use ($app) {
    $twitter = new TwitterRequest();
    $tweets = $twitter->requestTweet('search/tweets', array('q' => "$keyword", 'result_type' => 'recent', 'count' => 20, 'filter' => 'retweets'));
    $sentimentAnalyzer = new HPESentimentWrapper();
    $sentimentAverage = $sentimentAnalyzer->GetSentimentAverageForTweets($tweets);
    echo $sentimentAverage;

});

$app->get('/twitterTest', function () use ($app) {

    $twitter = new TwitterRequest();
    $app->log->info(json_encode($twitter));
    $tweets = $twitter->requestTweet('search/tweets', array('q' => 'superbowl', 'result_type' => 'recent', 'count' => 2));

    echo json_encode($tweets);

});

$app->get('/sentimentTest', function () use ($app) {

    $HPE = new HPESentimentWrapper();

    $vala = $HPE->GetSentimentValue("I really fucking hate my mother");
    $valb = $HPE->GetSentimentValue("I really love my mother");
    echo $vala. " " . $valb . "<br>".($vala+$valb)/2;

});



// Run app
$app->run();
