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

		/**
		// 函数: getStudentInfo($id)
		// 功能：获取指定学生信息
		// 返回：包含该学生信息的数组
		**/
		public function getStudentInfo($userID){
			$users = $this -> db -> 系统用户() -> where("用户id", $userID);
			if(sizeof($users) == 0){
				return null;
			}
			else{
				$user = $users[0];
				$students = $this -> db -> 学生表() -> where("学生id", $user["用户id"]);
				if(sizeof($students) == 0){
					return null;
				}
				else{
					$student = $students[0];
					$teachers = $this -> db ->系统用户() -> where("用户id", $student["导师id"]);
					$teacher = $teachers[0];
					$studentInfo = array(
						"用户id" => $user["用户id"],
						"用户角色" => $user["用户角色"],
						"密码" => $user["密码"], 
						"姓名" => $user["姓名"],
						"Email" => $student["Email"], 
						"电话" => $student["电话"],
						"导师" => $teacher["姓名"], 
						"入学时间" => $student["入学时间"],
						"盲审次数" => $student["盲审次数"]);
					return $studentInfo;
				}
			}
			return null;
		}

		/**
		// 函数: getTeacherInfo.php($id)
		// 功能：获取指定导师信息
		// 返回：包含该导师的数组
		**/
		public function getTeacherInfo($userID){
			$users = $this -> db -> 系统用户() -> where("用户id", $userID);
			if(sizeof($users) == 0){
				return null;
			}
			else{
				$user = $users[0];
				$teachers = $this -> db -> 导师表() -> where("导师id", $user["用户id"]);
				if(sizeof($teachers) == 0){
					return null;
				}
				else{
					$teacher = $teachers[0];
					// $teachers = $this -> db ->系统用户() -> where("用户id", $student["导师id"]);
					// $teacher = $teachers[0];
					$teacherInfo = array(
						"用户id" => $user["用户id"],
						"用户角色" => $user["用户角色"],
						"密码" => $user["密码"], 
						"姓名" => $user["姓名"],
						"学院" => $teacher["学院"], 
						"电话" => $teacher["电话"],
						"Email" => $teacher["Email"]);
					return $teacherInfo;
				}
			}
			return null;
		}

		/**
		// 函数: getManagerInfo.php($id)
		// 功能：获取指定导师信息
		// 返回：包含该导师的数组
		**/
		public function getManagerInfo($userID){
			$users = $this -> db -> 系统用户() -> where("用户id", $userID);
			if(sizeof($users) == 0){
				return null;
			}
			else{
				$user = $users[0];
				$managers = $this -> db -> 学院管理人员表() -> where("学院管理员id", $user["用户id"]);
				if(sizeof($managers) == 0){
					return null;
				}
				else{
					$manager = $managers[0];
					// $teachers = $this -> db ->系统用户() -> where("用户id", $student["导师id"]);
					// $teacher = $teachers[0];
					$managerInfo = array(
						"用户id" => $user["用户id"],
						"用户角色" => $user["用户角色"],
						"密码" => $user["密码"], 
						"姓名" => $user["姓名"],
						"电话" => $manager["电话"],
						"Email" => $manager["Email"]);
					return $managerInfo;
				}
			}
			return null;
		}

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