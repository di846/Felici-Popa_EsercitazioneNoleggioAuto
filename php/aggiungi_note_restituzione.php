<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Aggiungi note restituzione</title>
    </head>
    <body>
        <h1>Aggiungi note restituzione</h1>
        <?php
            include "config.php";

            $codice_noleggio = $_POST['codice_noleggio'] ?? '';
            $note = $_POST['note'] ?? '';

            if (!$codice_noleggio || !$note) {
                echo "Compila tutti i campi.";
                exit;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            $sql = "UPDATE Noleggi 
                    SET note_restituzione = '$note'
                    WHERE codice_noleggio = $codice_noleggio";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo "Note aggiunte con successo.";
                } else {
                    echo "Nessun noleggio trovato con il codice inserito.";
                }
            } else {
                echo "Errore nell'aggiornamento delle note: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        ?>
    </body>
</html>