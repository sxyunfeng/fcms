/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.236
Source Server Version : 50546
Source Host           : localhost:3306
Source Database       : fcms

Target Server Type    : MYSQL
Target Server Version : 50546
File Encoding         : 65001

Date: 2015-12-03 17:05:26
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of cache_static_manage
-- ----------------------------
INSERT INTO `cache_static_manage` VALUES ('1', '2015-12-03 15:00:34', '2015-12-03 15:00:34', '0', '0', '首页静态化', '60', '1', '1', '/cms/index/index');
INSERT INTO `cache_static_manage` VALUES ('2', '2015-12-03 15:01:02', '2015-12-03 15:01:02', '0', '0', '列表静态化', '60', '1', '2', '/cms/index/list/cid');
INSERT INTO `cache_static_manage` VALUES ('3', '2015-12-03 15:02:12', '2015-12-03 15:10:31', '0', '0', '详情页', '60', '1', '3', '/cms/index/detail/id');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表格';

-- ----------------------------
-- Records of pri_users
-- ----------------------------
-- INSERT INTO `pri_users` VALUES ('1', null, null, '0', null, 'admin', null, 'admin', null, 'e10adc3949ba59abbe56e057f20f883e', 'admin@163.com', null, '1', null, '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_article_cats
-- ----------------------------
INSERT INTO `xuxu_article_cats` VALUES ('1', '2015-11-25 11:04:42', '2015-11-25 11:04:42', '0', null, 'FCMS强势登陆', '0', null, '0', null, null, null, '0');
INSERT INTO `xuxu_article_cats` VALUES ('2', '2015-11-25 13:53:09', '2015-11-25 13:53:09', '0', null, '互联网动态', '0', null, '0', null, null, null, '0');
INSERT INTO `xuxu_article_cats` VALUES ('3', '2015-11-27 13:27:11', '2015-11-27 13:27:11', '0', null, '关于我们', '0', null, '0', null, null, null, '0');
INSERT INTO `xuxu_article_cats` VALUES ('4', '2015-11-27 13:27:17', '2015-11-27 13:27:17', '0', null, '联系我们', '0', null, '0', null, null, null, '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_articles
-- ----------------------------
INSERT INTO `xuxu_articles` VALUES ('1', '2015-11-25 11:23:14', '2015-11-26 13:34:23', '0', null, 'FCMS特点全解析', '/upload/image/article/0/20151125/1448421726121293.png', 'FCMS强势登陆，相信大家都对FCMS性能到底如何，有什么样的特点非常关心。下面就和大家一起聊一聊，FCMS为什么是你独一无二的选择！', '1', '<p><img src=\"http://cms.huaer.dev/public/upload/image/article/0/20151125/1448421726121293.png\" alt=\"1448421726121293.png\" height=\"345\" width=\"690\"/></p><p>FCMS强势登陆，相信大家都对FCMS性能到底如何，有什么样的特点非常关心。下面就和大家一起聊一聊，FCMS为什么是你独一无二的选择！</p><p><br/></p>', '0', null, null, '1', '阿牛', 'FCMS 特点 解析', '2015-11-25 11:23:06');
INSERT INTO `xuxu_articles` VALUES ('2', '2015-11-25 13:55:54', '2015-11-25 14:22:11', '0', null, '马云谈商人责任：钱越多责任越多', '/upload/image/article/0/20151125/1448430890740447.jpg', '商人不是一个唯利是图的群体，我是当老师出身，以前也看不起商人，但是经过十几年的创业，现在我为商人骄傲，商人不仅解决创造财富的问题，也是社会进步的积极推动者和参与者。', '2', '<p>今天上午，省委书记李鸿忠、省长王国生在武汉东湖宾馆会见了<span id=\"usstock_BABA\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/BABA.html\" class=\"keyword f_st\" target=\"_blank\">阿里巴巴</a></span><span id=\"quote_BABA\"></span>集团董事局主席马云，并共同见证了湖北省政府与阿里巴巴集团战略合作协议的签署，双方还签订了智慧光谷、武汉智慧交通、全民阅读等合作内容的子协议。</p><p>阿里的销售已超<span id=\"usstock_WMT\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/WMT.html\" class=\"keyword f_st\" target=\"_blank\">沃尔玛</a></span><span id=\"quote_WMT\"></span>成为全世界最大的销售平台？</p><p>武汉是阿里内部重中之重的地方？</p><p>阿里不想成为一个帝国？</p><p>今天的双十一是十年后的常态？</p><p>建商场实际是建仓库？</p><p>马云透露了哪些讯息？又有怎样的金句？会与湖北如何合作？</p><p>小编独家获取会谈录音，为您打探到马云说了这些：</p><p><strong>马云谈首富：钱越多、责任越多、首富责任最多</strong></p><p>商人不是一个唯利是图的群体，我是当老师出身，以前也看不起商人，但是经过十几年的创业，现在我为商人骄傲，商人不仅解决创造财富的问题，也是\n社会进步的积极推动者和参与者。商人也好，企业家也好，是经济发展的科学家，是稀缺资源。大众创业、万众创新口号提得很好，但是需要做大量的工作。阿里是\n最早做互联网+商业+金融，但是每次都会有冲突，都是一种社会摩擦进步。阿里理想主义色彩是超越其他，我们做任何事情不是因为有钱赚，而是因为社会经济进\n步，而我们同时也挣了不少钱。钱越多，责任越多，首富是负责任最多。16年来，我们发展到今天的规模，18个人里有不少是老师出身，我们希望以知识分子的\n理想主义色彩加上商人的脚踏实地结合起来。我们高度想参与到未来大众创业、万众创新，现在大家都起来了，如何让大家活下去，让大家活好，让大家生存下去，\n这是我们未来要做的。</p><p><strong>马云谈湖北：这是最有意义的一站</strong></p><p>我11月份也特别忙，在忙双十一的光棍节。这是最后一站，今天晚上可以回到家了。最后一站也是最有意义的一站。大家都对湖北有很大期待，也对阿里巴巴在这里取得的初步成绩感到很感恩。湖北刚刚开了楚商大会，由于事务繁忙不能到会，但我也很关注楚商的观点和想法。</p><p>湖北有深厚的文化，一个小时的博物馆参观，让我很震撼。我自己对中国的儒释道也很感兴趣。我对阿里成立时，西方看起来我们有点像西方，中国人看我们又像东方，我们定位是东方的智慧、西方的运作、全世界的大市场。</p><p>湖北武汉有强大的文化，有优秀的人才，130万在校大学生，大家都在讲未来制造业的发展，我们认为是落后的制造业不行，落后的产能过剩，而不是\n先进的产能过剩，如果大家还在讲制造业还在靠人工成本的话，这个制造业是不会有希望的，以后比的是不是一个地区劳动力成本多低，而是人才素质有多高。以后\n考察一个地方是看老百姓消费能力有多高。我看曾侯乙墓，我看以前曾国的消费能力很强。武汉的战略地位，区域位置，我们在这里考虑很多，武汉一直在我们公司\n内部作为重中之重的地方。</p><p><strong>马云谈武汉：不提供枪炮，如何留下130万大学生</strong></p><p>最近我们在湖北光谷的想法，智慧光谷的想法，我们想利用130万在校大学生，把我们的数据和我们数据处理能力，为年轻人所用，使得他们创造出无数想法。中国的新消费诞生了新需求，都是年轻人用自己的创意引领、发现、创造需求。</p><p>武汉的农业现代化和农业电商有很大机遇，我们接下来想鼎力合作。湖北的农产品要起来，要面对全国市场，我们是有些想法的。大数据、云计算，不仅\n是光谷，我们也希望这里能够诞生杭州的云溪小镇，我觉得武汉130万大学生，怎样把这些大学生留在本地创业，如果不提供最优秀的枪炮，他怎么去打仗。</p><p><strong>马云谈阿里：我们不想成为一个帝国</strong></p><p>阿里16年创业，我们瞄准中小企业和年轻人，用互联网技术帮助中小企业家和年轻人，帮助他们创新创造。我们自己觉得引以为豪的，我们一直没有改\n变我们的使命，互联网让天下没有难做的生意。阿里从18人变成五个产业群，电子商务，金融服务，现代智慧物流，云计算和大数据，跨境贸易。这五个发展方\n面，好像阿里到处都在，其实我们紧紧围绕我们的使命，让天下没有难做的生意。我们就是围绕这五个主要环节去做的。我们不想成为一个帝国，我们建立商业生\n态，共同发展，大家参与大家共享大家创造价值大家分享价值。我们的客户、使命、价值体系不会变。</p><p><strong>马云谈电商：今天的双十一是十年后的常态</strong></p><p>这几年我们的电子商务发展还算比较快，今年阿里的销售会超过沃尔玛成为全世界最大的销售平台。我们不希望变成一家很会卖东西的公司，沃尔玛的了\n不起是在工业后期以it为基础，标准化、规模化、低成本，形成流水线、集装箱，对世界的影响很大，他们对经济社会的进步是有巨大作用。但是我们的定位是以\n消费者为中心，大规模、柔性化定制，今后比的不是标准化而是个性化，以后比的不是价格而是价值。这个世纪应该是以平台和生态系统为思想。对阿里来讲，我们\n最兴奋不是我们卖了多少货、挣了多少钱，当然我们也交了不少税收，但是我们最骄傲的是去年创造了1600万人直接和间接就业。我们电商的链条里创造的就业\n超过大家想象，解决的问题也超过大家想象。这是一场完全技术驱动的，不能简单看成卖货，这是第一次中国在模式创新后的技术创新，我们必须完成1秒钟\n8900笔的交易，这不是随便就能完成。双十一是整个中国商业基础的大裂变，对供应链、支付的考核，我们今年的设计水平做到12万笔交易，VISA的设计\n能力只有1.4万笔，我们的高峰值达到8.9万笔。这是背后强大的计算、数据、服务能力的体现。我们认为今天的双十一是十年以后的常态，只有今天积累出来\n的技术才能支撑明天。从零售方式改变生活方式，未来五年是改变生产制造方式，以企业为中心变成以消费者为中心。</p><p><ins style=\"display: block; overflow: hidden; text-decoration: none;\" data-ad-offset-top=\"0\" data-ad-offset-left=\"0\" data-ad-status=\"done\" id=\"SinaAdsArtical\" class=\"sinaads sinaads-done\" data-ad-pdps=\"PDPS000000056054\"></ins><strong>马云谈零售业：不可能被消灭</strong></p><p>在人口最密集的市中心，建商场实际上是建仓库，所以对很多将来都市商业区的建设一定要高度重视，大家要开始重新构思新都市商业圈，我认为零售不\n可能被消灭，但是零售必须网上网下相结合。互联网企业和传统企业如何结合，我认为这条路必须打通，我们不是为了消灭传统经济，而是为了提升传统经济。未来\n30年不是互联网公司的天下，是用好互联网技术公司的天下。我们在全球布局，在中国也确立了八个主要核心战略区域，而武汉是我们很重要的区域之一。但是要\n跟当地政府达成高度一致。城市的变迁是跟交通物流的变迁有关系。未来都市的衰落，是跟你能不能集聚货物和人有关系，将来要把货物和人的运输作为城市很重要\n的战略点来思考。今后都市的变革，市中心的商场已经不会在市中心建大楼，而是在郊外建仓储直接物流发货。</p><p><br/></p>', '0', null, null, '1', '湖北之声整理', '商人 责任', '2015-11-25 01:55:38');
INSERT INTO `xuxu_articles` VALUES ('3', '2015-11-25 14:05:28', '2015-11-25 14:18:56', '0', null, '春运首日火车票明天发售 多个抢票软件已失效', '/upload/image/article/0/20151125/1448431479941922.png', '由于12306网站启用了图形验证码，旅客们的部分抢票软件也无法再用，如何选择购票工具也值得留意。', '2', '<p style=\"text-align:center\"><img src=\"/upload/image/article/0/20151125/1448431836100836.jpg\" title=\"1448431836100836.jpg\" alt=\"4.jpg\" height=\"276\" width=\"613\"/></p><p>明天是春运火车票首战日。根据2015年春运网络购票新规实施来看，广州开往川湘等部分热点线路的火车票一直十分抢手。有 \n观点称出现上述情况或因放票过早，有旅客在不能确定回家时间之下，只好抢票“囤”起来。正因如此，今年6月起，铁道部针对退改签又推出了“新政”，改签过\n \n一次后，又在开车前15天前退票，将收取5%的手续费。此外，由于12306网站启用了图形验证码，旅客们的部分抢票软件也无法再用，如何选择购票工具也\n值得留意。<br/></p><p><strong>部分热点路线开通高铁</strong></p><p>2014年12月7日，网上刚开售2015年春运首日车票仅3分钟，从广州 \n南开往湖南长沙的58趟高铁中，就仅有两趟高铁剩下少量车票。随后，广州开往湖南、四川、湖北、安徽等热点城市的火车票均被秒杀。这样的情况2016年春\n \n运是否会重演？但由于今年开通了两条新高铁线路：广州南—成都东及合富高铁，部分热点城市车票或有所缓解。比如从历年来看，广州开往川渝多个城市的列车都\n 极为抢手，如广州到宜宾及达州等方向的车票不仅分分钟被抢光，更甚少会被退票。</p><p>目前广州开通到成都的高铁后，出行川渝就有了更多选择。目前广州南开往成都东的高铁每天有两趟，均为早上6时多出发，历经十三四个小时到达成都东。此外，今年广州南还开通了到安徽合肥的高铁。</p><p><strong>错开放票时间+“捡漏”</strong></p><p>昨日，南都记者从广铁集团获悉，今天将公布广州火车站、东站及南站网络放票时间。去年铁道部公布的各站放票时间为，广州火车站为上午11时放票，广州东站为\n \n11时30分，广州南站为下午1时。正因为三个火车站有售票时间差，所以旅客可做多个抢票准备。比如广州开往长沙的火车票，目前有普速和高铁票两种。如果\n 广州火车站始发的火车票没法抢到，这时便可转战抢广州南站车票。</p><p>值得注意的是，不少网友根据去年春运购票经历，总结出捡漏经验。具 \n体到“捡漏”的时间。2015年春运时，铁路部门表示会将车票放在库内保留一段时间后再进入售票系统，进行二轮回笼发售，而每天中午的12点和晚上的11\n 点是这些退票最集中出现的时刻，所以很多人表示在每天晚上11点的时候如果有空可以查询余票，到第二天早上7点再开始抢票。</p><p>根据往 \n年经验，对于一些热门的线路铁路部门会考虑加开临客，旅客也可以随时关注相关信息进行抢票，也有网站提供的捡漏技巧称，建议亲朋好友齐齐上阵，可以提前把\n 您的12306账号交给家人或者朋友，找一个网络环境比较好的朋友相助，这样抢到的可能性会更大一点。此外，2015年春运，也有旅客花10 \n0到150 块钱找网络代购来买票，用购票人的12306账号来买票，票到付款，当然，这种购票方式稍有风险，就是要避免泄露个人信息。</p><p><strong>购票软件大PK</strong></p><p><strong>官方购票APP更直接 第三方网站可代购</strong></p><p>今年3月，铁道部放出“大招”，12306网站及APP购票启用图形验证码。昨日，南都记者登录高铁管家等部分抢票软件时发现登录时受阻。因为以前软件直接可以登录，而现在则需要用户自己输入验证码，无疑令抢票软件失去了过往抢票功效。</p><p>早前，便曾有业内人士称该图形验证码技术或被破解，但目前来看，南都记者尝试使用360抢票王、“12306抢票专家”、智行、铁友等抢票软件均需人工填写验证码。当然，目前旅客还可选择第三方购票软件的代购服务。</p><p>昨 日，南都记者使用<span id=\"usstock_CTRP\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/CTRP.html\" class=\"keyword f_st\" target=\"_blank\">携程</a></span><span id=\"quote_CTRP\"></span>及<span id=\"usstock_QUNR\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/QUNR.html\" class=\"keyword f_st\" target=\"_blank\">去哪儿</a></span><span id=\"quote_QUNR\"></span>手\n机APP进行车票预订时，看到该两家均有代购服务。但值得注意的是，虽然代购服务不需要旅客填写图形验证码，且有后台帮助 \n旅客买票，但在车票紧张时，经常会有无法代购成功的情况出现。因此，不如直接在12306网站或手机APP购买车票。相比两个官方购票工具，12306手\n 机APP更加便捷。</p><p><strong>火车购票新政须知</strong></p><p>1、验身份需要去火车站</p><p>12306网站首次购票需要先核验身份证。目前广州火车站、东站及南站的人工窗口均可办理此业务。火车票代售点已不能办理。</p><p>2 、改签后15天退票不再免费</p><p>调整完善车票改签措施，对开车前48小时~15天内，改签或变更到站至距开车15天以上其他列车车票，又在距开车15天前退票的，核收5%退票费。这意味着，如旅客改签过一次后，又想在开车前15天内把车票退掉，按照新政，就要收取5%的退票费。</p><p>3、“变更到站”只能办理一次</p><p>自 6月10日起，在原车票开车前48小时以上，旅客可任意选择有余票的列车。已取得纸质车票的，可在车站指定售票窗口办理；未换取纸质车票的，也可在\n \n12306网站办理。办理“变更到站”不收取手续费。“变更到站”只能办理一次。已经办理“变更到站”的车票，不再办理改签。对已改签车票、团体票及通票\n 暂不提供此项服务。办理“变更到站”时，新车票票价“多退少补”，对差额部分核收退票费并执行现行退票费标准。</p><p>4 、12306网站可购买人身意外保险</p><p>11月1日起，12306网站提供铁路旅客人身意外伤害保险服务，旅客在网站购票时可自愿购买。详情见《铁路旅客人身意外伤害保险条款(A)款》和《铁路旅客人身意外伤害保险(指定行程)投保须知》。</p><p>5、广州市区火车票可快递</p><p>广 \n州市车票快递区域暂定为越秀、天河、白云、黄埔、海珠、荔湾等6个区。旅客可于列车开行36小时前，在www.12306.cn购票成功后，自愿选择车票\n \n快递服务，并指定收件日期和时段，送件时间最快次日上午可以送达。快递费定价为17元/件，每件不超过5张车票(含5张车票)，超出数量为1-5张时，按\n 2件收费。需要注意的是，纸质车票送达前，旅客不能办理退票、改签及换取纸质车票。</p><p><br/></p>', '0', null, null, '1', '南方都市报', '春运', '2015-11-25 02:05:14');
INSERT INTO `xuxu_articles` VALUES ('4', '2015-11-25 14:15:43', '2015-11-26 13:33:41', '0', null, '互联网企业签署社会责任宣言 作出十大承诺', '/upload/image/article/0/20151125/1448432084408672.jpg', '中国互联网协会组织召开2015(第二届)中国互联网企业社会责任论坛，与会互联网企业就积极履行社会责任作出十项郑重承诺。', '2', '<p>新华网北京11月24日电 今天，中国互联网协会在京举办2015(第二届)中国互联网企业社会责任论坛。来自中央网络安全和信息化领导小组办公室、工业和信息化部的有关领导以及互联网企业代表出席论坛。新华网、光明网、中国新闻网、<span id=\"usstock_BABA\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/BABA.html\" class=\"keyword f_st\" target=\"_blank\">阿里巴巴</a></span><span id=\"quote_BABA\"></span>、<span id=\"hkstock_hk00700\"><a href=\"http://stock.finance.sina.com.cn/hkstock/quotes/00700.html\" class=\"keyword f_st\" target=\"_blank\">腾讯</a></span><span id=\"quote_hk00700\"></span>、<span id=\"usstock_BIDU\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/BIDU.html\" class=\"keyword f_st\" target=\"_blank\">百度</a></span><span id=\"quote_BIDU\"></span>、<span id=\"usstock_JD\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/JD.html\" class=\"keyword f_st\" target=\"_blank\">京东</a></span><span id=\"quote_JD\"></span>、<span id=\"usstock_QIHU\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/QIHU.html\" class=\"keyword f_st\" target=\"_blank\">奇虎360</a></span><span id=\"quote_QIHU\"></span>、<span id=\"usstock_SINA\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/SINA.html\" class=\"keyword f_st\" target=\"_blank\">新浪</a></span><span id=\"quote_SINA\"></span>网、<span id=\"usstock_SOHU\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/SOHU.html\" class=\"keyword f_st\" target=\"_blank\">搜狐</a></span><span id=\"quote_SOHU\"></span>网、<span id=\"usstock_NTES\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/NTES.html\" class=\"keyword f_st\" target=\"_blank\">网易</a></span><span id=\"quote_NTES\"></span>、<span id=\"usstock_FENG\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/FENG.html\" class=\"keyword f_st\" target=\"_blank\">凤凰网</a></span><span id=\"quote_FENG\"></span>、乐视网、滴滴出行、安存科技等互联网企业共同签署《互联网企业社会责任宣言》。</p><p><strong>宣言全文如下：</strong></p><p>经过20余年发展，中国已成为互联网大国，拥有全球最大的用户规模，拥有全球最大的的电子信息产品生产基地和全球最具成长性的信息消费市场。其间，中国互联网企业不断发展壮大，日益重视社会责任，促进了中国的经济发展和社会进步，并在越来越多的领域发挥着重要作用。</p><p><ins style=\"display: block; overflow: hidden; text-decoration: none;\" data-ad-offset-top=\"0\" data-ad-offset-left=\"0\" data-ad-status=\"done\" id=\"SinaAdsArtical\" class=\"sinaads sinaads-done\" data-ad-pdps=\"PDPS000000056054\"></ins>为进一步推动互联网企业社会责任建设，营造良好的互联网产业环境，构建健康网络生态，树立互联网企业负责任的社会形象，促进中国互联网产业可持续发展，\n中国互联网协会组织召开2015(第二届)中国互联网企业社会责任论坛，与会互联网企业就积极履行社会责任作出以下郑重承诺：</p><p>一、树立底线意识，积极传播正能量，大力弘扬社会主义核心价值观。</p><p>二、积极参与网络生态治理，努力构建清朗网络空间。</p><p>三、自觉维护国家网络和信息安全，履行信息网络安全管理义务。</p><p>四、加强自主创新，保护知识产权，提升企业核心竞争力。</p><p>五、诚信守法经营，公平有序竞争，自觉维护良好市场秩序。</p><p>六、提供便捷多样的网络产品和服务，尊重用户隐私，保护用户合法权益。</p><p>七、保证财务信息真实、完整、及时，保障投资人的合法权益。</p><p>八、营造特色企业文化，重视员工个人发展，关爱员工职业健康。</p><p>九、积极参与社会公益事业，缩小数字鸿沟，促进社会和谐。</p><p>十、积极参与国际交流与合作，提升中国在互联网全球治理中的话语权和影响力。</p><p><br/></p>', '0', null, null, '1', '新华网', '互联网 企业 责任 社会', '2015-11-25 02:15:36');
INSERT INTO `xuxu_articles` VALUES ('5', '2015-11-25 14:28:55', '2015-11-25 15:09:04', '0', null, '农村金融难啃：互联网企业能走通？', '/upload/image/article/0/20151125/1448432860606188.png', '农村过于分散，覆盖难，至今没有一个企业能在农村互联网金融领域取得成功，而互联网企业采用的加盟商模式以及线下渠道难以管控风险。', '2', '<p>河北省保定市曲阳县某村，农民老张正为家里盖新房的一笔钱发愁，借钱难，贷款更难，他跑遍了镇上的银行和农村信用社，但都要求颇多，单“需要抵押”这条就难住了他。遇到这样难题的不止老张一个，农村里许多有贷款需求的人都难通过银行这种正常渠道去贷款，有些人甚至铤而走险借高利贷。</p><p>实际上有一些P2P企业和互联网公司早就尝试做农村互联网金融，尤其针对贷款业务推出了不少产品，诸如宜信在农村有宜农贷、农商贷、农机融资租赁、普惠1号小额信贷等产品；翼龙贷自成立初就投入农村市场。这两年，<span id=\"usstock_JD\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/JD.html\" class=\"keyword f_st\" target=\"_blank\">京东</a></span><span id=\"quote_JD\"></span>和阿里也进入农村市场，京东京农贷推出农资信贷领域的“先锋京农贷”和农产品信贷领域的“仁寿京农贷”；蚂蚁金服旗下网商银行有小额贷款产品旺农贷。</p><p>然而，农户并不知道互联网金融能实现无抵押借款，该村大约500户，新浪科技抽样问及23家农户是否知道互联网借贷，90%答案是否定的。</p><p>虽然每年国家都有支持三农的政策出台，但农村互联网金融并不是香饽饽，而是一块难啃的骨头。农村过于分散，覆盖难，至今没有一个企业能在农村互联网金融领域取得成功，而互联网企业采用的加盟商模式以及线下渠道难以管控风险。</p><p>据央行统计，截至2014年底全国涉农贷款余额23.6万亿元，占贷款总比重的28.1%，同比增长13%，其中农户贷款余额5.4万亿元，同比增长19%。农村贷款方面还有很大的提升空间，然而，钱贷出去容易，收回来呢？</p><p><strong>难考量农户偿债能力</strong></p><p>农村地域辽阔，农民居住较为分散，中国很多地区的农村处在山区或者半山区，农民收入不稳定，无财产性收入，抵押品、担保缺乏，单笔贷款金额小，且能承受的利率有限。</p><p>如果是种植业、畜牧业的农村地区，农民的收入极易受到天气等因素的影响，农村地区的偿债能力具有很大的不确定性。</p><p>农村地区很早就盛行民间借贷，但危险系数较高。生活在农村的小琴（化名）向新浪科技透露，“农村有很多贷款渠道，但很多时候都是借款人不了了\n之，导致很多人血本无归。还有一种特殊现象是，农户在村里的小商铺买东西喜欢赊账，大多数会等到年底才会还。所以，在农村钱放出容易，收回来并不容易。”</p><p>　　为了解决信用风险防控问题，几乎所有互联网企业都选择与第三方合作的方式。翼龙贷采用加盟商的模式；宜信的宜农贷是通过与MFI（小额信贷机\n构）合作，并由MFI来把控风险；网商银行是通过农村淘宝（村淘），并与中和农信合作共同把控风险；京东京农贷是交给合作方控制风险。</p><p>虽然都有各自的风控方案，但都依托于“第三方”，不论是加盟模式还是通过农村线下渠道，都难以做到万无一失，甚至会出现逾期和坏账。</p><p><strong>加盟商模式难控风险</strong></p><p><img src=\"http://n.sinaimg.cn/tech/transform/20151125/xmG9-fxkwvap1676913.jpg\" alt=\"翼龙贷\" data-link=\"\"/><span class=\"img_descr\"></span></p><p>P2P公司翼龙贷早在2009年就开始走农村路线，翼龙贷用加盟商的模式给农户提供贷款，强调在农村熟人的作用，以及加盟商的本地属性。翼龙贷\n董事长王思聪在接受新浪科技采访时指出，“金融本身就具有地域属性、社交属性，在农村仅靠大数据难实现风控，需要线上和线下的结合。”</p><p>据翼龙贷介绍，其95%的借款用户都是“三农”用户，截止目前翼龙贷在中国大陆已经覆盖了除青海、西藏、新疆、海南之外的全部省市区，加盟运营商网络延伸到300多个地级市、1800多个县区、1万多个乡镇，部分网点已经到村级。</p><p>加盟商加入翼龙贷，需要一些严苛的手续。如果加盟商是本地人，要向翼龙贷提供身份证、户口本、结婚证等文件以及无犯罪记录证明。如果是外地人在本地做业务，则要提供居住五年以上的证明。</p><p>加盟商开展业务之前，需要把自己的房产证抵押给翼龙贷，并且向总部交保证金，加盟商负责县级业务的要交50万保证金，各地不同，北京、上海等地区更高。</p><p>即使这样，翼龙贷的加盟商模式仍存在风险，王思聪也承认，翼龙贷有两次差点“死掉”：一次是2011年盟商出现问题，扔下业务不干了；一次是2014年初，依然是盟商出现问题，盟商道德败坏，骗贷款。</p><p>前几年，翼龙贷的加盟商多是来自民间高利贷放贷者，河北山东加盟商联合黑户骗贷的事情一度闹得沸沸扬扬，造成大量逾期和坏账。翼龙贷也表示要严查，赶走了几个加盟商，并且自己全都垫了，这样才逃过“一死”，骗贷事件可以看出翼龙贷在前期对加盟商的管理存在漏洞。</p><p>为了解决盟商出现的问题，翼龙贷选择让大企业背书。2014年11月联想战略投资翼龙贷之后，原联想战略投资部高级总监毛向前担任翼龙贷总裁。\n王思聪告诉新浪科技，“联想进来后，我们的加盟模式有了改观，因为联想最懂盟商管理，他们有30年的管理经验，毛向前担任总裁后对我们盟商进行了系统化管\n理。”</p><p>在王思聪看来，大企业有做农村互联网金融的实力，但即使是阿里也要走弯路。</p><p><strong>线下站点服务面临考验</strong></p><p>农村互联网普及率低，且年纪大的人群不会使用互联网。虽然阿里称要通过手机、互联网等突破空间、时间限制，但在先期，只能依赖于线下渠道。</p><p>目前，网商银行和京东都通过建农村站点来帮助农村互联网化，网商银行依托<span id=\"usstock_BABA\"><a href=\"http://stock.finance.sina.com.cn/usstock/quotes/BABA.html\" class=\"keyword f_st\" target=\"_blank\">阿里巴巴</a></span><span id=\"quote_BABA\"></span>的农村淘宝合伙人，京东有京东县级服务站和京东帮服务站。</p><p><img src=\"http://n.sinaimg.cn/tech/transform/20151125/qv0D-fxkwvcp2984066.jpg\" alt=\"农村淘宝\" data-link=\"\"/><span class=\"img_descr\"></span></p><p>今年11月，网商银行推出针对农村的小额贷款产品旺农贷，通过农村淘宝合伙人帮助农户上网就可以完成借款，互联网覆盖消费品的下行以及当地的上行，但村淘合伙人是整个流程的核心一环。</p><p>农村淘宝计划三年内投资100亿元，在1000个县域建立10万个农村淘宝村级服务点，截至“双11”，已对接全国8000多个村淘点，其中大约有10%覆盖了旺农贷。</p><p>在河北省邢台市清河县柳林村，47岁的农民马玉明已经通过旺农贷的借款买到了拖拉机。11月初，在他想添一台拖拉机时资金周转不开，经村里农村淘宝合伙人杨德超介绍，他带着身份证和户口本到村淘点，由杨德超帮助他录入信息，以个人信用申请了贷款。</p><p>马玉明告诉新浪科技，“旺农贷无需抵押物也无需担保，通过审核后，仅一周左右8万元贷款就到账了，接着让杨德超帮在淘宝网上采购了一台拖拉机，不到一周就从我们村附近的农机专卖店开回来了，这是从没想到过的事儿。”</p><p>推荐人看似解决了农民不会上网难题，实际上是押宝“推荐人”。也有人质疑这种“推荐人”的专业性，认为他们不是银行正式员工，缺少专业知识或存在道德风险。</p><p>对此，网商银行农村金融业务负责人陈嘉轶对新浪科技表示，村淘合伙人只是负责推荐，审批过程完全由网商银行负责。此外，网商银行会随时关注各村\n淘站点客户违约情况。如发现除正常逾期以外的集中道德风险产生的不良记录，不仅会收回这一站点的旺农贷发放资格，取消合伙人资格，必要时也会联合当地政府\n采取法律手段。</p><p>与阿里巴巴类似，京东也进行渠道下沉，设置线下站点，并号称提供电商、物流、金融等全链条服务。截至目前京东已拥有近700家县级服务中心和1200多家京东帮服务店，已招募近10万名乡村推广员，覆盖10万个重点行政村，还成立了专门的农村金融业务部门队。</p><p><img src=\"http://n.sinaimg.cn/tech/transform/20151125/WqAp-fxkwuzu0663072.jpg\" alt=\"京东帮服务店\" data-link=\"\"/></p><p><span class=\"img_descr\"></span>京东CEO刘强东曾在今年年初指出，“到农村就没有什么规律可循，可能几天才有一件货。我们是通过发展‘村民代理’的模式来解决难题，希望在每\n个村找一到两名长期在家的村民，做我们的代理人员，负责帮我们送件、收钱，解决农村信用卡和在线支付等很多问题，同时负责售后服务。他也是我们在当地农村\n的信贷人员，让‘京东白条’这样的分期付款业务能够让农民用上。2015年，我们计划发展数万名的村民代理，覆盖中国数万个村庄。”</p><p>与此同时，今年9月，京东推出农村信贷品牌“京农贷”。在控制风险方面，京东金融选择和涉农机构合作，基于合作伙伴、电商平台等沉淀的大数据信息，了解农民的信用水平，并给予相应的授信额度。</p><p>在农村市场，与网商银行相比，京东金融更多是交给合作方。京东金融方面表示，“做农村市场还是希望和第三方合作，达到多方共赢。”</p><p>值得注意的是，京东金融与阿里系网商银行的农村互联网金融布局，都与其各自的电商体系捆绑，摆脱不了电商+互联网金融的循环生态。此外，农村地区运营模式涉及线下实体站以及第三方，尤其京东，铺设人力比较大，如何建立有效的服务及风控体系面临考验。</p><p><strong>做好农村互联网金融仍需时间</strong></p><p>同样是河北省，保定曲阳县的老张没有邢台清河县的马玉明幸运，这是因为互联网金融难以在短期内覆盖广袤的农村市场，宜信的“宜农贷”自2009年推出以来也只覆盖了几十个农村。</p><p>宜信翼龙贷6年之久仍在摸索，农村互联网金融的复杂性可见一斑。王思聪坦言，农村金融跟城市金融完全不同，翼龙贷也只是万里长征走了三分之二，他说，“三农金融的难度在于文化、地理、民风等方面的差异千变万化，一个镇和一个镇民风都不一样，南方和北方不一样。”</p><p>有不愿透露姓名的农村互联网金融先行者告诉新浪科技，“农村互联网金融是一块被人遗忘的角落，是一个庞大的市场，但是也比较分散。现在这个市场\n严重供应不足，进来的企业只是微乎其微，拓展农村互联网金融需要大量资金，而很多投资人并不看好这块。企业能进来就是好事，但真需要花时间花精力去做，并\n且也不是单单几家互联网公司就能做好的。”</p><p><br/></p>', '0', null, null, '1', '新浪科技 王上', '农村 互联网', '2015-11-25 03:08:20');
INSERT INTO `xuxu_articles` VALUES ('15', '2015-11-25 15:18:11', '2015-11-25 15:18:45', '0', null, '面对最严监管的229号文件，互联网电视能做什么？', '/upload/image/article/0/20151125/1448435850134521.jpg', '今年9月广电总局联合公安部等四部门发布了229号文件，这份文件被业内称作为“史上最严的非法互联网电视终端查处文件”。229号文件由多部委联合出台，这文件的发布意味着对互联网电视行', '2', '<p>今年9月广电总局联合公安部等四部门发布了229号文件，这份文件被业内称作为“史上最严的非法互联网电视终端查处文件”。229号文件由多部委联合出台，这文件的发布意味着对互联网电视行业的监管不再是一纸空文，而是联合执法。</p><p>毫无疑问，广电对互联网电视的监管正在加强。过去无视法律法规的互联网电视野蛮生长，很快占据了市场份额。伴随着相关法规走向明朗，今年上半年就曾出现互联网电视品牌之间举起“违规”大棒进行对杀的戏码，未来行业格局逆转的现象只会越来越多。</p><p>万变不离其宗。不管相关规定合理与否，挑战监管无益自身发展，市场参与者遵循法律法规，顺应游戏规则才是增强竞争力的应对之策。</p><p><strong>打擦边球牟利，害了用户苦了自己</strong></p><p>广电对互联网电视行业的监管始终未变。早在2011年，广电181号文件就对互联网电视做出了相关规定；而去年6月，广电也曾重申相关法律法规，对市场中的灰色地带进行了明确规定。</p><p>虽然三令五申，但由于广电缺乏执法权，市场上的违规行为依旧不绝如缕，互联网电视厂商纷纷打擦边球谋取利益，抱着侥幸心态触碰政策底线，无论广电系的牌照商，还是合法或违法的内容提供商，都或多或少做出了不少违规行为。</p><p>过去此类行为不绝如缕，但229号文件出台后，情况发生了变化。由于是多部委联合出台，过去的指导性意见的逐渐演变成多部委联合执法，广电与工商等部门已经在多地对不合规的电视盒子、互联网电视进行了查处，部分互联网电视的寒冬已经来临。</p><p>不合规厂商在牟利的同时给消费者正常收看埋下了隐患。此次229号文件还给市场带来了不少连锁反应。11月15日，国内众多互联网机顶盒都进行了系统升\n级，第一批公布的81个非法视频应用软件被屏蔽。不少在15号之前购买不合规电视盒子的用户发现无法安装第三方直播软件，将怒火撒在了电视盒子厂商身上，\n引发了退货风波。</p><p>这些厂商不仅害了用户，也苦了自己，但这种情况正是给过去遵循法律法规，在严守政策底线的基础上布局内容生态的厂商带来了机会。</p><p><strong>行业大势逆转，合规内容成为王道</strong></p><p>互联网电视厂商之间的比拼的重点有两个，一是硬件，而是内容。在硬件层面上，欧美、韩日等厂商作为上游供应商和电视厂商的双重身份，一直都占据优势，比\n如说三星、LG、索尼等厂商的电视面板技术始终独步天下，三星的曲面屏和超高清技术，LG、索尼的色彩调教，这些都一直被业内称道；但从内容来看，由于国\n际厂商一直都遵循国内法律法规，电视内伤层面上相比国内互联网电视始终差了一截。</p><p>国内互联网电视相比韩日、欧美电视最大的优势在于内容，但这种内容优势建立在违规的基础之上——没有牌照限制，没有三方监管的电视内容给用户带来了极大的便利，电视盒子低廉的价格机上聚合软件，用户所有的需求都可以解决。</p><p>只是，这种便利在法律法规面前虚无缥缈。229号文件出台后，内容依旧会是互联网电视厂商比拼的两大战场之一，但内容层面上的竞争逐渐出现了两个新维度，第一个是选择一个强大的播控平台，第二则是拥有一个开放的电视系统。</p><p>1、播控平台的内容基础</p><p>今年上半年，国产厂商之间呛声的主要根源其实就是在与播控平台和内容合法这两个要点。</p><p>互联网电视厂商以及视频服务提供商想要合规运营，只有至少与CNTV、华数、芒果TV等七家互联网电视牌照方中的一家合作，才能名正言顺的在电视端提供服务。终端内容不管来源是哪里，都计入集成播控平台管理，平台上所有内容都由七大牌照方负责。</p><p>不得不承认，以三星为代表的韩日电视厂商在内容差异上的优势正在缩小，而且未来在内容上的比拼，更多比的是合规内容，而不是挖空心思钻营的非法内容。以\n三星为例，三星电视一直不参与过去的灰色地带竞争，维持行业正常运转，2014年接入芒果TV VOD平台之后，在合法内容上内其实已经占据优势。</p><p>芒果TV背靠湖南卫视，强势娱乐资源不必多说。这几天马云造访芒果TV，阿里投资传言不胫而走。虽说不少消息只是传闻，但其实让业内对阿里娱乐和芒果TV之间的合作产生了诸多联想。拥有芒果TV这样的合作伙伴，互联网电视厂商在合法内容的竞争上必然还会占据更大优势。</p><p>2、操作系统的生态服务</p><p>内容基础是一方面，生态服务则是电视内容竞争的另一个层面。国内无论是小米、乐视、阿里其实都在基于自身的生态圈打造自家的电视产品。</p><p>生态一直都是国内厂商喜欢打造的概念。小米、乐视的电视操作系统基于安卓，两家的系统好用、便捷已是行业公认；阿里则是与传统电视厂商合作，推出了电视版的YunOS，其生态野心不可小觑。</p><p>国外的索尼、LG在硬件上同样所建树，但在生态系统层面上还是略逊一筹。相比而言，三星在软硬件统一上走的更远。三星电视搭载了最新研发的Tizen系统，搭载的APP均经过审查，提供了双重保证。</p><p>其实这种推出自家电视操作系统的做法为电视、手机之间的未来整合夯实了基础。电视未来不仅仅是一个观影观剧平台，更是多屏互动的重要重心——游戏、生活、支付、旅行等生活服务都将在电视和手机的互动中进行，这种生态级别的内容服务更值得期待。</p><p><strong>后记：</strong></p><p>面临229号文件，互联网电视其实能做的事情依旧很多。有人对文件无脑谩骂，但市场从不相信谩骂和眼泪，顺应大势进行改变才是正确做法。</p><p>三星为代表的国际厂商一直都走的很稳健。互联网电视经历了前两年的狂飙突进已经逐渐走向平稳，接下来构建生态、细心合作打磨内容才是各家竞争的重点。</p><p><br/></p>', '0', null, null, '1', '吴俊宇', '229号文件 互联网电视', '2015-11-25 03:18:08');
INSERT INTO `xuxu_articles` VALUES ('16', '2015-11-27 13:27:57', '2015-11-27 15:15:36', '0', null, '关于我们', '', '关于我们', '3', '<p>FCMS由一支年轻并且追求极致的团队开发，其特点是</p><p>1、专业；</p><p>2、注重高性能；</p><p>3、基于性能强大的Phalcon框架；</p><p>4、易于二次开发；</p><p>5、支持全站静态化（应用静态化、全静态化）；</p><p>6、支持多平台（windows，linux/unix/osx）；</p><p>7、支持多服务器；</p><p>8、支持多级多层缓存；</p><p>感谢您的使用，并希望您能够为我们提出宝贵的意见，帮助我们为您提供更好的服务，谢谢！<br/></p>', '0', null, null, '0', 'admin', 'FCMS', '2015-11-27 01:27:52');
INSERT INTO `xuxu_articles` VALUES ('19', '2015-11-27 13:32:53', '2015-11-27 15:15:21', '0', null, '联系我们', '', '联系我们', '4', '<p>电话：18888888888</p><p>QQ：88888888</p><p>微信：88888888</p><p>微博：8888@weibo.com</p><p>地址：北京市天安门广场<br/></p><p><br/></p>', '0', null, null, '0', 'admin', 'FCMS', '2015-11-27 01:30:57');

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
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_articles_tags
-- ----------------------------
INSERT INTO `xuxu_articles_tags` VALUES ('100', '0', '2015-11-26 13:34:23', '2015-11-26 13:34:23', '解析', null, null, null, '0', null, null, null, '0', '1', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('50', '0', '2015-11-25 14:22:11', '2015-11-25 14:22:11', '马云', null, null, null, '0', null, null, null, '0', '2', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('51', '0', '2015-11-25 14:22:11', '2015-11-25 14:22:11', '责任', null, null, null, '0', null, null, null, '0', '2', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('35', '0', '2015-11-25 14:18:56', '2015-11-25 14:18:56', '春运', null, null, null, '0', null, null, null, '0', '3', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('34', '0', '2015-11-25 14:18:56', '2015-11-25 14:18:56', '过年', null, null, null, '0', null, null, null, '0', '3', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('33', '0', '2015-11-25 14:18:56', '2015-11-25 14:18:56', '回家', null, null, null, '0', null, null, null, '0', '3', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('32', '0', '2015-11-25 14:18:56', '2015-11-25 14:18:56', '车票', null, null, null, '0', null, null, null, '0', '3', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('96', '0', '2015-11-26 13:33:41', '2015-11-26 13:33:41', '社会责任', null, null, null, '0', null, null, null, '0', '4', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('49', '0', '2015-11-25 14:22:11', '2015-11-25 14:22:11', '阿里巴巴', null, null, null, '0', null, null, null, '0', '2', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('97', '0', '2015-11-26 13:33:41', '2015-11-26 13:33:41', '互联网责任', null, null, null, '0', null, null, null, '0', '4', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('99', '0', '2015-11-26 13:34:23', '2015-11-26 13:34:23', 'FCMS', null, null, null, '0', null, null, null, '0', '1', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('98', '0', '2015-11-26 13:34:23', '2015-11-26 13:34:23', '特点', null, null, null, '0', null, null, null, '0', '1', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('81', '0', '2015-11-25 15:09:04', '2015-11-25 15:09:04', '农户', null, null, null, '0', null, null, null, '0', '5', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('82', '0', '2015-11-25 15:09:04', '2015-11-25 15:09:04', '互联网', null, null, null, '0', null, null, null, '0', '5', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('83', '0', '2015-11-25 15:09:04', '2015-11-25 15:09:04', '金融农户', null, null, null, '0', null, null, null, '0', '5', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('87', '0', '2015-11-25 15:18:11', '2015-11-25 15:18:11', '229号文件', null, null, null, '0', null, null, null, '0', '15', '0');
INSERT INTO `xuxu_articles_tags` VALUES ('88', '0', '2015-11-25 15:18:11', '2015-11-25 15:18:11', '互联网电视', null, null, null, '0', null, null, null, '0', '15', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_menu
-- ----------------------------
INSERT INTO `xuxu_menu` VALUES ('1', '2015-11-25 16:11:14', '2015-11-25 16:33:25', '0', '0', '1', '0', '网站首页', null, '0', '0', '', '0', '50');
INSERT INTO `xuxu_menu` VALUES ('2', '2015-11-25 16:35:16', '2015-11-27 13:34:18', '0', '0', '1', '0', '互联网动态', null, '2', '0', '', '0', '50');
INSERT INTO `xuxu_menu` VALUES ('3', '2015-11-25 16:36:31', '2015-11-26 13:32:37', '0', '0', '1', '0', 'FCMS强势登陆', null, '1', '0', '', '0', '50');
INSERT INTO `xuxu_menu` VALUES ('4', '2015-11-27 13:26:47', '2015-11-27 13:57:16', '0', '0', '1', '0', '关于我们', 'http://cms.huaer.dev/cms/index/detail/id/16', null, '0', '', '0', '49');
INSERT INTO `xuxu_menu` VALUES ('5', '2015-11-27 13:26:56', '2015-11-27 13:56:42', '0', '0', '1', '0', '联系我们', 'http://cms.huaer.dev/cms/index/detail/id/19', null, '0', '', '0', '48');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of xuxu_menu_category
-- ----------------------------
INSERT INTO `xuxu_menu_category` VALUES ('1', '2015-11-25 16:10:58', '2015-11-27 15:01:39', '0', '主导航', '0', '主导航');

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
