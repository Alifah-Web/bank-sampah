<?php
include 'koneksi.php';

session_start();
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
	exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
$data = null;

if ($id) {
    $sql = "SELECT * FROM nasabah WHERE id_nasabah = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // $id_nasabah = isset($_POST['id_nasabah']) ? intval($_POST['id_nasabah']) : null;
    $tanggal = $_POST['tanggal'];
    $id_nasabah = intval($_POST['id_nasabah']);
    $nama = $_POST['nama_nasabah'];
    $no_reg = isset($_POST['no_registrasi']) ? intval($_POST['no_registrasi']) : null; // No registrasi dikonversi ke int
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];

    if (
        !empty($tanggal) &&
        !empty($id_nasabah) &&
        !empty($nama) &&
        is_numeric($no_reg) &&
        !empty($kontak) &&
        !empty($alamat)
    ) {
        if ($id) {
            $sql = "UPDATE nasabah SET tanggal = ?, nama = ?, no_reg = ?, kontak = ?, alamat = ? WHERE id_nasabah = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssissi", $tanggal, $nama, $no_reg, $kontak, $alamat, $id);
        } else {
            $sql = "INSERT INTO nasabah (tanggal, id_nasabah, nama, no_reg, kontak, alamat) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisdds", $tanggal, $id_nasabah, $nama, $no_reg, $kontak, $alamat);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil disimpan!'); window.location = 'DataNasabah.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan data: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Data tidak valid! Pastikan semua input telah diisi dengan benar.');</script>";
    }
}

$conn->close();
?>


<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </link>
</head>

<body class="bg-gray-800 min-h-screen">
    <div class="bg-white rounded-lg shadow-lg w-full h-full">
        <div class="bg-teal-500 rounded-t-lg p-4 h-24 flex items-center justify-between">
            <button class="bg-white text-teal-500 px-4 py-2 rounded-md flex items-center"
                onclick="window.location.href= 'DataNasabah.php'">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </button>
        </div>
        <div class="p-8 rounded-b-lg min-h-screen bg-white">
            <h1 class="text-2xl font-bold text-center mb-6">Daftarkan Nasabah</h1>
            <form action="" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="tanggal">Tanggal Registrasi</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200" type="date"
                        id="tanggal" name="tanggal" value="<?php echo isset($data['tanggal']) ? $data['tanggal'] : ''; ?>">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="id-nasabah">Id Nasabah</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200" type="text"
                        id="id-nasabah" name="id_nasabah" value="<?php echo isset($data['id_nasabah']) ? $data['id_nasabah'] : ''; ?>">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="nama-nasabah">Nama Nasabah</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200" type="text"
                        id="nama-nasabah" name="nama_nasabah" value="<?php echo isset($data['nama']) ? $data['nama'] : ''; ?>">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="no-registrasi">No.Registrasi</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200" type="text"
                        id="no-registrasi" name="no_registrasi" value="<?php echo isset($data['no_reg']) ? $data['no_reg'] : ''; ?>">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="kontak">Kontak</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200" type="text"
                        id="kontak" name="kontak" value="<?php echo isset($data['kontak']) ? $data['kontak'] : ''; ?>">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="alamat">Alamat</label>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200" type="text"
                        id="alamat" name="alamat" value="<?php echo isset($data['alamat']) ? $data['alamat'] : ''; ?>">
                </div>
                <div class="text-center">
                    <button class="bg-teal-500 text-white px-4 py-2 rounded-md" type="submit"
                        name="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>