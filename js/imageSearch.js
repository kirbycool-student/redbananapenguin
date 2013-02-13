var imageSearches = new Array();
var colors = new Array();
google.load('search', '1');

//callback(results). results is a 2 dimensional array results[pages][jsonResultObject]
function getImages(searchTerm, color, n, callback) {
    console.log(typeof callback);
    
    if( n == null || n > 64 ) {
        n = 64;
    }
    console.log("n", n);

    searchConfig(color, n, callback);
    imageSearches[color].execute(searchTerm);
    
}

function searchInit() {
    console.log("searchInit");
        
    //init colors
    colors["black"] = google.search.ImageSearch.COLOR_BLACK;
    colors["blue"] = google.search.ImageSearch.COLOR_BLUE;
    colors["brown"] = google.search.ImageSearch.COLOR_BROWN;
    colors["gray"] = google.search.ImageSearch.COLOR_GRAY;
    colors["green"] = google.search.ImageSearch.COLOR_GREEN;
    colors["orange"] = google.search.ImageSearch.COLOR_ORANGE;
    colors["pink"] = google.search.ImageSearch.COLOR_PINK;
    colors["purple"] = google.search.ImageSearch.COLOR_PURPLE;
    colors["red"] = google.search.ImageSearch.COLOR_RED;
    colors["teal"] = google.search.ImageSearch.COLOR_TEAL;
    colors["white"] = google.search.ImageSearch.COLOR_WHITE;
    colors["yellow"] = google.search.ImageSearch.COLOR_YELLOW;
}

function searchConfig(color, n, callback) {
    //set the callback to use
    imageSearches[color] = new google.search.ImageSearch;
    var imageSearch = imageSearches[color];

    console.log(typeof callback);
    imageSearch.setSearchCompleteCallback(this, searchComplete, [callback, color]);
    
    imageSearch.setNoHtmlGeneration();

    //determine number of pages and number of results
    var pages = Math.floor(n/8) + 1;
    if ( pages == 0 ) {
        imageSearch.setResultSetSize(n); 
    }
    else {
        imageSearch.setResultSetSize(8);
    }
    imageSearch.pages = pages;

    //restrict the color
    if( colors[color] != "undefined" ) {
        imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_COLORFILTER, colors[color]);
    }
}

function searchComplete(callback, color) {
    var imageSearch = imageSearches[color];
    var cursor = imageSearch.cursor;
    //create a persistent object to hold results, if it doesnt exist
    if(!imageSearch.allResults || cursor.currentPageIndex == 0) {
          imageSearch.allResults = Array(); 
    }

    //add the page
    imageSearch.allResults[cursor.currentPageIndex] = imageSearch.results;

    //go to the next page
    if(cursor && cursor.pages.length > cursor.currentPageIndex+1 && cursor.currentPageIndex+1 < imageSearch.pages) {
        imageSearch.gotoPage(cursor.currentPageIndex+1);
    }
    else {
        callback(imageSearch.allResults, color);
    }
}