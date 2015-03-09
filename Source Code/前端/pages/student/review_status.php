<?php
    // print_r($_COOKIE);
    if(strcmp($_COOKIE["role"],"学生")){
       header("refresh:3;url=../login.php");
       echo "无权限浏览此页，3秒后跳转...";
       exit();
    }

    // 开启错误提示
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    // 引用文件
    require_once("../../phpLibrary/users.php");
    require_once("../../phpLibrary/message_class.php");
    require_once("../../phpLibrary/notorm-master/NotORM.php");
    require_once("../../phpLibrary/Application.php");
    require_once("../..//phpLibrary/review_class.php");

    // 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);

    // 初始化 Review 类
    $review = new review($db);
    $result = $review -> getStudentReviewResult($_COOKIE["username"]);
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
                            <a href="#"><i class="fa fa-file-text-o fa-fw"></i> 审核申请<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="application_form.php"> 填写申请</a>
                                </li>
                                <li>
                                    <a href="application_status.php"> 审核状态</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-file-text-o fa-fw"></i> 论文评审<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="upload_paper.php"> 上传论文</a>
                                </li>
                                <li>
                                    <a href="add_modify.php"> 提交修改说明</a>
                                </li>
                                <li>
                                    <a href="review_status.php"> 评审结果</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
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
                    <h1 class="page-header">评审结果</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           当前状态：<b><font color="#6495ED"><?php echo $result["结果"];?></font></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>论文题目：</label>
                                            <input class="form-control" value="<?php echo $result["论文题目"];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>论文摘要：</label>
                                            <textarea class="form-control" rows="5" disabled><?php echo $result["论文摘要"];?></textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label>学术不端文献检测系统检测结果：</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1"  disabled
                                                    <?php if($result["学术不端检测结果"] == "高于 25%,评审不通过") echo "checked"?>
                                                    >&nbsp;高于 25%,评审不通过
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" disabled <?php if($result["学术不端检测结果"] == "低于 25%,论文主体部分重合率高") echo "checked"?> >&nbsp;低于 25%,论文主体部分重合率高
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled <?php if($result["学术不端检测结果"] == "低于 25%,绪论及文献综述部分重合率高") echo "checked"?>>&nbsp;低于 25%,绪论及文献综述部分重合率高
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>评审专家一意见：</label>
                                            <textarea class="form-control" rows="5" disabled><?php echo $result["评审专家一意见"];?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>评审专家一分数：</label>
                                            <input class="form-control" value="<?php echo $result["评审专家一分数"];?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>评审专家二意见：</label>
                                            <textarea class="form-control" rows="5" disabled><?php echo $result["评审专家二意见"];?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>评审专家二分数：</label>
                                            <input class="form-control" value="<?php echo $result["评审专家二分数"];?>" disabled>
                                        </div>
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
