<?php
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

function closeDatabase($link)
{
    mysqli_close($link);
}

function getPoolData($url)
{
    $name = array(2);
    $index = 0;
    $link = openDatabase();
    $sql = "SELECT cp_id, cp_name, cp_name_initiator, cp_message, cp_datetillsuccess, cp_summe, cp_current_amount, cp_teilbetrag, cp_default_product_id
            FROM crowdproject
            WHERE cp_url = '" . $url . "'";
    $resultPool = mysqli_query($link, $sql);
    $rowPool = mysqli_fetch_object($resultPool);

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

    $sql = "SELECT value
            FROM catalog_product_entity_media_gallery
            WHERE entity_id = " . $rowPool->cp_default_product_id;
    $resultBild = mysqli_query($link, $sql);
    $rowBild = mysqli_fetch_object($resultBild);

    $pool = new Pool();
    $pool->setData($rowPool->cp_id, $url, $rowPool->cp_name, "../../media/catalog/product" . $rowBild->value, $name[0] . " " . $name[1], $rowPool->cp_message, $rowPool->cp_datetillsuccess, $rowPool->cp_current_amount, $rowPool->cp_teilbetrag, $rowPool->cp_summe);

    closeDatabase($link);

    return $pool;
}