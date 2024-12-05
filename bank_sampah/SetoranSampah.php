<?php
include 'koneksi.php';


$sql_nasabah = "SELECT id_nasabah, nama FROM nasabah";
$result_nasabah = $conn->query($sql_nasabah);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
$data = null;

if ($id) {
    $sql = "SELECT * FROM data_sampah WHERE id = ?";
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
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $nama = $_POST['nama_nasabah'];
    $id_nasabah = isset($_POST['id_nasabah']) ? intval($_POST['id_nasabah']) : null;
    $tanggal = $_POST['tanggal'];
    $harga = isset($_POST['harga']) ? floatval($_POST['harga']) : null;
    $berat = isset($_POST['berat']) ? floatval($_POST['berat']) : null;
    $jenis = $_POST['jenis'];

    if (
        !empty($nama) &&
        !empty($id_nasabah) &&
        !empty($tanggal) &&
        is_numeric($harga) &&
        is_numeric($berat) &&
        !empty($jenis)
    ) {
        if ($id) {
            $sql = "UPDATE data_sampah SET nama = ?, id_nasabah = ?, tanggal = ?, harga = ?, berat = ?, jenis = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisddsi", $nama, $id_nasabah, $tanggal, $harga, $berat, $jenis, $id);
        } else {
            $sql = "INSERT INTO data_sampah (nama, id_nasabah, tanggal, harga, berat, jenis) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisdds", $nama, $id_nasabah, $tanggal, $harga, $berat, $jenis);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil disimpan!'); window.location = 'DaftarSetoranSampah.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan data: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Data tidak valid! Pastikan semua input telah diisi dengan benar.');</script>";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setoran Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        const hargaSampah = {
            "Sampah Plastik": 5000,
            "Sampah Kaca": 3000,
            "Sampah Logam": 7000,
            "Sampah Kertas": 2000,
        };

        function toggleJenisSampah() {
            const dropdown = document.getElementById('dropdown-jenis-sampah');
            dropdown.classList.toggle('hidden');
        }

        function pilihJenisSampah(jenis) {
            const jenisInput = document.getElementById('jenis-sampah');
            const beratInput = document.getElementById('berat-sampah');
            const totalHargaInput = document.getElementById('total-harga');

            jenisInput.value = jenis;

            const berat = parseFloat(beratInput.value) || 0;
            const harga = hargaSampah[jenis];
            const total = berat * harga;

            totalHargaInput.value = total;

            toggleJenisSampah();
        }

        function updateBeratSampah(increment) {
            const beratInput = document.getElementById('berat-sampah');
            const totalHargaInput = document.getElementById('total-harga');
            const jenisInput = document.getElementById('jenis-sampah');

            let berat = parseFloat(beratInput.value) || 0;

            berat += increment;

            if (berat < 0) {
                berat = 0;
            }

            beratInput.value = berat;

            const jenis = jenisInput.value;
            if (hargaSampah[jenis]) {
                const harga = hargaSampah[jenis];
                const total = berat * harga;

                totalHargaInput.value = total;
            }
        }

        function toggleNamaNasabah() {
            const dropdown = document.getElementById('dropdown-nama-nasabah');
            dropdown.classList.toggle('hidden');
        }

        function pilihNamaNasabah(nama, id) {
            document.getElementById('nama-nasabah').value = nama;
            document.getElementById('id-nasabah').value = id;
            toggleNamaNasabah();
        }
    </script>
</head>

<body class="bg-teal-500 flex items-center justify-center min-h-screen relative">
    <a href="DaftarSetoranSampah.php" class="absolute top-4 left-4">
        <i class="fas fa-chevron-left text-white text-2xl"></i>
    </a>
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8 mt-24">
        <div class="flex items-center justify-center mb-6">
            <h1 class="text-2xl font-bold text-black">Setoran Sampah</h1>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="" method="post">
                <div class="mb-4">
                    <div class="w-100 pr-2 relative">
                        <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">

                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nama-nasabah">Nama
                            Nasabah</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                            id="nama-nasabah" type="text" name="nama_nasabah" readonly placeholder="Pilih Nama Nasabah"
                            onclick="toggleNamaNasabah()"
                            value="<?php echo isset($data['nama']) ? $data['nama'] : ''; ?>">

                        <!-- Dropdown Nama Nasabah -->
                        <div id="dropdown-nama-nasabah"
                            class="absolute z-10 hidden bg-white border border-gray-300 rounded shadow-lg mt-1 w-full">
                            <ul class="text-gray-700 text-sm">
                                <?php
                                    if ($result_nasabah->num_rows > 0) {
                                        while ($row = $result_nasabah->fetch_assoc()) {
                                            echo "<li class='px-4 py-2 hover:bg-gray-100 cursor-pointer'
                                                 onclick=\"pilihNamaNasabah('{$row['nama']}', '{$row['id_nasabah']}')\">
                                                 {$row['nama']}
                                                 </li>";
                                        }
                                    } else {
                                        echo "<li class='px-4 py-2 text-gray-500'>Tidak ada data yang tersedia</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id-nasabah">Id Nasabah</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="id-nasabah" name="id_nasabah" type="text" readonly
                        value="<?php echo isset($data['id_nasabah']) ? $data['id_nasabah'] : ''; ?>">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal">Tanggal</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="tanggal" name="tanggal" type="date" placeholder="" value="<?php echo $data['tanggal']; ?>">
                </div>
                <div class="flex mb-4">
                    <!-- Jenis Sampah -->
                    <div class="w-1/2 pr-2 relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis-sampah">Jenis
                            Sampah</label>
                        <div class="relative flex">
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline cursor-pointer"
                                id="jenis-sampah" type="text" name="jenis" readonly placeholder="Pilih jenis sampah"
                                onclick="toggleJenisSampah()" value="<?php echo $data['jenis']; ?>">
                        </div>
                        <div id="dropdown-jenis-sampah"
                            class="absolute z-10 hidden bg-white border border-gray-300 rounded shadow-lg mt-1 w-full">
                            <ul class="text-gray-700 text-sm">
                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                    onclick="pilihJenisSampah('Sampah Plastik')">Sampah Plastik</li>
                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                    onclick="pilihJenisSampah('Sampah Kaca')">Sampah Kaca</li>
                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                    onclick="pilihJenisSampah('Sampah Logam')">Sampah Logam</li>
                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                    onclick="pilihJenisSampah('Sampah Kertas')">Sampah Kertas</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Berat Sampah -->
                    <div class="w-1/2 pl-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="berat-sampah">Berat
                            Sampah</label>
                        <div class="flex items-center">
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="berat-sampah" type="text" name="berat" placeholder="" readonly
                                value="<?php echo $data['berat']; ?>">
                            <button class="ml-2 bg-gray-200 text-gray-700 px-2 fw-bolder py-1 rounded-lg" type="button"
                                onclick="updateBeratSampah(-1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button class="ml-2 bg-gray-200 text-gray-700 px-2 fw-bolder py-1 rounded-lg" type="button"
                                onclick="updateBeratSampah(1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="total-harga">Total Harga</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="total-harga" type="text" name="harga" placeholder="" value="<?php echo $data['harga']; ?>">
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-teal-500 text-white px-4 py-2 rounded-lg" type="submit"
                        name="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>