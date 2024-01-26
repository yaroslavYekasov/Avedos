<?php
// Check if 'code' parameter is set in the URL
if (isset($_GET['code'])) {
    // Display the highlighted source code of this file and terminate execution
    die(highlight_file(__FILE__, 1));
}

require_once('conf.php');
session_start();

if (isset($_REQUEST["punktid0"])) {
    global $yhendus;
    $kask = $yhendus->prepare("UPDATE tantsud set punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["punktid0"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

// Kui peitmine parameeter on määratud, siis muuda veo seisundit (valmis=0).
if (isset($_REQUEST["peitmine"])) {
    global $yhendus;
    $kask = $yhendus->prepare("UPDATE veod set valmis=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["peitmine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

// Kui naitmine parameeter on määratud, siis muuda veo seisundit (valmis=1).
if (isset($_REQUEST["naitmine"])) {
    global $yhendus;
    $kask = $yhendus->prepare("UPDATE veod set valmis=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["naitmine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

// Kui kustutapaar parameeter on määratud, siis kustuta veo paar vastavalt id-le.
if (isset($_REQUEST["kustutapaar"])) {
    global $yhendus;
    $kask = $yhendus->prepare("DELETE FROM veod WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutapaar"]);
    $kask->execute();
}

// Kui autonr parameeter on määratud, siis uuenda veo autonumbrit ja juhti vastavalt id-le.
if (isset($_REQUEST["autonr"])) {
    $autonr = $_POST['autonr'];
    $juht = $_POST['juht'];
    $id = $_POST['id'];
    $autonr = ($_POST['autonr'] === "") ? null : $_POST['autonr'];
    $juht = ($_POST['juht'] === "") ? null : $_POST['juht'];

    $stmt = $yhendus->prepare("UPDATE veod SET autonr=?, juht=? WHERE id=?");
    $stmt->bind_param("ssi", $autonr, $juht, $id);
    $stmt->execute();
    $stmt->close();
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
    <title>Avedos_Admin</title>
</head>

<body>
<!-- HTML kehaosa algus -->
<p>
    <?php
    // Kasutaja sisselogimise staatuse kontrollimine
    if (isset($_SESSION['kasutaja'])) {
    ?>
<a href="logout.php">Logi välja</a>
<?php
} else {
    ?>
    <a href="login.php">Logi sisse</a>
    <?php
}
?>
</p>
<h1>Avedos</h1>
<nav>
    <ul>
        <!-- Navigeerimise lingid admin-lehele ja veo lisamise lehele -->
        <li>
            <a href="veoAdminLeht.php">Admin leht</a>
        </li>
        <li>
            <a href="veoLisamine.php">Sissestamine leht</a>
        </li>
    </ul>
</nav>
<h1>Lisa auto number ja autojuhi</h1>
<table>
    <tr>
        <th>#</th>
        <th>algus</th>
        <th>ots</th>
        <th>aeg</th>
        <th>autonr</th>
        <th>juht</th>
    </tr>
    <?php
    global $yhendus;

    // Vali veod, kus autonr või juht on puudu
    $kask = $yhendus->prepare("SELECT id, algus, ots, aeg, autonr, juht FROM veod WHERE autonr IS NULL OR juht IS NULL");
    $kask->bind_result($id, $algus, $ots, $aeg, $autonr, $juht);
    $kask->execute();

    // Kuvatakse veod, kus autonr või juht on puudu
    while ($kask->fetch()) {
        echo "<tr>";
        echo "<td>" . $id . "</td>";
        echo "<td>" . $algus . "</td>";
        echo "<td>" . $ots . "</td>";
        echo "<td>" . $aeg . "</td>";
        ?>
        <form action="?" method="post">
            <td>
                <!-- Valikud autonumbri valikuks -->
                <select id="autonr" name="autonr" required>
                    <option value="">-</option>
                    <option value="1234">1234</option>
                    <option value="6473">6473</option>
                    <option value="5678">5678</option>
                    <option value="9876">9876</option>
                    <option value="4321">4321</option>
                    <option value="8765">8765</option>
                    <option value="2345">2345</option>
                    <option value="7890">7890</option>
                    <option value="3456">3456</option>
                    <option value="6789">6789</option>
                    <option value="4567">4567</option>
                    <option value="8901">8901</option>
                    <option value="1235">1235</option>
                    <option value="5671">5671</option>
                </select>

            </td>
            <td>
                <!-- Valikud juhi valikuks -->
                <select id="juht" name="juht" required>
                    <option value="">-</option>
                    <option value="Kara">Kara</option>
                    <option value="Smith">Smith</option>
                    <option value="Johnson">Johnson</option>
                    <option value="Williams">Williams</option>
                    <option value="Jones">Jones</option>
                    <option value="Brown">Brown</option>
                    <option value="Davis">Davis</option>
                    <option value="Miller">Miller</option>
                    <option value="Wilson">Wilson</option>
                    <option value="Moore">Moore</option>
                    <option value="Taylor">Taylor</option>
                    <option value="Anderson">Anderson</option>
                </select>

            </td>
            <td id='phplink'>
                <!-- Peidetud väljad - id ja submit nupp -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" value="Submit">
            </td>
        </form>
        <?php
    }
    ?>
</table>

</br>
<h1>Korras</h1>
<table>
    <tr>
        <th>#</th>
        <th>algus</th>
        <th>ots</th>
        <th>aeg</th>
        <th>autonr</th>
        <th>juht</th>
        <th>valmis</th>
    </tr>
    <?php
    global $yhendus;

    // Vali valmisolekuga veod, kus autonr ja juht on määratud
    $kask = $yhendus->prepare("SELECT id, algus, ots, aeg, autonr, juht, valmis FROM veod WHERE valmis = 0 AND (autonr IS NOT NULL AND juht IS NOT NULL)");
    $kask->bind_result($id, $algus, $ots, $aeg, $autonr, $juht, $valmis);
    $kask->execute();

    // Kuvatakse valmisolekuga veod, kus autonr ja juht on määratud
    while ($kask->fetch()) {
        $tekst = "Valmis";
        $seisund = "naitmine";
        if ($valmis == 1) {
            $tekst = "Pole valmis";
            $seisund = "peitmine";
        } else if ($valmis == 0) {
            $tekst = "Valmis";
            $seisund = "naitmine";
        }
        echo "<tr>";
        echo "<td>" . $id . "</td>";
        echo "<td>" . $algus . "</td>";
        echo "<td>" . $ots . "</td>";
        echo "<td>" . $aeg . "</td>";
        echo "<td>" . $autonr . "</td>";
        echo "<td>" . $juht . "</td>";
        echo "<td>" . $valmis . "</td>";
        echo "<td id='phplink'><a href='?$seisund=$id'>$tekst</a></td>";
        echo "<td id='phplink'><a href='?kustutapaar=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</br>

<h1>Kõik tabel</h1>
<table>
    <tr>
        <th>#</th>
        <th>algus</th>
        <th>ots</th>
        <th>aeg</th>
        <th>autonr</th>
        <th>juht</th>
        <th>valmis</th>
    </tr>
    <?php
    global $yhendus;

    // Vali kõik veod koos autonumbri, juhi ja valmisolekuga
    $kask = $yhendus->prepare("SELECT id, algus, ots, aeg, autonr, juht, valmis FROM veod ");
    $kask->bind_result($id, $algus, $ots, $aeg, $autonr, $juht, $valmis);
    $kask->execute();

    // Kuvatakse kõik veod koos autonumbri, juhi ja valmisolekuga
    while ($kask->fetch()) {
        $tekst = "Valmis";
        $seisund = "naitmine";
        if ($valmis == 1) {
            $tekst = "Pole valmis";
            $seisund = "peitmine";
        } else if ($valmis == 0) {
            $tekst = "Valmis";
            $seisund = "naitmine";
        }
        echo "<tr>";
        echo "<td>" . $id . "</td>";
        echo "<td>" . $algus . "</td>";
        echo "<td>" . $ots . "</td>";
        echo "<td>" . $aeg . "</td>";
        echo "<td>" . $autonr . "</td>";
        echo "<td>" . $juht . "</td>";
        echo "<td>" . $valmis . "</td>";
        echo "<td id='phplink'><a href='?kustutapaar=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>

</html>
