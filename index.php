<!DOCTYPE html>
<html>
<head>
  <meta content="width=device-width,maximum-scale=1.0,initial-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
  <style>
  body {
    margin: 0;
    padding: 0;
  }

  .container {
    position: relative;
    width: 320px;
    height: 480px;
    background: url("bg.jpg");
    background-size: 320px 480px;
    background-repeat: no-repeat;
  }

  .gacha {
    position: absolute;
    bottom: 20px;
  }
  </style>
</head>
<body>
  <form method="post" enctype="multipart/form-data" action="gacha.php">
 		 <div class="container">
    			<input type="image" src="btn.png" class="gacha">
  		 </div>
  </form>
</body>
</html>
</html>
