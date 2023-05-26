<?php $title="Home-All Animal Information";
include_once('includes/header.php'); ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="text-center">All Animal List </h1>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
            <?php if(isset($_SESSION['message'])){ ?>
            <div class="alert alert-primary text-center" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']);?>
            </div>
       <?php  }?>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-11">
        <table id="animals" class="table table-light">
            <thead>
                <tr><td colspan=7><button class="btn btn-primary "><a href="submition.php" class="text-white">Add </a></button></td></tr>
                <tr>
                    <th>Sr.No.</th>
                    <th>Name </th>
                    <th>Photo </th>
                    <th>Category </th>
                    <th>Life Span </th>
                    <th>Description </th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody>
                <?php include_once("database.php");
                $query = "SELECT * FROM `animals` ORDER BY animal_id DESC;";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $count = 1;
                while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $count;?></td>
                    <td><?php echo $row['animal_name']; ?></td>
                    <td><img style="height:100px;width:100px;" src="<?php echo $row['animal_photo']; ?>" alt="animal"></td>
                    <td><?php echo $row['animal_category']; ?></td>
                    <td><?php echo $row['animal_life']; ?></td>
                    <td><?php echo $row['animal_description']; ?></td>
                    <td>
                        <a class="text-success" href="edit.php?edit_id=<?php echo $row['animal_id']?>"><i class="fa-solid fa-pencil"></i></a>
                        <a class="text-danger" onclick="return confirm('Are you sure you want to delete this item?');" href="delete.php?delete_id=<?php echo $row['animal_id']?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php $count ++;
            }
                } else {
                    echo "0 results";
                    }
                    ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once('includes/footer.php'); ?>
