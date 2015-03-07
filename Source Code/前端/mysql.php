<?php
 	include "phpLibrary/notorm-master/NotORM.php";
    $pdo = new PDO('mysql:host=localhost;dbname=blind_review_db','root','');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);
?>