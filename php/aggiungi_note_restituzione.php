<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Aggiungi note restituzione</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Aggiungi note restituzione</h1>
        <?php
            include "config.php";

            try {
                // Recupera i dati dal form
                $codice_noleggio = $_POST['codice_noleggio'] ?? '';
                $note = $_POST['note'] ?? '';

                // Verifica che tutti i campi siano compilati
                if (!$codice_noleggio || !$note) {
                    throw new Exception("Compila tutti i campi.");
                }

                // Connessione al database
                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
                if (!$conn) {
                    throw new Exception("Errore di connessione al database: " . mysqli_connect_error());
                }

                // Aggiorna le note di restituzione
                $sql = "UPDATE Noleggi 
                        SET note_restituzione = '$note'
                        WHERE codice_noleggio = $codice_noleggio";

                if (mysqli_query($conn, $sql)) {
                    if (mysqli_affected_rows($conn) > 0) {
                        echo "Note aggiunte con successo.";
                    } else {
                        throw new Exception("Nessun noleggio trovato con il codice inserito.");
                    }
                } else {
                    throw new Exception("Errore nell'aggiornamento delle note: " . mysqli_error($conn));
                }

                mysqli_close($conn);
            } catch (Exception $e) {
                echo "Si è verificato un errore: " . $e->getMessage();
            }
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>