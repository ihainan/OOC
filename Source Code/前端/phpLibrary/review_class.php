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

	}
?>