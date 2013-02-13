var numRequests = 0;



function printImages(arr, color){
	var countX = document.getElementById("imagesContainer").getAttribute("numX");
	var countY = document.getElementById("imagesContainer").getAttribute("numY");
	var width = document.getElementById("imagesContainer").getAttribute("value");
	
	
	var coords = document.getElementById(color)
	
	if(coords)
		coords = coords.getAttribute("value");
	else
		return;
	
	coords = coords.split(';');
	var links = Array();
	var linksNum = 0;
	for(var i=0; i < coords.length-1; i++){
		console.log(coords[i]);
		var x = coords[i].split(',');
		var y = parseInt(x[1]);
		x = parseInt(x[0]);
		var randNum=Math.floor(Math.random()*(arr.length))
		var image = arr[randNum];
		var link = document.createElement('img');
		link.setAttribute('src', image);
		link.setAttribute('id', x + 'sep' + y);
		links[randNum] += x + ','+ y + ';';
		linksNum++;
		link.setAttribute('style', 'z-index: 5; position: absolute; top: ' + parseInt(10+width*y) + 'px; left: ' + parseInt(10+width*x) + 'px; display: inline-block; width: ' + width + 'px;height: ' + width + 'px');
		//document.getElementById("imagesContainer").innerHTML += '<img src="' + 'images/thumb.jpg' + '" style=>';
		document.getElementById("imagesContainer").appendChild(link);	
	}
	 
	
}

function getImageUrls(arr, color){
	var images = new Array();
	var width = document.getElementById("imagesContainer").value;
	var num = 0;
	for(var x=0; x < arr.length; x++){
		for(var y=0; y < arr[x].length; y++){
			images[num] = arr[x][y]['tbUrl'];
			num++;
		}
	}
	printImages(images, color);
}

function compileMosaic(){
	var countX = document.getElementById("imagesContainer").getAttribute("numX");
	var countY = document.getElementById("imagesContainer").getAttribute("numY");
	var width = document.getElementById("imagesContainer").getAttribute("value");
	connection = new AjaxConnection("compileMosaic.php");
	var params = 'width=' + parseInt(countX*width) + '&height=' + parseInt(countY*width);
    	connection.connect("handleCompileMosaic", params, "POST");
}

function handleCompileMosaic(response){
	alert("Image ready to download :)");
}


function download(){
	var countX = escape(document.getElementById("imagesContainer").getAttribute("numX"));
	var countY = escape(document.getElementById("imagesContainer").getAttribute("numY"));
	var width = escape(document.getElementById("imagesContainer").getAttribute("value"));

	var images = Array();
	var num = 0;
	for(var x=1; x < countX-1; x++){
		for(var y=1; y < countY-1; y++){
			var url = document.getElementById(x + 'sep' + y).getAttribute('src');
			url= url.replace('gstatic.com/images?q=tbn:', '');
			url= url.replace('http://', '');
			for(var c=0; c < images.length; c++){
				if(url == images[c])
					url = c;
			}
			images[num] = url;
			num++;
		}
	}
	images = images.join(' ');
	//images = escape(images);
	images = encodeURIComponent(images);
	//images = images.substr(0, parseInt(images.length / 4));
	
	
	//Here Kirby, send AJAX to download.php with images as a string
	var jqXHR =   $.ajax({
	        type: "POST",
	        url: "download.php",
	        data: images,
	        contentType: "application/json",
	        dataType: "json",
	        success: function(data){console.log("post succeeded")},
	        failure: function(errMsg) {
	            alert(errMsg);
        	}
  	});
		
	/*connection = new AjaxConnection("download.php");
	var params = 'name=' + 'images' + '&images=' + images;
	numRequests++;
    	connection.connect("handleDownload", params, "POST");
    	*/
    	
      
}
function handleDownload(response){
	numRequests--;
	if(numRequests == 0){
		compileMosaic();
	}

}