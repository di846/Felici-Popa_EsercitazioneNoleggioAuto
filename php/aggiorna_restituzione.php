<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Restituzione auto</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Restituzione auto</h1>
        <?php
            include "config.php";

            // Recupera i dati dal form
            $codice_noleggio = $_POST['codice_noleggio'] ?? '';
            $data_restituzione = $_POST['data_restituzione'] ?? '';

            if (!$codice_noleggio || !$data_restituzione) {
                echo "Compila tutti i campi.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Aggiorna la data di restituzione del noleggio
            $sql = "UPDATE Noleggi 
                    SET auto_restituita = '$data_restituzione'
                    WHERE codice_noleggio = $codice_noleggio";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    // Recupera la targa dell'auto noleggiata
                    $sql_auto = "SELECT auto FROM Noleggi WHERE codice_noleggio = $codice_noleggio";
                    $result_auto = mysqli_query($conn, $sql_auto);
                    if ($row = mysqli_fetch_assoc($result_auto)) {
                        $targa = $row['auto'];
                        // Imposta l'auto come disponibile
                        $sql_update_auto = "UPDATE Auto SET disponibile = 1 WHERE targa = '$targa'";
                        mysqli_query($conn, $sql_update_auto);
                    }
                    echo "Restituzione registrata con successo e auto impostata come disponibile.";
                } else {
                    echo "Nessun noleggio trovato con il codice inserito.";
                }
            } else {
                echo "Errore nell'aggiornamento della restituzione: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>