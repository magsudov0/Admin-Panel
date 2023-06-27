<?php
$uploadingFileLocation = "uploads/".$_FILES["uploadingFile"]["name"];

$fileFormat = strtolower(pathinfo($uploadingFileLocation,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    // if (getimagesize($_FILES["uploadingFile"]["tmp_name"])) {
    //     $em = "You can send only image files";
    //     header("Location: index.php?error=$em"); // -> duzemelli islemir
    //     exit;
    // }
    if (file_exists($uploadingFileLocation)) {
        $em = "This file is already exist";
        header("Location: index.php?error=$em");
        exit;
    }
    if ($_FILES["uploadingFile"]["size"] > 500000) {
        $em = "Your image is large. Try to send under 5mb images";
        header("Location: index.php?error=$em");
        exit;
    }
    if($fileFormat != "jpg" && $fileFormat != "png") {
        $em = "Only jpg and png formats allowed";
        header("Location: index.php?error=$em");
        exit;
    }
    if (move_uploaded_file($_FILES["uploadingFile"]["tmp_name"], $uploadingFileLocation)) {
        $sm = "Your file has been uploaded succesfully";
        header("Location: index.php?success=$sm");
        exit;
      } 
    else 
    {
       $em = "Only jpg and png formats allowed";
       header("Location: index.php?error=$em");
       exit;
    }
}

?>