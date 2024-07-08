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
    } ?>


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
                foreach ($_SESSION['data'] as $row) { ?>
                    <tr>
                        <?php
                        foreach ($row as $item) {
                            ?>
                            <td><?php echo "$item" ?></td>
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

    <hr>
    <h1>
        Search Database for something.
    </h1>

    <form method="POST" action="">
        <label for="databases">Select Database:</label>
        <select id="databases" name="databases" onchange="this.form.submit()">
            <option value="">Select a database</option>
            <?php
            // Fetch databases
            $servername = "localhost";
            $username = "root";
            $password = "";

            $conn = new mysqli($servername, $username, $password);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SHOW DATABASES";
            $result = $conn->query($sql);

            $databases = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $databases[] = $row["Database"];
                }
            }



            foreach ($databases as $database) {
                $selected = (isset($_POST['databases']) && $_POST['databases'] === $database) ? 'selected' : '';
                echo "<option value=\"" . $database . "\" $selected>" . $database . "</option>";
            }
            $conn->close();
            ?>
        </select>.

        <select id="tables" name="tables" onchange="this.form.submit()">
            <option value="">Select a table</option>
            <?php
            if (isset($_POST['databases']) && $_POST['databases'] !== '') {
                $selecteddb = $_POST['databases'];

                $conn = new mysqli($servername, $username, $password, $selecteddb);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sqlrequest = "show tables;";

                $tables = [];
                $result = $conn->query($sqlrequest);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tables[] = $row["Tables_in_" . $_POST['databases']];
                    }
                }

                foreach ($tables as $table) {
                    $selected = (isset($_REQUEST["tables"]) && $_REQUEST["tables"] == $table) ? "selected" : "";
                    echo "<option value=\"" . $table . "\" $selected>" . $table . "</option>";
                }
            }
            $conn->close();
            ?>

        </select>.

        <select id="headers" name="headers" onchange="this.form.submit()">
            <option value="">Select a table</option>
            <?php
            if (isset($_POST['tables']) && $_POST['tables'] !== '') {
                $selecteddb = $_POST['databases'];

                $conn = new mysqli($servername, $username, $password, $selecteddb);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sqlrequest = "describe " . $_POST['tables'] . ";";

                $headers = [];
                $result = $conn->query($sqlrequest);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $headers[] = $row["Field"];
                    }
                }

                foreach ($headers as $header) {
                    $selected = (isset($_REQUEST["headers"]) && $_REQUEST["headers"] == $header) ? "selected" : "";
                    echo "<option value=\"" . $header . "\" $selected>" . $header . "</option>";
                }
            }
            $conn->close();
            ?>
        </select>
        <label for="search">Search for:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Search</button>
        <br>
        <?php
        if (isset($_POST["search"]) && $_POST["search"] !== "") {
            
            $selecteddb = $_POST['databases'];

            $conn = new mysqli($servername, $username, $password, $selecteddb);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("select " . $_POST["headers"] . " from " . $_POST["tables"] . " where " . $_POST["headers"] = " ? ;");
            $stmt->bind_param("s", $_POST["search"]);

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                //  echo "id: " . $userId. ", Name: " . $Name. ", Nachname: " . $nachname. ", email: " . $email. "<br>";
                //$data[] = array($userId, $Name, $nachname, $email);
                $data[] = $row;
            }

            // foreach ($data as $row) {
            //     echo "<p>$row</p> <br>;";
            // }

            echo "<p>";
            foreach ($data as $row) {
                foreach ($row as $key => $value) {
                    echo "$value <br>" ;
                }
            }
            echo "</p><br>";
            $conn->close();
        }
        ?>
    </form>
    </body>

</html>