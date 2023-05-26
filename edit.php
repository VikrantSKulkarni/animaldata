<?php $title="Home-All Animal Information";
include_once('includes/header.php'); 
$edit_id= $_GET['edit_id'];
echo $edit_id;
include_once("database.php");
$query = "SELECT * FROM animals WHERE animal_id=$edit_id";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $animal_name = $row['animal_name'];
        $animal_category = $row['animal_category'];
        $animal_life = $row['animal_life'];
        $animal_desc = $row['animal_description'];
        $animal_photo = $row['animal_photo'];
    }
}
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="text-center">Edit Animal information </h1>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="" method="post" class="form-group" enctype="multipart/form-data">
            <label for="name"> Name *</label>
            <input type="text" name="edit_id" value="<?php echo $edit_id;?>">
            <input type="text" name="animal_name" value="<?php echo $animal_name;?>" id="" class="form-control" required>
            <label for="name">Upload Photo *</label>
            <input type="file" name="animal_photo" id="" class="form-control">
            <input type="text" name="old_pic" value="<?php echo $animal_photo ?>" id="">
           
            <label for="Category">Category *</label>
            <select name="animal_category" class="form-control" id="" required>
                <option value="omnivores"<?php if($animal_category=='omnivores'){ echo 'selected';}?>>Omnivores</option>
                <option value="carnivores" <?php if($animal_category=='carnivores'){ echo 'selected';}?>>Carnivores</option>
                <option value="herbivores"<?php if($animal_category=='herbivores'){ echo 'selected';}?>>Herbivores</option>
           </select>
           <label for="Life expectancy">Life expectancy*</label>
            <select name="animal_life" class="form-control" id="" required>
                <option value="0-1"<?php if($animal_life=='0-1'){ echo 'selected';}?> >0-1 years</option>
                <option value="1-5" <?php if($animal_life=='1-5'){ echo 'selected';}?>>1-5 years</option>
                <option value="5-10" <?php if($animal_life=='5-10'){ echo 'selected';}?>>5-10 years</option>
                <option value="10+"<?php if($animal_life=='10+'){ echo 'selected';}?> >10+ years</option>
           </select>
            <label for="name">Animal Description *</label>
            <textarea class="form-control" name="animal_desc"  cols="30" rows="5" required><?php echo $animal_desc; ?></textarea>

            <button class="btn btn-primary mt-2" type="submit" name="submit">Sumbit</button>
        </form>
    </div>
</div>

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
        echo $animal_photo;
        include_once("database.php");
        $query = "UPDATE animals SET animal_name='$animal_name',animal_photo='$animal_photo',animal_category='$animal_category',animal_life='$animal_life',animal_description='$animal_desc' WHERE animal_id='$edit_id';";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message']="Record Edited";
            echo "<script>alert('Record Edited successfully');</script>";
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
            echo "<script>alert('Record Edited successfully');</script>";
            echo "<script>location.href='index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }
}

?>
<?php include_once('includes/footer.php'); ?>
