<?php
$total_ratio = 0;
$csv		= array();
$file		= 'database.csv';
$handle	= fopen($file, "r");
  
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
  $csv[] = $data;
}

fclose($handle);

for ($i = 0; $i < count($csv); $i++) {
	while ($csv[$i][1] < 1) {
		for ($j = 0; $j < count($csv); $j++) {
			$csv[$j][1] = $csv[$j][1] * 10;
		}
	}
}

function gacha ($csv = array()){
	
	$total_ratio = 0;
	foreach( $csv as $record ) $total_ratio += $record[1];
	
	$hit = mt_rand( 0, ($total_ratio - 1 ) );
	
	foreach ($csv as $key => $record ){
		$total_ratio -= $record[1];
		if( $total_ratio <= $hit ) return $key;
	}
}
?>
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
    background: url("gacha.png");
    background-size: 320px 480px;
    background-repeat: no-repeat;
  }
  
  .img {
    position: absolute;
    bottom: 50px;
    left: 25px;
    margin: auto;
  }
  </style>
</head>
<body>
  <div class="container">
    <img class="img" src="<?php echo $csv[gacha($csv)][2]; ?>">
  </div>
</body>
</html>
