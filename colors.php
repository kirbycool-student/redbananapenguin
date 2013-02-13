<?
function rgb2xyz($rgb) {
$R = $rgb[0];
$G = $rgb[1];
$B = $rgb[2];
$R = ( $R / 255.000 );
$G = ( $G / 255.000 );
$B = ( $B / 255.000 );
if ( $R > 0.04045 ) { $R =  pow((( $R + 0.055 ) / 1.055 ),2.4); }
else  { $R = ($R / 12.92); }
if ( $G > 0.04045 ) { $G =  pow((( $G + 0.055 ) / 1.055 ),2.4); }
else { $G = ($G / 12.92); }
if ( $B > 0.04045 ) { $B =  pow((( $B + 0.055 ) / 1.055 ),2.4); }
else { $B = ($B / 12.92); }
$R = $R * 100;
$G = $G * 100;
$B = $B * 100;
$X = $R * 0.4124 + $G * 0.3576 + $B * 0.1805;
$Y = $R * 0.2126 + $G * 0.7152 + $B * 0.0722;
$Z = $R * 0.0193 + $G * 0.1192 + $B * 0.9505;
return array($X,$Y,$Z);
}
function xyz2lab($xyz) {
$X = $xyz[0];
$Y = $xyz[1];
$Z = $xyz[2];
$X = $X / 95.047;
$Y = $Y / 100.000;
$Z = $Z / 108.883;
if ( $X > 0.008856 ) { $X = pow($X,( 1/3 )); }
else                 { $X = ( 7.787 * $X ) + ( 16 / 116 ); }
if ( $Y > 0.008856 ) { $Y = pow($Y,( 1/3 )); }
else                 {   $Y = ( 7.787 * $Y ) + ( 16 / 116 ); }
if ( $Z > 0.008856 ) { $Z = pow($Z,( 1/3 )); }
else                 {   $Z = ( 7.787 * $Z ) + ( 16 / 116 ); }
$L = ( 116 * $Y ) - 16;
$a = 500 * ( $X - $Y );
$b = 200 * ( $Y - $Z );
return array($L, $a, $b);
}
function dE($Lab1, $Lab2) {
$L1=$Lab1[0]; $a1=$Lab1[1]; $b1=$Lab1[2];
$L2=$Lab2[0]; $a2=$Lab2[1]; $b2=$Lab2[2];
return sqrt( ( pow(( $L1 - $L2 ),2) ) + ( pow(( $a1 - $a2 ),2) ) + ( pow(($b1 - $b2 ),2) ) );
}
function bestColor($r, $g, $b){
    $colorsRGB = array(array(204, 0, 0),array(251, 148, 11),array(255, 255, 0),array(0, 204, 0),array(3, 192, 198),array(0, 0, 255),array(118, 44, 167),array(255, 152, 191),array(255, 255, 255),array(153, 153, 153),array(0, 0, 0),array(136, 84, 24));
    $colorsLab = array();
    for ($i=0; $i < 12; $i++) {
        $xyz = rgb2xyz($colorsRGB[$i]);
        $Lab = xyz2lab($xyz);
        $colorsLab[$i] = $Lab;
    }
    $differencearray = array();
    foreach ($colorsLab as $value) {
    $diff = dE(xyz2lab(rgb2xyz(array($r,$g,$b))),$value);
    array_push($differencearray, $diff);
    }
    $smallest = min($differencearray);
    $key = array_search($smallest, $differencearray);
    return $key;
}
function rgb2string($r, $g, $b){
    $key = bestColor($r, $g, $b);
    switch($key){
        case 0;
            return "red";
            break;
        case 1;
            return "orange";
            break;
        case 2;
            return "yellow";
            break;
        case 3;
            return "green";
            break;
        case 4;
            return "teal";
            break;
        case 5;
            return "blue";
            break;
        case 6;
            return "purple";
            break;
        case 7;
            return "pink";
            break;
        case 8;
            return "white";
            break;
        case 9;
            return "gray";
            break;
        case 10;
            return "black";
            break;
        case 11;
            return "brown";
            break;
        default:
            return "WTF";
        }
}
?>
