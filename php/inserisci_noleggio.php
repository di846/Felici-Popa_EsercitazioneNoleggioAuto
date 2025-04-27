<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Inserimento nuovo noleggio</title>
    </head>
    <body>
        <h1>Inserimento nuovo noleggio</h1>
        <?php
            include "config.php";

            $cf = $_POST['cf'] ?? '';
            $auto = $_POST['auto'] ?? '';
            $inizio = $_POST['inizio'] ?? '';
            $fine = $_POST['fine'] ?? '';

            if (!$cf || !$auto || !$inizio || !$fine) {
                echo "Compila tutti i campi.";
                exit;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            $sql_periodo = "SELECT * FROM Noleggi 
                            WHERE auto = '$auto' 
                            AND (
                                (inizio <= '$fine' AND fine >= '$inizio')
                            )";
            $result_periodo = mysqli_query($conn, $sql_periodo);
            if (mysqli_num_rows($result_periodo) > 0) {
                echo "Auto già noleggiata in questo periodo.";
                mysqli_close($conn);
                exit;
            }

            $sql = "INSERT INTO Noleggi (inizio, fine, auto, socio) 
                    VALUES ('$inizio', '$fine', '$auto', '$cf')";

            if (mysqli_query($conn, $sql)) {
                echo "Noleggio inserito con successo.";
            } else {
                echo "Errore nell'inserimento del noleggio: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        ?>
    </body>
</html>