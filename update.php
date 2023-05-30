<?php $title="Home-All Animal Information";
include_once('includes/header.php'); 
?>
<?php
if(isset($_POST['submit'])){
    $edit_id = $_POST['edit_id'];
    $animal_name = $_POST['animal_name'];
    $animal_category = $_POST['animal_category'];
    $animal_life = $_POST['animal_life'];
    $animal_desc = $_POST['animal_desc'];
    $animal_old_pic = $_POST['old_pic'];

    function upload(){
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["animal_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["animal_photo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            unlink($target_file);
            $uploadOk = 1;
          }
          if ($_FILES["animal_photo"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
          }
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
              // if everything is ok, try to upload file
              } else {
                if (move_uploaded_file($_FILES["animal_photo"]["tmp_name"], $target_file)) {
                  echo "The file ". htmlspecialchars( basename( $_FILES["animal_photo"]["name"])). " has been uploaded.";

                } else {
                  echo "Sorry, there was an error uploading your file.";
                }
              }
              return $target_file;
    }

    if(empty($_FILES['animal_photo']['tmp_name'])) {
        
        $animal_photo = $animal_old_pic;
        //echo $animal_photo;
        include_once("database.php");
        $query = "UPDATE animals SET animal_name='$animal_name',animal_photo='$animal_photo',animal_category='$animal_category',animal_life='$animal_life',animal_description='$animal_desc' WHERE animal_id='$edit_id';";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message']="Record Edited";
            echo "<script>location.href='index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }else{
        $animal_photo= upload();
        include_once("database.php");
        $query = "UPDATE animals SET animal_name='$animal_name',animal_photo='$animal_photo',animal_category='$animal_category',animal_life='$animal_life',animal_description='$animal_desc' WHERE animal_id='$edit_id';";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message']="Record Edited";
            echo "<script>location.href='index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }
}

?>
<?php include_once('includes/footer.php'); ?>
