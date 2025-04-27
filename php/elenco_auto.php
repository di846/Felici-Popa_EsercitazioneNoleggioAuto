<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Auto disponibili</title>
    </head>
    <body>
        <h1>Auto disponibili</h1>
        <?php
            include "config.php";

            $inizio = $_POST['inizio'] ?? '';
            $fine = $_POST['fine'] ?? '';

            if (!$inizio || !$fine) {
                echo "Seleziona entrambe le date.";
                exit;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

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

            mysqli_close($conn);
        ?>
    </body>
</html>