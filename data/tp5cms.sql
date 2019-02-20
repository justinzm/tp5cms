-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 10 月 23 日 01:08
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tp5cms`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_ad`
--

CREATE TABLE IF NOT EXISTS `tp_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `title` varchar(200) NOT NULL COMMENT '广告标题',
  `url` varchar(300) NOT NULL COMMENT '广告网址',
  `img` varchar(300) NOT NULL COMMENT '广告图片',
  `content` text NOT NULL COMMENT '广告代码',
  `intro` tinytext NOT NULL COMMENT '广告描述',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `status` int(2) unsigned NOT NULL COMMENT '是否发布',
  `type` varchar(50) NOT NULL COMMENT '类型',
  `hits` int(11) unsigned NOT NULL COMMENT '点击量',
  `ordernum` int(30) unsigned NOT NULL COMMENT '排序',
  `params` text NOT NULL COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告表' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_admin_log`
--

CREATE TABLE IF NOT EXISTS `tp_admin_log` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `admin_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `log_info` varchar(255) DEFAULT NULL COMMENT '日志描述',
  `log_ip` varchar(30) DEFAULT NULL COMMENT 'ip地址',
  `log_url` varchar(50) DEFAULT NULL COMMENT 'url',
  `log_time` int(10) DEFAULT NULL COMMENT '日志时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员日志表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `tp_admin_log`
--

INSERT INTO `tp_admin_log` (`id`, `admin_id`, `log_info`, `log_ip`, `log_url`, `log_time`) VALUES
(1, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1490579955),
(2, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1490580752),
(3, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1490580864),
(4, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1490580946),
(5, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1490580986),
(6, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1490581012),
(7, 1, '后台登录', '0.0.0.0', 'admin/Login/login', 1508720782);

-- --------------------------------------------------------

--
-- 表的结构 `tp_admin_user`
--

CREATE TABLE IF NOT EXISTS `tp_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tp_admin_user`
--

INSERT INTO `tp_admin_user` (`id`, `username`, `password`, `status`, `create_time`, `last_login_time`, `last_login_ip`) VALUES
(1, 'admin', '445ce2f9e4af88402523fc58074e6a6f', 1, 2016, '2017-10-23 09:06:22', '0.0.0.0'),
(2, 'zm', '909bffa74e6c88ead30741436c9ef688', 1, 1482984735, '2016-12-30 11:07:44', '0.0.0.0');

-- --------------------------------------------------------

--
-- 表的结构 `tp_article`
--

CREATE TABLE IF NOT EXISTS `tp_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(100) DEFAULT NULL COMMENT '文章标题',
  `alias` varchar(100) DEFAULT NULL COMMENT '别名',
  `istop` tinyint(1) unsigned DEFAULT NULL COMMENT '是否置顶',
  `metakeys` varchar(100) DEFAULT NULL COMMENT '关键词',
  `metadesc` tinytext COMMENT '关键描述',
  `praise` int(30) unsigned DEFAULT '0' COMMENT '点赞次数',
  `intro` tinytext COMMENT '简介',
  `img` varchar(200) DEFAULT NULL COMMENT '新闻图片',
  `content` text COMMENT '正文',
  `s_id` int(5) unsigned DEFAULT NULL COMMENT '单元编号',
  `c_id` int(5) unsigned DEFAULT NULL COMMENT '分类编号',
  `status` int(2) unsigned DEFAULT NULL COMMENT '是否启动',
  `author` varchar(100) DEFAULT NULL COMMENT '来源/作者',
  `author_id` int(5) unsigned DEFAULT NULL COMMENT '创建者ID',
  `addtime` datetime DEFAULT NULL COMMENT '发布时间',
  `endtime` datetime DEFAULT NULL COMMENT '停止时间',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL,
  `ordernum` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `access` int(5) unsigned DEFAULT NULL COMMENT '级别',
  `hits` int(10) unsigned DEFAULT NULL COMMENT '点击量',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `tp_article`
--

INSERT INTO `tp_article` (`id`, `title`, `alias`, `istop`, `metakeys`, `metadesc`, `praise`, `intro`, `img`, `content`, `s_id`, `c_id`, `status`, `author`, `author_id`, `addtime`, `endtime`, `create_time`, `update_time`, `delete_time`, `ordernum`, `access`, `hits`, `params`) VALUES
(9, '文章二', '', 0, '', '', 0, NULL, NULL, '<p>点的的<br/></p>', 2, 2, 1, '', NULL, '2016-12-28 00:00:00', NULL, 1482912363, 1482912469, 1482912469, 0, NULL, NULL, NULL),
(8, '文章一', 'xx', 0, '', '', 0, NULL, NULL, '<p>笑嘻嘻笑嘻嘻笑嘻嘻笑嘻嘻系<br/></p>', 1, 1, 1, '', NULL, '2016-12-28 00:00:00', NULL, 1482912318, 1482912318, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_group`
--

CREATE TABLE IF NOT EXISTS `tp_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='AUTH 用户组表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `tp_auth_group`
--

INSERT INTO `tp_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(3, '系统管理员', 1, '1,7,11,30,31,32,33,34,8,35,36,37,38,39,40,9,41,42,43,44,45,46,10,47,48,49,50,51,52,2,14,53,15,54,55,56,57,58,59,60,16,61,62,63,64,65,66,17,67,68,69,70,71,72,18,73,74,75,76,77,78,3,13,24,25,26,27,28,29,4,20,79,80,81,82,83,84,21,85,86,87,88,89,90,91,92,93,5,12,95,96,97,98,99,19,94,6,22,100,101,102,23,103,104,105,106'),
(4, '普通管理员', 1, '1,7,11,30,31,32,33,34,8,35,36,37,38,39,40,9,41,42,43,44,45,46,10,47,48,49,50,51,'),
(5, 'CCC111', 1, '2,14,15,16,17,18,4,20,21,5,12,19');

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `tp_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='AUTH 用户组明细表';

--
-- 转存表中的数据 `tp_auth_group_access`
--

INSERT INTO `tp_auth_group_access` (`uid`, `group_id`) VALUES
(1, 3),
(2, 4);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_rule`
--

CREATE TABLE IF NOT EXISTS `tp_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(80) NOT NULL COMMENT '规则名称（控制器）',
  `title` varchar(20) NOT NULL COMMENT '菜单名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单 规则表' AUTO_INCREMENT=108 ;

--
-- 转存表中的数据 `tp_auth_rule`
--

INSERT INTO `tp_auth_rule` (`id`, `name`, `title`, `type`, `status`, `pid`, `icon`, `sort`, `condition`) VALUES
(1, '', '内容管理', 1, 1, 0, '&#xe639;', 10, NULL),
(2, '', '微信基础管理', 1, 1, 0, '&#xe6c5;', 8, NULL),
(3, '', '扩展管理', 1, 1, 0, '&#xe654;', 6, NULL),
(4, '', '管理员管理', 1, 1, 0, '&#xe62b;', 5, NULL),
(5, '', '站点管理', 1, 1, 0, '&#xe62e;', 4, NULL),
(6, '', '插件管理', 1, 1, 0, '&#xe63c;', 2, NULL),
(7, 'admin/Section/index', '单元管理', 1, 1, 1, '', 4, ''),
(8, 'admin/Category/index', '分类管理', 1, 1, 1, '', 3, ''),
(9, 'admin/Article/index', '文章管理', 1, 1, 1, '', 2, ''),
(10, 'admin/Page/index', '单页管理', 1, 1, 1, '', 1, ''),
(11, 'admin/Section/add', '添加单元', 1, 1, 7, '', 0, ''),
(12, 'admin/Menu/index', '菜单管理', 1, 1, 5, '', 0, ''),
(13, 'admin/Ad/index', '广告管理', 1, 1, 3, '', 0, ''),
(14, 'admin/WxReply/index', '关注回复管理 ', 1, 1, 2, '', 0, ''),
(15, 'admin/WxDiymenu/index', '微信菜单管理', 1, 1, 2, '', 0, ''),
(16, 'admin/WxText/index', '文本回复管理', 1, 1, 2, '', 0, ''),
(17, 'admin/WxImg/index', '图文回复管理 ', 1, 1, 2, '', 0, ''),
(18, 'admin/WxImgs/index', '多图文回复管理 ', 1, 1, 2, '', 0, ''),
(19, 'admin/Conf/index', '站点配置 ', 1, 1, 5, '', 1, ''),
(20, 'admin/AdminUser/index', '管理员管理', 1, 1, 4, '', 3, ''),
(21, 'admin/AuthGroup/index', '权限组管理', 1, 1, 4, '', 2, ''),
(22, 'admin/Tools/index', '数据备份', 1, 1, 6, '', 0, ''),
(23, 'admin/Tools/restore', '数据还原', 1, 1, 6, '', 0, ''),
(24, 'admin/Ad/add', '添加广告', 1, 1, 13, '', 0, ''),
(25, 'admin/Ad/insert', '插入广告', 1, 1, 13, '', 0, ''),
(26, 'admin/Ad/edit', '编辑广告', 1, 1, 13, '', 0, ''),
(27, 'admin/Ad/update', '修改广告', 1, 1, 13, '', 0, ''),
(28, 'admin/Ad/status', '启动广告', 1, 1, 13, '', 0, ''),
(29, 'admin/Ad/delete', '删除广告', 1, 1, 13, '', 0, ''),
(30, 'admin/Section/insert', '插入单元', 1, 1, 7, '', 0, ''),
(31, 'admin/Section/edit', '编辑广告', 1, 1, 7, '', 0, ''),
(32, 'admin/Section/update', '修改单元', 1, 1, 7, '', 0, ''),
(33, 'admin/Section/status', '启动单元', 1, 1, 7, '', 0, ''),
(34, 'admin/Section/delete', '删除单元', 1, 1, 7, '', 0, ''),
(35, 'admin/Category/add', '添加分类', 1, 1, 8, '', 0, ''),
(36, 'admin/Category/insert', '插入分类', 1, 1, 8, '', 0, ''),
(37, 'admin/Category/edit', '编辑分类', 1, 1, 8, '', 0, ''),
(38, 'admin/Category/update', '修改分类', 1, 1, 8, '', 0, ''),
(39, 'admin/Category/status', '启动分类', 1, 1, 8, '', 0, ''),
(40, 'admin/Category/delete', '删除分类', 1, 1, 8, '', 0, ''),
(41, 'admin/Article/add', '添加文章', 1, 1, 9, '', 0, ''),
(42, 'admin/Article/insert', '插入文章', 1, 1, 9, '', 0, ''),
(43, 'admin/Article/edit', '编辑文章', 1, 1, 9, '', 0, ''),
(44, 'admin/Article/update', '修改文章', 1, 1, 9, '', 0, ''),
(45, 'admin/Article/status', '启动文章', 1, 1, 9, '', 0, ''),
(46, 'admin/Article/delete', '删除文章', 1, 1, 9, '', 0, ''),
(47, 'admin/Page/add', '添加单页', 1, 1, 10, '', 0, ''),
(48, 'admin/Page/insert', '插入单页', 1, 1, 10, '', 0, ''),
(49, 'admin/Page/edit', '编辑单页', 1, 1, 10, '', 0, ''),
(50, 'admin/Page/update', '修改单页', 1, 1, 10, '', 0, ''),
(51, 'admin/Page/status', '启动单页', 1, 1, 10, '', 0, ''),
(52, 'admin/Page/delete', '删除单页', 1, 1, 10, '', 0, ''),
(53, 'admin/WxReply/update', '修改关注回复', 1, 1, 14, '', 0, ''),
(54, 'admin/WxDiymenu/add', '添加微信菜单', 1, 1, 15, '', 0, ''),
(55, 'admin/WxDiymenu/insert', '插入微信菜单', 1, 1, 15, '', 0, ''),
(56, 'admin/WxDiymenu/edit', '编辑微信菜单', 1, 1, 15, '', 0, ''),
(57, 'admin/WxDiymenu/update', '修改微信菜单', 1, 1, 15, '', 0, ''),
(58, 'admin/WxDiymenu/status', '启动微信菜单', 1, 1, 15, '', 0, ''),
(59, 'admin/WxDiymenu/delete', '删除微信菜单', 1, 1, 15, '', 0, ''),
(60, 'admin/WxDiymenu/diymenu_send', '生成微信菜单', 1, 1, 15, '', 0, ''),
(61, 'admin/WxText/add', '添加文本回复', 1, 1, 16, '', 0, ''),
(62, 'admin/WxText/insert', '插入文本回复', 1, 1, 16, '', 0, ''),
(63, 'admin/WxText/edit', '编辑文本回复', 1, 1, 16, '', 0, ''),
(64, 'admin/WxText/update', '修改文本回复', 1, 1, 16, '', 0, ''),
(65, 'admin/WxText/status', '启动文本回复', 1, 1, 16, '', 0, ''),
(66, 'admin/WxText/delete', '删除文本回复', 1, 1, 16, '', 0, ''),
(67, 'admin/WxImg/add', '添加图文回复', 1, 1, 17, '', 0, ''),
(68, 'admin/WxImg/insert', '插入图文回复', 1, 1, 17, '', 0, ''),
(69, 'admin/WxImg/edit', '编辑图文回复', 1, 1, 17, '', 0, ''),
(70, 'admin/WxImg/update', '修改图文回复', 1, 1, 17, '', 0, ''),
(71, 'admin/WxImg/status', '启动图文回复', 1, 1, 17, '', 0, ''),
(72, 'admin/WxImg/delete', '删除图文回复', 1, 11, 17, '', 0, ''),
(73, 'admin/WxImgs/add', '添加多图文回复', 1, 1, 18, '', 0, ''),
(74, 'admin/WxImgs/insert', '插入多图文回复', 1, 1, 18, '', 0, ''),
(75, 'admin/WxImgs/edit', '编辑多图文回复', 1, 1, 18, '', 0, ''),
(76, 'admin/WxImgs/update', '修改多图文回复', 1, 1, 18, '', 0, ''),
(77, 'admin/WxImgs/status', '启动多图文回复', 1, 1, 18, '', 0, ''),
(78, 'admin/WxImgs/delete', '删除多图文回复', 1, 1, 18, '', 0, ''),
(79, 'admin/AdminUser/add', '添加管理员', 1, 1, 20, '', 0, ''),
(80, 'admin/AdminUser/insert', '插入管理员', 1, 1, 20, '', 0, ''),
(81, 'admin/AdminUser/edit', '编辑管理员', 1, 1, 20, '', 0, ''),
(82, 'admin/AdminUser/update', '修改管理员', 1, 1, 20, '', 0, ''),
(83, 'admin/AdminUser/status', '启动管理员', 1, 1, 20, '', 0, ''),
(84, 'admin/AdminUser/delete', '删除管理员', 1, 1, 20, '', 0, ''),
(85, 'admin/AuthGroup/add', '添加权限组', 1, 1, 21, '', 0, ''),
(86, 'admin/AuthGroup/insert', '插入权限组', 1, 1, 21, '', 0, ''),
(87, 'admin/AuthGroup/edit', '编辑权限组', 1, 1, 21, '', 0, ''),
(88, 'admin/AuthGroup/update', '修改权限组', 1, 1, 21, '', 0, ''),
(89, 'admin/AuthGroup/status', '启动权限组', 1, 1, 21, '', 0, ''),
(90, 'admin/AuthGroup/delete', '删除权限组', 1, 1, 21, '', 0, ''),
(91, 'admin/AuthGroup/auth', '授权权限组', 1, 1, 21, '', 0, ''),
(92, 'admin/AuthGroup/getJson', '获取规则数据', 1, 1, 21, '', 0, ''),
(93, 'admin/AuthGroup/updateAuthGroupRule', '更新权限组规则', 1, 1, 21, '', 0, ''),
(94, 'admin/Conf/update', '修改站点配置', 1, 1, 19, '', 0, ''),
(95, 'admin/Menu/add', '添加菜单', 1, 1, 12, '', 0, ''),
(96, 'admin/Menu/insert', '插入菜单', 1, 1, 12, '', 0, ''),
(97, 'admin/Menu/edit', '编辑菜单', 1, 1, 12, '', 0, ''),
(98, 'admin/Menu/update', '修改菜单', 1, 1, 12, '', 0, ''),
(99, 'admin/Menu/delete', '删除菜单', 1, 1, 12, '', 0, ''),
(100, 'admin/Tools/optimize', '优化数据', 1, 1, 22, '', 0, ''),
(101, 'admin/Tools/repair', '修复数据', 1, 1, 22, '', 0, ''),
(102, 'admin/Tools/backup', '备份数据', 1, 1, 22, '', 0, ''),
(103, 'admin/Tools/delSqlFiles', '删除数据', 1, 1, 23, '', 0, ''),
(104, 'admin/Tools/downFile', '下载数据', 1, 1, 23, '', 0, ''),
(105, 'admin/Tools/restoreData', '还原数据', 1, 1, 23, '', 0, ''),
(106, 'admin/Tools/getRestoreFiles', '读取导入数据', 1, 1, 23, '', 0, ''),
(107, 'admin/AdminLog/index', '管理员日志', 1, 1, 4, '', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `tp_category`
--

CREATE TABLE IF NOT EXISTS `tp_category` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `s_id` int(5) unsigned DEFAULT NULL COMMENT '单元编号',
  `title` varchar(100) DEFAULT NULL COMMENT '分类名',
  `alias` varchar(100) DEFAULT NULL COMMENT '别名',
  `intro` tinytext COMMENT '描述',
  `status` int(2) unsigned DEFAULT NULL COMMENT '是否启动',
  `ordernum` int(5) unsigned DEFAULT NULL COMMENT '排序',
  `access` int(2) unsigned DEFAULT NULL COMMENT '级别',
  `params` tinytext COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分类表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tp_category`
--

INSERT INTO `tp_category` (`id`, `s_id`, `title`, `alias`, `intro`, `status`, `ordernum`, `access`, `params`) VALUES
(1, 1, '分类一', '', '', 1, 0, NULL, NULL),
(2, 2, '分类二', '', '', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_config`
--

CREATE TABLE IF NOT EXISTS `tp_config` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `sitename` varchar(300) DEFAULT NULL COMMENT '站点名称',
  `metakeys` varchar(300) DEFAULT NULL COMMENT '站点关键词',
  `metadesc` tinytext COMMENT '站点描述',
  `pagesize` int(10) unsigned DEFAULT NULL COMMENT '分页显示长度',
  `email` varchar(200) DEFAULT NULL COMMENT 'Email',
  `company` varchar(100) DEFAULT NULL COMMENT '公司名称',
  `siteurl` varchar(300) DEFAULT NULL COMMENT '站点网址',
  `icp` varchar(100) DEFAULT NULL COMMENT '备案',
  `tel` varchar(100) DEFAULT NULL COMMENT '电话',
  `qq` varchar(100) DEFAULT NULL COMMENT 'QQ',
  `address` tinytext COMMENT '地址',
  `webname` varchar(300) DEFAULT NULL COMMENT '网名',
  `wxname` varchar(50) DEFAULT NULL COMMENT '微信公众号名称',
  `wxnumber` varchar(50) DEFAULT NULL COMMENT '微信号',
  `wxid` varchar(50) DEFAULT NULL COMMENT '公众号原始ID',
  `wxappid` varchar(50) DEFAULT NULL COMMENT 'appID',
  `wxappsecret` varchar(100) DEFAULT NULL COMMENT 'appsecret',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配置表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tp_config`
--

INSERT INTO `tp_config` (`id`, `sitename`, `metakeys`, `metadesc`, `pagesize`, `email`, `company`, `siteurl`, `icp`, `tel`, `qq`, `address`, `webname`, `wxname`, `wxnumber`, `wxid`, `wxappid`, `wxappsecret`) VALUES
(1, 'CMS 后台', 'CMS', 'XX', NULL, '', 'XXXXX', 'http://localhost/tp5cms', '', '', '', '', NULL, '位视', 'weishilive', 'gh_c907ba4a3344', 'wxe01c2db54cdadccf', 'd985802f00fc9d82b3c496ea5e33d806');

-- --------------------------------------------------------

--
-- 表的结构 `tp_member`
--

CREATE TABLE IF NOT EXISTS `tp_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户序号ID',
  `username` varchar(100) DEFAULT NULL COMMENT '登录名',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `tel` varchar(30) DEFAULT NULL COMMENT '手机号',
  `addtime` datetime DEFAULT NULL COMMENT '入驻时间',
  `endtime` datetime DEFAULT NULL COMMENT '到期时间',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `logintime` datetime DEFAULT NULL COMMENT '登录时间',
  `status` int(2) unsigned DEFAULT NULL COMMENT '是否激活',
  `ip` varchar(255) DEFAULT NULL COMMENT 'ip地址',
  `face_img` varchar(200) DEFAULT NULL COMMENT '头像地址',
  `num` int(50) unsigned DEFAULT '0' COMMENT '登录次数',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员用户表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `tp_member`
--

INSERT INTO `tp_member` (`id`, `username`, `password`, `nickname`, `tel`, `addtime`, `endtime`, `email`, `logintime`, `status`, `ip`, `face_img`, `num`, `params`) VALUES
(1, 'admin', '53dd9c6005f3cdfc5a69c5c07388016d', 'admin', NULL, NULL, NULL, NULL, '2016-05-26 11:55:04', 1, NULL, NULL, 1, NULL),
(2, 'zmwl', '53dd9c6005f3cdfc5a69c5c07388016d', '郑明', '13377885996', '2016-05-24 03:45:47', NULL, NULL, '2016-05-26 11:37:25', 1, NULL, NULL, 0, NULL),
(11, NULL, NULL, '流年002', NULL, NULL, NULL, 'thinkphp@qq.com', NULL, NULL, NULL, NULL, 0, NULL),
(12, NULL, NULL, '流年002', NULL, NULL, NULL, 'thinkphp@qq.com', NULL, NULL, NULL, NULL, 0, NULL),
(10, NULL, NULL, '流年002', NULL, NULL, NULL, 'thinkphp@qq.com', NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu`
--

CREATE TABLE IF NOT EXISTS `tp_menu` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `title` varchar(255) DEFAULT NULL COMMENT '菜单标题',
  `path` varchar(300) DEFAULT NULL COMMENT '链接路径',
  `menutype` varchar(255) DEFAULT NULL COMMENT '菜单类型',
  `intro` varchar(300) DEFAULT NULL COMMENT '描述',
  `ordernum` int(20) unsigned DEFAULT NULL COMMENT '排序',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否激活',
  `params` tinytext COMMENT '注解',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu_item`
--

CREATE TABLE IF NOT EXISTS `tp_menu_item` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单项ID',
  `title` varchar(255) DEFAULT NULL COMMENT '菜单项标题',
  `menu_id` int(10) unsigned DEFAULT NULL COMMENT '所属菜单编号',
  `alias` varchar(255) DEFAULT NULL COMMENT '别名',
  `url` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `type` varchar(255) DEFAULT NULL COMMENT '菜单类型',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否启动',
  `pid` int(10) unsigned DEFAULT NULL COMMENT '父ID',
  `path` varchar(255) DEFAULT NULL COMMENT '路径',
  `componentid` int(10) unsigned DEFAULT NULL COMMENT '组件编号',
  `ordernum` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `browserNav` varchar(200) DEFAULT NULL COMMENT '浏览器打开方式',
  `intro` varchar(255) DEFAULT NULL,
  `params` text COMMENT '参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单项表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_message`
--

CREATE TABLE IF NOT EXISTS `tp_message` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `source` tinyint(1) unsigned DEFAULT NULL COMMENT '来源',
  `uid` int(30) unsigned DEFAULT NULL COMMENT '会员ID',
  `truename` varchar(60) DEFAULT NULL COMMENT '留言姓名',
  `wxname` varchar(60) DEFAULT NULL COMMENT '微信名',
  `tel` varchar(30) DEFAULT NULL COMMENT '电话',
  `openid` varchar(100) DEFAULT NULL,
  `content` text COMMENT '留言内容',
  `reply` text COMMENT '回复内容',
  `reauthor` varchar(60) DEFAULT NULL COMMENT '回复者',
  `create_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `retime` datetime DEFAULT NULL COMMENT '回复时间',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '0未看1看过2回复',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_page`
--

CREATE TABLE IF NOT EXISTS `tp_page` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '单页ID',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `link_label` varchar(100) DEFAULT NULL COMMENT '链接标识',
  `metakeys` varchar(200) DEFAULT NULL COMMENT '关键词',
  `img` varchar(300) DEFAULT NULL COMMENT '单页图片',
  `intro` tinytext COMMENT '描述',
  `content` text COMMENT '正文',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否启动',
  `hits` int(10) unsigned DEFAULT NULL COMMENT '点击量',
  `createtime` int(16) DEFAULT NULL COMMENT '添加时间',
  `updatetime` int(16) DEFAULT NULL COMMENT '修改时间',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_section`
--

CREATE TABLE IF NOT EXISTS `tp_section` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '单元ID',
  `title` varchar(100) DEFAULT NULL COMMENT '单元名',
  `alias` varchar(50) DEFAULT NULL COMMENT '别名',
  `intro` tinytext COMMENT '描述',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否启动',
  `ordernum` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `access` int(5) unsigned DEFAULT NULL COMMENT '级别',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='单元表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tp_section`
--

INSERT INTO `tp_section` (`id`, `title`, `alias`, `intro`, `status`, `ordernum`, `access`, `params`) VALUES
(1, '单元一', '', '', 1, 0, NULL, NULL),
(2, '单元二', '', '', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_wx_diymenu`
--

CREATE TABLE IF NOT EXISTS `tp_wx_diymenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `pid` int(5) unsigned DEFAULT NULL COMMENT '父ID',
  `keyword` varchar(50) DEFAULT NULL COMMENT '关键词',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否激活',
  `ordernum` int(11) unsigned DEFAULT NULL COMMENT '排序',
  `url` varchar(255) DEFAULT NULL COMMENT '链接',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信-菜单表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `tp_wx_diymenu`
--

INSERT INTO `tp_wx_diymenu` (`id`, `pid`, `keyword`, `title`, `status`, `ordernum`, `url`, `params`) VALUES
(1, 0, '1', '222', 1, 322, '', NULL),
(2, 0, 'xxxxxxxxx', 'xxx', 1, 32, '我噩噩噩噩噩噩噩我呃呃呃呃呃呃呃呃', NULL),
(3, 1, '广告歌', '各国国歌各国', 1, 43, '各国国歌各国各国国歌各国', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_wx_imgs`
--

CREATE TABLE IF NOT EXISTS `tp_wx_imgs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `keyword` varchar(50) DEFAULT NULL COMMENT '关键词',
  `title` varchar(50) DEFAULT NULL COMMENT '多图文标题',
  `wid` varchar(50) DEFAULT NULL COMMENT '多图文ID',
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '1完全2模糊',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `createauthor` varchar(30) DEFAULT NULL COMMENT '创建者',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `updateauthor` varchar(30) DEFAULT NULL COMMENT '修改者',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否启动',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信-多图文回复表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_wx_imgtext`
--

CREATE TABLE IF NOT EXISTS `tp_wx_imgtext` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT COMMENT '图文回复ID',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关键词',
  `praise` int(30) unsigned NOT NULL DEFAULT '0' COMMENT '点赞',
  `hits` int(30) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '1完全匹配2模糊匹配',
  `title` varchar(255) DEFAULT NULL COMMENT '回复标题',
  `intro` text COMMENT '简介',
  `content` text COMMENT '正文',
  `img` varchar(255) DEFAULT NULL COMMENT '图',
  `is_img` tinyint(1) unsigned DEFAULT NULL COMMENT '是否显示封面0不显示1显示',
  `url` varchar(255) DEFAULT NULL COMMENT '链接',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否激活',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `createauthor` varchar(50) DEFAULT NULL COMMENT '创建者',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `updateauthor` varchar(50) DEFAULT NULL COMMENT '修改者',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信-图文回复表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tp_wx_reply`
--

CREATE TABLE IF NOT EXISTS `tp_wx_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `content` text COMMENT '内容',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信-关注回复表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tp_wx_reply`
--

INSERT INTO `tp_wx_reply` (`id`, `content`, `params`) VALUES
(1, 'eeweweweweew/流汗/可怜/可怜/可怜/可怜/白眼/示爱/示爱', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_wx_text`
--

CREATE TABLE IF NOT EXISTS `tp_wx_text` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT COMMENT '文本回复ID',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关键词',
  `content` text COMMENT '回复文本内容',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否激活',
  `type` tinyint(1) unsigned DEFAULT NULL COMMENT '1完全2模糊匹配',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `createauthor` datetime DEFAULT NULL COMMENT '创建者',
  `update_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `updateauthor` datetime DEFAULT NULL COMMENT '修改者',
  `params` text COMMENT '其他参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微信-文本回复表' AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
