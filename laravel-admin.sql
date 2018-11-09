/*
SQLyog Professional v12.09 (64 bit)
MySQL - 5.7.24-0ubuntu0.16.04.1 : Database - laravel_admin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel_admin` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `laravel_admin`;

/*Table structure for table `yy_admin_log` */

DROP TABLE IF EXISTS `yy_admin_log`;

CREATE TABLE `yy_admin_log` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '只增ID',
  `admin_id` int(11) unsigned NOT NULL COMMENT '管理员ID',
  `operator` varchar(64) NOT NULL COMMENT '操作者',
  `ip` varchar(64) NOT NULL COMMENT 'IP地址',
  `func` varchar(100) NOT NULL DEFAULT '' COMMENT '操作的权限点',
  `url` text NOT NULL COMMENT '访问地址',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `details` text COMMENT '详情',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1日志 2错误 3警告',
  `create_time` decimal(16,3) unsigned NOT NULL COMMENT '数据插入时间',
  PRIMARY KEY (`id`),
  KEY `func` (`func`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='运营后台操作日志记录表';

/*Data for the table `yy_admin_log` */

/*Table structure for table `yy_auth_admin` */

DROP TABLE IF EXISTS `yy_auth_admin`;

CREATE TABLE `yy_auth_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(128) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '密码',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `avatar` varchar(200) DEFAULT '' COMMENT '用户头像',
  `mobile` varchar(32) DEFAULT '' COMMENT '手机号',
  `email` varchar(100) DEFAULT '' COMMENT '电子邮箱',
  `dingtalk_id` varchar(200) DEFAULT '' COMMENT '钉钉ID',
  `dingtalk_globalid` varchar(200) DEFAULT '' COMMENT '钉钉全局ID',
  `last_login` decimal(16,3) unsigned DEFAULT '0.000' COMMENT '最后登录时间',
  `last_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `try_time` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '密码尝试次数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '账号状态 1:正常 2:禁止登陆',
  `create_time` decimal(16,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '数据插入时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COMMENT='运营后台用户列表';

/*Data for the table `yy_auth_admin` */

insert  into `yy_auth_admin`(`id`,`username`,`password`,`realname`,`avatar`,`mobile`,`email`,`dingtalk_id`,`dingtalk_globalid`,`last_login`,`last_ip`,`try_time`,`status`,`create_time`) values (1,'god','$2y$12$wNn2NqR0kIXdG4H0/WJrf.NfS8csPHGC1xUGO0KDTYe.zKlqkbxMy','SuperAdmin','/storage/avatars/ZREEU7nrxhmCNsI4VTuOTlbWwh6479pWHz7aW0to.jpeg','15888030318','yuyuefeng@kaike.la','3527594120810015','','1541753128.147','192.168.126.1',0,1,'0.000'),(2,'test','$2y$12$23bjKmox2SuRsEQQxp4YcOGx.3nHo6vEvX2yjBYTNs84buy8.I42O','测试号','/storage/avatars/xL35yynYjcCmQdhGDqjqwEnwPGFASjGCp35RNbBE.jpeg',NULL,NULL,'','','1541751851.787','192.168.126.1',0,1,'1541734248.958');

/*Table structure for table `yy_auth_group` */

DROP TABLE IF EXISTS `yy_auth_group`;

CREATE TABLE `yy_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '组名称',
  `rules` text NOT NULL COMMENT '权限列表',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='组列表';

/*Data for the table `yy_auth_group` */

insert  into `yy_auth_group`(`id`,`title`,`rules`,`status`) values (1,'上帝组','1,2,3,4,5,6',1),(2,'高级管理员','1,2,3,4,5',1);

/*Table structure for table `yy_auth_group_access` */

DROP TABLE IF EXISTS `yy_auth_group_access`;

CREATE TABLE `yy_auth_group_access` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `group_id` int(11) unsigned NOT NULL COMMENT '所属组',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户所属组';

/*Data for the table `yy_auth_group_access` */

insert  into `yy_auth_group_access`(`uid`,`group_id`) values (1,1),(80,2);

/*Table structure for table `yy_auth_rule` */

DROP TABLE IF EXISTS `yy_auth_rule`;

CREATE TABLE `yy_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '权限点',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '名称',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1 启用; 0 禁用',
  `menu` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1 作为菜单显示; 0 不显示',
  `condition` varchar(255) DEFAULT '',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `icon` varchar(100) DEFAULT '' COMMENT '菜单的图标',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='权限点和菜单列表';

/*Data for the table `yy_auth_rule` */

insert  into `yy_auth_rule`(`id`,`name`,`title`,`type`,`status`,`menu`,`condition`,`pid`,`remark`,`icon`) values (1,'/system','系统设置',1,1,1,'',0,'','<i class=\"fa fa-gear\"></i>'),(2,'/system/profile','个人设置',1,1,1,'',1,'',NULL),(3,'/system/admin','管理员列表',1,1,1,'',1,'',NULL),(4,'/system/group','管理组列表',1,1,1,'',1,'',NULL),(5,'/system/rule','权限点管理',1,1,1,'',1,'',NULL),(6,'/system/logs','操作日志',1,1,1,'',1,'',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
