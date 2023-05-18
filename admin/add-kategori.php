<?php
session_start();
include_once('conn/koneksi.php');
if (!isset($_SESSION['email'])) {
    header("location:auth/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once('partial/header.php'); ?>

<body>
    <div class="container-scroller">
        <?php include_once('partial/navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('partial/sidebar.php'); ?>
            <div class="main-panel">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Kategori</h4>
                            <div class="row mt-2" style="float: right; margin-right: 20px;">
                            </div>
                            <p class="card-description">
                            </p>
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">

                                        <form class="forms-sample d-inline" method="post">
                                            <div class="form-group">
                                                <label for="cgy">Category Name</label>
                                                <input type="text" name="kategori" class="form-control" id="cgy" placeholder="category name" required>
                                            </div>
                                            <button type="submit" name="tambah" class="btn btn-primary mr-2">Submit</button>
                                        </form>
                                        <a href="kategori.php"><button class="btn btn-light">Cancel</button></a>
                                        <?php
                                        if (isset($_POST['tambah'])) {
                                            $kategori = $_POST["kategori"];

                                            $koneksi->query("INSERT INTO kategori(nama_kategori)
		                                    VALUES ('$kategori')");
                                            echo "<script> alert('Kategori Sudah Bertambah');</script>";
                                        }


                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('partial/footer.php'); ?>

</body>

</html>