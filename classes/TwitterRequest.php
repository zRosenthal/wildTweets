<?php
/**
 * Created by PhpStorm.
 * User: rosent76
 * Date: 11/21/15
 * Time: 5:38 PM
 */
require '../vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterRequest {

    //twitter auth keys
    const CONSUMER_KEY = "4eb9kZcRB4KZf9p6Pp4dxeN1W";
    const CONSUMER_SECRET = "xfTRGk2xK7y0QeQ9PjoCB6rTrBWgYpNQL2y9tTigetN1Ftsl4Y";

    private $connection;

    /**
     * intialize OAuth connection
     */
    public function __construct()
    {
        //create new OAuth connection
        $connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET);

        //get request token object
        $request_token = $connection->oauth2("oauth2/token", array("oauth_callback" => "http://wildTweets.dev/callback", "grant_type" =>"client_credentials"));

        //get OAuth token
        $oauth_token=$request_token->access_token;

        //set connection attribute
        $this->connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET, null, $oauth_token);
    }

    /**
     * @param $twitterObj
     * @return array
     *
     * Given json object returned by twitter api
     *
     * parses out text
     *
     * returns array of text from each tweet
     *
     * i.e array("this is a tweet", "this is another tweet")
     */
    function buildTweetArray($twitterObj) {

        $tweets = $twitterObj->statuses;

        $tweetArray = array();

        foreach ($tweets as $twats) {

            array_push($tweetArray, $twats->text);

        }

        return $tweetArray;

    }

    /**
     * @param $api
     * @param $args
     * @return array
     *
     * sends a request to a twitter api
     *
     * sends result object to buildTweet array
     *
     * to extrat the text
     */
    function requestTweet($api,$args)
    {
        $result = $this->connection->get($api, $args);

        $tweets = $this->buildTweetArray($result);

        return $tweets;
    }
}