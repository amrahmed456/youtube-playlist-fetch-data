<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="jquery-3.6.0.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


  <title>Youtuble playlist exporter</title>
</head>
  <style>
    *{
      padding: 0;
      margin: 0;
    }
    body{background: #F5F5F5;}
    .container{
      width: 100%;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    .container .parent{
      min-width: 400px;
      box-shadow: 14px 17px 40px #E9E9E9;
      border-radius: 8px;
      padding: 45px 20px;
      background: #FFF;
    }
    @media(max-width:650px){
      .container .parent{
        min-width: 90% !important;
      }
    }
    h3{text-transform: uppercase;font-weight: bold;}
    .small{
      font-size: 15px;
      color: #555;
      margin-bottom: 35px;
    }
    input{
      display: block;
      margin: auto;
      width: 80%;
      padding: 15px;
      border: 1px solid #DBDBDB;
      box-shadow: inset 4px 4px 5px #EDECEC;
    }
    button{
      border: none;
      margin: 12px 0;
      width: 85%;
      padding: 12px;
      color: #FFF;
      background: #1b780d;
      cursor: pointer;
    }
    button:hover{
      background: #1a6c0e;
    }
    button:disabled{
      background: #6d6d6d;
    }
    .recap-container{
      overflow: hidden;
      margin: auto;
      margin-top: 15px;
    }
    .success{
      padding: 18px;
background: #C8FFC9;
border: 1px solid green;
    }
  </style>
<body>

<div class="container">
    <div class="parent">
      <h3>Get Youtube Playlist Stats</h3>
      <p class="small">paste a youtube playlist to start</p>
      <div class="success">your playlist xlsx file is downloading...</div>
      <form id="newsletterForm" action="exporter.php" method="POST">
        <input type="url" placeholder="playlist url..." name="url" required style="margin-bottom:7px" />
        <input type="password" placeholder="password" name="password" required />
        <div class="recap-container">
          <div class="g-recaptcha" data-sitekey="6LffQWIfAAAAAA21L5PcQ9YgbZla2hSubRsGDYaa"></div>
        </div>
        

        <button type="submit">Submit</button>

      </form>
      
    </div>
</div>

<script>
  $(".success").slideUp(0);
  var v = 0;

  $("form").on("submit" , function(e){
    
    if(v == 0){
      e.preventDefault();
      var response = grecaptcha.getResponse();

      if(response.length == 0){
      //reCaptcha not verified
      alert("Not Verified");
      }else{
        v = 1;
        //reCaptch verified
        $("button").attr("disabled" , true);
        $("form").submit();
        $(".success").slideDown();
        $("form").slideUp();

      }
    }
    
  })
</script>


</body>
</html>