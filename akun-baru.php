<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Akun Baru</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<?php

session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

//import database
include("koneksi.php");

if ($_POST) {
    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $pname = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $nik = $_SESSION['personal']['nik'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['katasandibaru'];
    $cpassword = $_POST['katasandi'];

    if ($newpassword === $cpassword) {
        $sqlmain = "SELECT * FROM webpengguna WHERE email = ?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Sudah memiliki akun untuk alamat email ini</label>';
        } else {
            // Use prepared statements for both queries
            $stmt = $database->prepare("INSERT INTO pasien (pemail, pnama, pkatasandi, palamat, pnik, pdob, ptel) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $email, $pname, $newpassword, $address, $nik, $dob, $tele);
            $stmt->execute();
            $stmt->close();

            $stmt = $database->prepare("INSERT INTO webpengguna VALUES (?, 'p')");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            $_SESSION["user"] = $email;
            $_SESSION["tipepengguna"] = "p"; // Corrected typo
            $_SESSION["username"] = $fname;

            header('Location: pasien/index.php');
            exit(); // Prevent further code execution
        }
    } else { 
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Kesalahan konfirmasi kata sandi! konfirmasi ulang kata sandi</label>';
    }    
}else{
    //header('location: daftar.php');
    $error='<label for="promter" class="form-label"></label>';
}
?>
    <center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">Mari kita mulai</p>
                    <p class="sub-text">Tidak masalah, buatlah akun pengguna sekarang</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="newemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Alamat Email" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Nomor ponsel: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="tele" class="input-text"  placeholder="contoh: 0812345678">
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="katasandibaru" class="form-label">Buat Kata Sandi Baru: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="katasandibaru" class="input-text" placeholder="Kata Sandi baru" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="katasandi" class="form-label">Konfirmasi Kata sandi: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="katasandi" class="input-text" placeholder="Konfirmasi Kata Sandi" required>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $error ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Atur Ulang" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Daftar" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Sudah memiliki akun&#63; </label>
                    <a href="masuk.php" class="hover-link1 non-style-link">Masuk</a>
                    <br><br><br>
                </td>
            </tr>
                    </form>
            </tr>
        </table>
    </div>
</center>
</body>
</html>