<?php  
require_once('barcode_lib/class/BCGFontFile.php');
require_once('barcode_lib/class/BCGColor.php');
require_once('barcode_lib/class/BCGDrawing.php');

require_once('barcode_lib/class/BCGcode128.barcode.php');

header('Content-Type: image/png');

$color_white = new BCGColor(255, 255, 255);

$code = new BCGcode128();
$code->parse($_REQUEST['code']);

$drawing = new BCGDrawing('', $color_white);
$drawing->setBarcode($code);

$drawing->draw();
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

?>
