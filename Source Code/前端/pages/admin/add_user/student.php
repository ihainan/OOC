<?php  

    // 开启错误提示
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    if(strcmp($_COOKIE["role"],"系统管理员")){
       header("refresh:3;url=../login.php");
       echo "无权限浏览此页，3秒后跳转...";
       exit();
    }

    // 引用文件
    require_once("../../../phpLibrary/users.php");
    require_once("../../../phpLibrary/notorm-master/NotORM.php");

    // 初始化数据库
    $pdo = new PDO('mysql:host=lab.ihainan.me;dbname=blind_review_db','ss','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('set names utf8');
    $db = new NotORM($pdo);

    // 初始化 Users 类
    $users = new Users($db);

    // 添加用户
    if(array_key_exists("用户id", $_POST)
        && array_key_exists("密码", $_POST) 
        && array_key_exists("姓名", $_POST)){
        $userBasicInfo = array(    
                "用户id" => $_POST["用户id"],
                "用户角色" => "学生", 
                "密码" => md5($_POST["密码"]),
                "姓名" => $_POST["姓名"]);
        
        $externInfo = array(
                "学生id" => $_POST["用户id"],
                "Email" => $_POST["Email"],
                "电话" => $_POST["电话"],
                "导师id" => $_POST["导师id"],
                "入学时间" => $_POST["入学时间"],
                "盲审次数" => 0
                );

        $result = $users -> addStudentUser($userBasicInfo, $externInfo);

        // Cookie 操作，存储近期操作
        if(array_key_exists("recent_operations", $_COOKIE)){
             $oldArray = unserialize($_COOKIE['recent_operations']);
             $oldArray[time()] = "添加了研究生用户 ".$_POST["用户id"];
             setcookie("recent_operations", 
                serialize($oldArray),
                time() + 3600,
                "/");
        }
        else{
            
            $emptyArray = array(time() => "添加了研究生用户 ".$_POST["用户id"]);
            setcookie("recent_operations", 
                serialize($emptyArray),
                time() + 3600,
                "/");

        }

        $message = "添加用户成功！";
        echo "<script type='text/javascript'>alert('$message');</script>";

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
    <link href="../../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../../../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../dist/css/profile.css" rel="stylesheet">


    <!-- Morris Charts CSS -->
    <link href="../../../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom Script -->
    <script src="../../../dist/css/profile.js"></script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function getval(sel) {
            if(sel.value == 0){
                window.location.replace("admin.php");
            }
            else if(sel.value == 1){
                window.location.replace("student.php");
            }
            else if(sel.value == 2){
                window.location.replace("teacher.php");
            }
            else if(sel.value == 3){
                window.location.replace("manager.php");
            }
        }
    </script>
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
                <a class="navbar-brand" href="../index.php">研究生论文盲审系统</a>
            </div>
            <!-- /.navbar-header -->



            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="../index.php"><i class="fa fa-dashboard fa-fw"></i> 概要</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> 用户管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../user_list.php"> 用户列表</a>
                                </li>
                                <li>
                                    <a href="#"> 添加用户</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="../profile.php"><i class="fa fa-user fa-fw"></i> 个人资料</a>
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
                    <h1 class="page-header">添加用户</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           
           <div class="container">
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0   toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">添加学生角色</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" class="img-circle"> </div>
                
                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 "> 
                <form action="#" method="post" id = "form-id">
                    <table class="table table-user-information">
                        <tbody>
                          <tr>
                            <td>用户角色：</td>
                            <td>
                                <select onchange="getval(this);"> 
                                    <option value="1">研究生</option>                 
                                    <option value="0">管理员</option> 
                                    <option value="2">导师</option> 
                                    <option value="3">学院管理人员</option> 
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td>用户名：</td>
                            <td><input type="text" value="ihainan" name="用户id" /></td>
                          </tr>
                          <tr>
                            <td>密码：</td>
                            <td><input type="password" value="123456" name = "密码"/></td>
                          </tr>
                          <tr>
                            <td>真实姓名：</td>
                            <td><input type="text" value="符积高" name = "姓名"/></td>
                          </tr>
                          <tr>
                            <td>Email: </td>
                            <td><input type="text" value="ihainan@bit.edu.cn" name = "Email"/></td>
                          </tr>
                          <tr>
                            <td>电话：</td>
                            <td><input type="text" value="15201613615" name = "电话"/></td>
                          </tr>
                          <tr>
                            <td>导师 ID：</td>
                            <td><input type="text" value="lilaoshi" name = "导师id"/></td>
                          </tr>
                          <tr>
                            <td>入学时间：</td>
                            <td><input type="date" value="2014-09-01" name = "入学时间"/></td>
                          </tr>
                        </tbody>
                    </table>
                    <a class="btn btn-primary" onclick="document.getElementById('form-id').submit();">添加</a>
                    <a href="#" class="btn btn-primary">重置</a>
                </form>
                </div>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../../bower_components/raphael/raphael-min.js"></script>
    <script src="../../../bower_components/morrisjs/morris.min.js"></script>
    <script src="../../../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../../dist/js/sb-admin-2.js"></script>

</body>

</html>
