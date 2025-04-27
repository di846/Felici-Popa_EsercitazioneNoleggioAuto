<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Imposta auto disponibile</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Imposta auto come disponibile</h1>
        <?php
            include "config.php";

            // Recupera la targa dall'input POST
            $targa = $_POST['targa'] ?? '';

            if (!$targa) {
                echo "Inserisci la targa dell'auto.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Aggiorna lo stato dell'auto a disponibile
            $sql = "UPDATE Auto SET disponibile = 1 WHERE targa = '$targa'";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo "Stato dell'auto aggiornato a disponibile.";
                } else {
                    echo "Nessuna auto trovata con la targa inserita.";
                }
            } else {
                echo "Errore nell'aggiornamento dello stato: " . mysqli_error($conn);
            }

            // Chiude la connessione al database
            mysqli_close($conn);
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>