<?php
// Check if 'code' parameter is set in the URL
if (isset($_GET['code'])) {
    // Display the highlighted source code of this file and terminate execution
    die(highlight_file(__FILE__, 1));
}
require_once("conf.php");
global $yhendus;
session_start();

//kontrollime kas väljad  login vormis on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $cool = 'grave';
    $krypt = crypt($pass, $cool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $kask = $yhendus->prepare("SELECT kasutaja, onAdmin FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $krypt);
    $kask->bind_result($kasutaja, $onAdmin);
    $kask->execute();
    //kui on, siis loome sessiooni ja suuname
    if ($kask->fetch()) {
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        $_SESSION['onAdmin'] = $onAdmin;
        if ($onAdmin == 1) {
            header('Location: veoAdminLeht.php');}
        else {
                header('Location: veoLisamine.php');
            }
            $yhendus->close();
            exit();

    } else {
        echo "kasutaja $login või parool $krypt on vale";
        $yhendus->close();
    }
}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="formStyle.css">
    <title>Tantsud tähtedega</title>
</head>
<h1>Login</h1>
<form action="" method="post">
<table>
    <tr>
        <td>
            <input type="text" name="login" placeholder="login"><br>
        </td>
    </tr>
    <tr>
        <td>
            <input type="password" name="pass" placeholder="pass"><br>
        </td>
    </tr>
    <tr>
        <td>
            <input type="submit" value="Logi sisse">
        </td>
    </tr>
    <tr>
        <td>
            <a href="veoLisamine.php">X</a>
        </td>
    </tr>
</table>
</form>





