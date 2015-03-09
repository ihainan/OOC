<?php
	require_once("notorm-master/NotORM.php");
	require_once("application.php");
	class studentInfo{
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
			return $this->db->学生表()->where("导师id",$teacherId)->count("*");
		}
		/** 
		//	函数: getStudentInfo($teacherId)
		//	功能：获取该老师的学生信息(姓名，学号，申请表状态，论文审核状态)
		//	返回：学生信息数组
		**/
		public function getStudentInfo($teacherId){
			$studentIds = $this->db->学生表()->select("学生id")->where("导师id",$teacherId);
			$arry = array();
			foreach ($studentIds as $studentId) {
				$names = $this->db->系统用户()->where("用户id",$studentId["学生id"])->fetch();
				$name = $names["姓名"];
				//获取该学生提交的评审申请
    			$stu_apply = $this->db->评审申请()->where("学生id",$studentId["学生id"])->order("id DESC")->limit(1,0);
   				$last_apply = $stu_apply->fetch();
   				//获取最近的申请状态
   				if($last_apply["开放审核申请id"] == $this->db->开放审核申请()->max("id")){
   				 	$application = new Application($this->db);
    				$statu_apply = $application->getApplicationStatusText($studentId["学生id"]);
    			}else{
    				$statu_apply = "未提交";
    			}
    			$year = date("Y");
    			$papers = $this->db->论文表()->where("学生id",$studentId["学生id"])->where("年份",$year);
    			//echo $papers;
    			if($papers->count("*") > 0){
    				$paper = $papers[0];
    				$paper_statu = "论文已上传";
    			}else $paper_statu = "暂未更新";
    			//echo "状态".$name."<br>".$studentId["学生id"]."<br>".$statu_apply."<br>".$paper_statu;
    			$arry[$studentId["学生id"]] = array(
    				"学生id" => $studentId["学生id"],
    				"姓名" => $name,
    				"学号" => $studentId["学生id"],
    				"申请表" => $statu_apply,
    				"论文审核" => $paper_statu);
			}
			return $arry;
		}
		/** 
		//	函数: getNumberApply($teacherId)
		//	功能：获取该老师的学生评审申请表个数
		//	返回：学生评审申请表个数
		**/
		public function getNumberApply($teacherId){
			$studentIds = $this->db->学生表()->select("学生id")->where("导师id",$teacherId);
			$i = 0;
			foreach ($studentIds as $studentId) {
				
				//获取该学生提交的评审申请
    			$stu_apply = $this->db->评审申请()->where("学生id",$studentId["学生id"])->order("id DESC")->limit(1,0);
   				$last_apply = $stu_apply->fetch();
   				//获取最近的申请状态
   				if($last_apply["开放审核申请id"] == $this->db->开放审核申请()->max("id")){
       				$i++;
    			}
			}
			return $i;
		}
		/** 
		//	函数: getNumberPapers($teacherId)
		//	功能：获取该老师的学生论文提交数量
		//	返回：学生论文提交数量
		**/
		public function getNumberPapers($teacherId){
			$studentIds = $this->db->学生表()->select("学生id")->where("导师id",$teacherId);
			$i = 0;
			foreach ($studentIds as $studentId) {
				$year = date("Y");
    			$papers = $this->db->论文表()->where("学生id",$studentId["学生id"])->where("年份",$year);
    			//echo $papers;
    			if($papers->count("*") > 0){
    				$i++;
    			}
			}
			return $i;
		}
	}
?>