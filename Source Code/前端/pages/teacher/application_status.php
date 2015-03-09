<?php
    // print_r($_COOKIE);
    if(strcmp($_COOKIE["role"],"导师")){
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

    // 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);

    $application = $db->评审申请();
    $userId = $_GET["userId"];
    //echo $userId;
    if($_GET["action"] == "review"){//判断用户是否执行提交操作
        if(!empty($_POST)){
            //print_r($_POST);
            $data = array(
            "导师意见" => $_POST["teacherReview"]);

            $records = $application->where("学生id",$_GET["userId"]);
            $result = $records->update($data);
        }
    }
    //获取该学生提交的评审申请
    $stu_apply = $application->where("学生id",$_GET["userId"])->order("id DESC")->limit(1,0);
    //echo $stu_apply;
    $last_apply = $stu_apply->fetch();
    //print_r($last_apply);
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
                            <a href="students.php"><i class="fa fa-users fa-fw"></i> 学生列表</a>
                        </li>
                        <li>
                            <a href="papers.php"><i class="fa fa-pencil-square-o fa-fw"></i> 审核论文</a>
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
                    <h1 class="page-header">研究生学位论文评审申请书</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           当前状态：<b><font color="#6495ED">待填写导师意见</font></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="application_status.php?action=review&userId=<?php echo $userId; ?>" method="post">
                                        <div class="form-group">
                                            <label>论文题目：</label>
                                            <input class="form-control" value="<?php echo $last_apply['论文题目']?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>论文摘要：</label>
                                            <textarea class="form-control" rows="5" disabled>
                                                <?php echo $last_apply['论文摘要']?>
                                            </textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label>导师意见：</label>
                                            <textarea name ="teacherReview" class="form-control" rows="5" <?php if(!empty($last_apply['导师意见'])){echo "disabled";}?>>写得非常好！</textarea>
                                        </div>
                                         <button type="submit" class="btn btn-default">导出文档</button>
                                        <button type="submit" class="btn btn-default" <?php if(!empty($last_apply['导师意见'])){echo "disabled";}?>>提交</button>
                                        <button type="reset" class="btn btn-default" <?php if(!empty($last_apply['导师意见'])){echo "disabled";}?>>重置</button>
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
