# [Avedos](https://yaroslavyekasov22.thkit.ee/Avedos/veoLisamine.php):money_mouth_face:

Esiteks, logige sisse.

![pilt](https://github.com/yaroslavYekasov/Avedos/assets/120181426/87dd304d-b488-4d0e-a8d1-f18203c0f25a)

Kui sul ei ole kontot, võid selle luua.

![pilt](https://github.com/yaroslavYekasov/Avedos/assets/120181426/d8bf2052-4f0c-4e63-8270-4470510c6ea7)

See sait on mõeldud transpordi tellimiseks, täites tühiku.

![pilt](https://github.com/yaroslavYekasov/Avedos/assets/120181426/8bcb2d4c-6950-4785-ad6f-8a1df9d40b4b)

Kui olete registreerunud administraatorina, saate tellimusi lõpetada.

![pilt](https://github.com/yaroslavYekasov/Avedos/assets/120181426/7491f9b7-46e3-4dec-ba37-8f912d2148de)

On veebisait ***tellimuste täitmiseks, muutmiseks, vastuvõtmiseks ja kustutamiseks***.

# Kood selgitada

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
Kui olete administraator, saate kasutada nii ***admin kui ka kasutaja lehekülge***. Administraatori lehel saate  
- jätkata täitmist
- määrata juhi
- sisestada auto numbrimärgi
- esitada tellimusi
- kustutada tellimusi
