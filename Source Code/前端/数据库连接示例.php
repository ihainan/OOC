<?php
include "phpLibrary/notorm-master/NotORM.php";
$pdo = new PDO('mysql:host=localhost;dbname=blind_review_db','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('set names utf8');
$db = new NotORM($pdo);
$stus = $db->学生表();
echo "学生表";
foreach($stus as $stu){
	echo $stu["学生id"]." ".$stu["Email"]." ".$stu["电话"]." ".$stu["导师id"]." ".$stu["入学时间"]." ".$stu["盲审次数"]."<br>";
}
?>