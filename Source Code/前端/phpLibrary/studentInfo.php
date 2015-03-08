<?php
	require_once("notorm-master/NotORM.php");
	class studentInfo(){
		private $db;
		/** 
		//	函数: __construct($db)
		//	功能：构造函数
		//	返回：无
		**/
		public function __construct($db){
			$this -> db = $db;
		}
		/** 
		//	函数: getStudentNumber($teacherId)
		//	功能：获取该老师的学生数量
		//	返回：学生数量
		**/
		public function getStudentNumber($teacherId){
			return $this->db->学生表()->where("学生id",$teacherid)->count("*");
		}
		/** 
		//	函数: getStudentInfo($teacherId)
		//	功能：获取该老师的学生信息(姓名，学号，申请表状态，论文审核状态)
		//	返回：学生信息数组
		**/
		public getStudentInfo($teacherId){
			$studentIds = $this->db->学生表()->select("学生id")->where("学生id",$teacherid);
			foreach ($studentIds as $studentId) {
				$names = $this->db->系统用户()->where("姓名",$studentId["学生id"])->fetch();
				$name = $names["姓名"];
				//获取该学生提交的评审申请
    			$stu_apply = $this->db->评审申请()->where("学生id",$studentId["学生id"])->order("id DESC")->limit(1,0);
   				$last_apply = $stu_apply->fetch();
   				//获取最近的申请状态
   				if($last_apply["开放审核申请id"] == $this->db->开放审核申请()->max("id")){
       				$statu_apply = $last_apply["审核状态"];
    			}else{
    				$statu_apply = "未提交";
    			}

			}
		}
	}
?>