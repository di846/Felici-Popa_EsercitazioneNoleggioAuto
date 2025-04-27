<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Inserimento nuova auto</title>
    </head>
    <body>
        <h1>Inserimento nuova auto</h1>
        <?php
            include "config.php";

            $targa = $_POST['targa'] ?? '';
            $marca = $_POST['marca'] ?? '';
            $modello = $_POST['modello'] ?? '';
            $costo = $_POST['costo'] ?? '';

            if (!$targa || !$marca || !$modello || !$costo) {
                echo "Compila tutti i campi.";
                exit;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            $sql = "INSERT INTO Auto (targa, marca, modello, costo_giornaliero, disponibile) 
                    VALUES ('$targa', '$marca', '$modello', '$costo', 1)";

            if (mysqli_query($conn, $sql)) {
                echo "Auto inserita con successo.";
            } else {
                echo "Errore nell'inserimento dell'auto: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        ?>
    </body>
</html>