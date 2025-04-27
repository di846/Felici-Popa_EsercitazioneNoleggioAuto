<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Calcola costi aggiuntivi noleggio</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Calcola costi aggiuntivi noleggio</h1>
        <?php
            include "config.php";

            $codice_noleggio = $_POST['codice_noleggio'] ?? '';

            if (!$codice_noleggio) {
                echo "Inserisci il codice del noleggio.";
                exit;
            }

            // Connessione al database
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            // Query per ottenere i dati del noleggio e dell'auto
            $sql = "SELECT Noleggi.*, Auto.costo_giornaliero 
                    FROM Noleggi 
                    JOIN Auto ON Noleggi.auto = Auto.targa
                    WHERE codice_noleggio = $codice_noleggio";

            if (!$result = mysqli_query($conn, $sql)) {
                echo "Errore nell'esecuzione della query: " . mysqli_error($conn);
                exit;
            }

            if (mysqli_num_rows($result) === 0) {
                echo "Nessun noleggio trovato con il codice inserito.";
            } else {
                $row = mysqli_fetch_assoc($result);

                $inizio = $row['inizio'];
                $fine_prevista = $row['fine'];
                $restituita = $row['auto_restituita'];
                $costo_giornaliero = $row['costo_giornaliero'];

                $inizio_dt = new DateTime($inizio);
                $fine_prevista_dt = new DateTime($fine_prevista);

                // Calcolo della data di fine effettiva
                if ($restituita) {
                    $fine_effettiva_dt = new DateTime($restituita);
                } else {
                    $fine_effettiva_dt = new DateTime(); // ora
                }

                // Calcolo dei giorni previsti ed effettivi
                $giorni_previsti = $inizio_dt->diff($fine_prevista_dt)->days;
                if ($giorni_previsti == 0) $giorni_previsti = 1;

                $giorni_effettivi = $inizio_dt->diff($fine_effettiva_dt)->days;
                if ($giorni_effettivi == 0) $giorni_effettivi = 1;

                // Calcolo dei costi
                $costo_previsto = $giorni_previsti * $costo_giornaliero;
                $costo_effettivo = $giorni_effettivi * $costo_giornaliero;

                $costi_aggiuntivi = 0;
                $penale = 0;

                // Calcolo della penale in caso di ritardo
                if ($giorni_effettivi > $giorni_previsti) {
                    $giorni_ritardo = $giorni_effettivi - $giorni_previsti;
                    $penale = $giorni_ritardo * $costo_giornaliero * 0.2;
                    $costi_aggiuntivi = $costo_effettivo - $costo_previsto + $penale;
                }

                // Visualizzazione dei risultati
                echo "<table border='1' cellpadding='5'>
                        <tr><th>Codice Noleggio</th><td>{$row['codice_noleggio']}</td></tr>
                        <tr><th>Data inizio</th><td>{$inizio}</td></tr>
                        <tr><th>Data fine prevista</th><td>{$fine_prevista}</td></tr>
                        <tr><th>Data restituzione</th><td>" . ($restituita ? $restituita : "Non ancora restituita") . "</td></tr>
                        <tr><th>Costo giornaliero</th><td>€{$costo_giornaliero}</td></tr>
                        <tr><th>Giorni previsti</th><td>{$giorni_previsti}</td></tr>
                        <tr><th>Giorni effettivi</th><td>{$giorni_effettivi}</td></tr>
                        <tr><th>Costo previsto</th><td>€" . number_format($costo_previsto, 2) . "</td></tr>
                        <tr><th>Costo effettivo</th><td>€" . number_format($costo_effettivo, 2) . "</td></tr>
                        <tr><th>Penale per ritardo</th><td>€" . number_format($penale, 2) . "</td></tr>
                        <tr><th>Costi aggiuntivi totali</th><td>€" . number_format($costi_aggiuntivi, 2) . "</td></tr>
                      </table>";
            }

            mysqli_close($conn);
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>