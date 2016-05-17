/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : localhost:3306
Source Database       : xuxu

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2015-11-21 16:41:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cache_manage
-- ----------------------------
DROP TABLE IF EXISTS `cache_manage`;
CREATE TABLE `cache_manage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `name` varchar(128) NOT NULL COMMENT '缓存中文名字',
  `ename` varchar(128) NOT NULL COMMENT '缓存英文名字',
  `ename_rule` varchar(255) NOT NULL COMMENT '缓存英文名规则 ',
  `cache_time` int(11) NOT NULL COMMENT '缓存时间',
  `type` tinyint(1) NOT NULL COMMENT '缓存类型  0 memcache 1memcachedb 2 redis 3mongodb 4 mysql',
  `is_warm_up` tinyint(1) NOT NULL COMMENT '是否预热 0 no 1 yes',
  `module` tinyint(1) NOT NULL COMMENT '0 前台 1 后台 2 OA 3 common',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cache_manage
-- ----------------------------

-- ----------------------------
-- Table structure for cache_manage_config
-- ----------------------------
DROP TABLE IF EXISTS `cache_manage_config`;
CREATE TABLE `cache_manage_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `index` varchar(32) DEFAULT NULL COMMENT '配置项',
  `list` varchar(128) DEFAULT NULL COMMENT '配置项值',
  `detail` varchar(255) DEFAULT NULL,
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '类别  0 基本配置 1 驱动配置 2 存储配置',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cache_manage_config
-- ----------------------------

-- ----------------------------
-- Table structure for cache_page_manage
-- ----------------------------
DROP TABLE IF EXISTS `cache_page_manage`;
CREATE TABLE `cache_page_manage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `cname` varchar(128) DEFAULT NULL COMMENT '缓存名称',
  `cache_time` int(11) DEFAULT NULL COMMENT '缓存时间',
  `type` tinyint(1) DEFAULT NULL COMMENT '驱动类型',
  `is_warm_up` tinyint(1) NOT NULL COMMENT '是否预热 0 no 1 yes',
  `module` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '所属页面   0 首页 1 列表页 2 详细页面',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cache_page_manage
-- ----------------------------

-- ----------------------------
-- Table structure for cache_static_manage
-- ----------------------------
DROP TABLE IF EXISTS `cache_static_manage`;
CREATE TABLE `cache_static_manage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `name` varchar(128) DEFAULT NULL COMMENT '缓存名称',
  `cache_time` int(11) DEFAULT NULL COMMENT '缓存时间',
  `type` tinyint(1) DEFAULT NULL COMMENT '驱动类型',
  `cfgtype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '静态化类型  1 栏目配置 2 列表页配置 3 详情页配置',
  `prefix` varchar(128) NOT NULL COMMENT '访问前缀  module/controller/action/params',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cache_static_manage
-- ----------------------------

-- ----------------------------
-- Table structure for log_members_login
-- ----------------------------
DROP TABLE IF EXISTS `log_members_login`;
CREATE TABLE `log_members_login` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `last_login_time` datetime DEFAULT NULL COMMENT '2013',
  `last_login_ip` varchar(16) DEFAULT NULL,
  `last_logout_time` datetime DEFAULT NULL,
  `last_login_city` varchar(256) DEFAULT NULL,
  `device` tinyint(4) DEFAULT '0' COMMENT '0 for pc 1 for android phone 2 for android pad 3 for iphone 4 for ipad 5 for wp phone 6 for others',
  `useragent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='登陆日志';

-- ----------------------------
-- Records of log_members_login
-- ----------------------------

-- ----------------------------
-- Table structure for log_members_operation
-- ----------------------------
DROP TABLE IF EXISTS `log_members_operation`;
CREATE TABLE `log_members_operation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned DEFAULT NULL COMMENT '前台用户id',
  `username` char(128) DEFAULT NULL,
  `controller` char(128) NOT NULL COMMENT '控制器',
  `action` char(32) NOT NULL COMMENT '方法',
  `operation` tinyint(1) unsigned NOT NULL COMMENT '操作类型    1:add  2:update 3:delete',
  `dataid` bigint(20) unsigned DEFAULT NULL COMMENT '数据id',
  `dataids` mediumtext COMMENT '以@为分隔符的字符串形式记录数据id 如： 1@2@3',
  `addtime` datetime DEFAULT NULL,
  `delsign` tinyint(4) DEFAULT NULL,
  `postcontent` mediumtext,
  `descr` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_members_operation
-- ----------------------------

-- ----------------------------
-- Table structure for log_users_operation
-- ----------------------------
DROP TABLE IF EXISTS `log_users_operation`;
CREATE TABLE `log_users_operation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL COMMENT '后台用户id',
  `username` char(128) NOT NULL,
  `controller` char(128) NOT NULL COMMENT '控制器',
  `action` char(32) NOT NULL COMMENT '方法',
  `operation` tinyint(1) unsigned NOT NULL COMMENT '操作类型    1:add  2:update 3:delete',
  `dataid` bigint(20) unsigned DEFAULT NULL COMMENT '数据id',
  `dataids` mediumtext COMMENT '以@为分隔符的字符串形式记录数据id 如： 1@2@3',
  `addtime` datetime DEFAULT NULL,
  `delsign` tinyint(4) DEFAULT NULL,
  `postcontent` mediumtext,
  `descr` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_users_operation
-- ----------------------------

-- ----------------------------
-- Table structure for log_visit_record
-- ----------------------------
DROP TABLE IF EXISTS `log_visit_record`;
CREATE TABLE `log_visit_record` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `memid` bigint(16) unsigned DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `goodid` bigint(16) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `refer` varchar(255) DEFAULT NULL COMMENT '从哪个页面跳转过来',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='访问统计表';

-- ----------------------------
-- Records of log_visit_record
-- ----------------------------

-- ----------------------------
-- Table structure for mem_footprint
-- ----------------------------
DROP TABLE IF EXISTS `mem_footprint`;
CREATE TABLE `mem_footprint` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `spec_id` bigint(20) NOT NULL COMMENT ' 规格ID',
  `visit_cnt` smallint(6) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `mem_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户足迹';

-- ----------------------------
-- Records of mem_footprint
-- ----------------------------

-- ----------------------------
-- Table structure for mem_grades
-- ----------------------------
DROP TABLE IF EXISTS `mem_grades`;
CREATE TABLE `mem_grades` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `mem_id` bigint(20) DEFAULT NULL,
  `left_point` int(11) DEFAULT NULL COMMENT '升级之后剩余点数',
  `grade_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mem_grades
-- ----------------------------

-- ----------------------------
-- Table structure for mem_grade_dic
-- ----------------------------
DROP TABLE IF EXISTS `mem_grade_dic`;
CREATE TABLE `mem_grade_dic` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `lowlimit` int(11) DEFAULT NULL COMMENT '最低消费 >=',
  `highlimit` int(11) DEFAULT NULL COMMENT '到 <',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mem_grade_dic
-- ----------------------------

-- ----------------------------
-- Table structure for mem_members
-- ----------------------------
DROP TABLE IF EXISTS `mem_members`;
CREATE TABLE `mem_members` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `create_time` datetime DEFAULT '0000-00-00 00:00:00',
  `email` varchar(128) DEFAULT '0.00',
  `username` varchar(128) DEFAULT '' COMMENT 'user''s real name',
  `login_name` varchar(128) NOT NULL,
  `password` char(128) NOT NULL COMMENT 'algor:hash(hash(password)+sessionid))',
  `head_img` varchar(128) DEFAULT NULL,
  `gender` tinyint(1) unsigned DEFAULT '0' COMMENT '0 for male 1 for female',
  `birthdate` date DEFAULT '2014-01-01' COMMENT '出生日期',
  `money_left` decimal(10,2) DEFAULT '0.00',
  `accu_points` int(10) unsigned DEFAULT '0' COMMENT '累积积分',
  `rest_points` mediumint(11) DEFAULT NULL COMMENT '剩余积分',
  `rank` int(10) unsigned DEFAULT '0' COMMENT '会员等级',
  `visit_count` smallint(5) unsigned DEFAULT '0',
  `salt` varchar(10) DEFAULT '0',
  `parent_id` mediumint(9) DEFAULT '0',
  `qq` varchar(20) DEFAULT '0',
  `office_phone` varchar(20) DEFAULT '0',
  `home_phone` varchar(20) DEFAULT '0',
  `mobile_phone` varchar(20) DEFAULT '0',
  `passwd_question` varchar(50) DEFAULT NULL,
  `passwd_answer` varchar(255) DEFAULT NULL,
  `user_icon` varchar(255) DEFAULT 'usericon/user_icon.jpg',
  `active` tinyint(3) DEFAULT '0',
  `activation_key` varchar(32) DEFAULT NULL,
  `ucode` varchar(25) DEFAULT NULL,
  `nickname` varchar(30) DEFAULT NULL COMMENT '妮称',
  `province` tinyint(2) DEFAULT NULL,
  `city` smallint(5) DEFAULT NULL,
  `district` smallint(5) DEFAULT NULL,
  `addr` varchar(100) DEFAULT NULL,
  `bind_email` tinyint(1) DEFAULT '0' COMMENT '0 for yes 1 for no',
  `bind_mobile` tinyint(1) DEFAULT '0' COMMENT '0 for yes 1 for no',
  `forget_code` varchar(16) DEFAULT NULL COMMENT '忘记密码找回码',
  `status` tinyint(1) DEFAULT '0' COMMENT '0 for ok 1 for lock 2 for delete 3 for forget password ',
  `delsign` tinyint(4) DEFAULT '0' COMMENT '0 for ok',
  `height` smallint(6) DEFAULT NULL COMMENT 'cm',
  `weight` smallint(6) DEFAULT NULL,
  `waistline` smallint(6) DEFAULT NULL COMMENT '腰围',
  `chest` smallint(6) DEFAULT NULL COMMENT '胸围',
  `hipline` smallint(6) DEFAULT NULL COMMENT '臀围',
  `legline` smallint(6) DEFAULT NULL COMMENT '腿围',
  `shoesize` tinyint(4) DEFAULT NULL COMMENT '足长',
  `marital_status` tinyint(4) DEFAULT '0' COMMENT '婚否 0 for yes 1 for no',
  `alipay` varchar(128) DEFAULT '0' COMMENT '支付宝帐号',
  `token` varchar(128) DEFAULT '0',
  `token_time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of mem_members
-- ----------------------------

-- ----------------------------
-- Table structure for mem_member_login_address
-- ----------------------------
DROP TABLE IF EXISTS `mem_member_login_address`;
CREATE TABLE `mem_member_login_address` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `mem_id` mediumint(8) unsigned DEFAULT NULL COMMENT '会员ID',
  `min` bigint(16) unsigned DEFAULT NULL COMMENT '起始IP对应的整型',
  `max` bigint(16) unsigned DEFAULT NULL COMMENT '终止IP对应的整型',
  `address` varchar(128) DEFAULT NULL COMMENT '用户常用登录地址（理想情况下精确到市）',
  `addtime` varchar(20) DEFAULT NULL,
  `network` varchar(128) DEFAULT NULL COMMENT '网段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COMMENT='用户常用登录IP地址字典表（轻量级）\r\n理想情况下精确到市\r\n每个用户保存10条记录，且不断更新';

-- ----------------------------
-- Records of mem_member_login_address
-- ----------------------------

-- ----------------------------
-- Table structure for mem_notices
-- ----------------------------
DROP TABLE IF EXISTS `mem_notices`;
CREATE TABLE `mem_notices` (
  `id` bigint(20) NOT NULL,
  `mem_id` bigint(20) DEFAULT NULL,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `content` text,
  `status` tinyint(4) DEFAULT '0' COMMENT '0 for yes 1 for not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='针对会员的站内通知';

-- ----------------------------
-- Records of mem_notices
-- ----------------------------

-- ----------------------------
-- Table structure for pri_groups
-- ----------------------------
DROP TABLE IF EXISTS `pri_groups`;
CREATE TABLE `pri_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `shopid` bigint(20) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pri_groups
-- ----------------------------
INSERT INTO `pri_groups` VALUES ('1', '2015-07-06 09:57:30', '2015-07-08 17:39:11', '0', '0', '0', '超级管理员');

-- ----------------------------
-- Table structure for pri_groups_roles
-- ----------------------------
DROP TABLE IF EXISTS `pri_groups_roles`;
CREATE TABLE `pri_groups_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `roleid` bigint(20) NOT NULL,
  `groupid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of pri_groups_roles
-- ----------------------------
INSERT INTO `pri_groups_roles` VALUES ('1', '2015-07-28 15:43:28', '0', '1', '1');

-- ----------------------------
-- Table structure for pri_pris
-- ----------------------------
DROP TABLE IF EXISTS `pri_pris`;
CREATE TABLE `pri_pris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT '' COMMENT '可以用作菜单的icon',
  `name` varchar(64) DEFAULT NULL COMMENT 'module name controller name action name ',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '0 for top module others for controllers and actions',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for not display 1 for display',
  `src` varchar(64) DEFAULT NULL,
  `sort` tinyint(3) DEFAULT '0' COMMENT '排序',
  `module` varchar(16) DEFAULT NULL COMMENT '模块名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pri_pris
-- ----------------------------
INSERT INTO `pri_pris` VALUES ('1', '2015-06-15 14:53:33', '2015-06-15 14:53:35', '0', '', '管理后台', '0', '0', ' ', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('2', '2015-06-15 14:54:44', '2015-06-15 14:54:46', '0', 'home', '后台首页', '1', '1', 'index/show', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('3', '2015-06-15 14:56:19', '2015-06-15 14:56:20', '0', 'sitemap', '权限管理', '1', '1', 'pris', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('4', '2015-06-15 14:57:32', '2015-06-15 14:57:33', '0', null, '用户', '3', '1', 'users', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('5', '2015-06-15 14:58:32', '2015-06-15 14:58:33', '0', null, '删除用户', '4', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('6', '2015-06-15 15:02:46', '2015-06-15 15:02:48', '0', null, '新增用户', '4', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('7', '2015-06-15 15:04:36', '2015-06-15 15:04:38', '0', null, '编辑用户', '4', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('9', '2015-07-08 10:36:46', '2015-07-08 10:36:50', '0', '', '用户组', '3', '1', 'groups', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('10', '2015-07-09 13:33:10', '2015-07-09 13:33:14', '0', '', '删除用户组', '9', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('11', '2015-07-09 13:39:16', '2015-07-09 13:39:19', '0', '', '新增用户组', '9', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('12', '2015-07-09 13:40:16', '2015-07-09 13:40:18', '0', '', '编辑用户组', '9', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('13', '2015-07-09 13:42:04', '2015-07-09 13:42:06', '0', '', '角色', '3', '1', 'roles', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('14', '2015-07-10 10:02:02', '2015-07-10 10:02:03', '0', '', '删除角色', '13', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('15', '2015-07-10 10:02:30', '2015-07-10 10:02:33', '0', '', '新增角色', '13', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('16', '2015-07-10 10:03:02', '2015-07-10 10:03:04', '0', '', '编辑角色', '13', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('19', '2015-07-13 09:59:36', '2015-07-13 09:59:39', '0', '', '检验用户名', '4', '0', 'checkloginname', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('25', '2015-07-17 09:27:33', '2015-07-17 09:27:35', '0', '', '更新用户', '4', '0', 'update', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('26', '2015-07-17 09:28:39', '2015-07-17 09:28:41', '0', '', '更新用户组', '9', '0', 'update', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('27', '2015-07-17 09:29:09', '2015-07-17 09:29:05', '0', '', '更新角色', '13', '0', 'update', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('37', '2015-07-23 10:06:18', '2015-07-23 10:06:24', '0', 'user', '会员管理', '1', '0', 'membersmanager', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('38', '2015-07-23 10:07:21', '2015-07-23 10:07:25', '0', '', '会员', '37', '0', 'members', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('39', '2015-07-23 10:08:18', '2015-07-23 10:08:21', '0', '', '删除会员', '38', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('47', '2015-07-27 09:47:58', '2015-07-27 09:47:59', '0', 'file', '文章管理', '1', '1', 'articlemanager', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('48', '2015-07-27 09:50:09', '2015-07-27 09:50:07', '0', '', '文章分类', '47', '1', 'articlecats', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('49', '2015-07-27 09:50:15', '2015-07-27 09:50:16', '0', '', '文章', '47', '1', 'articles', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('50', '2015-07-28 10:46:59', '2015-07-28 10:47:02', '0', '', '删除分类', '48', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('51', '2015-07-28 10:48:05', '2015-07-28 10:48:07', '0', '', '新增分类', '48', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('52', '2015-07-28 10:48:37', '2015-07-28 10:48:38', '0', '', '编辑分类', '48', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('53', '2015-07-28 10:49:00', '2015-07-28 10:49:03', '0', '', '删除文章', '49', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('54', '2015-07-28 10:50:16', '2015-07-28 10:50:17', '0', '', '新增文章', '49', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('55', '2015-07-28 10:52:36', '2015-07-28 10:52:38', '0', '', '编辑文章', '49', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('60', '2015-08-11 10:12:28', '2015-08-11 10:12:30', '0', 'picture-o', '图片管理', '1', '1', 'images', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('61', '2015-08-24 14:12:44', '2015-08-24 14:12:51', '0', 'table', '广告管理', '1', '1', 'admanager', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('62', '2015-08-24 14:14:51', '2015-08-24 14:14:56', '0', '', '广告分类', '61', '1', 'adcats', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('63', '2015-08-24 14:16:39', '2015-08-24 14:16:42', '0', '', '广告', '61', '1', 'ad', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('64', '2015-08-27 13:57:21', '2015-08-27 13:57:28', '0', '', '删除分类', '62', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('65', '2015-08-27 13:57:35', '2015-08-27 13:57:40', '0', '', '新增分类', '62', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('66', '2015-08-27 13:57:51', '2015-08-27 13:57:51', '0', '', '编辑分类', '62', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('67', '2015-08-27 13:57:51', '2015-08-27 13:57:51', '0', '', '删除广告', '63', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('68', '2015-08-27 13:57:51', '2015-08-27 13:57:51', '0', '', '新增广告', '63', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('69', '2015-08-27 13:57:51', '2015-08-27 13:57:51', '0', '', '编辑广告', '63', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('76', '2015-08-28 13:53:43', '2015-08-28 13:53:45', '0', 'cog', '系统配置', '1', '1', 'config/index', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('78', '2015-08-31 16:37:03', '2015-08-28 16:37:06', '0', '', '通信配置', '76', '1', 'config/cmm', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('79', '2015-08-31 14:18:58', '2015-08-31 14:19:00', '0', '', 'seo配置', '76', '1', 'config/seo', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('80', '2015-09-02 15:31:14', '2015-09-02 15:31:16', '0', 'wrench', '安全中心', '1', '1', 'securitymanager', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('81', '2015-09-02 15:32:01', '2015-09-02 15:32:03', '0', '', '文件安全', '80', '1', 'security/file', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('82', '2015-09-02 15:33:38', '2015-09-02 15:33:40', '0', '', '全站扫描', '81', '0', 'scanWebSite', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('83', '2015-09-02 15:33:49', '2015-09-02 15:33:51', '0', '', '异常扫描', '81', '0', 'scanAbnormal', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('84', '2015-09-02 15:34:21', '2015-09-02 15:34:24', '0', '', '异常文件', '81', '0', 'abnomalList', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('85', '2015-09-02 15:35:25', '2015-09-02 15:35:27', '0', '', '处理异常', '81', '0', 'handle', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('93', '2015-09-16 16:19:36', '2015-09-16 16:19:39', '0', '', '缓存管理', '1', '1', 'cache', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('94', '2015-09-16 16:25:51', '2015-09-16 16:25:54', '0', '', '添加缓存', '141', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('95', '2015-09-16 16:27:25', '2015-09-16 16:27:28', '0', '', '编辑缓存', '141', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('96', '2015-09-16 16:27:30', '2015-09-16 16:27:33', '0', '', '删除缓存', '141', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('97', '2015-09-18 16:47:33', '2015-09-18 16:47:35', '0', '', '部门', '3', '0', 'departments', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('98', '2015-09-25 16:50:33', '2015-09-18 16:50:36', '0', '', '添加部门', '97', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('99', '2015-09-18 16:51:42', '2015-09-18 16:51:45', '0', '', '编辑部门', '97', '0', 'edit', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('100', '2015-09-18 16:52:38', '2015-09-18 16:52:41', '0', '', '删除部门', '97', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('109', '2015-10-15 17:13:13', '2015-10-15 17:13:17', '0', '', '敏感词管理', '76', '1', 'sensitive', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('110', '2015-10-15 17:14:10', '2015-10-15 17:14:12', '0', '', 'Tags管理', '47', '1', 'articlestags', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('111', '2015-10-15 17:15:02', '2015-10-15 17:15:04', '0', '', '添加敏感词', '76', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('112', '2015-10-15 17:16:13', '2015-10-15 17:16:15', '0', '', '删除敏感词', '76', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('113', '2015-10-15 17:17:06', '2015-10-15 17:17:03', '0', '', '修改敏感词', '76', '0', 'replace', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('114', '2015-10-15 17:18:35', '2015-10-15 17:18:37', '0', '', 'tag更新', '47', '0', 'optionPage', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('115', '2015-10-15 17:19:23', '2015-10-15 17:19:24', '0', '', 'tag删除', '47', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('116', '2015-10-20 16:27:29', '2015-10-20 16:27:31', '0', 'list', '菜单管理', '1', '1', 'menu', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('117', '2015-10-20 16:28:03', '2015-10-20 16:28:05', '0', '', '前台菜单', '116', '1', 'menu/frontend', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('118', '2015-10-20 16:29:38', '2015-10-20 16:29:40', '0', '', '后端菜单', '116', '1', 'menu/backend', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('119', '2015-10-20 16:40:07', '2015-10-20 16:40:09', '0', '', '菜单分类', '116', '0', 'menu/category', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('120', '2015-10-22 13:22:59', '2015-10-22 13:23:18', '0', '', '添加菜单分类', '116', '0', 'menu/addCategory', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('121', '2015-10-22 13:23:02', '2015-10-22 13:23:21', '0', '', '更新菜单分类', '116', '0', 'menu/upcmenus', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('122', '2015-10-22 13:23:05', '2015-10-22 13:23:24', '0', '', '删除菜单分类', '116', '0', 'menu/delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('123', '2015-10-22 13:23:08', '2015-10-22 13:23:27', '0', '', '添加菜单', '116', '0', 'menu/addmenus', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('124', '2015-10-22 13:23:12', '2015-10-22 13:23:29', '0', '', '更新菜单', '116', '0', 'menu/upmenus', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('125', '2015-10-22 13:23:15', '2015-10-22 13:23:32', '0', '', '删除菜单', '116', '0', 'menu/delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('126', '2015-10-22 14:09:44', '2015-10-22 14:09:46', '0', '', '站点管理', '76', '1', 'sitesetting', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('127', '2015-10-22 17:11:43', '2015-10-22 17:11:45', '0', 'cloud', '扩展工具', '1', '1', 'tools', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('128', '2015-10-22 17:16:51', '2015-10-22 17:16:53', '0', '', '友情链接', '127', '1', 'friendlink', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('129', '2015-10-22 17:17:40', '2015-10-22 17:17:42', '0', '', '备份中心', '127', '1', 'backup', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('130', '2015-10-23 09:20:48', '2015-10-23 09:20:51', '0', '', '添加站点', '126', '0', 'addsite', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('131', '2015-10-23 09:21:31', '2015-10-23 09:21:33', '0', '', '修改站点', '126', '0', 'upsiteinfo', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('132', '2015-10-23 09:22:11', '2015-10-23 09:22:13', '0', '', '删除站点', '126', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('133', '2015-10-23 09:22:47', '2015-10-23 09:22:48', '0', '', '添加友链', '128', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('134', '2015-10-23 09:23:27', '2015-10-23 09:23:28', '0', '', '更新友链', '128', '0', 'update', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('135', '2015-10-23 09:23:52', '2015-10-23 09:23:55', '0', '', '删除友链', '128', '0', 'update', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('141', '2015-11-13 16:00:16', '2015-11-13 16:00:18', '0', '', '应用缓存', '93', '1', 'cache', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('142', '2015-11-13 16:01:34', '2015-11-13 16:01:36', '0', '', '页面缓存', '93', '1', 'pagecache', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('143', '2015-11-13 16:02:04', '2015-11-13 16:02:07', '0', '', '添加缓存', '142', '0', 'add', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('144', '2015-11-13 16:03:24', '2015-11-13 16:03:28', '0', '', '更新缓存', '142', '0', 'update', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('145', '2015-11-13 16:03:52', '2015-11-13 16:03:54', '0', '', '删除缓存', '142', '0', 'delete', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('146', '2015-11-13 16:04:17', '2015-11-13 16:04:19', '0', '', '静态化', '93', '1', 'staticcache', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('147', '2015-11-13 16:05:27', '2015-11-13 16:05:29', '0', '', '自动化配置', '146', '0', 'index', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('148', '2015-11-13 16:06:02', '2015-11-13 16:06:03', '0', '', '栏目配置', '146', '0', 'column', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('149', '2015-11-13 16:06:33', '2015-11-13 16:06:34', '0', '', '列表配置', '146', '0', 'list', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('150', '2015-11-13 16:06:53', '2015-11-13 16:06:55', '0', '', '详细页配置', '146', '0', 'detail', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('151', '2015-11-13 16:07:27', '2015-11-13 16:07:28', '0', '', '配置项处理', '148', '0', 'optcolumn', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('152', '2015-11-13 16:09:22', '2015-11-13 16:09:24', '0', '', '配置项删除', '148', '0', 'delcolumn', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('153', '2015-11-13 16:07:27', '2015-11-13 16:07:28', '0', '', '配置项处理', '149', '0', 'optlist', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('154', '2015-11-13 16:09:22', '2015-11-13 16:09:24', '0', '', '配置项删除', '149', '0', 'dellist', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('155', '2015-11-13 16:07:27', '2015-11-13 16:07:28', '0', '', '配置项处理', '150', '0', 'optdetail', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('157', '2015-11-18 15:16:14', '2015-11-18 15:16:15', '0', '', '系统主页配置', '76', '1', 'sysindex', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('158', '2015-11-18 15:16:43', '2015-11-18 15:16:44', '0', '', '系统主页操作', '157', '0', 'opt', '0', 'admin');
INSERT INTO `pri_pris` VALUES ('159', '2015-11-18 15:17:26', '2015-11-18 15:17:28', '0', '', '删除系统主页配置', '157', '0', 'delete', '0', 'admin');

-- ----------------------------
-- Table structure for pri_roles
-- ----------------------------
DROP TABLE IF EXISTS `pri_roles`;
CREATE TABLE `pri_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT '',
  `shopid` bigint(20) DEFAULT NULL COMMENT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pri_roles
-- ----------------------------
INSERT INTO `pri_roles` VALUES ('1', '2015-07-08 12:08:19', '2015-07-17 15:06:46', '0', '所有权限', '0', 'superadmin');

-- ----------------------------
-- Table structure for pri_roles_pris
-- ----------------------------
DROP TABLE IF EXISTS `pri_roles_pris`;
CREATE TABLE `pri_roles_pris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `roleid` bigint(20) NOT NULL,
  `priid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=681 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of pri_roles_pris
-- ----------------------------
INSERT INTO `pri_roles_pris` VALUES ('99', '2015-07-10 15:22:51', '0', '3', '2');
INSERT INTO `pri_roles_pris` VALUES ('100', '2015-07-10 15:22:51', '0', '3', '3');
INSERT INTO `pri_roles_pris` VALUES ('101', '2015-07-10 15:22:51', '0', '3', '4');
INSERT INTO `pri_roles_pris` VALUES ('102', '2015-07-10 15:22:51', '0', '3', '5');
INSERT INTO `pri_roles_pris` VALUES ('103', '2015-07-10 15:22:51', '0', '3', '6');
INSERT INTO `pri_roles_pris` VALUES ('104', '2015-07-10 15:22:51', '0', '3', '7');
INSERT INTO `pri_roles_pris` VALUES ('105', '2015-07-10 15:22:51', '0', '3', '9');
INSERT INTO `pri_roles_pris` VALUES ('106', '2015-07-10 15:22:51', '0', '3', '10');
INSERT INTO `pri_roles_pris` VALUES ('107', '2015-07-10 15:22:51', '0', '3', '11');
INSERT INTO `pri_roles_pris` VALUES ('108', '2015-07-10 15:22:51', '0', '3', '12');
INSERT INTO `pri_roles_pris` VALUES ('109', '2015-07-10 15:22:51', '0', '3', '13');
INSERT INTO `pri_roles_pris` VALUES ('110', '2015-07-10 15:22:51', '0', '3', '14');
INSERT INTO `pri_roles_pris` VALUES ('122', '2015-07-10 16:23:30', '0', '2', '2');
INSERT INTO `pri_roles_pris` VALUES ('123', '2015-07-10 16:23:30', '0', '2', '3');
INSERT INTO `pri_roles_pris` VALUES ('124', '2015-07-10 16:23:30', '0', '2', '4');
INSERT INTO `pri_roles_pris` VALUES ('125', '2015-07-10 16:23:30', '0', '2', '5');
INSERT INTO `pri_roles_pris` VALUES ('126', '2015-07-10 16:23:30', '0', '2', '6');
INSERT INTO `pri_roles_pris` VALUES ('127', '2015-07-10 16:23:30', '0', '2', '7');
INSERT INTO `pri_roles_pris` VALUES ('492', '2015-07-17 15:06:46', '0', '1', '17');
INSERT INTO `pri_roles_pris` VALUES ('493', '2015-07-17 15:06:46', '0', '1', '21');
INSERT INTO `pri_roles_pris` VALUES ('494', '2015-07-17 15:06:46', '0', '1', '23');
INSERT INTO `pri_roles_pris` VALUES ('495', '2015-07-17 15:06:46', '0', '1', '24');
INSERT INTO `pri_roles_pris` VALUES ('496', '2015-07-17 15:06:46', '0', '1', '22');
INSERT INTO `pri_roles_pris` VALUES ('497', '2015-07-17 15:06:46', '0', '1', '18');
INSERT INTO `pri_roles_pris` VALUES ('498', '2015-07-17 15:06:46', '0', '1', '20');
INSERT INTO `pri_roles_pris` VALUES ('499', '2015-07-17 15:06:46', '0', '1', '3');
INSERT INTO `pri_roles_pris` VALUES ('500', '2015-07-17 15:06:46', '0', '1', '4');
INSERT INTO `pri_roles_pris` VALUES ('501', '2015-07-17 15:06:46', '0', '1', '6');
INSERT INTO `pri_roles_pris` VALUES ('502', '2015-07-17 15:06:46', '0', '1', '19');
INSERT INTO `pri_roles_pris` VALUES ('503', '2015-07-17 15:06:46', '0', '1', '5');
INSERT INTO `pri_roles_pris` VALUES ('504', '2015-07-17 15:06:46', '0', '1', '7');
INSERT INTO `pri_roles_pris` VALUES ('505', '2015-07-17 15:06:46', '0', '1', '25');
INSERT INTO `pri_roles_pris` VALUES ('506', '2015-07-17 15:06:46', '0', '1', '28');
INSERT INTO `pri_roles_pris` VALUES ('507', '2015-07-17 15:06:46', '0', '1', '13');
INSERT INTO `pri_roles_pris` VALUES ('508', '2015-07-17 15:06:46', '0', '1', '15');
INSERT INTO `pri_roles_pris` VALUES ('509', '2015-07-17 15:06:46', '0', '1', '14');
INSERT INTO `pri_roles_pris` VALUES ('510', '2015-07-17 15:06:46', '0', '1', '16');
INSERT INTO `pri_roles_pris` VALUES ('511', '2015-07-17 15:06:46', '0', '1', '27');
INSERT INTO `pri_roles_pris` VALUES ('512', '2015-07-17 15:06:46', '0', '1', '9');
INSERT INTO `pri_roles_pris` VALUES ('513', '2015-07-17 15:06:46', '0', '1', '10');
INSERT INTO `pri_roles_pris` VALUES ('514', '2015-07-17 15:06:46', '0', '1', '12');
INSERT INTO `pri_roles_pris` VALUES ('515', '2015-07-17 15:06:46', '0', '1', '11');
INSERT INTO `pri_roles_pris` VALUES ('516', '2015-07-17 15:06:46', '0', '1', '2');
INSERT INTO `pri_roles_pris` VALUES ('636', '2015-07-28 17:06:43', '0', '10', '17');
INSERT INTO `pri_roles_pris` VALUES ('637', '2015-07-28 17:06:43', '0', '10', '21');
INSERT INTO `pri_roles_pris` VALUES ('638', '2015-07-28 17:06:43', '0', '10', '24');
INSERT INTO `pri_roles_pris` VALUES ('639', '2015-07-28 17:06:43', '0', '10', '23');
INSERT INTO `pri_roles_pris` VALUES ('640', '2015-07-28 17:06:43', '0', '10', '22');
INSERT INTO `pri_roles_pris` VALUES ('641', '2015-07-28 17:06:43', '0', '10', '18');
INSERT INTO `pri_roles_pris` VALUES ('642', '2015-07-28 17:06:43', '0', '10', '20');
INSERT INTO `pri_roles_pris` VALUES ('643', '2015-07-28 17:06:43', '0', '10', '47');
INSERT INTO `pri_roles_pris` VALUES ('644', '2015-07-28 17:06:43', '0', '10', '49');
INSERT INTO `pri_roles_pris` VALUES ('645', '2015-07-28 17:06:43', '0', '10', '53');
INSERT INTO `pri_roles_pris` VALUES ('646', '2015-07-28 17:06:43', '0', '10', '54');
INSERT INTO `pri_roles_pris` VALUES ('647', '2015-07-28 17:06:43', '0', '10', '55');
INSERT INTO `pri_roles_pris` VALUES ('648', '2015-07-28 17:06:43', '0', '10', '48');
INSERT INTO `pri_roles_pris` VALUES ('649', '2015-07-28 17:06:43', '0', '10', '50');
INSERT INTO `pri_roles_pris` VALUES ('650', '2015-07-28 17:06:43', '0', '10', '51');
INSERT INTO `pri_roles_pris` VALUES ('651', '2015-07-28 17:06:43', '0', '10', '52');
INSERT INTO `pri_roles_pris` VALUES ('652', '2015-07-28 17:06:43', '0', '10', '56');
INSERT INTO `pri_roles_pris` VALUES ('653', '2015-07-28 17:06:43', '0', '10', '57');
INSERT INTO `pri_roles_pris` VALUES ('654', '2015-07-28 17:06:43', '0', '10', '58');
INSERT INTO `pri_roles_pris` VALUES ('655', '2015-07-28 17:06:43', '0', '10', '29');
INSERT INTO `pri_roles_pris` VALUES ('656', '2015-07-28 17:06:43', '0', '10', '30');
INSERT INTO `pri_roles_pris` VALUES ('657', '2015-07-28 17:06:43', '0', '10', '36');
INSERT INTO `pri_roles_pris` VALUES ('658', '2015-07-28 17:06:43', '0', '10', '34');
INSERT INTO `pri_roles_pris` VALUES ('659', '2015-07-28 17:06:43', '0', '10', '32');
INSERT INTO `pri_roles_pris` VALUES ('660', '2015-07-28 17:06:43', '0', '10', '33');
INSERT INTO `pri_roles_pris` VALUES ('661', '2015-07-28 17:06:43', '0', '10', '31');
INSERT INTO `pri_roles_pris` VALUES ('662', '2015-07-28 17:06:43', '0', '10', '35');
INSERT INTO `pri_roles_pris` VALUES ('663', '2015-07-28 17:06:43', '0', '10', '2');
INSERT INTO `pri_roles_pris` VALUES ('664', '2015-07-28 17:06:43', '0', '10', '3');
INSERT INTO `pri_roles_pris` VALUES ('665', '2015-07-28 17:06:43', '0', '10', '9');
INSERT INTO `pri_roles_pris` VALUES ('666', '2015-07-28 17:06:43', '0', '10', '26');
INSERT INTO `pri_roles_pris` VALUES ('667', '2015-07-28 17:06:43', '0', '10', '12');
INSERT INTO `pri_roles_pris` VALUES ('668', '2015-07-28 17:06:43', '0', '10', '11');
INSERT INTO `pri_roles_pris` VALUES ('669', '2015-07-28 17:06:43', '0', '10', '10');
INSERT INTO `pri_roles_pris` VALUES ('670', '2015-07-28 17:06:43', '0', '10', '4');
INSERT INTO `pri_roles_pris` VALUES ('671', '2015-07-28 17:06:43', '0', '10', '5');
INSERT INTO `pri_roles_pris` VALUES ('672', '2015-07-28 17:06:43', '0', '10', '6');
INSERT INTO `pri_roles_pris` VALUES ('673', '2015-07-28 17:06:43', '0', '10', '19');
INSERT INTO `pri_roles_pris` VALUES ('674', '2015-07-28 17:06:43', '0', '10', '7');
INSERT INTO `pri_roles_pris` VALUES ('675', '2015-07-28 17:06:43', '0', '10', '25');
INSERT INTO `pri_roles_pris` VALUES ('676', '2015-07-28 17:06:43', '0', '10', '13');
INSERT INTO `pri_roles_pris` VALUES ('677', '2015-07-28 17:06:43', '0', '10', '16');
INSERT INTO `pri_roles_pris` VALUES ('678', '2015-07-28 17:06:43', '0', '10', '15');
INSERT INTO `pri_roles_pris` VALUES ('679', '2015-07-28 17:06:43', '0', '10', '27');
INSERT INTO `pri_roles_pris` VALUES ('680', '2015-07-28 17:06:43', '0', '10', '14');

-- ----------------------------
-- Table structure for pri_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `pri_site_setting`;
CREATE TABLE `pri_site_setting` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `name` varchar(128) DEFAULT NULL COMMENT '网站名称',
  `domain` varchar(64) DEFAULT NULL COMMENT '网站域名',
  `logo` varchar(128) DEFAULT NULL COMMENT '网站logo',
  `seokey` varchar(64) DEFAULT NULL COMMENT 'seo关键字',
  `seodescr` varchar(255) DEFAULT NULL COMMENT 'seo描述',
  `copyright` varchar(255) DEFAULT NULL COMMENT '版权',
  `static_code` text COMMENT '统计访问代码',
  `is_main` tinyint(1) unsigned DEFAULT '1' COMMENT '是否是默认 0 是 1否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of pri_site_setting
-- ----------------------------

-- ----------------------------
-- Table structure for pri_users
-- ----------------------------
DROP TABLE IF EXISTS `pri_users`;
CREATE TABLE `pri_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `addtime` datetime DEFAULT NULL,
  `uptime` datetime DEFAULT NULL,
  `delsign` tinyint(1) DEFAULT '0',
  `descr` varchar(256) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `nickname` varchar(128) DEFAULT NULL,
  `loginname` varchar(128) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `pwd` varchar(64) NOT NULL COMMENT 'password',
  `email` varchar(64) NOT NULL,
  `shopid` bigint(20) DEFAULT NULL,
  `groupid` bigint(20) DEFAULT NULL,
  `forget_code` varchar(16) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '0 for ok 1 for lock 2 for delete 3 for forget password',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表格';

-- ----------------------------
-- Records of pri_users
-- ----------------------------

-- ----------------------------
-- Table structure for sec_file
-- ----------------------------
DROP TABLE IF EXISTS `sec_file`;
CREATE TABLE `sec_file` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `filename` varchar(128) DEFAULT NULL COMMENT '异常文件名称',
  `hashname` varchar(180) DEFAULT NULL COMMENT '加密文件名称',
  `filepath` varchar(180) DEFAULT NULL COMMENT '异常文件所处位置',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '处理状态 1处理 0未处理',
  `descr` varchar(256) DEFAULT '0' COMMENT '备注信息',
  `addtime` datetime NOT NULL COMMENT '文件扫描时间',
  `opttime` datetime DEFAULT NULL COMMENT '异常文件处理时间',
  `uptime` datetime DEFAULT NULL COMMENT '手动扫描时 文件异常时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fname` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sec_file
-- ----------------------------

-- ----------------------------
-- Table structure for system_dic
-- ----------------------------
DROP TABLE IF EXISTS `system_dic`;
CREATE TABLE `system_dic` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` mediumtext,
  `valtype` tinyint(4) DEFAULT '0' COMMENT '0 int 1 float 2 string',
  `kind` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of system_dic
-- ----------------------------
INSERT INTO `system_dic` VALUES ('1', '2015-09-01 00:00:00', '2015-09-01 00:00:00', '0', '0', '标题', 'title', '华尔', '0', 'seo');
INSERT INTO `system_dic` VALUES ('2', '2015-09-01 00:00:00', '2015-09-01 00:00:00', '0', '0', '关键字', 'keywords', '商城', '0', 'seo');
INSERT INTO `system_dic` VALUES ('4', '2015-09-02 00:00:00', '2015-09-02 00:00:00', '0', '0', '协议', 'protocol', 'smtp', '0', 'email');
INSERT INTO `system_dic` VALUES ('3', '2015-09-01 00:00:00', '2015-09-01 00:00:00', '0', '0', '描述', 'description', '线上超市', '0', 'seo');
INSERT INTO `system_dic` VALUES ('5', '2015-09-02 00:00:00', '2015-09-02 00:00:00', '0', '0', '字符集', 'charset', 'utf8', '0', 'email');
INSERT INTO `system_dic` VALUES ('6', '2015-09-02 00:00:00', '2015-09-02 00:00:00', '0', '0', 'smtp地址', 'smtp_host', 'smtp.163.com', '0', 'email');
INSERT INTO `system_dic` VALUES ('7', '2015-09-02 00:00:00', '2015-09-02 00:00:00', '0', '0', '邮箱地址', 'smtp_user', 'sina163163126@163.com', '0', 'email');
INSERT INTO `system_dic` VALUES ('8', '2015-09-02 00:00:00', '2015-09-02 00:00:00', '0', '0', '邮箱密码', 'smtp_pass', 'testtest', '0', 'email');
INSERT INTO `system_dic` VALUES ('9', '2015-09-02 00:00:00', '2015-09-02 00:00:00', '0', '0', '发送者姓名', 'user', 'huaer company', '0', 'email');

-- ----------------------------
-- Table structure for sys_index_cfg
-- ----------------------------
DROP TABLE IF EXISTS `sys_index_cfg`;
CREATE TABLE `sys_index_cfg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `name` varchar(32) DEFAULT NULL COMMENT '标题',
  `icon` varchar(64) DEFAULT NULL COMMENT '小图标',
  `color` varchar(32) DEFAULT NULL COMMENT '颜色',
  `line` int(10) unsigned DEFAULT NULL COMMENT '行数',
  `size` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '模块大小',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示  0 显示  1 不显示',
  `groupid` bigint(20) unsigned DEFAULT NULL COMMENT '用户组id',
  `sort` bigint(20) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of sys_index_cfg
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_ad
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_ad`;
CREATE TABLE `xuxu_ad` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `media_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0图片 1视频',
  `name` varchar(60) NOT NULL DEFAULT '',
  `url` varchar(512) NOT NULL DEFAULT '',
  `begin_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `click_count` mediumint(8) unsigned DEFAULT '0',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否展示',
  `cat_id` mediumint(5) NOT NULL,
  `sort_order` smallint(5) NOT NULL DEFAULT '50',
  `title` varchar(128) NOT NULL,
  `uptime` datetime DEFAULT NULL COMMENT 'update time',
  `delsign` tinyint(1) NOT NULL,
  `click_left` mediumint(9) DEFAULT NULL,
  `weight` tinyint(4) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'user_id',
  `descr` varchar(256) DEFAULT NULL COMMENT 'description',
  `addtime` datetime NOT NULL COMMENT 'create time',
  `src` tinytext NOT NULL COMMENT 'img url flash url etc.',
  `shopid` bigint(20) NOT NULL,
  `nofollow` tinyint(1) DEFAULT NULL COMMENT '0 for no follow 1 for yes',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`) USING BTREE,
  KEY `cat_id` (`cat_id`,`sort_order`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xuxu_ad
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_ad_cats
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_ad_cats`;
CREATE TABLE `xuxu_ad_cats` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `pid` mediumint(5) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT NULL,
  `width` mediumint(9) NOT NULL,
  `height` mediumint(9) NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `base_price` float DEFAULT NULL,
  `click_price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告分类表格';

-- ----------------------------
-- Records of xuxu_ad_cats
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_ad_trace
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_ad_trace`;
CREATE TABLE `xuxu_ad_trace` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `ad_id` bigint(20) NOT NULL,
  `referer` tinytext,
  `city` varchar(64) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='广告追踪';

-- ----------------------------
-- Records of xuxu_ad_trace
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_artical_visits
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_artical_visits`;
CREATE TABLE `xuxu_artical_visits` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `artical_id` bigint(20) NOT NULL,
  `addtime` datetime DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `visit_times` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_artical_visits
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_articles
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_articles`;
CREATE TABLE `xuxu_articles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `face` varchar(128) DEFAULT NULL,
  `description` tinytext,
  `cat_id` bigint(20) NOT NULL,
  `content` text,
  `status` tinyint(4) NOT NULL COMMENT '0 for ok 1 for not review 2 for reviewed',
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `top` tinyint(1) DEFAULT '0' COMMENT '0 for not set top 1 for yes',
  `author` varchar(64) DEFAULT NULL,
  `keywords` tinytext,
  `pubtime` datetime DEFAULT NULL COMMENT '文章发布日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_articles
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_articles_tags
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_articles_tags`;
CREATE TABLE `xuxu_articles_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `name` varchar(36) DEFAULT NULL COMMENT 'tag名称',
  `seo` varchar(64) DEFAULT NULL COMMENT 'seo标题',
  `seokey` varchar(128) DEFAULT NULL COMMENT 'seo关键字',
  `seodescr` varchar(255) DEFAULT NULL COMMENT 'seo描述',
  `display` tinyint(1) unsigned DEFAULT '0' COMMENT '是否显示  0 显示  1 不现实 ',
  `pinyin` varchar(64) DEFAULT NULL COMMENT '拼音名字',
  `fname` varchar(64) DEFAULT NULL COMMENT '首字母',
  `linkurl` varchar(128) DEFAULT NULL COMMENT '链接网址',
  `descr` varchar(256) DEFAULT '0',
  `aid` bigint(20) unsigned DEFAULT NULL COMMENT '文章id',
  `sort` int(20) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_articles_tags
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_article_cats
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_article_cats`;
CREATE TABLE `xuxu_article_cats` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(64) DEFAULT NULL COMMENT 'for seo',
  `keywords` varchar(256) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for catagory 1 for single article',
  `description` varchar(512) DEFAULT NULL COMMENT 'description for seo',
  `nofollow` tinyint(1) DEFAULT NULL COMMENT '0 for no follow 1 for yes',
  `img` varchar(512) DEFAULT NULL COMMENT '栏目首图',
  `parent_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_article_cats
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_article_imgs
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_article_imgs`;
CREATE TABLE `xuxu_article_imgs` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `name` varchar(128) NOT NULL COMMENT 'uuid 301a9e765c2192b0b9e66bc48bf69990efdfeng',
  `dir` varchar(512) DEFAULT NULL COMMENT '001/axz/03b',
  `realname` varchar(256) DEFAULT NULL COMMENT 'avatar.jpg',
  `server` char(8) DEFAULT NULL COMMENT 'img001 img002 img003....',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_article_imgs
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_cards
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_cards`;
CREATE TABLE `xuxu_cards` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL DEFAULT '',
  `img` varchar(255) NOT NULL DEFAULT '',
  `fee` decimal(6,2) unsigned NOT NULL DEFAULT '0.00',
  `free_money` decimal(6,2) unsigned NOT NULL DEFAULT '0.00',
  `descr` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of xuxu_cards
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_customers
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_customers`;
CREATE TABLE `xuxu_customers` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `nickname` varchar(128) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `province` tinyint(64) DEFAULT NULL,
  `city` smallint(6) DEFAULT NULL,
  `disctrict` smallint(6) DEFAULT NULL,
  `detail_addr` varchar(256) DEFAULT NULL,
  `qq` varchar(32) DEFAULT NULL,
  `cellphone1` varchar(32) DEFAULT NULL,
  `cellphone2` varchar(32) DEFAULT NULL,
  `phone1` varchar(32) DEFAULT NULL,
  `phone2` varchar(32) DEFAULT NULL,
  `fax1` varchar(32) DEFAULT NULL,
  `fax2` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_customers
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_friendly_links
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_friendly_links`;
CREATE TABLE `xuxu_friendly_links` (
  `id` bigint(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `delsign` tinyint(1) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(64) NOT NULL,
  `nofollow` tinyint(1) NOT NULL COMMENT '0 for no follow 1 for yes',
  `url` varchar(256) NOT NULL,
  `sort` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='友情链接';

-- ----------------------------
-- Records of xuxu_friendly_links
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_menu
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_menu`;
CREATE TABLE `xuxu_menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `cid` bigint(20) unsigned NOT NULL COMMENT '分类id',
  `pid` bigint(20) unsigned DEFAULT '0' COMMENT '父级id   0顶级',
  `name` varchar(64) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(128) DEFAULT NULL COMMENT '链接地址',
  `relid` bigint(20) DEFAULT NULL COMMENT '关联文章分类id',
  `target` tinyint(2) DEFAULT NULL COMMENT '打开方式 0 内  1 外',
  `icon` varchar(128) DEFAULT NULL COMMENT '图标',
  `is_show` tinyint(2) DEFAULT '0' COMMENT '是否显示 0显示  1不显示',
  `sort` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_menu
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_menu_category
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_menu_category`;
CREATE TABLE `xuxu_menu_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `descr` varchar(256) DEFAULT '0',
  `is_main` tinyint(1) unsigned zerofill DEFAULT '1' COMMENT '是否主导航 0是  1否',
  `name` varchar(64) DEFAULT NULL COMMENT '菜单分类名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_menu_category
-- ----------------------------

-- ----------------------------
-- Table structure for xuxu_payment
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_payment`;
CREATE TABLE `xuxu_payment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime DEFAULT '1970-01-01 00:00:00',
  `delsign` tinyint(1) DEFAULT '0',
  `descr` varchar(256) DEFAULT NULL COMMENT '支付描述',
  `name` varchar(128) DEFAULT '' COMMENT '支付名称',
  `config` text COMMENT '支付配置',
  `img` varchar(256) DEFAULT NULL COMMENT '支付图片',
  `style` tinyint(1) DEFAULT '0' COMMENT '支付方式  0 货到付款 1 在线支付',
  `sort` smallint(5) DEFAULT NULL,
  `fee` varchar(10) DEFAULT NULL COMMENT '支付的费率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_payment
-- ----------------------------
INSERT INTO `xuxu_payment` VALUES ('1', '1970-01-01 00:00:00', '1970-01-01 00:00:00', '0', null, '支付宝', null, '/img/home/pyament_img/alipay.jpg', '0', '1', null);
INSERT INTO `xuxu_payment` VALUES ('2', '1970-01-01 00:00:00', '1970-01-01 00:00:00', '0', null, '财付通', null, '/img/home/pyament_img/ban.jpg', '0', '2', null);
INSERT INTO `xuxu_payment` VALUES ('3', '1970-01-01 00:00:00', '1970-01-01 00:00:00', '0', null, '工商银行', null, '/img/home/pyament_img/balance.jpg', '0', '2', null);

-- ----------------------------
-- Table structure for xuxu_sens_wd
-- ----------------------------
DROP TABLE IF EXISTS `xuxu_sens_wd`;
CREATE TABLE `xuxu_sens_wd` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `delsign` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `uptime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `word` varchar(64) DEFAULT NULL COMMENT '敏感词',
  `rword` varchar(32) DEFAULT NULL,
  `uid` int(20) unsigned DEFAULT NULL COMMENT '添加人',
  `descr` varchar(256) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_sens_wd
-- ----------------------------
