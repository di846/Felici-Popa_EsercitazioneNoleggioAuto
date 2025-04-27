<?php
    header("Access-Control-Allow-Origin: *");
    function setup_database()
    {
        include "config.php";
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        if (!$connection) {
            echo "Errore nella connessione al server ".mysqli_connect_error();
            return;
        } else {
            echo "Connessione effettuata con successo";
        }

        $databaseName = "Carsharing";
        $sql = "CREATE DATABASE IF NOT EXISTS $databaseName";

        if (mysqli_query($connection, $sql)) {
            echo "Database " .$databaseName ." creato con successo o già esistente ";
        } else {
            echo "Errore nella creazione del database: " .mysqli_error($connection);
        }

        if (mysqli_select_db($connection, $databaseName)) {
            echo "Database " .$databaseName ." selezionato con successo";
        } else {
            echo "Errore nella selezione del database ".mysqli_error($connection);
        }

        $sql = "CREATE TABLE IF NOT EXISTS Auto (
                    targa VARCHAR(7) PRIMARY KEY,
                    marca VARCHAR(50) NOT NULL,
                    modello VARCHAR(50) NOT NULL,
                    costo_giornaliero DECIMAL(4,2) NOT NULL)";

        if (mysqli_query($connection, $sql)) {
            echo "Tabella Auto creata con successo";
        } else {
            echo "Errore nella creazione di Auto " .
                mysqli_error($connection);
        }

        $sql = "CREATE TABLE IF NOT EXISTS Soci (
                    CF VARCHAR(16) PRIMARY KEY,
                    cognome VARCHAR(50) NOT NULL,
                    nome VARCHAR(50) NOT NULL,
                    indirizzo VARCHAR(150) NOT NULL,
                    telefono VARCHAR(20) NOT NULL
                    )";

        if (mysqli_query($connection, $sql)) {
            echo "Tabella Soci creata con successo ";
        } else {
            echo "Errore nella creazione di Soci " .mysqli_error($connection);
        }

        $sql = "CREATE TABLE IF NOT EXISTS Noleggi (
                    codice_noleggio INT AUTO_INCREMENT PRIMARY KEY,
                    inizio datetime NOT NULL,
                    fine datetime NOT NULL,
                    auto_restituita datetime DEFAULT NULL,
                    auto varchar(10) NOT NULL,
                    socio varchar(16) NOT NULL,
                    FOREIGN KEY (auto) REFERENCES Auto(targa) ON DELETE CASCADE,
                    FOREIGN KEY (socio) REFERENCES Soci(CF) ON DELETE CASCADE
                    )";

        if (mysqli_query($connection, $sql)) {
            echo "Tabella Noleggi creata con successo ";
        } else {
            echo "Errore nella creazione di Noleggi " .mysqli_error($connection);
        }

        mysqli_close($connection);
    }

    setup_database();

?>
