<?php

$nextPageToken = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nextPageToken  = $_POST['token'];
    $playlistId     = $_POST['playlistId'];

}else{
    return '';
}

require_once 'vendor/autoload.php';
require_once 'YouTubeVideo.php';

$client = new Google\Client();
$api_key = ''; // provide api key here <<<<<<<
$client->setDeveloperKey($api_key);
$youtube = new Google_Service_YouTube($client);
$stats = new YouTubeVideo($api_key);


$data = [];

    $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
    'playlistId' => $playlistId,
    'maxResults' => 50,
    'pageToken' => $nextPageToken));

    /* echo '<pre>';
    print_r( $playlistItemsResponse ); */
    foreach ($playlistItemsResponse['items'] as $playlistItem) {

      $title = $playlistItem['snippet']['title'];
      $published = substr($playlistItem['snippet']['publishedAt'] , 0 , 10);
      $id = $playlistItem['snippet']['resourceId']['videoId'];
      if($title == 'Private video'){
        $likes = '';
        $views = '';
        $comments = '';
      }else{
        $comments = $stats->getStatistics($id)->commentCount;
        $likes = $stats->getStatistics($id)->likeCount;
        $views = $stats->getStatistics($id)->viewCount;
      }
      
      $data[] = [
        'title'     => $title,
        'link'      => 'https://www.youtube.com/watch?v=' . $id,
        'comments'  => $comments,
        'likes'     => $likes,
        'views'     => $views,
        'published' => $published
      ];
    }

    $nextPageToken = $playlistItemsResponse['nextPageToken'];


if(count($data) > 0){

   
      foreach($data as $row){
        ?>
          <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['link']; ?></td>
            <td><?php echo $row['comments']; ?></td>
            <td><?php echo $row['likes']; ?></td>
            <td><?php echo $row['views']; ?></td>
            <td><?php echo $row['published']; ?></td>
            <td class="next_token"><?php echo $nextPageToken; ?></td>
          </tr>
        <?php
      }
    

      ?>
      
      <?php
}



?>