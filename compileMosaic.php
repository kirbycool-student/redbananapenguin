<?
$width = $_POST['width'];
$height = $_POST['height'];

$img = imagecreate($width, $height);

$dir = "images/mosaic/";


if ($handle = opendir('images/mosaic/')) {
    echo "Directory handle: $handle\n";
    echo "Entries:\n";

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        if($entry != '.' && $entry != '..'){
        	$compile = imagecreatefromjpeg($dir.$entry);
        	
        	echo 'Compiling '.$entry.'...<br>';
        	
        	imagecopymerge($img, $compile, '0', '0', '0', '0', $width, $height, '100');
        	
        	unlink($dir.$entry);
        
        
        }
    }

   

    closedir($handle);
    
    
    imagejpeg($img, 'images/mosaic/mosaic.jpg');

}
    
    
?>