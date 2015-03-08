<?php
    // print_r($_COOKIE);
    if(strcmp($_COOKIE["role"],"学院管理人员")){
       header("refresh:3;url=../login.php");
       echo "无权限浏览此页，3秒后跳转...";
       exit();
      }

    // 开启错误提示
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    // 引用文件
    require_once("../../phpLibrary/users.php");
    require_once("../../phpLibrary/review_class.php");
    require_once("../../phpLibrary/message_class.php");
    require_once("../../phpLibrary/application.php");
    require_once("../../phpLibrary/notorm-master/NotORM.php");

    // 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);

  
    // 初始化函数库类
    $review = new Review($db);
    $users = new Users($db);
    $application = new Application($db);
  

    // 更新学术不端检测结果
    if(array_key_exists("评分", $_GET) 
        && array_key_exists("学术评语", $_GET)
        && array_key_exists("userId", $_GET)
         && array_key_exists("expert", $_GET)){
        if($_GET["评分"] != "无"){
            if($_GET["expert"] == 1){
                $review -> updateExpertOneReview($_GET["userId"], $_GET["学术评语"], $_GET["评分"]);
            }
            else{
                $review -> updateExpertTwoReview($_GET["userId"], $_GET["学术评语"], $_GET["评分"]);
            }
        }
        else{
            $message = "请选择一个评分等级！";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>北京理工大学软件学院 - 研究生论文盲审系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">


        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">研究生论文盲审系统</a>
            </div>
            <!-- /.navbar-header -->



            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> 概要</a>
                        </li>
                        <li>
                            <a href="openApplication.php"><i class="fa fa-pencil fa-fw"></i> 开放申请</a>
                        </li>
                        <li>
                            <a href="students.php"><i class="fa fa-users fa-fw"></i> 学生列表</a>
                        </li>
                        <li>
                            <a href="profile.php"><i class="fa fa-user fa-fw"></i> 个人资料</a>
                        </li>
                        <li>
                            <a href="javascript:winconfirm()"><i class="fa fa-sign-out fa-fw"></i> 登出系统</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">研究生学位论文评阅书 - 专家 <?php echo $_GET["expert"];?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="#" method="get">
                                        <div class="form-group">
                                            <label>学术评语：</label>
                                            <textarea class="form-control" rows="5" name = "学术评语">不错</textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label>评分：</label>
                                            <select class="form-contrl" name = "评分">
                                                <option>无</option>
                                                <option>A</option>
                                                <option>B</option>
                                                <option>C</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name = "userId" value = "<?php echo $_GET["userId"];?>"/>
                                        <input type="hidden" name = "expert" value = "<?php echo $_GET["expert"];?>"/>
                                        <button type="submit" class="btn btn-default">导出文档</button>
                                        <button type="submit" class="btn btn-default">提交</button>
                                        <button type="reset" class="btn btn-default">重置</button>
                                    </form>
                                </div>
                               
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>
