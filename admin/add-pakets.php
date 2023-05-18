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
                            <h4 class="card-title">Add Packets</h4>
                            <div class="row mt-2" style="float: right; margin-right: 20px;">
                            </div>
                            <p class="card-description">
                            </p>
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card ">
                                    <div class="card-body">
                                        <?php
                                        $datakategori = array();
                                        $ambil = $koneksi->query("SELECT * FROM kategori");
                                        while ($tiap = $ambil->fetch_assoc()) {
                                            $datakategori[] = $tiap;
                                        }
                                        ?>

                                        <form class="forms-sample d-inline" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="paket">Packets Name</label>
                                                <input type="text" name="nama" class="form-control" id="paket" placeholder="packets name" required>
                                            </div>
                                            <!-- select option kategory -->
                                            <div class="form-group">
                                                <label for="kategory">Nama Kategori</label>
                                                <select id="kategory" class="form-control" name="id_kategori" required>
                                                    <option value="">Pilih Kategori</option>
                                                    <?php foreach ($datakategori as $key => $value) : ?>
                                                        <option value="<?php echo $value["id_kategori"] ?>"><?php echo $value["nama_kategori"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga1">Harga Paket (Rp)</label>
                                                <input type="number" name="harga" class="form-control" id="harga1" placeholder="harga pakets" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lokasi1">Lokasi Maps</label>
                                                <input type="text" name="lokasi" class="form-control" id="lokasi1" placeholder="Input embed maps on Google" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="img">Images</label>
                                                <div class="letak-input input-group col-xs-12 mb-3">
                                                    <input id="img" type="file" class="form-control file-upload-info" name="foto[]" required>
                                                </div>
                                                <span class="btn btn-primary btn-tambah">+
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <label for="des">Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" id="des" rows="4" required></textarea>
                                            </div>
                                            <button type="submit" name="save" class="btn btn-primary mr-2">Submit</button>
                                        </form>
                                        <a href="pakets.php"><button class="btn btn-danger">Cancel</button></a>
                                        <?php
                                        if (isset($_POST['save'])) {
                                            $namanamafoto = $_FILES['foto']['name'];
                                            $lokasilokasifoto = $_FILES['foto']['tmp_name'];
                                            move_uploaded_file($lokasilokasifoto[0], "../foto_paket/" . $namanamafoto[0]);
                                            $koneksi->query("INSERT INTO paket
		(nama_paket,id_kategori, harga_paket,lokasi_maps,foto_wisata,deskripsi_wisata)
		VALUES('$_POST[nama]','$_POST[id_kategori]','$_POST[harga]','$_POST[lokasi]','$namanamafoto[0]','$_POST[deskripsi]')");
                                            $id_paket_barusan = $koneksi->insert_id;
                                            foreach ($namanamafoto as $key => $tiap_nama) {
                                                $tiap_lokasi = $lokasilokasifoto[$key];

                                                move_uploaded_file($tiap_lokasi, "../foto_paket/" . $tiap_nama);

                                                $koneksi->query("INSERT INTO paket_foto(id_paket, nama_paket_foto)
			VALUES('$id_paket_barusan','$tiap_nama')");
                                            }

                                            // echo "<div class='alert alert-info'>Data Tersimpan</div>";
                                            // echo "<meta http-equiv='refresh' content='l;url=index.php?halaman=produk'>";
                                            echo "<pre>";
                                            print_r($_FILES["foto"]);
                                            echo "</pre>";
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
    <script>
        $(document).ready(function() {
            $(".btn-tambah").on("click", function() {
                $(".letak-input").append("<input type='file' class='form-control' name='foto[]'>");
            })
        })
    </script>
    <?php include_once('partial/footer.php'); ?>
</body>

</html>