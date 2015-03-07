-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2015 �?03 �?07 �?07:33
-- 服务器版本: 5.6.11
-- PHP 版本: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `blind_review_db`
--
CREATE DATABASE IF NOT EXISTS `blind_review_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blind_review_db`;

-- --------------------------------------------------------

--
-- 表的结构 `修改说明类`
--

CREATE TABLE IF NOT EXISTS `修改说明类` (
  `论文id` char(20) NOT NULL,
  `修改说明表id` char(20) NOT NULL,
  `修改说明` text NOT NULL,
  PRIMARY KEY (`论文id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `学生表`
--

CREATE TABLE IF NOT EXISTS `学生表` (
  `学生id` char(20) NOT NULL,
  `Email` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  `导师id` char(20) NOT NULL,
  `入学时间` date NOT NULL,
  `盲审次数` int(11) NOT NULL,
  PRIMARY KEY (`学生id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `学生表`
--

INSERT INTO `学生表` (`学生id`, `Email`, `电话`, `导师id`, `入学时间`, `盲审次数`) VALUES
('123456789', '10101010@qq.com', '15201615874', '李志强', '2014-09-15', 0);

-- --------------------------------------------------------

--
-- 表的结构 `学院管理人员表`
--

CREATE TABLE IF NOT EXISTS `学院管理人员表` (
  `学院管理员id` char(20) NOT NULL,
  `Email` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  PRIMARY KEY (`学院管理员id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `导师表`
--

CREATE TABLE IF NOT EXISTS `导师表` (
  `导师id` char(20) NOT NULL,
  `学院` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  `Email` char(20) NOT NULL,
  PRIMARY KEY (`导师id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `消息表`
--

CREATE TABLE IF NOT EXISTS `消息表` (
  `消息id` char(20) NOT NULL,
  `消息标题` varchar(50) NOT NULL,
  `消息内容` text NOT NULL,
  `消息接受用户id` char(20) NOT NULL,
  PRIMARY KEY (`消息id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `系统用户`
--

CREATE TABLE IF NOT EXISTS `系统用户` (
  `学生id` char(20) NOT NULL,
  `导师意见` text NOT NULL,
  `学院意见` text NOT NULL,
  `评审申请表id` char(20) NOT NULL,
  PRIMARY KEY (`评审申请表id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `系统管理员表`
--

CREATE TABLE IF NOT EXISTS `系统管理员表` (
  `系统管理员id` char(20) NOT NULL,
  `Email` char(20) NOT NULL,
  `电话` char(11) NOT NULL,
  PRIMARY KEY (`系统管理员id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `论文审核申请`
--

CREATE TABLE IF NOT EXISTS `论文审核申请` (
  `截止日期` date NOT NULL,
  `操作人id` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `论文表`
--

CREATE TABLE IF NOT EXISTS `论文表` (
  `论文id` char(20) NOT NULL,
  `学生id` char(20) NOT NULL,
  `评审信息表id` char(20) NOT NULL,
  `评审结果` tinyint(1) NOT NULL,
  PRIMARY KEY (`论文id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `论文评审`
--

CREATE TABLE IF NOT EXISTS `论文评审` (
  `列名 论文提交截止日期` date NOT NULL,
  `专家评审截止日期` date NOT NULL,
  `操作人id` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `论文评阅书`
--

CREATE TABLE IF NOT EXISTS `论文评阅书` (
  `评审人id` char(20) NOT NULL,
  `论文评审书id` char(20) NOT NULL,
  `学术评语` text NOT NULL,
  `总分` char(20) NOT NULL,
  PRIMARY KEY (`论文评审书id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `评审信息类`
--

CREATE TABLE IF NOT EXISTS `评审信息类` (
  `学生id` char(20) NOT NULL,
  `学术不端检测结果` char(20) NOT NULL,
  `评审专家一意见` text NOT NULL,
  `评审专家二意见` text NOT NULL,
  `修改说明` text NOT NULL,
  `学院意见` text NOT NULL,
  `评审信息表id` char(20) NOT NULL,
  PRIMARY KEY (`评审信息表id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
