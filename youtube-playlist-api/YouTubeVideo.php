<?php
class YouTubeVideo
{
    // video id
    public $id;

    // generate at https://console.developers.google.com/apis
    public $apiKey;

    // google youtube service
    private $youtube;

    public function __construct($api)
    {
        $this->apiKey = $api;
        $client = new Google\Client();
        $client->setDeveloperKey($this->apiKey);
        $this->youtube = new Google_Service_YouTube($client);

    }
    /*
     * @return Google_Service_YouTube_VideoStatistics
     * Google_Service_YouTube_VideoStatistics Object ( [commentCount] => 0 [dislikeCount] => 0 [favoriteCount] => 0 [likeCount] => 0 [viewCount] => 5 )  
     */
    public function getStatistics($id)
    {
        $this->id = $id;
        try{
            // Call the API's videos.list method to retrieve the video resource.
            $response = $this->youtube->videos->listVideos("statistics",
                array('id' => $this->id));
            
            $googleService = current($response->items);
            if($googleService instanceof Google_Service_YouTube_Video) {
                return $googleService->getStatistics();
            }
        } catch (Google_Service_Exception $e) {
            return sprintf('<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
        } catch (Google_Exception $e) {
            return sprintf('<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));
        }
    }
}