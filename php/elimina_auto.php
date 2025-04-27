<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Elimina Auto</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Elimina Auto</h1>
        <?php
            include "config.php"; 

            try {
                $targa = $_POST['targa'] ?? ''; // Recupera la targa dall'input del form

                if (!$targa) {
                    // Controlla se la targa è vuota
                    throw new Exception("Inserisci la targa dell'auto da eliminare.");
                }

                // Connessione al database
                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
                if (!$conn) {
                    throw new Exception("Errore di connessione al database: " . mysqli_connect_error());
                }

                // Query per eliminare l'auto con la targa specificata
                $sql = "DELETE FROM Auto WHERE targa = '$targa'";

                if (mysqli_query($conn, $sql)) {
                    if (mysqli_affected_rows($conn) > 0) {
                        // Conferma eliminazione se l'auto è stata trovata
                        echo "Auto eliminata con successo.";
                    } else {
                        // Messaggio se nessuna auto corrisponde alla targa
                        echo "Nessuna auto trovata con la targa inserita.";
                    }
                } else {
                    // Messaggio di errore in caso di problemi con la query
                    throw new Exception("Errore nell'eliminazione dell'auto: " . mysqli_error($conn));
                }

                mysqli_close($conn); // Chiude la connessione al database
            } catch (Exception $e) {
                // Gestione delle eccezioni e stampa dell'errore
                echo "<p style='color: red;'>Errore: " . $e->getMessage() . "</p>";
            }
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>