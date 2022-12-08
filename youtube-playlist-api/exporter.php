<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youtube Playlist Stats</title>
  <script type="text/javascript" src="xlsx.full.min.js"></script>
  <link rel="stylesheet" href="spinner.css" />
  <style>
    button{
      border: none;
      padding: 25px;
      border-radius: 2px;
      margin: 25px;
      color: #FFF;
      background: green;
      cursor: pointer;
    }
    .d-none{
      display: none !important;
    }
  </style>
</head>
<body>
  
<?php

function error($mssg){
  echo '<div class="error">'. $mssg .' <a href="index.php">go back</a></div>';
  exit();
}
$playlistId = '';
if(isset($_POST['url'])){
  $url = $_POST['url'];
  if(substr_count($url,'playlist?list=') > 0){
    $plid = explode('playlist?list=' , $url)[1];
  }else{
    error('Playlist url not valid');
  }
  
  if(strlen( $plid ) <= 8){
    error('Playlist url not valid');
  }
  $playlistId = $plid;
}else{
  error('Please provide a url');
}
echo '<p id="plid" style="display:none">' . $playlistId . '</p>';

?>

<div class="loading">
  

<div>
<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
   <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
</svg>

<p>جارى تحميل البيانات...</p>
</div>

</div>
<div class="btn-coint">
  <button onclick="ExportToExcel('xlsx')" style="margin: auto;display: block;margin-bottom: 20px;margin-top: 20px;">Export table to excel</button>
</div>
<div class="results">

    <table id="tbl_exporttable_to_xls" border="1">
      <thead>
          <th>العنوان</th>
          <th>الرابط</th>
          <th>التعليقات</th>
          <th>الإعجابات</th>
          <th>المشاهدات</th>
          <th>المشاهدات</th>
          <th></th>
      </thead>
      <tbody>

      </tbody>
    </table>

</div>

<div class="tokens"></div>

<script src="jquery-3.6.0.min.js"></script>
<script src="xlsx.full.min.js"></script>
    <script>

  $(document).ready(function(){

    var token = $(".tokens").text().trim();
    var pid = $("#plid").text().trim();


    function get_next_token(){
      token = $("#tbl_exporttable_to_xls tr:last-of-type td:last-of-type").text().trim();
      $(".next_token").text("");
      return token;
    }

    function get_playlist_items(token){
      $.ajax({
        url: 'takeaway.php',
        dataType: 'text',
        data: {token:token,playlistId:pid},
        method:"POST",
        success:function(t){
          $("#tbl_exporttable_to_xls tbody").append(t);
          token = get_next_token();
          if( token != '' ){
            get_playlist_items(token);
          }else{
            $(".btn-coint").removeClass("d-none");
            $(".loading").addClass("d-none");
          }
          
        }
      });
    }
    get_playlist_items(token);

  });

    function ExportToExcel(type, fn, dl) {
          var elt = document.getElementById('tbl_exporttable_to_xls');
          var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
          return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
            XLSX.writeFile(wb, fn || ('youtube_playlist_stats.' + (type || 'xlsx')));
        }
    </script>
</body>
</html>