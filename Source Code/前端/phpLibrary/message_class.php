<?php
	require_once("notorm-master/NotORM.php");
	class Message{
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
		//	函数: getMessage($userid)
		//	功能：获取指定用户的所有消息
		//	返回：消息数组
		**/
		public function getUserMessage($userid){
			$messages = $this -> db -> 消息表() -> where("消息接受用户id = ? OR 消息接受用户id = '*'", array($userid));
			return $messages;
		}

	}
?>