<?php
use Symfony\Component\HttpFoundation\Request;

//Die Datenbank-Funktionen

//Öffnet die Datenbank
//Bei Server-Wechsel die Connect-Daten ändern
//Wenn keine Datenbank-Verbindung möglich, wird die Datei noDatabaseConnection aufgerufen
function openDatabase()
{
    $link = mysqli_connect("localhost", "root", "root123", "addawish");

    if (!$link)
    {
        require_once ("templates/noDatabaseConnection.php");
        die();
    }
    mysqli_set_charset($link, "UTF-8");
    return $link;
}

//Schließt die Datenbank-Verbindung
function closeDatabase($link)
{
    mysqli_close($link);
}

//Holt sich die Pooldaten entsprechend der gegebenen URL
function getPoolData($url)
{
    $name = array(2);
    $index = 0;
    $link = openDatabase();
    //Holt sich die Daten auf der CrowdProjekt-Tabelle
    $sql = "SELECT cp_id, cp_name, cp_name_initiator, cp_message, cp_datetillsuccess, cp_summe, cp_current_amount, cp_teilbetrag, cp_default_product_id
            FROM crowdproject
            WHERE cp_url = '" . $url . "'";
    $resultPool = mysqli_query($link, $sql);
    $rowPool = mysqli_fetch_object($resultPool);

    //Holt sich Vor- und Nachname auf der Kunden Tabelle, wo die Email mit dem Initiator übereinstimmt
    $sql = "SELECT value
            FROM customer_entity_varchar
            WHERE entity_id IN (SELECT entity_id
                                FROM customer_entity
                                WHERE email = '" . $rowPool->cp_name_initiator . "')
            AND (attribute_id = 5 OR attribute_id = 7)
            ORDER BY attribute_id";
    $resultInitiator = mysqli_query($link, $sql);
    while ($rowInitiator = mysqli_fetch_object($resultInitiator))
    {
        $name[$index] = $rowInitiator->value;
        $index++;
    }

    //Holt sich den Pfad zum Bild, welches als Produkt für den Pool gewählt wurde
    $sql = "SELECT value
            FROM catalog_product_entity_media_gallery
            WHERE entity_id = " . $rowPool->cp_default_product_id;
    $resultBild = mysqli_query($link, $sql);
    $rowBild = mysqli_fetch_object($resultBild);

    //Erstellt Pool und weist dem Object alle Daten zu
    $pool = new Pool();
    $pool->setData($rowPool->cp_id, $url, $rowPool->cp_name, "../../../media/catalog/product" . $rowBild->value, $name[0] . " " . $name[1], $rowPool->cp_message, $rowPool->cp_datetillsuccess, $rowPool->cp_current_amount, $rowPool->cp_teilbetrag, $rowPool->cp_summe);

    //Schließt Datenbank-Verbindung
    closeDatabase($link);

    return $pool;
}

//Schreibt die Zahlung in die Datenbank
function writeTeilnehmen($url, $teilbetrag)
{
    //öffnet Datenbank-Verbindung
    $link = openDatabase();

    //Erhöht den Betrag und fügt eine Order-Nummer hinzu
    //MUSS NOCH IN DIE ORDER TABELLE GESCHRIEBEN WERDEN!!!
    $sql = "UPDATE crowdproject
            SET cp_current_amount = cp_current_amount + '" . $teilbetrag . "',
            cp_order_number = CONCAT(cp_order_number, IF(cp_order_number IS NOT NULL, ', 500', '500'))
            WHERE cp_url = '" . $url . "'";
    mysqli_query($link, $sql);

    //Schließt Datenbank-Verbinduung
    closeDatabase($link);
}