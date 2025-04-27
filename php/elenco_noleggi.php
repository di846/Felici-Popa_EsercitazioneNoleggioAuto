<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Noleggi effettuati da un socio</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Noleggi effettuati da un socio</h1>
        <?php
            include "config.php";

            // Recupera i dati dal form
            $cf = $_POST['cf'] ?? '';
            $inizio = $_POST['inizio'] ?? '';
            $fine = $_POST['fine'] ?? '';

            if (!$cf || !$inizio || !$fine) {
                echo "Inserisci codice fiscale e seleziona entrambe le date.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Query per ottenere i noleggi del socio nel periodo selezionato
            $sql = "SELECT Noleggi.*, Auto.marca, Auto.modello 
                    FROM Noleggi 
                    JOIN Auto ON Noleggi.auto = Auto.targa
                    WHERE socio = '$cf' 
                    AND inizio >= '$inizio' 
                    AND fine <= '$fine'
                    ORDER BY inizio";

            if (!$result = mysqli_query($conn, $sql)) {
                echo "Errore nell'esecuzione della query: " . mysqli_error($conn);
                exit;
            }

            // Verifica se ci sono risultati
            if (mysqli_num_rows($result) === 0) {
                echo "Nessun noleggio trovato per il socio nel periodo selezionato.";
            } else {
                echo "<table border='1' cellpadding='5'>
                        <tr>
                            <th>Codice Noleggio</th>
                            <th>Auto</th>
                            <th>Marca</th>
                            <th>Modello</th>
                            <th>Inizio</th>
                            <th>Fine</th>
                            <th>Restituita</th>
                        </tr>";
                // Stampa i risultati
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['codice_noleggio']}</td>
                            <td>{$row['auto']}</td>
                            <td>{$row['marca']}</td>
                            <td>{$row['modello']}</td>
                            <td>{$row['inizio']}</td>
                            <td>{$row['fine']}</td>
                            <td>" . ($row['auto_restituita'] ? $row['auto_restituita'] : "Non ancora") . "</td>
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