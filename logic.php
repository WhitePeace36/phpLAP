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
$nachname = $_REQUEST["Nachname"];
$email = $_REQUEST["email"];
$password = $_REQUEST["Passwort"];

echo "$name";
echo "$nachname";
echo "$email";
echo "$password";

$salt="123124123124123";

$encrypted_pw = hash("sha256",$password.$salt);

$stmt = $conn->prepare('insert into user(Name,Nachname,email,password) values (?,?,?,?)');
$stmt->bind_param("ssss", $name, $nachname,$email,$encrypted_pw);


try {
    $result = $stmt->execute();
    if ($result) {
        $_SESSION["successCreate"] = "Successfully created Account!";
        header("Location: index.php");
        exit;
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        // Duplicate entry error
        $_SESSION["errorCreate"] = "Email already exists!";
    } else {
        // Other SQL errors
        $_SESSION["errorCreate"] = "Something went wrong for account creation!";
    }
    header("Location: index.php");
    exit;
}