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
$name = $_REQUEST["name"];

$query = $conn->prepare("select userId, Name, Nachname, email from user where Name=?;");
$query->bind_param("s",$name);

$query->execute();

//$query->bind_result($userId,$Name,$nachname,$email);
$returnValue = $query->get_result();
    while($row = $returnValue->fetch_assoc()) {

        //  echo "id: " . $userId. ", Name: " . $Name. ", Nachname: " . $nachname. ", email: " . $email. "<br>";
        //$data[] = array($userId, $Name, $nachname, $email);
    $data[] = $row;
    }
$_SESSION["data"] = $data;
header("Location:index.php");