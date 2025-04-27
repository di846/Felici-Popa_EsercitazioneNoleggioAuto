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

            try {
                // Abilita le eccezioni per MySQLi
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                // Connessione al database
                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");

                // Query per ottenere i noleggi del socio nel periodo selezionato
                $sql = "SELECT Noleggi.*, Auto.marca, Auto.modello 
                        FROM Noleggi 
                        JOIN Auto ON Noleggi.auto = Auto.targa
                        WHERE socio = ? 
                        AND inizio >= ? 
                        AND fine <= ?
                        ORDER BY inizio";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $cf, $inizio, $fine);
                $stmt->execute();
                $result = $stmt->get_result();

                // Verifica se ci sono risultati
                if ($result->num_rows === 0) {
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
                    while ($row = $result->fetch_assoc()) {
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
                $stmt->close();
                $conn->close();
            } catch (Exception $e) {
                echo "Si è verificato un errore: " . htmlspecialchars($e->getMessage());
            }
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>