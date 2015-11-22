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
    // Render index view
    $app->render('index.html');
});


$app->get('/process/:keyword/:count', function ($keyword, $count) use ($app) {
    $app->log->info("here");
    $twitter = new TwitterRequest();
    $tweets = $twitter->requestTweet('search/tweets', array('q' => "$keyword  -http -filter:retweets -filter:links -filter:replies -filter:images since:2015-11-17 until:2015-11-18 lang:en", 'result_type' => 'recent', 'count' => $count, 'exclude_replies' => true));
    $sentimentAnalyzer = new HPESentimentWrapper();
    $sentimentAverage = $sentimentAnalyzer->GetSentimentAverageForTweets($tweets);
    $app->log->info("sentimentDone: " .$sentimentAverage);
    echo $sentimentAverage;

});

// Run app
$app->run();
