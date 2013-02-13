<link rel="stylesheet" type="text/css" href="niceforms-default.css"  />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/imageSearch.js"></script>
<script type="text/javascript" src="js/printImages.js"></script>




	

<?

include("colors.php");

//Makes grid of colors based on image and has xCount images horizontally and calculates necessary number of images vertically to keep them square
function analyzeImageColors($im, $width){
    //get dimensions for image
    $imWidth =imagesx($im);
    $imHeight =imagesy($im);

    //find out the dimensions of the blocks we're going to make
    $blockWidth = $width;
    $blockHeight = $blockWidth;   //round($imHeight/$yCount);
    $xCount = round($imWidth / $width);
    $yCount = round($imHeight / $blockHeight);

    //now get the image colors...
    $colorArray['width']['height']['value'] = $blockWidth;
    for($x =0; $x<$xCount; $x++) { //cycle through the x-axis
    	for ($y =0; $y<$yCount; $y++) { //cycle through the y-axis
	        //this is the start x and y points to make the block from
	        $blockStartX =($x*$blockWidth);
	        $blockStartY =($y*$blockHeight);
	        //create the image we'll use for the block
	        $block =imagecreatetruecolor(1, 1);
	        //We'll put the section of the image we want to get a color for into the block
	        imagecopyresampled($block, $im, 0, 0, $blockStartX, $blockStartY, 1, 1, $blockWidth, $blockHeight );
	        //the palette is where I'll get my color from for this block
	        imagetruecolortopalette($block, true, 1);
	        //I create a variable called eyeDropper to get the color information
	        $eyeDropper =imagecolorat($block, 0, 0);
	        $palette =imagecolorsforindex($block, $eyeDropper);
	        $colorArray[$y][$x]['r'] =$palette['red'];
	        $colorArray[$y][$x]['g'] =$palette['green'];
	        $colorArray[$y][$x]['b'] =$palette['blue'];
	        //get the rgb value too
	        $hex =sprintf("%02X%02X%02X", $colorArray[$y][$x]['r'], $colorArray[$y][$x]['g'], $colorArray[$y][$x]['b']);
	        $colorArray[$y][$x]['rgbHex'] =$hex;
	        //destroy the block
	        imagedestroy($block);
    	}
    }
    //destroy the source image
    imagedestroy($im);
    return $colorArray;
}

function resizeImage( $pathToImage, $pathToThumb, $thumbWidth, $external=0 )
{ 
      // load image and get image size
      if($external == 0){
      	$file = file_get_contents("http://www.comebind.com/".$pathToImage);
      	$test = substr($pathToImage, -4);
      }else{
      	$file = file_get_contents($pathToImage);
      	$test = substr($pathToImage, -4);
      }
      
      $arr = explode('.', $test);
      $ext = $arr[1];
      if ( $ext == 'jpg' )
           $img = imagecreatefromjpeg($pathToImage);
          
      if ( $ext == 'png' )
           $img = imagecreatefrompng($pathToImage);
           
      if ( $ext == 'gif' )
           $img = imagecreatefromgif($pathToImage);

      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, $pathToThumb );
}


function incrementColor($color){
	if($color == 'red')
		return 'orange';
	if($color == 'orange')
		return 'yellow';
	if($color == 'yellow')
		return 'green';
	if($color == 'green')
		return 'teal';
	if($color == 'teal')
		return 'blue';
	if($color == 'blue')
		return 'purple';
	if($color == 'purple')
		return 'pink';
	if($color == 'pink')
		return 'white';
	if($color == 'white')
		return 'gray';
	if($color == 'gray')
		return 'black';
	if($color == 'black')
		return 'brown';
	if($color == 'brown')
		return 'done';
         
}


//Prints out image grid with DIVS and semi-transparent color tints
function printImageColors($img){
	$pathToImage = "http://www.comebind.com/hackathon/images/Penguins.jpg";
	//createThumbs($pathToImage, 'images/thumb.jpg', '25');
	
	$colorArr = array();
	$colorNum = array();
	
	$colorArr['red'] = '';
	$colorArr['orange'] = '';
	$colorArr['yellow'] = '';
	$colorArr['green'] = '';
	$colorArr['teal'] = '';
	$colorArr['blue'] = '';
	$colorArr['purple'] = '';
	$colorArr['pink'] = '';
	$colorArr['white'] = '';
	$colorArr['gray'] = '';	
	$colorArr['black'] = '';
	$colorArr['brown'] = '';
	
	$colorNum['red'] = '0';
	$colorNum['orange'] = '0';
	$colorNum['yellow'] = '0';
	$colorNum['green'] = '0';
	$colorNum['teal'] = '0';
	$colorNum['blue'] = '0';
	$colorNum['purple'] = '0';
	$colorNum['pink'] = '0';
	$colorNum['white'] = '0';
	$colorNum['gray'] = '0';	
	$colorNum['black'] = '0';
	$colorNum['brown'] = '0';
	
	
	$width = $img['width']['height']['value'];
	echo '<div id="overlay">';
	for($y = 0; $y < count($img); $y++){
		for($x = 0; $x < count($img[$y]); $x++){
			//createThumbs($pathToImage, 'images/thumb'.$x.$y.'.jpg', $width, $img[$y][$x]['r'], $img[$y][$x]['g'], $img[$y][$x]['b'], '50');
			//echo '<img src="images/thumb'.$x.$y.'.jpg">';
			//imagejpeg($tile);
			echo '<div id="'.$y.$x.'" style="background: rgba('.$img[$y][$x]['r'].', '.$img[$y][$x]['g'].', '.$img[$y][$x]['b'].', 0.4); z-index: 10;
			      position: absolute; top: '.round(10+$width*$y).'px; left: '.round(10+$width*$x).'px; display: inline-block; width: '.$width.'px;height: '.$width.'px"></div>';
			
			$color = rgb2string($img[$y][$x]['r'], $img[$y][$x]['g'], $img[$y][$x]['b']);
			$colorArr[$color] .= $x.','.$y.';';
			$colorNum[$color]++;
		}
		echo '<br>';
	}
	echo '</div>';
	
	echo '<script type="text/javascript">
		function caller(){ searchInit();
		';
	for($color = 'red'; $color != 'done'; $color = incrementColor($color)){
		if($colorArr[$color] != '')
			echo "getImages('".$_POST['tags']."', '".$color."', ".$colorNum[$color].", getImageUrls);
			";
	}
	
	echo '}</script>';
	
	for($color = 'red'; $color != 'done'; $color = incrementColor($color)){
		if($colorArr[$color] != '')
			echo '<div id="'.$color.'" value="'.$colorArr[$color].'" number="'.$colorNum[$color].'"></div>';
	}
	
	
	return $width;
}




//Prints out images in background
function printImages($width, $numX, $numY){
	for($y = 0; $y < $numY; $y++){
		for($x = 0; $x < $numX; $x++){
			//createThumbs($pathToImage, 'images/thumb'.$x.$y.'.jpg', $width, $img[$y][$x]['r'], $img[$y][$x]['g'], $img[$y][$x]['b'], '50');
			//echo '<img src="images/thumb'.$x.$y.'.jpg">';
			//imagejpeg($tile);
			echo '<img src="images/thumb.jpg" style="z-index: 5;
			      position: absolute; top: '.round(10+$width*$y).'px; left: '.round(10+$width*$x).'px; display: inline-block; width: '.$width.'px;height: '.$width.'px"></div>';
		}
		echo '<br>';
	}

}




if(isset($_POST['submit'])){

	//Image Processing
	if($_POST['mediaSelect'] == 'video') {
		$url = $_POST['youtubeUrl'];
		if(!filter_var($url, FILTER_VALIDATE_URL)) {
			die("Invalid Url");
		}
			
		$parsedUrl = parse_url($url);
		$query = $parsedUrl['query'];
		
		parse_str($query);
		$videoId = $v;
		
		$imageUrl = "http://img.youtube.com/vi/" . $videoId . "/0.jpg";
		echo($imageUrl);
		//process image
		$img = imagecreatefromjpeg($imageUrl);
		resizeImage($imageUrl, 'images/main.jpg', 800, 1);
		$img = imagecreatefromjpeg('images/main.jpg');	
		
		$width = $_POST['numPixels'];
		$color = analyzeImageColors($img, $width);
		$numY = count($color);
		$numX = count($color[1]);
		$width = printImageColors($color);
		//printImages($width, $numX, $numY);
		
		echo '<div id="imagesContainer" value="'.$width.'" numX="'.$numX.'" numY="'.$numY.'"></div>';
		
		
		
	}
	else if($_POST['mediaSelect'] == 'imageLink'){
		$imag = $_POST['imageLink'];
		//echo($imag);
		//process image
		$test = substr($imag, -4);
		//echo 'Test: '.$test.'<Br>';
		$ext = explode('.', $test);
		/*
		$ext = $ext[1];
		echo '<br>Extension: '.$ext.'<br>';
		if ( $ext == 'jpg' )
		     $img = imagecreatefromjpeg($imag);
		else if ( $ext == 'png' )
		     $img = imagecreatefrompng($imag);
		else if ( $ext == 'gif' )
		     $img = imagecreatefromgif($imag);
		else
			die("Unsupported image type <Br>");
			*/
		resizeImage($imag, 'images/main.jpg', 800, 1);
		$img = imagecreatefromjpeg('images/main.jpg');	
		
		$width = $_POST['numPixels'];
		$color = analyzeImageColors($img, $width);
		$numY = count($color);
		$numX = count($color[1]);
		$width = printImageColors($color);
		//printImages($width, $numX, $numY);
		
		echo '<div id="imagesContainer" value="'.$width.'" numX="'.$numX.'" numY="'.$numY.'"></div>';
	}else{
		//echo '<body onload="caller(\''.$_POST['tags'].'\', \'NULL\', \'32\', \'getImageUrls\')">';
		$target_path = "images/";
		
		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
		
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
		    ;
		} else{
		    echo "There was an error uploading the file, please try again!";
		}
		
		$pathToImage = $target_path;
		$arr = explode('.', $pathToImage);
		$ext = $arr[1];
		if ( $ext == 'jpg' )
		     $img = imagecreatefromjpeg($pathToImage);
		else if ( $ext == 'png' )
		     $img = imagecreatefrompng($pathToImage);
		else if ( $ext == 'gif' )
		     $img = imagecreatefromgif($pathToImage);
		else
			die("Unsupported image type.".$pathToImage);
			
		resizeImage($pathToImage, 'images/main.jpg', 800);
		$img = imagecreatefromjpeg('images/main.jpg');	
		unlink($target_path);
		$width = $_POST['numPixels'];
		$color = analyzeImageColors($img, $width);
		$numY = count($color);
		$numX = count($color[1]);
		$width = printImageColors($color);
		//printImages($width, $numX, $numY);
		
		echo '<div id="imagesContainer" value="'.$width.'" numX="'.$numX.'" numY="'.$numY.'"></div>';
		/*  Code to get frame in movie
		$movie = new ffmpeg_movie('foo.flv');
		$frame = $movie->getFrame(1234);
		imagefromjpeg($frame, 'foo.jpeg');
		imagedestroy($frame);
		*/
		
		?>
		<!--<input value="Download File" type="submit" onclick="download()" style="position: absolute; left: 20px; top: <? echo $width*$numY; ?>;">-->
		<?
	}
}else{
?>
<div style="align: center;">
<form action="mosaic.php" align="left" enctype="multipart/form-data" method="post">
<img src="images/icon.png"/><br clear="left">
<table>
<tr><td>Media type: </td><td><select id='mediaSelect' name='mediaSelect'>
    <option id='imageOption' value='imageUpload' selected="selected">Image Upload</option>
    <option id='imageOption' value='imageLink'>Image Link</option>
    <option id='videoOption' value='video'>Video</option>
</select></td></tr>



<tr><td><div>Type in tags for background images:
    </td><td><input type="text" id="tags" name="tags" size="30">
</div></td></tr>


    <tr id='imageUploadForm'><td>Please specify an image for the mosaic:</td><Td>
    <input type="file" name="uploadedfile" size="40">
    <input type="hidden" name="submit"></td></tr>


	<tr id='imageLinkForm'><td>Image Link</td><Td><input type="text" name="imageLink" size="50" /></td></tr>



    <tr id='videoForm'><td>YouTube Url</td><td><input type="text" name="youtubeUrl" size="50" /></td></tr>
    <tr id='pixels'><td>Thumbnail pixel width: (around 10 recommended) </td><td><input type="text" value="10" name="numPixels" size="5" /></td></tr>
</table>

<div><input type="submit" value="Send"></div>
</form>
</div>
<?
}

?>

<script type="text/javascript">


function init() {
    //init form swapping
    $('#videoForm').hide();
    $('#imageLinkForm').hide();
    
    $('#mediaSelect').change( function() {
        console.log('select changed');
            $('#imageUploadForm, #imageLinkForm, #videoForm').hide();
            if($(this).val() == "imageUpload")
                $('#imageUploadForm').show();
            else if ($(this).val() == "video")
                $('#videoForm').show();
            else
            	$('#imageLinkForm').show();
    });

    caller();
}

document.ready = init();

</script>
