<?php
   /* include "../phpLibrary/notorm-master/NotORM.php";
    $pdo = new PDO('mysql:host=localhost;dbname=blind_review_db','root','');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);*/
    include "../phpLibrary/mysql.php";
    include "../phpLibrary/cookie.php";
   
    if($_GET["action"] == "login"){
        clearCookies();
        $user = $db->系统用户->where("用户id",$_POST["username"]);
        //echo $user->fetch();
        //echo $user->count("*");
       // echo $user["用户id"]." ".$user["密码"]." ".$user["用户角色"];
        if($user->count("*") == 1){//用户名正确
            $user = $user->fetch();
            //$i = strcmp($user["密码"],md5($_POST["password"]));
            if(strcmp($user["密码"],md5($_POST["password"])) == 0){//密码正确
                if(0 == strcmp($user["用户角色"],"系统管理员")){
                    setcookie('username',$_POST["username"],time()+60*60*24*7);
                    setcookie('role','系统管理员',time()+60*60*24*7);
                    header('Location:admin/index.php');
                }else if(strcmp($user["用户角色"],"学生") == 0){
                    setcookie('username',$_POST["username"],time()+60*60*24*7);
                    setcookie('role','学生',time()+60*60*24*7);
                    header('Location:student/index.php');
                }else if(0 == strcmp($user["用户角色"],"导师")){
                    setcookie('username',$_POST["username"],time()+60*60*24*7);
                    setcookie('role','导师',time()+60*60*24*7);
                    header('Location:teacher/index.php');
                }else if(0 == strcmp($user["用户角色"],"学院管理人员")){
                    setcookie('username',$_POST["username"],time()+60*60*24*7);
                    setcookie('role','学院管理人员',time()+60*60*24*7);
                    header('Location:manager/index.php');
                }
            }else {
                die("用户名或密码错误!".$_POST["password"]." ".md5($_POST["password"]." ".$user["密码"]));
            }
        }else{
            die("用户名或密码错误!".$user->count("*"));
        }
    }
    //根据cookie自动登录
    if(!strcmp($_COOKIE["role"],"系统管理员")){
        header('Location:admin/index.php');
    }else if(!strcmp($_COOKIE["role"],"学生")){
        header('Location:student/index.php');
    }else if(!strcmp($_COOKIE["role"],"导师")){
        header('Location:teacher/index.php');
    }else if(!strcmp($_COOKIE["role"],"学院管理人员")){
        header('Location:manager/index.php');
    }
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>北京理工大学软件学院 - 研究生论文盲审系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <div align="center">
                            <img src="../images/bit_logo_ori.png" width="200" height="200" />
                            <h2 style="font-family:STKaiti, KaiTi">研究生论文盲审系统</h2>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="login.php?action=login" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="用户名" name="username" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="密码" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">记住我
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block"  placeholder="登录">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
