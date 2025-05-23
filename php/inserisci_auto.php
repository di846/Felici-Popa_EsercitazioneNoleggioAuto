<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Inserimento nuova auto</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Inserimento nuova auto</h1>
        <?php
            include "config.php"; // Inclusione file di configurazione

            try {
                // Recupero dati dal form
                $targa = $_POST['targa'] ?? '';
                $marca = $_POST['marca'] ?? '';
                $modello = $_POST['modello'] ?? '';
                $costo = $_POST['costo'] ?? '';

                // Verifica che tutti i campi siano compilati
                if (!$targa || !$marca || !$modello || !$costo) {
                    throw new Exception("Compila tutti i campi.");
                }

                // Connessione al database
                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
                if (!$conn) {
                    throw new Exception("Errore di connessione al database: " . mysqli_connect_error());
                }

                // Query per inserire una nuova auto
                $sql = "INSERT INTO Auto (targa, marca, modello, costo_giornaliero, disponibile) 
                        VALUES ('$targa', '$marca', '$modello', '$costo', 1)";

                // Esecuzione della query
                if (!mysqli_query($conn, $sql)) {
                    throw new Exception("Errore nell'inserimento dell'auto: " . mysqli_error($conn));
                }

                echo "Auto inserita con successo.";
            } catch (Exception $e) {
                echo "Si è verificato un errore: " . $e->getMessage();
            } finally {
                if (isset($conn) && $conn) {
                    mysqli_close($conn); // Chiusura connessione
                }
            }
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>