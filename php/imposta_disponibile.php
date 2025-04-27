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

            try {
                // Recupera la targa dall'input POST
                $targa = $_POST['targa'] ?? '';

                if (!$targa) {
                    throw new Exception("Inserisci la targa dell'auto.");
                }

                // Connessione al database
                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
                if (!$conn) {
                    throw new Exception("Errore di connessione al database: " . mysqli_connect_error());
                }

                // Aggiorna lo stato dell'auto a disponibile
                $sql = "UPDATE Auto SET disponibile = 1 WHERE targa = '$targa'";

                if (!mysqli_query($conn, $sql)) {
                    throw new Exception("Errore nell'aggiornamento dello stato: " . mysqli_error($conn));
                }

                if (mysqli_affected_rows($conn) > 0) {
                    echo "Stato dell'auto aggiornato a disponibile.";
                } else {
                    echo "Nessuna auto trovata con la targa inserita.";
                }

                // Chiude la connessione al database
                mysqli_close($conn);
            } catch (Exception $e) {
                echo "Si è verificato un errore: " . $e->getMessage();
            }
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>