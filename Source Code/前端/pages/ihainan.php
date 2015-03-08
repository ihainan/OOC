<?php
	// 开启错误提示
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

	// 引用文件
	require_once("../phpLibrary/notorm-master/NotORM.php");
	require_once("../phpLibrary/users.php");
	require_once("../phpLibrary/message_class.php");

	// 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);

    // 初始化 Users 类

	$users = new Users($db);

	/* 函数功能测试 */
	// 获取不同角色用户的数量
	$arr = $users -> getUsersNumber();
	print_r($arr);
	echo "</br></br>";

	// 获取指定 ID 用户的信息
	$usersInfo = $users -> getUsersInfo();
	// print_r($usersInfo);

	$message = new Message($db);
	$message -> getUserMessage("2220140550");
?>