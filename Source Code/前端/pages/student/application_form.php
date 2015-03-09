<?php
    // print_r($_COOKIE);
    if(strcmp($_COOKIE["role"],"学生")){
       header("refresh:3;url=../login.php");
       echo "无权限浏览此页，3秒后跳转...";
       exit();
      }
      // 开启错误提示
    //error_reporting(E_ALL);
    //ini_set('display_errors', 'On');

    // 引用文件
    require_once("../../phpLibrary/users.php");
    require_once("../../phpLibrary/notorm-master/NotORM.php");
    require_once("../../phpLibrary/application.php");

    // 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);
    // 初始化 Users 类
    $users = new Users($db);

    $studentInfo = $users->getStudentInfo($_COOKIE["username"]);
    //print_r($studentInfo);
    $apply = $db->评审申请();
    
    if($_GET["action"] == "application"){//判断用户是否执行提交操作
        if(!empty($_POST)){
            //print_r($_POST);
            $data = array(
            "学生id" => $studentInfo["用户id"],
            "开放审核申请id" => $db->开放审核申请()->max("id"),
            "论文摘要" => $_POST["abstract"],
            "论文题目" => $_POST["paper_tile"],
            "申请理由" => $_POST["reason"]);
            $result = $apply->insert($data);
        }
    }
    $application = new Application($db);
    $flag = $application->getApplicationStatusText($studentInfo["用户id"]);
    echo $flag;
    /*//获取该学生提交的评审申请
    $stu_apply = $application->where("学生id",$_COOKIE["username"])->order("id DESC")->limit(1,0);
    //echo $stu_apply;
    $last_apply = $stu_apply->fetch();
    //$flag;
    if($last_apply["开放审核申请id"] == $db->开放审核申请()->max("id")){
       $flag = "状态：".$last_apply["审核状态"];
    }*/
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
                    <h1 class="page-header">填写申请 <?php  echo "　".$flag;?>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           《北京理工大学软件学院 研究生学位论文评审申请书》
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="application_form.php?action=application" method="post">
                                        <div class="form-group">
                                            <label>学号：</label>
                                            <input name="userid" class="form-control" value="<?php echo $studentInfo["用户id"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>姓名：</label>
                                            <input name="username" class="form-control" value="<?php echo $studentInfo["姓名"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>指导老师：</label>
                                            <input name="teacher" class="form-control" value="<?php echo $studentInfo["导师"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>入学时间：</label>
                                            <input name="admission_time" class="form-control" value="<?php echo $studentInfo["入学时间"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>手机：</label>
                                            <input name="phone" class="form-control" value="<?php echo $studentInfo["电话"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>邮箱：</label>
                                            <input name="email" class="form-control" value="<?php echo $studentInfo["Email"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>论文题目：</label>
                                            <input name="paper_tile" class="form-control" value="《一个非常屌的论文题目》" <?php if($flag != "学生未提交"){ echo "disabled";}?>>
                                        </div>
                                        <div class="form-group">
                                            <label>论文摘要：</label>
                                            <textarea name="abstract" class="form-control" rows="5" <?php if($flag != "学生未提交"){ echo "disabled";}?>
                                            >一个非常屌的论文摘要</textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label>申请理由：</label>
                                            <textarea name="reason" class="form-control" rows="5" <?php if($flag != "学生未提交"){ echo "disabled";}?>
                                            >我已获得软件工程硕士培养计划中规定的全部学分,并完成了学位论文的 撰写工作。现申请进行学位论文评审,请审批。</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-default" <?php if($flag != "学生未提交"){ echo "disabled";}?>>提交</button>
                                        <button type="reset" class="btn btn-default" <?php if($flag != "学生未提交"){ echo "disabled";}?>>重置</button>
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
    <script>
        function winconfirm(){
            question = confirm("确定登出本系统？")
            if (question != "0"){
             window.location = "../logout.php"
            }
        }
    </script>
</body>

</html>
