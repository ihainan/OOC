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

<<<<<<< HEAD
		/**
		// ����: getApplicationInfo()
		// ���ܣ���ȡָ���û�����������
		// ���أ������������Ϣ������
		**/
		public function getApplicationInfo($userID){
			
			$users = $this -> db -> ��������() -> where('ѧ��id', $userID);
			if(sizeof($users) == 0){
=======
		public function getApplicationInfo($userId){
			$apps = $this -> db -> 评审申请() -> where('学生id', $userId);
			if(sizeof($apps) == 0){
>>>>>>> 7503f77429654fcf670a5e955ecd5fb47ccd8e97
				return null;
			}
			else{
				$app = $apps[0];
				echo "here<br>";
				print_r($apps[2]);
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