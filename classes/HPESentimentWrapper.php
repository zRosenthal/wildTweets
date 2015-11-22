<?php
/**
 * Created by PhpStorm.
 * User: rosent76
 * Date: 11/21/15
 * Time: 7:54 PM
 */

class HPESentimentWrapper {

    const APIKEY = "83689e9e-10df-4519-a0bc-071a206dd25b";

    private function stripText($text)
    {
    }

    public function GetSentimentJson($text)
    {
        $correctText = str_replace(" ","+",$text);
        $correctText = preg_replace("/[^a-zA-Z0-9+]/", "", $correctText);
        $query = "https://api.havenondemand.com/1/api/sync/analyzesentiment/v1?text="
                    . $correctText . "&language=eng&apikey=" . self::APIKEY;

        echo $query . "<br>";
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

        return $output;
    }

    public function GetSentimentValue($text)
    {
        $json = json_decode(self::GetSentimentJson($text));
        echo json_encode($json) . "<br>";
        $aggregate = $json->aggregate;
        return json_encode($aggregate->score);
    }

    public function GetSentimentAverageForTweets($tweets)
    {
        $sum = 0;
        $size = sizeof($tweets);
        foreach($tweets as $twat)
        {
            try {
                $sentimentVal = self::GetSentimentValue($twat);
            }
            catch(Exception $e)
            {
                $sentimentVal = 0;
            }
            if($sentimentVal == 0)
            {
                $size = $size-1;
            }
            $sum = $sum + $sentimentVal;
        }
        return $sum/$size;
    }
}