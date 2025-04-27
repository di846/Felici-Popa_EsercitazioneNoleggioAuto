<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <title>Elimina Socio</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Elimina Socio</h1>
        <?php
            include "config.php"; 

            $cf = $_POST['cf'] ?? ''; // Recupero codice fiscale

            if (!$cf) {
                echo "Inserisci il codice fiscale del socio da eliminare.";
                exit;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "Carsharing"); // Connessione al database
            if (!$conn) {
                echo "Errore di connessione al database. " . mysqli_connect_error();
                exit;
            }

            $sql = "DELETE FROM Soci WHERE CF = '$cf'"; // Query per eliminare il socio

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo "Socio eliminato con successo.";
                } else {
                    echo "Nessun socio trovato con il codice fiscale inserito.";
                }
            } else {
                echo "Errore nell'eliminazione del socio: " . mysqli_error($conn);
            }

            mysqli_close($conn); // Chiude la connessione al database 
        ?>
        <a href="/Felici-Popa_EsercitazioneNoleggioAuto/index.html" class="back-to-menu-link">Torna al Menu</a>
    </body>
</html>