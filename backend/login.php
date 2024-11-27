<?php
session_start();
require './../config/db.php';

if(isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = mysqli_query($db_connect,"SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($user) > 0) {
        $data = mysqli_fetch_assoc($user);
        
        if(password_verify($password,$data['password'])) {
            // echo "selamat datang ".$data['name'];
            // die;

            //otorisasi
            $_SESSION['name'] = $data['name'];
            $_SESSION['role'] = $data['role'];

            if($_SESSION['role'] == 'admin') {
                header('Location: ./../admin.php');
            } else {
                header('Location: ./../profile.php');
            }
        } else {
            $_SESSION['error'] = 'Password salah.';
            header('Location: ./../index.php');
            exit();
        }

    } else {
        $_SESSION['error'] = 'Email atau password salah.';
        header('Location: ./../index.php');
        exit();
    }
}
?>