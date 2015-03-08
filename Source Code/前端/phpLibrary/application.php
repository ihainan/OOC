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

		public function getApplicationInfo($userId){
			$apps = $this -> db -> 评审申请() -> where("学生id",$userId)->order("id DESC")->limit(1,0);

			if(sizeof($apps) == 0){
				return null;
			}
			else{
				$app = $apps[0];

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