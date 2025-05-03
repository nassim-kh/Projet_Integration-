<?php
session_start();
$conn = new mysqli("localhost", "root", "", "recettes_faciles");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password']; 

$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION["admin"] = $username;
    header("Location: ../dashboard_admin/index.php");
} else {
    echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect'); window.location.href='login.html';</script>";
}
$conn->close();
?>