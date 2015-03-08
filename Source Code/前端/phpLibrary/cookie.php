<?php
 function clearCookies(){
        setcookie('username',"",time()-3600);
        setcookie("role","",time()-3600);
    }
?>