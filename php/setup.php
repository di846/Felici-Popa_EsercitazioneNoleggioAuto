<?php
    header("Access-Control-Allow-Origin: *");

    function setup_database()
    {
        include "config.php";

        // Abilita la gestione delle eccezioni per MySQLi
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
            echo "Connessione effettuata con successo";

            $databaseName = "Carsharing";
            $sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
            mysqli_query($connection, $sql);
            echo "Database " .$databaseName ." creato con successo o già esistente ";

            mysqli_select_db($connection, $databaseName);
            echo "Database " .$databaseName ." selezionato con successo";

            // Creazione tabella Auto
            $sql = "CREATE TABLE IF NOT EXISTS Auto (
                        targa VARCHAR(7) PRIMARY KEY,
                        marca VARCHAR(50) NOT NULL,
                        modello VARCHAR(50) NOT NULL,
                        disponibile BOOLEAN DEFAULT 1,
                        costo_giornaliero INT NOT NULL)";
            mysqli_query($connection, $sql);
            echo "Tabella Auto creata con successo";

            // Creazione tabella Soci
            $sql = "CREATE TABLE IF NOT EXISTS Soci (
                        CF VARCHAR(16) PRIMARY KEY,
                        cognome VARCHAR(50) NOT NULL,
                        nome VARCHAR(50) NOT NULL,
                        indirizzo VARCHAR(150) NOT NULL,
                        telefono VARCHAR(20) NOT NULL
                        )";
            mysqli_query($connection, $sql);
            echo "Tabella Soci creata con successo ";

            // Creazione tabella Noleggi con chiavi esterne
            $sql = "CREATE TABLE IF NOT EXISTS Noleggi (
                        codice_noleggio INT AUTO_INCREMENT PRIMARY KEY,
                        inizio datetime NOT NULL,
                        fine datetime NOT NULL,
                        auto_restituita datetime DEFAULT NULL,
                        note_restituzione TEXT DEFAULT NULL,
                        auto varchar(10) NOT NULL,
                        socio varchar(16) NOT NULL,
                        FOREIGN KEY (auto) REFERENCES Auto(targa) ON DELETE CASCADE,
                        FOREIGN KEY (socio) REFERENCES Soci(CF) ON DELETE CASCADE
                        )";
            mysqli_query($connection, $sql);
            echo "Tabella Noleggi creata con successo ";

            mysqli_close($connection);
        } catch (mysqli_sql_exception $e) {
            echo "Errore durante l'esecuzione: " . $e->getMessage();
        }
    }

    setup_database();
?>
