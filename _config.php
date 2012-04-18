<?php
$base_url = 'http://demo.oscillosoft.com/modpix_final/';
$js = $base_url.'js/';
$css = $base_url.'css/';
$images = $base_url.'images/';

$fileUploadDirectory = $_SERVER['DOCUMENT_ROOT'].'/demo/modpix_final/uploadedfile/';
$ProductUploadDirectory = $_SERVER['DOCUMENT_ROOT'].'/demo/modpix_final/product/';
$ProductItemUploadDirectory = $_SERVER['DOCUMENT_ROOT'].'/demo/modpix_final/product/item/';
$fileUploadUrl = $base_url.'uploadedfile/';
$dir = str_replace(chr(92),chr(47),getcwd());
$userprofile = $_SERVER['DOCUMENT_ROOT'].'/demo/modpix_final/user/profile/';
$userprofile = str_replace(chr(92),chr(47),$userprofile);

?>
