<?php
	require_once("notorm-master/NotORM.php");
	class Review{
		private $db;		// 数据库

		/** 
		//	函数: __construct($db)
		//	功能：构造函数
		//	返回：无
		**/
		public function __construct($db){
			// 开启错误提示
    		error_reporting(E_ALL);
    		ini_set('display_errors', 'On');
			$this -> db = $db;
		}

		/** 
		//	函数: addEmptyReview($userid)
		//	功能：生成一张评审信息表
		//	返回：生成的评审信息表
		**/
		public function addEmptyReview($userid){
			$r = $this -> db  -> 评审信息类() -> insert(array(
				"学生id" => $userid
			));
			return $r;
		}

		/** 
		//	函数: addPaper($userid, $keywords)
		//	功能：上传论文
		//	返回：上传的论文的信息
		**/
		public function addPaper($userid, $keywords){
			$review = $this -> addEmptyReview($userid);
			$reviewId = $review["id"];
			
			$paper = $this -> db -> 论文表() -> insert(array(
				"学生id" => $userid,
				"评审信息表id" => $reviewId,
				"关键字" => $keywords,
				"年份" => date("Y"),
			));
			return $paper;
		}

		/** 
		//	函数: isPaperUploaded($userid)
		//	功能：检查指定用户的论文是否已经上传
		//	返回：已经上传返回 true，否则返回 false;
		**/
		public function isPaperUploaded($userid){
			$paper = $this -> db -> 论文表() -> where("学生id", $userid);
			if(sizeof($paper) > 0){
				return true;
			}
			else{
				return false;
			}
		}

		/** 
		//	函数: getReviewResult($userid)
		//	功能：获取信息表
		//	返回：已经上传返回 true，否则返回 false;
		**/
		public function getReviewResult($userid){
			// 获取指定用户的评审结果
			$result = $this -> db -> 评审信息类() -> where("学生id", $userid);
			foreach ($result as $r) {
				return $r;
			}
		}

		/**
		// 函数: AssignPaperToTeachers($userid)
		// 功能：将论文分配给两位相关领域导师 
		// 返回：无
		 **/
		public function AssignPaperToTeachers($userid){
			// 获取审核信息表 ID
			$result = $this -> getReviewResult($userid);
			$id = $result["id"];

			// 获取学生论文的关键字
			// 寻找最合适的两位导师，存在数组 teachers，得到其 ID 号
			/* 直接分配给两位导师(记得修改) */
			$data = array(
				"评审专家一id" => "lilaoshi",
				"评审专家二id" => "liulaoshi");
			$data_r = array(
				"评审人id" => $data["评审专家一id"],
				"评审信息类id" => $id);

			$data_r_2 = array(
				"评审人id" => $data["评审专家二id"],
				"评审信息类id" => $id);

			// 更新 “评阅信息类” 表和插入 “论文评阅书” 表
			$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data);
			$this -> db -> 论文评阅书() -> insert($data_r);
			$this -> db -> 论文评阅书() -> insert($data_r_2);
		}

		/**
		// 函数: updatePaperReview($userid, $paperReview)
		// 功能：更新论文审核学术不端结果，并分配导师
		// 返回：无
		 **/
		public function updatePaperReview($userid, $paperReview){
			// 更新学术不端结果
			$data = array("学术不端检测结果" => $paperReview);
			$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data);

			// 如果学术不断结果为第一项，直接不通过
			if($paperReview == "高于 25%,评审不通过"){
				$data = array("学院意见" => "拒绝");
				$this -> db -> 评审信息类()  -> where("学生id", $userid) -> update($data);
			}
			else{
				// 否则，分配导师
				$this -> AssignPaperToTeachers($userid);
			}
		}

		/**
		// 函数: updateExpertOneReview($userid, $reviewContent, $score)
		// 功能：更新专家一意见
		// 返回：无
		 **/
		public function updateExpertOneReview($userid, $reviewContent, $score){
			// 获取专家 ID 和评审信息类 ID
			$result = $this -> getReviewResult($userid);
			$expertId = $result["评审专家一id"];
			$id = $result["id"];

			// 更新评审评阅书
			$row = $this -> db -> 论文评阅书() -> where(array(
				"评审信息类id" => $id,
				"评审人id" => $expertId));

			$data = array("学术评语" => $reviewContent,
				"总分" => $score);
			$row -> update($data);

			// 更新评审信息表
			$data_n = array("评审专家一意见" => $score);
			$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data_n);

			// 检查专家二是否已经给分，如果已经给分，则根据分数判断是否需要修改
			$scoreB = $result["评审专家二意见"];

			// 如果都是 A，则更新评审信息表中的 “修改说明” 为无需修改，信息表中的 “学院意见” 为同意
			if($scoreB == "A" && $score == "A"){
				$data_f = array("学院意见" => "同意");
				$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data_f);
			}
			// 如果有一个 C，则更新评审信息表中的 “学院意见” 为不同意
			else if($scoreB == "C" || $score == "C"){
				$data_f = array("学院意见" => "拒绝");
				$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data_f);
			}
			else if($scoreB == "B" || $score == "B"){
				// 如果出现一个 B，则啥也不做
			}
			else{

			}
		}

		/**
		// 函数: updateExpertTwoReview($userid, $reviewContent, $score)
		// 功能：更新专家二意见
		// 返回：无
		 **/
		public function updateExpertTwoReview($userid, $reviewContent, $score){
			// 获取专家 ID 和评审信息类 ID
			$result = $this -> getReviewResult($userid);
			$expertId = $result["评审专家二id"];
			$id = $result["id"];

			// 更新评审评阅书
			$row = $this -> db -> 论文评阅书() -> where(array(
				"评审信息类id" => $id,
				"评审人id" => $expertId));

			$data = array("学术评语" => $reviewContent,
				"总分" => $score);
			$row -> update($data);

			// 更新评审信息表
			$data_n = array("评审专家二意见" => $score);
			$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data_n);

			// 检查专家二是否已经给分，如果已经给分，则根据分数判断是否需要修改
			$scoreB = $result["评审专家一意见"];
			
			// 如果都是 A，则更新评审信息表中的 “修改说明” 为无需修改，信息表中的 “学院意见” 为同意
			if($scoreB == "A" && $score == "A"){
				$data_f = array("学院意见" => "同意");
				$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data_f);
			}
			// 如果有一个 C，则更新评审信息表中的 “学院意见” 为不同意
			else if($scoreB == "C" || $score == "C"){
				$data_f = array("学院意见" => "拒绝");
				$this -> db -> 评审信息类() -> where("学生id", $userid) -> update($data_f);
			}
			else if($scoreB == "B" || $score == "B"){
				// 如果出现一个 B，则啥也不做
			}
			else{

			}
		}

		/* 更新导师一的修改审核结果 */
		/* 返回： */
		public function updateExperOnetModifyReview($userid, $reviewContent){
			// 检查评审信息表中的 “学院意见” 是否为不同意，是的话，直接返回
			// 否则，若 $reviewContent 为不通过，则直接更新评审信息表中的 “学院意见” 为不同意
			// 否则，检查评审信息表中的 “修改说明” 是否为“专家二通过修改”，是的话，直接更新评审信息表中的 “学院意见” 为同意
			// 否则，修改评审信息表中的 “修改说明” 是否为“专家一通过修改”
		}


		/* 更新导师一的修改审核结果 */
		/* 返回： */
		public function updateExperTwotModifyReview($userid, $reviewContent){
			// 检查评审信息表中的 “学院意见” 是否为不同意，是的话，直接返回
			// 否则，若 $reviewContent 为不通过，则直接更新评审信息表中的 “学院意见” 为不同意
			// 否则，检查评审信息表中的 “修改说明” 是否为“专家一通过修改”，是的话，直接更新评审信息表中的 “学院意见” 为同意
			// 否则，修改评审信息表中的 “修改说明” 是否为“专家二通过修改”
		}
	}
?>