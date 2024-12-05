<?php
include 'koneksi.php';


$sql = "SELECT * FROM data_sampah";
$result = $conn->query($sql);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM data_sampah WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $status = "success"; 
        echo '<script>window.location.href= "DaftarSetoranSampah.php"</script>';
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
    <title>
        Daftar Setoran Sampah
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-white">
    <div class="bg-teal-500 p-4 flex items-center justify-between">
        <a href="Pencarian.php" class="mr-4">
            <i class="fas fa-chevron-right text-white text-2xl"></i>
        </a>
        <h1 class="text-white text-2xl font-bold text-center flex-grow">
            Daftar Setoran Sampah
        </h1>
    </div>
    <div class="p-4">
        <div class="flex items-center mb-4">
            <input class="p-2 border border-gray-300 rounded mr-2" placeholder="Cari Setoran" type="text" />
            <button class="bg-gray-200 p-2 rounded" onclick="window.location.href = 'SetoranSampah.php'">
                + Setoran Baru
            </button>
        </div>
        <table class="min-w-full bg-gray-100 rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">
                        No
                    </th>
                    <th class="py-2 px-4 border-b">
                        Nama
                    </th>
                    <th class="py-2 px-4 border-b">
                        Id Nasabah
                    </th>
                    <th class="py-2 px-4 border-b">
                        Tanggal
                    </th>
                    <th class="py-2 px-4 border-b">
                        Total Harga
                    </th>
                    <th class="py-2 px-4 border-b">
                        Jenis Sampah
                    </th>
                    <th class="py-2 px-4 border-b">
                        Berat Sampah
                    </th>
                    <th class="py-2 px-4 border-b">
                        Aksi
                    </th>
                </tr>
            </thead>
            <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                ?>
            <tbody>
                <tr class="text-center">
                    <td class="py-2 px-4 border-b">
                        <?php echo $counter; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <?php echo $row["nama"]; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <?php echo $row["id_nasabah"]; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <?php echo $row["tanggal"]; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <?php echo $row["harga"]; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <?php echo $row["jenis"]; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <?php echo $row["berat"]; ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="?delete_id=<?php echo $row['id']; ?>"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a class="fas fa-edit text-gray-600 cursor-pointer ml-2"
                            href="SetoranSampah.php?id=<?php echo $row['id']; ?>">
                        </a>
                        <i class="fas fa-eye text-gray-600 cursor-pointer ml-2">
                        </i>
                    </td>
                </tr>
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