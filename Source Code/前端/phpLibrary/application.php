<?php
	require_once("notorm-master/NotORM.php");
	class Application{
		private $db;		// æ•°æ®åº“

		/** 
		//	å‡½æ•°: __construct($db)
		//	åŠŸèƒ½ï¼šæž„é€ å‡½æ•°
		//	è¿”å›žï¼šæ— 
		**/
		public function __construct($db){
			$this -> db = $db;
		}

<<<<<<< HEAD
		/**
		// º¯Êý: getApplicationInfo()
		// ¹¦ÄÜ£º»ñÈ¡Ö¸¶¨ÓÃ»§µÄÉóºËÉêÇë±í
		// ·µ»Ø£º°üº¬ÉêÇë±íÐÅÏ¢µÄÊý×é
		**/
		public function getApplicationInfo($userID){
			
			$users = $this -> db -> ÆÀÉóÉêÇë() -> where('Ñ§Éúid', $userID);
			if(sizeof($users) == 0){
=======
		public function getApplicationInfo($userId){
			$apps = $this -> db -> è¯„å®¡ç”³è¯·() -> where('å­¦ç”Ÿid', $userId);
			if(sizeof($apps) == 0){
>>>>>>> 7503f77429654fcf670a5e955ecd5fb47ccd8e97
				return null;
			}
			else{
				$app = $apps[0];
				echo "here<br>";
				print_r($apps[2]);
				$arr = array(
						"è®ºæ–‡é¢˜ç›®" => $app['è®ºæ–‡é¢˜ç›®'],
						"è®ºæ–‡æ‘˜è¦" => $app['è®ºæ–‡æ‘˜è¦'],
						"å¯¼å¸ˆæ„è§" => $app['å¯¼å¸ˆæ„è§'],
						"å­¦é™¢æ„è§" => $app['å­¦é™¢æ„è§']);
				return $arr;
			}
		}
	}

?>