<?php

/* Die Antwort wird als JSON ausgegeben. */
header('Content-Type: application/json; charset=utf-8');

/* Gewünschte Tabelle lesen; Standardwert ist kunden. */
$tabelle = $_GET['tabelle'] ?? 'kunden';

/* Verbindung zur Datenbank herstellen. */
$verbindung = new mysqli('localhost', 'root', '', 'online_shop');
$verbindung->set_charset('utf8mb4');

/* Je nach URL-Parameter einen festgelegten SQL-Befehl auswählen. */
switch ($tabelle) {
    case 'kunden':
        $sql = 'SELECT * FROM kunden';
        break;

    case 'produkte':
        $sql = 'SELECT * FROM produkte';
        break;

    case 'hersteller':
        $sql = 'SELECT * FROM hersteller';
        break;

    case 'bestellungen':
        $sql = 'SELECT * FROM bestellungen';
        break;

    case 'bestellpositionen':
        $sql = 'SELECT * FROM bestellpositionen';
        break;    

    default:
        /* Unbekannte Tabellen mit einer Fehlermeldung ablehnen. */
        http_response_code(400);
        echo json_encode(['fehler' => 'Unbekannte Tabelle.']);
        $verbindung->close();
        exit;
}

/* Die ausgewählte Abfrage ausführen und die Daten abholen. */
$ergebnis = $verbindung->query($sql);
$daten = $ergebnis->fetch_all(MYSQLI_ASSOC);

/* Daten als JSON ausgeben. */
echo json_encode($daten, JSON_UNESCAPED_UNICODE);

/* Ergebnis und Verbindung freigeben. */
$ergebnis->free();
$verbindung->close();