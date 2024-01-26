<?php
// Check if 'code' parameter is set in the URL
if (isset($_GET['code'])) {
    // Display the highlighted source code of this file and terminate execution
    die(highlight_file(__FILE__, 1));
}

require_once('conf.php');
session_start();

// Kui vormi andmed on saadetud ja algus väli ei ole tühi, siis lisatakse uus veo kirje.
if (isset($_POST["algus"]) && !empty($_POST["algus"])) {
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO veod (algus, ots, aeg) VALUES (?, ?, ?)");
    $kask->bind_param("sss", $_POST["algus"], $_POST["ots"], $_POST["aeg"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $kask->close();
    $yhendus->close();
}

// Funktsioon, mis tagastab kasutaja administraatori staatuse.
function isAdmin()
{
    return isset($_SESSION['onAdmin']) && $_SESSION['onAdmin'];
}
?>

<!doctype html>
<html lang="et">

<head>
    <!-- HTML peaosa, määratud meta andmed ja stiilileht -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Avedos_Sissestamine</title>
</head>

<body>
<!-- HTML kehaosa algus -->
<p>
    <?php
    // Kasutaja sisselogimise staatuse kontrollimine
    if (isset($_SESSION['kasutaja'])) {
    ?>
<h1 id="avd">Avedos logistika</h1>
<?php
} else {
    ?>
    <a href="login.php">Logi sisse</a>
    <a href="registreeeimine.php">Registreerimine</a>
    <?php
}
?>
</p>
<?php if (isAdmin()) { ?>
    <!-- Administraatori menüü, kuvatakse ainult administraatorile -->
    <nav>
        <ul>
            <li>
                <a href="veoAdminLeht.php">Admin leht</a>
            </li>
            <li>
                <a href="veoLisamine.php">Sissestamine leht</a>
            </li>
        </ul>
    </nav>
<?php } ?>
<?php if (isset($_SESSION["kasutaja"])) { ?>
    <!-- Vorm veo andmete sisestamiseks, kuvatakse ainult sisseloginud kasutajale -->
    <form action="?" method="post">
        <table id="registr">
            <tr>
                <td>
                    <label for="algus">Algus:</label>
                    <input type="text" id="algus" name="algus" required>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="ots">Ots:</label>
                    <input type="text" id="ots" name="ots" required>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="aeg">Aeg:</label>
                    <input type="date" id="aeg" name="aeg" required>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Submit">
                </td>
            </tr>

            <tr>
                <td>
                    <a id="logout" href="logout.php">Logi välja</a>
                </td>
            </tr>
        </table>
    </form>
<?php } ?>
</body>

</html>
