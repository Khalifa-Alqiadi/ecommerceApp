<?php
ob_start();
session_start();
$pageTitle = 'Show Item';
include 'init.php';

$stm = $con->prepare("SELECT * FROM items");
$stm->execute();

$rows = $stm->fetchAll();

foreach($rows as $row){
    $stmt = $con->prepare("INSERT INTO
                                books(`name`, descrip, price)
                            VALUES(:zname, :zdesc, :zprice)");
    $stmt->execute(array(
        'zname'  => $row['Name'],
        'zdesc'  => $row['Description'],
        'zprice' => $row['Price']
    ));
}