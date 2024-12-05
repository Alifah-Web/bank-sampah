<?php
include 'koneksi.php';


$sql = "SELECT * FROM nasabah";
$result = $conn->query($sql);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM nasabah WHERE id_nasabah = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $status = "success"; 
        echo '<script>window.location.href= "DataNasabah.php"</script>';
    } else {
        $status = "error";
    }

    $stmt->close();
}

if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo "<div class='p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg' role='alert'>
            Data berhasil dihapus!
          </div>";
}


$conn->close();
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Data Nasabah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-white">
    <div class="bg-teal-500 p-4">
        <div class="flex items-center justify-between">
            <a href="Pencarian.php" class="text-white text-3xl mr-4">
                <i class="fas fa-chevron-right"></i>
            </a>
            <h1 class="text-white text-2xl font-bold text-center flex-grow">Data Nasabah</h1>
            <div class="w-10"></div> <!-- Placeholder to balance the flex layout -->
        </div>
        <div class="mt-4 flex space-x-2">
            <input type="text" placeholder="Cari Nasabah" class="bg-gray-200 text-black px-4 py-2 rounded" />
            <button class="bg-gray-400 text-black px-4 py-2 rounded"
                onclick="window.location.href= 'DaftarkanNasabah.php'">+ Tambah Nasabah</button>
        </div>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full bg-gray-300 text-left">
                    <th class="py-2 px-4">No</th>
                    <th class="py-2 px-4">Tanggal Regis</th>
                    <th class="py-2 px-4">Nasabah</th>
                    <th class="py-2 px-4">Alamat</th>
                    <th class="py-2 px-4">Telepon</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        // $id = $row['id'];
                        // $saldo = $row['masuk'] + $row['keluar'];
                ?>
            <tbody>
                <tr>
                    <td class="py-2 px-4"><?php echo $counter; ?></td>
                    <td class="py-2 px-4"><?php echo $row["tanggal"]; ?></td>
                    <td class="py-2 px-4"><?php echo $row["nama"]; ?></td>
                    <td class="py-2 px-4"><?php echo $row["alamat"]; ?></td>
                    <td class="py-2 px-4"><?php echo $row["kontak"]; ?></td>
                    <td class="py-2 px-4">
                        <a href="?delete_id=<?php echo $row['id_nasabah']; ?>"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a class="fas fa-edit text-gray-600 cursor-pointer ml-2"
                            href="DaftarkanNasabah.php?id=<?php echo $row['id_nasabah']; ?>">
                        </a>
                        <i class="fas fa-eye text-gray-600 cursor-pointer ml-2"></i>
                    </td>
                </tr>
                <!-- Repeat for each row as needed -->
            </tbody>
            <?php
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='12'>No data available</td></tr>";
                }
                ?>
        </table>
    </div>
</body>

</html>