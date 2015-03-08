<?php
	require_once("notorm-master/NotORM.php");
	class Application{
		private $db;		// Êý¾Ý¿â

		/** 
		//	º¯Êý: __construct($db)
		//	¹¦ÄÜ£º¹¹Ôìº¯Êý
		//	·µ»Ø£ºÎÞ
		**/
		public function __construct($db){
			$this -> db = $db;
		}

		/**
		// º¯Êý: getApplicationInfo()
		// ¹¦ÄÜ£º»ñÈ¡Ö¸¶¨ÓÃ»§µÄÉóºËÉêÇë±í
		// ·µ»Ø£º°üº¬ÉêÇë±íÐÅÏ¢µÄÊý×é
		**/
		public function getApplicationInfo($userID){
			
			$users = $this -> db -> ÏµÍ³ÓÃ»§() -> where('Ñ§Éúid', $userID);
			if(sizeof($users) == 0){
				return null;
			}
			/*
			else{
				
				$app = $users[0];
				echo "here<br>";
				$arr = array(
					"ÂÛÎÄÌâÄ¿" => $app['ÂÛÎÄÌâÄ¿'],
					"ÂÛÎÄÕªÒª" => $app['ÂÛÎÄÕªÒª'],
					"µ¼Ê¦Òâ¼û" => $app['µ¼Ê¦Òâ¼û'],
					"Ñ§ÔºÒâ¼û" => $app['Ñ§ÔºÒâ¼û']);
				return $arr;

			}*/
		}
	}
?>