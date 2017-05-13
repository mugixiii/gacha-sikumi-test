<?php
// テキスト
$database = array();

function save_database($database) {
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["img"]["name"]);
	$file = fopen('database.csv', 'ab');

	$data = array(
		array('name' => $_POST['name'], 'ratio' => $_POST['ratio'], 'img' => $target_file),
	);
 	foreach ($data as $row) {fputcsv($file, $row);}
	fclose($file);
}

// 画像
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["img"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// 画像かどうか確認する
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["img"]["tmp_name"]);
		if($check !== false) {
			echo "このファイルは画像です。 - " . $check["mime"] . ".";
			$uploadOk = 1;
    		} else {
    		    echo "このファイルは画像じゃないです。";
    		    $uploadOk = 0;
    		}
	}

	// ファイルは既存かどうかを確認する
	if (file_exists($target_file)) {
	    echo "ファイルは既存です。";
	    $uploadOk = 0;
	}

	// 拡張子を制限する
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	    echo "JPG・JPEG・GIF・PNGのみアップルード可能です";
	    $uploadOk = 0;
	}

	// エラーで$uploadOkを0かどうかチェックする
	if ($uploadOk == 0) {
	    echo "アップロード失敗です。";

	// 問題なければアップロード試行。
	} else {
	    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
	        echo basename( $_FILES["img"]["name"]). " がアップロードされました。";
		
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$img		= $_POST['img'];
    				$name	= $_POST['name'];
    				$ratio	= $_POST['ratio'];
				save_database($database);
			}
    		} else {
 	       echo "アップロード失敗です。";
 	   }
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <style>
    body {
        padding-top: 50px;
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

    <div class="starter-template">
      <h1>新規登録</h1>

      <form method="post" enctype="multipart/form-data" action="admin.php">
          <div class="form-group">
            <label for="img">画像</label>
            <input type="file" class="form-control" id="img" name="img">
          </div>

          <div class="form-group">
            <label for="name">機体名</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>

          <div class="form-group">
            <label for="ratio">確率(%)</label>
            <input type="text" class="form-control" id="ratio" name="ratio">
            <p class="help-block">100回引いた時にどれだけ出るか。</p>
          </div>

          <button type="submit" class="btn btn-default">登録</button>
      </form>

      <hr />

	  <h1>登録済一覧</h1>

      <table class="table">
        <thead>
            <tr><th>No.</th><th>画像</th><th>機体名</th><th>倍率(%)</th></tr></thead>
        <tbody>
            <tr>
				<?php $row = 1;
				if (($handle = fopen("database.csv", "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$row++; ?>
					<td><?php echo $row-1 . "."; ?></td>
                		<td><img src="<?php echo $data[2]; ?>"></td>
                		<td><?php echo $data[0] . "<br />\n"; ?></td>
                		<td><?php echo $data[1] . "%<br />\n"; ?></td>
                     </tr>
					<?php }
					fclose($handle);
        		} else {
					return 0;
				}?>
        </tbody>
      </table>
    </div>

    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </body>
</html>
