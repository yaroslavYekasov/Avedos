**Avedos Logistika,**

on veebisait ***tellimuste täitmiseks, muutmiseks, vastuvõtmiseks ja kustutamiseks***.

Kõigepealt peaksite sisse logima <sub>süsteemi</sub>, kui teil on juba konto. Kui ei ole, peate selle looma ja seejärel sisse logima.

    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $cool = 'grave';
    $krypt = crypt($pass, $cool);
Siin näete, et teie loodud paroolid on <sub>krüpteeritud</sub> andmebaasis, nii et keegi ei pääse neile ligi.

Kui olete registreerunud tavakasutajana, saate täita ainult tühikud tellimuse üksikasjadega **(alguse koht, lõpu koht, kuupäev)**.

    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO veod (algus, ots, aeg) VALUES (?, ?, ?)");
    $kask->bind_param("sss", $_POST["algus"], $_POST["ots"], $_POST["aeg"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $kask->close();
    $yhendus->close();
Kui olete administraator, saate kasutada nii ***admin kui ka kasutaja lehekülge***. Administraatori lehel saate jätkata **tellimuste täitmist, määrata juhi, sisestada auto numbrimärgi ja esitada või kustutada tellimusi**.
