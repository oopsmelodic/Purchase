<?php
/**
 * Created by PhpStorm.
 * User: melodic
 * Date: 03.03.2016
 * Time: 14:13
 */

require_once 'Iom.php';

//print_r($_POST);
$iom = new Iom();

if (empty($_FILES['file_data'])) {
    echo json_encode(Array('error'=>'No files found for upload.'));
    return;
}
$files = $_FILES['file_data'];
$iom_id = empty($_POST['$iom_id']) ? '' : $_POST['$iom_id'];
$file_id = $_POST['file_id'];
$file_title = $_POST['new_' . $file_id];
$success = null;
$paths= Array();
$filenames = $files['name'];
if ($file_title === '') {
    $file_title = $filenames;
}
$ext = pathinfo($filenames, PATHINFO_EXTENSION);
$target = $_SERVER['DOCUMENT_ROOT']."/uploads/" . $_POST['iom_id'] . "_" . md5(uniqid()) . "." . $ext;
if(move_uploaded_file($files['tmp_name'], $target)) {
    $success = true;
    $paths[] = $target;
    $iom->appendFileToIom($_POST['iom_id'],$file_title,$filenames,$ext,$target);

} else {
    $success = false;
}
if ($success === true) {
    $output = Array();

} elseif ($success === false) {
    $output = Array('error'=>'Error while uploading files. Contact the system administrator');
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $output = Array('error'=>'No files were processed.');
}

echo json_encode($output);