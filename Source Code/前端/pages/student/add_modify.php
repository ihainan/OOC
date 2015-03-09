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
    require_once("../../phpLibrary/notorm-master/NotORM.php");

    // 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);

    $users = new Users($db);
    $studentInfo = $users->getStudentInfo($_COOKIE["username"]);
    
    //获取该学生提交的评审申请
    $last_apply = $db->评审申请()->where("学生id",$_COOKIE["username"])->order("id DESC")->limit(1,0)->fetch();
    // 上传文件
    if(isset($_POST["submit"])){
        
       
            // 上传文件
            $target_dir = "../uploads/";
            $target_file = $target_dir . $_COOKIE["username"] . "_". date("Y") . ".docx";

            //echo $target_file;
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                //上传文件成功后更新数据库，向“修改说明类”中插入新行
                $modify_table = $db->修改说明类();
                $modifies = $modify_table->where("论文id",$_COOKIE["username"]);
                $message = "上传文件成功！";
                if(sizeof($modify_table) > 0){//存在，更新
                    $data = array(
                    "修改说明" => $_POST["modify_text"]);
                    $result = $modifies->update($data);
                }else {
                    $data = array(
                    "论文id" => $_COOKIE["username"],
                    "修改说明" => $_POST["modify_text"]);
                    //print_r($data);
                    $result = $modify_table->insert($data);
                    if($result != false){
                        $message = "上传文件成功！";
                    }else $message = "文件上传失败！";
                }
                 // 弹窗提示
                echo "<script type='text/javascript'>alert('$message');</script>";

            }
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
                    <h1 class="page-header">填写修改说明</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           《北京理工大学软件学院 研究生学位论文修改说明》
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                     <form role="form" action="#" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>学号：</label>
                                            <input class="form-control" value="<?php echo $studentInfo["用户id"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>姓名：</label>
                                            <input class="form-control" value="<?php echo $studentInfo["姓名"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>论文题目：</label>
                                            <input class="form-control" value="<?php echo $last_apply["论文题目"]?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>修改说明：</label>
                                            <textarea name ="modify_text" class="form-control" rows="5">我错了以后一定好好写论文！</textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label>上传论文：</label>
                                            <input type="file" id="fileToUpload" name = "fileToUpload">
                                        </div>
                                        <button type="submit" name = "submit" class="btn btn-default">提交</button>
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
