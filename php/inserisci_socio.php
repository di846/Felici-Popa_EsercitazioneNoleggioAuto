<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Inserimento nuovo socio</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Inserimento nuovo socio</h1>
        <?php
            include "config.php";

            // Recupera i dati dal form
            $cf = $_POST['cf'] ?? '';
            $cognome = $_POST['cognome'] ?? '';
            $nome = $_POST['nome'] ?? '';
            $indirizzo = $_POST['indirizzo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';

            // Verifica che tutti i campi siano compilati
            if (!$cf || !$cognome || !$nome || !$indirizzo || !$telefono) {
                echo "Compila tutti i campi.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Query per inserire un nuovo socio
            $sql = "INSERT INTO Soci (CF, cognome, nome, indirizzo, telefono) 
                    VALUES ('$cf', '$cognome', '$nome', '$indirizzo', '$telefono')";

            // Esegui la query e verifica il risultato
            if (mysqli_query($conn, $sql)) {
                echo "Socio inserito con successo.";
            } else {
                echo "Errore nell'inserimento del socio: " . mysqli_error($conn);
            }

            // Chiudi la connessione al database
            mysqli_close($conn);
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>