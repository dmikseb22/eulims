


<?php

$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = mktime() . ".png";
$imgName = $_POST['hidden_data'].name;
//$file = $_POST['hidden_filename'];
//$file = $hdnFilename;
$file = $_POST['hiddenFilename'];
$success = file_put_contents($file, $data);

echo $success ? $file : 'Unable to save the file.';






?>

