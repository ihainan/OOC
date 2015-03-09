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

    // 获取所有用户
    $usersInfo = $users -> getUsersInfo();    

    // 更新学术不端检测结果
    if(array_key_exists("学术不端检测结果", $_GET)
        && array_key_exists("userId", $_GET)){
        if($_GET["学术不端检测结果"] != "未设置"){
            $review -> updatePaperReview($_GET["userId"], $_GET["学术不端检测结果"]);
            $message = "保存成功！";
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

    <!-- DataTables CSS -->
    <link href="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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
                    <h1 class="page-header">学生列表</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>姓名</th>
                                            <th>学号</th>
                                            <th>申请表状态</th>
                                            <th>论文提交状态</th>
                                            <th>学术不端检测结果</th>
                                            <th>专家一</th>
                                            <th>专家一意见</th>
                                            <th>专家二</th>
                                            <th>专家二意见</th>
                                            <th>最终结果</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($usersInfo as $userInfo) {
                                                if($userInfo["用户角色"] == "学生"){
                                                    $userId = $userInfo["用户id"];

                                                    // 获取论文审核状态
                                                    $applicationStautsText = $application -> getApplicationStatusText($userId);

                                                    // 获取论文上传状态
                                                    $isPaperUploaded = $review -> isPaperUploaded($userId);
                                                    if($isPaperUploaded){
                                                        $isPaperUploadedText = "已上传";
                                                        $link = "../uploads/".$userId."_".date("Y").".docx";
                                                    }
                                                    else{
                                                        $isPaperUploadedText = "未上传";
                                                    }

                                                    // 获取审核信息表
                                                    $reviewResult = $review -> getReviewResult($userId);
                                                    $paperCheckStatus = $reviewResult["学术不端检测结果"];
                                        ?>
                                           
                                            <tr class="even gradeC">
                                                <td><?php echo $userInfo["姓名"]; ?></td>
                                                <td class="center"><?php echo $userInfo["用户id"]; ?> </td>
                                                <td class="center"><?php echo $applicationStautsText; ?>（<a href="application_status.php?userid=<?php echo $userId; ?>">查看详情</a>）</td>
                                                <td class="center"><?php echo $isPaperUploadedText; ?>
                                                    <?php
                                                        if($isPaperUploaded){
                                                    ?>
                                                        （<a href="<?php echo $link; ?>">下载</a>）
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                <td>
                                                     <form action="students.php" method="get">
                                                     <input type="hidden" name = "userId" value = "<?php echo $userId;?>" length = "0"/>
                                                    <select class="form-contrl" name = "学术不端检测结果">
                                                        
                                                        <option <?php if($paperCheckStatus == "") echo "selected";?>>未设置</option>
                                                        <option <?php if($paperCheckStatus == "高于 25%,评审不通过") echo "selected";?>>高于 25%,评审不通过</option>
                                                        <option <?php if($paperCheckStatus == "低于 25%,论文主体部分重合率高") echo "selected";?>>低于 25%,论文主体部分重合率高</option>
                                                        <option <?php if($paperCheckStatus == "低于 25%,绪论及文献综述部分重合率高") echo "selected";?>>低于 25%,绪论及文献综述部分重合率高</option>
                                                    </select>
                                                     <input type="submit" value="保存"/>
                                                    </form>
                                                </td>
                                                <td><?php echo $reviewResult["评审专家一id"];?></td>
                                                <td><?php echo $reviewResult["评审专家一意见"];?>（<a href="expertReview.php?userId=<?php echo $userId?>&expert=1">修改</a>）</td>
                                                <td><?php echo $reviewResult["评审专家二id"];?></td>
                                                <td><?php echo $reviewResult["评审专家二意见"];?>（<a href="expertReview.php?userId=<?php echo $userId?>&expert=2">填写</a>）</td>
                                                <td><?php echo $reviewResult["学院意见"];?></td>
                                            </tr>
                            
                                        <?php            

                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div align="right"><a href="#">下载论文</a></div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
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

    <!-- DataTables JavaScript -->
    <script src="../../bower_components/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
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
