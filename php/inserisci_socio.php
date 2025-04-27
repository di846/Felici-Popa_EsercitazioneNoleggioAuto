<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Inserimento nuovo socio</title>
    </head>
    <body>
        <h1>Inserimento nuovo socio</h1>
        <?php
            include "config.php";

            $cf = $_POST['cf'] ?? '';
            $cognome = $_POST['cognome'] ?? '';
            $nome = $_POST['nome'] ?? '';
            $indirizzo = $_POST['indirizzo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';

            if (!$cf || !$cognome || !$nome || !$indirizzo || !$telefono) {
                echo "Compila tutti i campi.";
                exit;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing");
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            $sql = "INSERT INTO Soci (CF, cognome, nome, indirizzo, telefono) 
                    VALUES ('$cf', '$cognome', '$nome', '$indirizzo', '$telefono')";

            if (mysqli_query($conn, $sql)) {
                echo "Socio inserito con successo.";
            } else {
                echo "Errore nell'inserimento del socio: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        ?>
    </body>
</html>