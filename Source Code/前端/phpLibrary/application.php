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

		/** 
		//	函数: getApplicationStatus($userid)
		//	功能：用户申请表的状态
		//	返回：学生是否已提交 / 导师是否已提交 / 学院是否已审核 / 审核是否通过
		**/
		public function getApplicationStatus($userid){
			$isStudentSubmitted = false;
			$isTeacherSubmitted = false;
			$isSchoolSubmitted = false;
			$isAccedpted = false;

			// 获取申请表
			$applicationForms = $this -> db -> 评审申请() -> where("学生id", $userid);
			// 检查学生是否已经提交
			if(sizeof($applicationForms) > 0){
				$isStudentSubmitted = true;

				// 检查导师是否已经提交
				$applicationForm = $applicationForms[1];

				if(isset($applicationForm["导师意见"])){
					$isTeacherSubmitted = true;
					if(isset($applicationForm["学院意见"])){
						$isSchoolSubmitted = true;
						if(isset($applicationForm["审核状态"]) && $applicationForm["审核状态"] == "通过"){
							$isAccedpted = true;
						}
					}
				}
			}

			return array(
				"isSchoolSubmitted" => $isSchoolSubmitted,
				"isStudentSubmitted" => $isStudentSubmitted,
				"isTeacherSubmitted" => $isTeacherSubmitted,
				"isAccedpted" => $isAccedpted,
				);
		}
	}

?>