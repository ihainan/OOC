<?php
	require_once("notorm-master/NotORM.php");
	class Application{
		private $db;		// 数据库

		/** 
		//	函数: __construct($db)
		//	功能：构造函数
		//	返回：无
		**/
		public function __construct($db){
			$this -> db = $db;
		}

		/**
		// 函数: getApplicationInfo()
		// 功能：获取指定用户的审核申请表
		// 返回：包含申请表信息的数组
		**/
		public function getApplicationInfo($userID){
			
			$users = $this -> db -> 系统用户() -> where('学生id', $userID);
			if(sizeof($users) == 0){
				return null;
			}
			else{
				$app = $users[0];
				echo "here<br>";
				$arr = array(
					"论文题目" => $app['论文题目'],
					"论文摘要" => $app['论文摘要'],
					"导师意见" => $app['导师意见'],
					"学院意见" => $app['学院意见']);
				return $arr;
			}
		}
	}
?>