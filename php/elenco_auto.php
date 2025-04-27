<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Auto disponibili</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Auto disponibili</h1>
        <?php
            include "config.php";

            // Recupera le date dal form
            $inizio = $_POST['inizio'] ?? '';
            $fine = $_POST['fine'] ?? '';

            if (!$inizio || !$fine) {
                echo "Seleziona entrambe le date.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Query per selezionare le auto disponibili
            $sql = "SELECT * FROM Auto
            WHERE targa NOT IN (
                SELECT auto FROM Noleggi
                WHERE 
                    (inizio <= $fine AND fine >= $fine) OR
                    (inizio <= $inizio AND fine >= $inizio) OR
                    (inizio >= $inizio AND fine <= $fine))";

            if (!$result = mysqli_query($conn, $sql)) {
                echo "Errore nell'esecuzione della query: " . mysqli_error($conn);
                exit;
            }

            // Mostra i risultati o un messaggio se non ci sono auto disponibili
            if (mysqli_num_rows($result) === 0) {
                echo "Nessuna auto disponibile nel periodo selezionato.";
            } else {
                echo "<table border='1' cellpadding='5'><tr><th>Targa</th><th>Marca</th><th>Modello</th><th>Costo giornaliero</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['targa']}</td>
                            <td>{$row['marca']}</td>
                            <td>{$row['modello']}</td>
                            <td>€{$row['costo_giornaliero']}</td>
                        </tr>";
                }
                echo "</table>";
            }

            // Chiude la connessione al database
            mysqli_close($conn);
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>