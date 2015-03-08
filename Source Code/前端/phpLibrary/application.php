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
		
		
		/** 		
		//	函数: getApplicationStatusText($userid)		
		//	功能：用户申请表的状态		
		//	返回：学生是否已提交 / 导师是否已提交 / 学院是否已审核 / 审核是否通过		
		**/		
		public function getApplicationStatusText($userid){		
			// 获取论文审核状态		
	        $applicationStauts = $this -> getApplicationStatus($userid);		
	        if($applicationStauts["isSchoolSubmitted"]){		
	            if($applicationStauts["isAccedpted"]){		
	                $applicationStautsText = "已通过";		
	            }		
	            else{		
	                $applicationStautsText = "已拒绝";		
	            }		
	        }		
	        else{		
	            if($applicationStauts["isTeacherSubmitted"]){		
	                 $applicationStautsText = "导师已提交";		
	            }		
	            else{		
	               if($applicationStauts["isStudentSubmitted"]){		
	                    $applicationStautsText = "学生已提交";		
	               }		
	               else{		
	                    $applicationStautsText = "学生未提交";		
	               }		
	            }		
	        }				
	        return $applicationStautsText;		
		}		
 	
	}

?>