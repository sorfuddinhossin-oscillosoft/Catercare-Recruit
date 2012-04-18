<?php
include_once 'recruit.php';
$log = new recruit();
$log->xmlURL = 'http://jobs.oscillosoft.com/user/xml/results.xml';
echo $log->jobOpenings();
?>

