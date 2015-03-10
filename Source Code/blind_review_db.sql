-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 10.4.20.193
-- Generation Time: Mar 10, 2015 at 03:52 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blind_review_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `修改说明类`
--

CREATE TABLE IF NOT EXISTS `修改说明类` (
  `论文id` char(20) NOT NULL,
  `修改说明表id` char(20) NOT NULL,
  `修改说明` varchar(1000) NOT NULL,
  PRIMARY KEY (`论文id`),
  UNIQUE KEY `论文id` (`论文id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `修改说明类`
--

INSERT INTO `修改说明类` (`论文id`, `修改说明表id`, `修改说明`) VALUES
('2220140537', '', '我错了以后一定好好写论文！');

-- --------------------------------------------------------

--
-- Table structure for table `学生表`
--

CREATE TABLE IF NOT EXISTS `学生表` (
  `学生id` char(20) NOT NULL,
  `Email` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  `导师id` char(20) NOT NULL,
  `入学时间` date NOT NULL,
  `盲审次数` int(11) NOT NULL,
  PRIMARY KEY (`学生id`),
  UNIQUE KEY `学生id` (`学生id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `学生表`
--

INSERT INTO `学生表` (`学生id`, `Email`, `电话`, `导师id`, `入学时间`, `盲审次数`) VALUES
('2220140537', '10101010@qq.com', '15201615874', 'lilaoshi', '2014-09-15', 0),
('2220140550', 'ihainan@bit.edu.cn', '15201613615', 'lilaoshi', '2014-09-01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `学院管理人员表`
--

CREATE TABLE IF NOT EXISTS `学院管理人员表` (
  `学院管理员id` char(20) NOT NULL,
  `Email` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  PRIMARY KEY (`学院管理员id`),
  UNIQUE KEY `学院管理员id` (`学院管理员id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `学院管理人员表`
--

INSERT INTO `学院管理人员表` (`学院管理员id`, `Email`, `电话`) VALUES
('ruanjianxueyuan', 'ssbit@bit.edu.cn', '15201613615');

-- --------------------------------------------------------

--
-- Table structure for table `导师表`
--

CREATE TABLE IF NOT EXISTS `导师表` (
  `导师id` char(20) NOT NULL,
  `学院` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `擅长领域` varchar(255) NOT NULL,
  PRIMARY KEY (`导师id`),
  UNIQUE KEY `导师id` (`导师id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `导师表`
--

INSERT INTO `导师表` (`导师id`, `学院`, `电话`, `Email`, `擅长领域`) VALUES
('lilaoshi', '软件学院', '15201613615', 'lizhiqiang@bit.edu.cn', '数据挖掘，网络管理'),
('liulaoshi', '软件学院', '12345678', 'liuchi@bit.edu.cn', '大数据，云计算，物联网'),
('mary', '软件学院', '1234567890', '01010100@qq.com', '数据挖掘，网络管理'),
('xuejingfeng', '软件学院', '010100101', '010100101@bit.com', '大数据，云计算');

-- --------------------------------------------------------

--
-- Table structure for table `开放审核申请`
--

CREATE TABLE IF NOT EXISTS `开放审核申请` (
  `截止日期` date NOT NULL,
  `操作人id` char(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `开放审核申请id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='学院管理人员开放审核申请' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `开放审核申请`
--

INSERT INTO `开放审核申请` (`截止日期`, `操作人id`, `id`) VALUES
('2015-03-09', 'ruanjianxueyuan', 1),
('2015-03-07', 'ruanjianxueyuan', 3),
('2015-03-13', 'ruanjianxueyuan', 4),
('2015-03-19', 'ruanjianxueyuan', 5),
('2015-03-25', 'ruanjianxueyuan', 6),
('2015-03-16', 'ruanjianxueyuan', 7),
('2015-03-16', 'ruanjianxueyuan', 8),
('2015-03-16', 'ruanjianxueyuan', 9),
('2015-03-17', 'ruanjianxueyuan', 10),
('2015-03-20', 'ruanjianxueyuan', 11),
('2015-03-31', 'ruanjianxueyuan', 12),
('2015-04-01', 'ruanjianxueyuan', 13),
('2015-03-26', 'ruanjianxueyuan', 14),
('2015-03-26', 'ruanjianxueyuan', 15),
('2015-03-30', 'ruanjianxueyuan', 16);

-- --------------------------------------------------------

--
-- Table structure for table `消息表`
--

CREATE TABLE IF NOT EXISTS `消息表` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `消息标题` varchar(50) NOT NULL,
  `消息内容` varchar(255) NOT NULL,
  `消息接受用户id` char(20) NOT NULL COMMENT '*号代表所有学生',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  PRIMARY KEY (`id`),
  UNIQUE KEY `消息id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `消息表`
--

INSERT INTO `消息表` (`id`, `消息标题`, `消息内容`, `消息接受用户id`, `time`) VALUES
(1, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-25前完成申请。', '*', '2015-03-08 04:00:00'),
(4, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-17前完成申请。', '*', '2015-03-08 09:09:56'),
(5, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-20前完成申请。', '*', '2015-03-09 05:11:31'),
(6, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-31前完成申请。', '*', '2015-03-09 05:44:11'),
(7, '开放申请通知', '论文审核申请已经开始，请同学们在2015-04-01前完成申请。', '*', '2015-03-09 07:13:43'),
(8, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-26前完成申请。', '*', '2015-03-09 08:56:19'),
(9, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-26前完成申请。', '*', '2015-03-09 08:56:34'),
(10, '开放申请通知', '论文审核申请已经开始，请同学们在2015-03-30前完成申请。', '*', '2015-03-09 13:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `系统用户`
--

CREATE TABLE IF NOT EXISTS `系统用户` (
  `用户id` char(20) NOT NULL,
  `用户角色` varchar(20) NOT NULL,
  `密码` char(32) NOT NULL,
  `姓名` varchar(20) NOT NULL,
  PRIMARY KEY (`用户id`),
  UNIQUE KEY `用户id` (`用户id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `系统用户`
--

INSERT INTO `系统用户` (`用户id`, `用户角色`, `密码`, `姓名`) VALUES
('2220140537', '学生', '670b14728ad9902aecba32e22fa4f6bd', '陈凯'),
('2220140550', '学生', 'e10adc3949ba59abbe56e057f20f883e', '符积高'),
('admin', '系统管理员', 'e10adc3949ba59abbe56e057f20f883e', '符积高'),
('lilaoshi', '导师', '670b14728ad9902aecba32e22fa4f6bd', '李志强'),
('liulaoshi', '导师', '670b14728ad9902aecba32e22fa4f6bd', '刘驰'),
('mary', '导师', '670b14728ad9902aecba32e22fa4f6bd', '马锐'),
('ruanjianxueyuan', '学院管理人员', '670b14728ad9902aecba32e22fa4f6bd', '王老师'),
('xuejingfeng', '导师', '670b14728ad9902aecba32e22fa4f6bd', '薛静峰');

-- --------------------------------------------------------

--
-- Table structure for table `系统管理员表`
--

CREATE TABLE IF NOT EXISTS `系统管理员表` (
  `系统管理员id` char(20) NOT NULL,
  `Email` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  PRIMARY KEY (`系统管理员id`),
  UNIQUE KEY `系统管理员id` (`系统管理员id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `系统管理员表`
--

INSERT INTO `系统管理员表` (`系统管理员id`, `Email`, `电话`) VALUES
('admin', '1096012414@qq.com', '15201615874');

-- --------------------------------------------------------

--
-- Table structure for table `论文表`
--

CREATE TABLE IF NOT EXISTS `论文表` (
  `学生id` char(20) NOT NULL,
  `评审信息表id` char(20) NOT NULL,
  `评审结果` tinyint(1) NOT NULL,
  `关键字` varchar(100) NOT NULL COMMENT '用中文"，"号隔开',
  `年份` int(11) NOT NULL COMMENT '整型，例2015',
  PRIMARY KEY (`学生id`),
  UNIQUE KEY `学生id` (`学生id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `论文表`
--

INSERT INTO `论文表` (`学生id`, `评审信息表id`, `评审结果`, `关键字`, `年份`) VALUES
('2220140537', '15', 0, '大数据，数据挖掘', 2015);

-- --------------------------------------------------------

--
-- Table structure for table `论文评审`
--

CREATE TABLE IF NOT EXISTS `论文评审` (
  `论文提交截止日期` date NOT NULL,
  `专家评审截止日期` date NOT NULL,
  `操作人id` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `论文评阅书`
--

CREATE TABLE IF NOT EXISTS `论文评阅书` (
  `评审人id` char(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `学术评语` text NOT NULL,
  `总分` char(20) NOT NULL,
  `评审信息类id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `论文评审书id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `论文评阅书`
--

INSERT INTO `论文评阅书` (`评审人id`, `id`, `学术评语`, `总分`, `评审信息类id`) VALUES
('liulaoshi', 7, '不错', 'A', 15),
('xuejingfeng', 8, '不错', 'B', 15);

-- --------------------------------------------------------

--
-- Table structure for table `评审信息类`
--

CREATE TABLE IF NOT EXISTS `评审信息类` (
  `学生id` char(20) NOT NULL,
  `学术不端检测结果` char(20) NOT NULL,
  `评审专家一意见` text NOT NULL,
  `评审专家一id` varchar(50) NOT NULL,
  `评审专家二意见` text NOT NULL,
  `评审专家二id` varchar(50) NOT NULL,
  `专家一修改说明` text NOT NULL,
  `专家二修改说明` text NOT NULL,
  `学院意见` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `评审信息表id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `评审信息类`
--

INSERT INTO `评审信息类` (`学生id`, `学术不端检测结果`, `评审专家一意见`, `评审专家一id`, `评审专家二意见`, `评审专家二id`, `专家一修改说明`, `专家二修改说明`, `学院意见`, `id`) VALUES
('2220140537', '低于 25%,论文主体部分重合率高', 'A', 'liulaoshi', 'B', 'xuejingfeng', '通过', '通过', '同意', 15);

-- --------------------------------------------------------

--
-- Table structure for table `评审申请`
--

CREATE TABLE IF NOT EXISTS `评审申请` (
  `学生id` char(20) NOT NULL,
  `论文题目` varchar(100) DEFAULT NULL,
  `论文摘要` varchar(1000) DEFAULT NULL,
  `导师意见` varchar(255) NOT NULL,
  `学院意见` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `开放审核申请id` int(11) NOT NULL,
  `审核状态` varchar(30) NOT NULL,
  `申请理由` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `评审申请表id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `评审申请`
--

INSERT INTO `评审申请` (`学生id`, `论文题目`, `论文摘要`, `导师意见`, `学院意见`, `id`, `开放审核申请id`, `审核状态`, `申请理由`) VALUES
('2220140537', '《一个非常屌的论文题目》', '一个非常屌的论文摘要', '写得非常好！', '写得非常好！', 13, 16, '通过', '我已获得软件工程硕士培养计划中规定的全部学分,并完成了学位论文的 撰写工作。现申请进行学位论文评审,请审批。');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
