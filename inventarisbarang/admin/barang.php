<?php
    require_once 'header_template.php';

    $action = isset($_GET['action']) ? $_GET['action'] : 'list'; // Default action adalah 'list'
    $id_barang = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

    $error_message = "";
    $success_message = "";

    // --- LOGIC CRUD ---
    // CREATE (Tambah Barang)
    if ($action == 'add' && isset($_POST['submit_add'])) {
        $no_urut = mysqli_real_escape_string($conn, $_POST['no_urut']);
        $jenis_nama_barang = mysqli_real_escape_string($conn, $_POST['jenis_nama_barang']);
        $merek_model = mysqli_real_escape_string($conn, $_POST['merek_model']);
        $no_seri_pabrik = mysqli_real_escape_string($conn, $_POST['no_seri_pabrik']);
        $ukuran = mysqli_real_escape_string($conn, $_POST['ukuran']);
        $warna = mysqli_real_escape_string($conn, $_POST['warna']);
        $bahan = mysqli_real_escape_string($conn, $_POST['bahan']);
        $tahun_pembuatan_pembelian = mysqli_real_escape_string($conn, $_POST['tahun_pembuatan_pembelian']);
        $harga_barang = mysqli_real_escape_string($conn, $_POST['harga_barang']); // Kolom harga_barang
        $no_kode_barang = mysqli_real_escape_string($conn, $_POST['no_kode_barang']);
        $jumlah_barang_register = mysqli_real_escape_string($conn, $_POST['jumlah_barang_register']);
        $keadaan_barang = mysqli_real_escape_string($conn, $_POST['keadaan_barang']);

        $query_insert = "INSERT INTO barang (no_urut, jenis_nama_barang, merek_model, no_seri_pabrik, ukuran, warna, bahan, tahun_pembuatan_pembelian, harga_barang, no_kode_barang, jumlah_barang_register, keadaan_barang) VALUES (
            '$no_urut', '$jenis_nama_barang', '$merek_model', '$no_seri_pabrik', '$ukuran', '$warna', '$bahan', '$tahun_pembuatan_pembelian', '$harga_barang', '$no_kode_barang', '$jumlah_barang_register', '$keadaan_barang'
        )";

        if (mysqli_query($conn, $query_insert)) {
            $success_message = "Data barang berhasil ditambahkan!";
            $action = 'list'; // Kembali ke tampilan list setelah berhasil
        } else {
            $error_message = "Gagal menambahkan data barang: " . mysqli_error($conn);
        }
    }

    // UPDATE (Edit Barang)
    if ($action == 'edit' && isset($_POST['submit_edit'])) {
        $no_urut = mysqli_real_escape_string($conn, $_POST['no_urut']);
        $jenis_nama_barang = mysqli_real_escape_string($conn, $_POST['jenis_nama_barang']);
        $merek_model = mysqli_real_escape_string($conn, $_POST['merek_model']);
        $no_seri_pabrik = mysqli_real_escape_string($conn, $_POST['no_seri_pabrik']);
        $ukuran = mysqli_real_escape_string($conn, $_POST['ukuran']);
        $warna = mysqli_real_escape_string($conn, $_POST['warna']);
        $bahan = mysqli_real_escape_string($conn, $_POST['bahan']);
        $tahun_pembuatan_pembelian = mysqli_real_escape_string($conn, $_POST['tahun_pembuatan_pembelian']);
        $harga_barang = mysqli_real_escape_string($conn, $_POST['harga_barang']); // Kolom harga_barang
        $no_kode_barang = mysqli_real_escape_string($conn, $_POST['no_kode_barang']);
        $jumlah_barang_register = mysqli_real_escape_string($conn, $_POST['jumlah_barang_register']);
        $keadaan_barang = mysqli_real_escape_string($conn, $_POST['keadaan_barang']);

        $query_update = "UPDATE barang SET
            no_urut = '$no_urut',
            jenis_nama_barang = '$jenis_nama_barang',
            merek_model = '$merek_model',
            no_seri_pabrik = '$no_seri_pabrik',
            ukuran = '$ukuran',
            warna = '$warna',
            bahan = '$bahan',
            tahun_pembuatan_pembelian = '$tahun_pembuatan_pembelian',
            harga_barang = '$harga_barang',    -- Kolom harga_barang
            no_kode_barang = '$no_kode_barang',
            jumlah_barang_register = '$jumlah_barang_register',
            keadaan_barang = '$keadaan_barang'
            WHERE id_barang = '$id_barang'
        ";

        if (mysqli_query($conn, $query_update)) {
            $success_message = "Data barang berhasil diupdate!";
            $action = 'list'; // Kembali ke tampilan list setelah berhasil
        } else {
            $error_message = "Gagal mengupdate data barang: " . mysqli_error($conn);
        }
    }

    // DELETE (Hapus Barang)
    if ($action == 'delete') {
        if (!empty($id_barang)) {
            $query_delete = "DELETE FROM barang WHERE id_barang = '$id_barang'";
            if (mysqli_query($conn, $query_delete)) {
                $success_message = "Data barang berhasil dihapus!";
            } else {
                $error_message = "Gagal menghapus data barang: " . mysqli_error($conn);
            }
        } else {
            $error_message = "ID barang tidak valid untuk dihapus!";
        }
        $action = 'list'; // Selalu kembali ke tampilan list setelah delete
    }

    // Mengambil data untuk form edit (jika action adalah 'edit')
    $current_barang = null;
    if ($action == 'edit' && !empty($id_barang)) {
        $query_select_edit = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
        $result_edit = mysqli_query($conn, $query_select_edit);
        $current_barang = mysqli_fetch_assoc($result_edit);
        if (!$current_barang) {
            $error_message = "Data barang tidak ditemukan!";
            $action = 'list'; // Kembali ke tampilan list jika data tidak ada
        }
    }

?>

<h3 class="page-tittle">Data Inventaris Barang</h3>

<?php if (!empty($success_message)): ?>
    <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        <?= $success_message ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        <?= $error_message ?>
    </div>
<?php endif; ?>

<?php if ($action == 'list'): ?>
    <a href="?action=add" class="btn btn-add">Tambah Barang</a>

    <div>
        <table class="table">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>No. Urut</th>
                    <th>Jenis/Nama Barang</th>
                    <th>Merek/Model</th>
                    <th>No. Seri Pabrik</th>
                    <th>Ukuran</th>
                    <th>Warna</th>
                    <th>Bahan</th>
                    <th>Tahun Pembuatan/Pembelian</th>
                    <th>Harga Barang</th>
                    <th>No. Kode Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Keadaan Barang</th>
                    <th width="120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query_list = "SELECT * FROM barang ORDER BY id_barang DESC";
                    $list_barang = mysqli_query($conn, $query_list);
                ?>
                <?php if (mysqli_num_rows($list_barang) > 0) : ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($list_barang)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['no_urut'] ?></td>
                            <td><?= $row['jenis_nama_barang'] ?></td>
                            <td><?= $row['merek_model'] ?></td>
                            <td><?= $row['no_seri_pabrik'] ?></td>
                            <td><?= $row['ukuran'] ?></td>
                            <td><?= $row['warna'] ?></td>
                            <td><?= $row['bahan'] ?></td>
                            <td><?= $row['tahun_pembuatan_pembelian'] ?></td>
                            <td>Rp<?= number_format($row['harga_barang'], 2, ',', '.') ?></td>
                            <td><?= $row['no_kode_barang'] ?></td>
                            <td><?= $row['jumlah_barang_register'] ?></td>
                            <td><?= $row['keadaan_barang'] ?></td>
                            <td>
                                <a href="?action=edit&id=<?= $row['id_barang'] ?>" class="btn btn-edit">Edit</a>
                                <a href="?action=delete&id=<?= $row['id_barang'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="14" style="text-align: center;">Tidak ada data barang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($action == 'add'): ?>

    <h3 class="page-tittle">Tambah Data Barang</h3>
    <div class="form-card">
        <form action="?action=add" method="POST">
            <div class="input-grup">
                <label for="no_urut">No. Urut:</label>
                <input type="text" name="no_urut" id="no_urut" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="jenis_nama_barang">Jenis Barang/Nama Barang:</label>
                <input type="text" name="jenis_nama_barang" id="jenis_nama_barang" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="merek_model">Merek/Model:</label>
                <input type="text" name="merek_model" id="merek_model" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="no_seri_pabrik">No. Seri Pabrik:</label>
                <input type="text" name="no_seri_pabrik" id="no_seri_pabrik" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="ukuran">Ukuran:</label>
                <input type="text" name="ukuran" id="ukuran" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="warna">Warna:</label>
                <input type="text" name="warna" id="warna" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="bahan">Bahan:</label>
                <input type="text" name="bahan" id="bahan" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="tahun_pembuatan_pembelian">Tahun Pembuatan/Pembelian:</label>
                <input type="text" name="tahun_pembuatan_pembelian" id="tahun_pembuatan_pembelian" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="harga_barang">Harga Barang:</label>
                <input type="number" step="0.01" name="harga_barang" id="harga_barang" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="no_kode_barang">No. Kode Barang:</label>
                <input type="text" name="no_kode_barang" id="no_kode_barang" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="jumlah_barang_register">Jumlah Barang/Register:</label>
                <input type="number" name="jumlah_barang_register" id="jumlah_barang_register" class="input-control" required>
            </div>
            <div class="input-grup">
                <label for="keadaan_barang">Keadaan Barang:</label>
                <select name="keadaan_barang" id="keadaan_barang" class="input-control" required>
                    <option value="">-- Pilih Keadaan --</option>
                    <option value="Baik">Baik</option>
                    <option value="Kurang Baik">Kurang Baik</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
            <div style="margin-top: 20px;">
                <button type="submit" name="submit_add" class="btn-submit">Simpan</button>
                <a href="barang.php" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>

<?php elseif ($action == 'edit' && $current_barang): ?>

    <h3 class="page-tittle">Edit Data Barang</h3>
    <div class="form-card">
        <form action="?action=edit&id=<?= $id_barang ?>" method="POST">
            <div class="input-grup">
                <label for="no_urut">No. Urut:</label>
                <input type="text" name="no_urut" id="no_urut" class="input-control" value="<?= $current_barang['no_urut'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="jenis_nama_barang">Jenis Barang/Nama Barang:</label>
                <input type="text" name="jenis_nama_barang" id="jenis_nama_barang" class="input-control" value="<?= $current_barang['jenis_nama_barang'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="merek_model">Merek/Model:</label>
                <input type="text" name="merek_model" id="merek_model" class="input-control" value="<?= $current_barang['merek_model'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="no_seri_pabrik">No. Seri Pabrik:</label>
                <input type="text" name="no_seri_pabrik" id="no_seri_pabrik" class="input-control" value="<?= $current_barang['no_seri_pabrik'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="ukuran">Ukuran:</label>
                <input type="text" name="ukuran" id="ukuran" class="input-control" value="<?= $current_barang['ukuran'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="warna">Warna:</label>
                <input type="text" name="warna" id="warna" class="input-control" value="<?= $current_barang['warna'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="bahan">Bahan:</label>
                <input type="text" name="bahan" id="bahan" class="input-control" value="<?= $current_barang['bahan'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="tahun_pembuatan_pembelian">Tahun Pembuatan/Pembelian:</label>
                <input type="text" name="tahun_pembuatan_pembelian" id="tahun_pembuatan_pembelian" class="input-control" value="<?= $current_barang['tahun_pembuatan_pembelian'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="harga_barang">Harga Barang:</label>
                <input type="number" step="0.01" name="harga_barang" id="harga_barang" class="input-control" value="<?= $current_barang['harga_barang'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="no_kode_barang">No. Kode Barang:</label>
                <input type="text" name="no_kode_barang" id="no_kode_barang" class="input-control" value="<?= $current_barang['no_kode_barang'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="jumlah_barang_register">Jumlah Barang/Register:</label>
                <input type="number" name="jumlah_barang_register" id="jumlah_barang_register" class="input-control" value="<?= $current_barang['jumlah_barang_register'] ?>" required>
            </div>
            <div class="input-grup">
                <label for="keadaan_barang">Keadaan Barang:</label>
                <select name="keadaan_barang" id="keadaan_barang" class="input-control" required>
                    <option value="">-- Pilih Keadaan --</option>
                    <option value="Baik" <?= ($current_barang['keadaan_barang'] == 'Baik') ? 'selected' : '' ?>>Baik</option>
                    <option value="Kurang Baik" <?= ($current_barang['keadaan_barang'] == 'Kurang Baik') ? 'selected' : '' ?>>Kurang Baik</option>
                    <option value="Rusak Berat" <?= ($current_barang['keadaan_barang'] == 'Rusak Berat') ? 'selected' : '' ?>>Rusak Berat</option>
                </select>
            </div>
            <div style="margin-top: 20px;">
                <button type="submit" name="submit_edit" class="btn-submit">Update</button>
                <a href="barang.php" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>

<?php endif; ?>

<?php require_once 'footer_template.php'; ?>