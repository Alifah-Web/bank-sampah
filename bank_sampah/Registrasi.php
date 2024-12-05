<?php
include 'koneksi.php';


if (isset($_SESSION['login'])) {
    header("Location: pembayaran.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fName = $_POST['fName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql6 = "insert into registrasi  (fName, email, password) VALUES ('$fName', '$email', '$password')";
    if (mysqli_query($conn, $sql6)) {
        echo "<script>window.location.href='login.php'</script>";
    } else {
        echo "Error: " . $sql6 . "<br>" . mysqli_error($conn);
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="Regist.css">
</head>

<body class="bg-gray-100">
    <div class="form-container">
        <div class="top-bar"></div>
        <div class="relative p-4 mt-8">
            <h2 class="text-center text-black text-xl font-bold">Buat Akun</h2>
        </div>
        <form action="" method="post" class="space-y-4 mt-4">
            <div class="input-group">
                <label for="name" class="label">Masukkan Nama</label>
                <input type="text" id="name" name="fName" class="input-field" placeholder="Masukkan Nama">
            </div>
            <div class="input-group">
                <label for="email" class="label">Masukkan Email</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="Masukkan Email">
            </div>
            <div class="input-group">
                <label for="password" class="label">Buat kata sandi</label>
                <input type="password" id="password" name="password" class="input-field" placeholder="Buat kata sandi">
            </div>
            <div class="input-group">
                <label for="confirm-password" class="label">Masukkan kembali kata sandi</label>
                <input type="password" id="confirm-password" name="password" class="input-field"
                    placeholder="Masukkan kembali kata sandi">
            </div>
            <div class="text-center">
                <button type="submit" class="submit-btn" name='submit'>Buat Akun</button>
            </div>
        </form>
    </div>
</body>

</html>