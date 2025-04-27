<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Inserimento nuovo noleggio</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Inserimento nuovo noleggio</h1>
        <?php
            include "config.php";

            // Recupero dati dal form
            $cf = $_POST['cf'] ?? '';
            $auto = $_POST['auto'] ?? '';
            $inizio = $_POST['inizio'] ?? '';
            $fine = $_POST['fine'] ?? '';

            // Controllo che tutti i campi siano compilati
            if (!$cf || !$auto || !$inizio || !$fine) {
                echo "Compila tutti i campi.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Controllo sovrapposizione periodi di noleggio
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

            // Inserimento del nuovo noleggio
            $sql = "INSERT INTO Noleggi (inizio, fine, auto, socio) 
                    VALUES ('$inizio', '$fine', '$auto', '$cf')";

            if (mysqli_query($conn, $sql)) {
                echo "Noleggio inserito con successo.";
            } else {
                echo "Errore nell'inserimento del noleggio: " . mysqli_error($conn);
            }

            // Chiusura connessione
            mysqli_close($conn);
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>