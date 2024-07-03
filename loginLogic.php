<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

session_start();
// Create connection

$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $_REQUEST["emailLogin"];
$password = $_REQUEST["passwordLogin"];

$query = $conn->prepare("select password from user where email=?;");
$query->bind_param("s",$email);

$query->execute();

$query->bind_result($passwordFromDB);


if ($query->fetch()) {
} else {
    $_SESSION["error"]= "No Record Found !!!";
    header("Location:index.php");
}

$salt="123124123124123";
$encrypted_pw = hash("sha256",$password.$salt);

if( $encrypted_pw == $passwordFromDB){
    $_SESSION["success"]= "Successfully logged in !!";
}else{
    $_SESSION["error"]= "False Password !!";

}

header("Location:index.php");