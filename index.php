<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>mein Startseite</title>
</head>

<body>
    <?php session_start(); ?>
    <h1>Startseite</h1>

    <ul>
        <li>
            <a href="https://www.google.com/">Google</a>
        </li>
        <li>
            <a href="https://news.orf.at/">News - ORF</a>
        </li>
        <li>
            <a href="https://www.derstandard.at/consent/tcf/">Standard</a>
        </li>
        <li>
            <a href="https://www.wifisalzburg.at/">WIFI</a>
        </li>
        <li>
            <a href="https://www.google.com/">...</a>
        </li>
    </ul>

    <form action="logic.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="Nachname">Nachname:</label>
        <input type="text" id="Nachname" name="Nachname" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="Passwort">Passwort:</label>
        <input type="password" id="Passwort" name="Passwort" required><br>
        <button type="submit">Submit</button>
    </form>
    <?php 
 if (isset($_SESSION['errorCreate'])) {
    echo '<p style="color: red">' . $_SESSION['errorCreate'] . '</p>';
    unset($_SESSION['errorCreate']);
}
if (isset($_SESSION['successCreate'])) {
    echo '<p style="color: green">' . $_SESSION['successCreate'] . '</p>';
    unset($_SESSION['successCreate']); 
}?>
    <hr>
    <h1>Login</h1>
    <form action="loginLogic.php" method="POST">
        <label for="emailLogin">Email:</label>
        <input type="email" id="emailLogin" name="emailLogin" required><br>
        <label for="passwordLogin">Passwort:</label>
        <input type="password" id="passwordLogin" name="passwordLogin" required><br>
        <button type="submit">Submit</button>
        <?php 
 if (isset($_SESSION['error'])) {
    echo '<p style="color: red">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<p style="color: green">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
?>
    </form>
    <hr>
    <h1>Search DB entries for names</h1>
    <form action="searchLogic.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        <button type="submit">Search</button>
    </form>
    <div>
        <table>
            <tr>
                <th>UserId</th>
                <th>Name</th>
                <th>Nachname</th>
                <th>email</th>
            </tr>

            <?php
 if (isset($_SESSION['data'])) {
    foreach($_SESSION['data'] as $row)
    {?>
            <tr>
                <?php
            foreach($row as $item)
            {
            ?>
                <td><?php echo "$item"?></td>
                <?php 
            }
            ?>
            </tr>
            <?php
    }
    unset($_SESSION['data']);
}
?>
        </table>
    </div>

</body>

</html>