<?php
	require_once("notorm-master/NotORM.php");
	class Users{
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
		// 函数: getUsersNumber()
		// 功能：获取指定角色用户数量
		// 返回：包含不同角色用户数量的数组
		**/
		public function getUsersNumber(){
			$arr = array("系统管理员" => $this -> db -> 系统用户() -> where("用户角色", "系统管理员") -> count("*"),
			"学生" => $this -> db -> 系统用户() -> where("用户角色", "学生") -> count("*"),
			"导师" => $this -> db -> 系统用户() -> where("用户角色", "导师") -> count("*"),
			"学院管理人员" => $this -> db -> 系统用户() -> where("用户角色", "学院管理人员") -> count("*"));
			return $arr;
		}

		/**
		// 函数: getUserInfo($userID)
		// 功能：获取指定用户信息
		// 返回：包含该用户信息的数组
		**/
		public function getUserInfo($userID){
			$users = $this -> db -> 系统用户() -> where("用户id", $userID);
			if(sizeof($users) == 0){
				return null;
			}
			else{
				return $users[0];
			}
		}

		// 获取所有用户信息
				/**
		// 函数: getUsersInfo()
		// 功能：获取所有用户的信息
		// 返回：包含所有用户信息的数组
		**/
		public function getUsersInfo(){
			$users = $this -> db -> 系统用户();
			return $users;
		}


		// 添加管理员角色用户

		// 添加研究生角色用户

		// 添加导师角色用户

		// 添加学院管理人员角色用户

		// 更新管理员角色用户

		// 更新研究生角色用户

		// 更新导师角色用户

		// 更新学院管理人员角色用户

		// 删除指定 ID 用户
	}
?>