<?php
include '../admin/conDB.php';
$keyword = $_GET["keyword"];

$semuadata = array();
$ambil = $conn->query("SELECT * FROM laporan,mahasiswa,kategori WHERE laporan.keluhan LIKE '%$keyword%' and laporan.nim=mahasiswa.nim and laporan.id_kategori=kategori.id_kategori");
while ($pecah = $ambil->fetch_assoc()) {
  $semuadata[] = $pecah;
}


?>

<?php if (empty($semuadata)) : ?>
  <div class="">Pencarian Tidak Ditemukan</div>
<?php endif ?>
<?php foreach ($semuadata as $key => $value) : ?>
  <div>
    <div class="laporan">
      <img src="../assets/img/laporan.png" alt="bukti_laporan" />
      <div class="detail_laporan">
        <h4 class="pengusul">Pengusul: <span>Pengusul: <span><?php echo $value['nama']; ?></span></h3>
            <h4 class="category">#<span><?php echo $value['nama_kategori']; ?></span></h4>
            <p>
              Usulan: <br />
              <span><?php echo $value['keluhan'] ?>.</span>
            </p>
      </div>
      <form action="" method="post" class="status">
        <button type="submit" name="approve" class="approve">APPROVE</button>
        <button type="submit" name="unapprove" class="delete">DELETE</button>
    </div>
    <div class="form">
      <textarea placeholder="Ketikkan feedback anda disini..." name="feedback" id="feedback" cols="10" rows="1"></textarea>
    </div>
    </form>
    <?php 
      if (isset($_POST['approve'])) {
        $id_status = $perlaporan['id_status'];
        $feedback = $_POST['feedback'];
        $conn->query("UPDATE status_laporan SET feedback='$feedback', status='approve' where '$id_status'=id_status");
        echo "<script>alert('Laporan Berhasil Di Approve')</script>";
        echo "<script>location='dashboard.php';</script>";
      }
    ?>
    <?php 
      if (isset($_POST['unapprove'])) {
        $id_status = $perlaporan['id_status'];
        $feedback = $_POST['feedback'];
        $conn->query("UPDATE status_laporan SET feedback='$feedback', status='unapprove' where '$id_status'=id_status");
        echo "<script>alert('Laporan Berhasil Di Delete')</script>";
        echo "<script>location='dashboard.php';</script>";
      }
    ?>
  </div>
<?php endforeach ?>