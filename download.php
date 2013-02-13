<?

$imgs = $_POST['images'];

echo $imgs.'<br>';
die("Success");
    
$countX = $_POST['countX'];
$countY = $_POST['countY'];
$width = $_POST['width'];

$img = imagecreate($countX*$width, $countY*$width);
$num = 0;


for($x = 0; $x < $countX; $n++){
	$y = explode(',', $coords[$n]);
	$x = $y[0];
	$y = $y[1];
	$tile = imagecreatefromjpeg($links[rand(0, count($links)-1)]);
	imagecopymerge($img, $tile, $x*$width, $y*$width, '0', '0', $width, $width, '100');
}

imagejpeg($img, 'images/mosaic/'.$name.'.jpg');

?>