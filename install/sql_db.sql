DROP TABLE IF EXISTS `yiqi_article`;
#<--break-->
CREATE TABLE `yiqi_article` (
  `aid` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cid` bigint NOT NULL,
  `thumb` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `uid` bigint DEFAULT NULL,
  `seotitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `seokeywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seodescription` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lasteditdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `templets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `viewcount` bigint NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_category`;
#<--break-->
CREATE TABLE `yiqi_category` (
  `cid` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seotitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `seokeywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `seodescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `pid` bigint NOT NULL DEFAULT '0',
  `templets` varchar(255) COLLATE utf8_unicode_ci DEFAULT '-',
  `takenumber` bigint NOT NULL DEFAULT '20',
  `displayorder` bigint NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_comments`;
#<--break-->
CREATE TABLE `yiqi_comments` (
  `cid` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_link`;
#<--break-->
CREATE TABLE `yiqi_link` (
  `lid` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `adddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_meta`;
#<--break-->
CREATE TABLE IF NOT EXISTS `yiqi_meta` (
  `metaid` bigint(20) NOT NULL auto_increment,
  `metatype` varchar(255) collate utf8_unicode_ci NOT NULL,
  `objectid` bigint(20) NOT NULL,
  `metaname` longtext collate utf8_unicode_ci NOT NULL,
  `metavalue` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`metaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_product`;
#<--break-->
CREATE TABLE `yiqi_product` (
  `pid` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cid` bigint NOT NULL,
  `thumb` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `seotitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `seokeywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seodescription` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lasteditdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `templets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `viewcount` bigint NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_navigate`;
#<--break-->
CREATE TABLE `yiqi_navigate` (
  `navid` bigint(20) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `displayorder` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`navid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_regular`;
#<--break-->
CREATE TABLE `yiqi_regular` (
  `rid` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pid` bigint NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;
#<--break-->
DROP TABLE IF EXISTS `yiqi_settings`;
#<--break-->
CREATE TABLE `yiqi_settings` (
  `sid` bigint NOT NULL AUTO_INCREMENT,
  `varname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;
#<--break-->
DROP TABLE IF EXISTS `yiqi_templets`;
#<--break-->
CREATE TABLE `yiqi_templets` (
  `tid` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `directory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `copyright` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `adddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_users`;
#<--break-->
CREATE TABLE `yiqi_users` (
  `uid` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` bigint NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regular` longtext COLLATE utf8_unicode_ci,
  `adddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
DROP TABLE IF EXISTS `yiqi_keywords`;
#<--break-->
CREATE TABLE `yiqi_keywords` (
`kid` bigint NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 255 ) COLLATE utf8_unicode_ci NOT NULL ,
`url` longtext COLLATE utf8_unicode_ci NOT NULL ,
`displayorder` int(11) NOT NULL ,
PRIMARY KEY ( `kid` ) 
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
#<--break-->
INSERT INTO `yiqi_article` (`aid`, `title`, `cid`, `thumb`, `uid`, `seotitle`, `seokeywords`, `seodescription`, `filename`, `content`, `adddate`, `lasteditdate`, `templets`, `viewcount`, `status`) VALUES
(1, '公司介绍', 1, '-', 1, '公司介绍', '公司介绍', '公司介绍', 'about', '<p><a href="http://www.yiqicms.com">易企CMS</a>是为国内用户专门定制的一套企业建站系统,操作简单,管理方便,对搜索引擎更友好,使您网站排名变得更轻松</p>', now(), now(), 'article.tpl', 1, 'ok'),
(3, '又一个使用易企CMS的网站开通了', 2, '-', 1, '又一个使用易企CMS的网站开通了', '又一个使用易企CMS的网站开通了', '又一个使用易企CMS的网站开通了', 'yiqi-starter', '<p>又一个使用<a href="http://www.yiqicms.com">易企CMS</a>的网站开通了.</p>', now(), now(), 'article.tpl', 1, 'ok'),
(2, '联系我们', 1, '-', 1, '联系我们', '联系我们', '联系我们', 'contact', '联系我们', now(), now(), 'article.tpl', 1, 'ok');
#<--break-->
INSERT INTO `yiqi_category` (`cid`, `name`, `type`, `seotitle`, `seokeywords`, `seodescription`, `description`, `filename`, `pid`,`templets`,`takenumber`, `status`) VALUES
(1, '关于我们', 'article', '关于我们', '-', '-', '关于我们', 'about', 0, 'category.tpl',24,'ok'),
(2, '公司动态', 'article', '公司动态', '-', '-', '公司动态', 'news', 0, 'category.tpl',24, 'ok'),
(3, '默认产品', 'product', '默认产品', '-', '-', '默认产品', 'default', 0, 'category.tpl',24, 'ok');
#<--break-->
INSERT INTO `yiqi_comments` (`cid`, `title`, `content`, `name`, `contact`, `ip`, `adddate`) VALUES
(1, '咨询一下', '咨询内容', '张先生', '13333333333', '127.0.0.1', now());
#<--break-->
INSERT INTO `yiqi_link` (`lid`, `title`, `url`, `displayorder`, `adddate`, `remark`, `status`) VALUES
(1, '易企CMS企业建站系统', 'http://www.yiqicms.com/', 0, now(), '易企CMS官方网站', 'ok'),
(2, '易企CMS论坛', 'http://www.yiqicms.com/forum/', 0, now(), '易企CMS官方论坛', 'ok');
#<--break-->
INSERT INTO `yiqi_regular` (`rid`, `name`, `description`, `type`, `pid`, `value`, `displayorder`, `status`) VALUES
(1, '文章管理', '-', 'member', 0, '#', 0, 'ok'),
(2, '添加文章', '添加文章', 'member', 1, 'article-add.php', 0, 'ok'),
(3, '修改文章', '修改文章', 'member', 1, 'article-edit.php', 0, 'hide'),
(4, '文章列表', '查看文章', 'member', 1, 'article.php', 0, 'ok'),
(5, '产品管理', '-', 'member', 0, '#', 1, 'ok'),
(6, '产品列表', '查看产品', 'member', 5, 'product.php', 0, 'ok'),
(7, '添加产品', '添加产品', 'member', 5, 'product-add.php', 0, 'ok'),
(8, '编辑产品', '编辑产品', 'member', 5, 'product-edit.php', 0, 'hide'),
(23, '模板管理', '-', 'member', 0, '#', 5, 'ok'),
(10, '文章分类', '编辑文章分类', 'member', 1, 'category.php?type=article', 0, 'ok'),
(11, '添加分类', '添加文章分类', 'member', 1, 'category-add.php?type=article', 0, 'ok'),
(12, '产品分类', '查看产品分类', 'member', 5, 'category.php?type=product', 0, 'ok'),
(13, '添加分类', '添加产品分类', 'member', 5, 'category-add.php?type=product', 0, 'ok'),
(14, '编辑产品分类', '编辑产品分类', 'member', 5, 'category-edit.php?type=product', 0, 'hide'),
(15, '编辑文章分类', '编辑文章分类', 'member', 1, 'category-edit.php?type=article', 0, 'hide'),
(16, '用户管理', '-', 'member', 0, '#', 4, 'ok'),
(17, '用户列表', '查看用户列表', 'member', 16, 'users.php', 0, 'ok'),
(18, '添加用户', '添加用户', 'member', 16, 'user-add.php', 0, 'ok'),
(19, '编辑用户', '编辑用户', 'member', 16, 'user-profile.php', 0, 'hide'),
(20, '网站设置', '-', 'member', 0, '#', 6, 'ok'),
(21, '基本设置', '基本设置', 'member', 20, 'option.php', 0, 'ok'),
(22, 'SEO设置', 'SEO设置', 'member', 20, 'option-seo.php', 0, 'ok'),
(24, '模板列表', '查看模板列表', 'member', 23, 'templets.php', 0, 'ok'),
(25, '留言管理', '-', 'member', 0, '#', 2, 'ok'),
(26, '留言列表', '查看留言列表', 'member', 25, 'comments.php', 0, 'ok'),
(27, '留言内容', '查看留言内容', 'member', 25, 'comment-info.php', 0, 'hide'),
(28, '友情链接', '-', 'member', 0, '#', 3, 'ok'),
(29, '链接列表', '友情链接管理', 'member', 28, 'link.php', 0, 'ok'),
(30, 'URL重写', 'URL重写', 'member', 20, 'option-url.php', 0, 'ok'),
(31, '公司资料', '-', 'member', 0, '#', 7, 'ok'),
(32, '公司简介', '公司简介设置', '-', 31, 'company-option.php', 0, 'ok'),
(33, '联系方式', '联系方式', '-', 31, 'company-contact.php', 0, 'ok'),
(34, '移动文章分类', '移动文章分类', 'member', 1, 'category-move.php?type=article', 0, 'hide'),
(35, '移动产品分类', '移动产品分类', 'member', 5, 'category-move.php?type=product', 0, 'hide'),
(36, '数据管理', '管理网站数据', 'member', 0, '#', '8', 'ok'),
(37, '数据备份', '备份网站数据', 'member', 36, 'dbbackup.php', 0, 'ok'),
(38, '数据恢复', '恢复网站数据', 'member', 36, 'dbrestore.php', 0, 'ok'),
(39, '关键词管理', '长尾关键词记录单', 'member', '0', '#', '9', 'ok'),
(40, '关键词列表', '关键词列表', 'member', '39', 'keywords.php', '0', 'ok'),
(41, '添加关键词', '添加关键词', 'member', '39', 'keyword-add.php', '0', 'ok'),
(42, '导航管理', '导航管理', 'member', '23', 'navigate.php', '0', 'ok'),
(43, '变量管理', '变量管理', 'member', '20', 'settings.php', '0', 'ok'),
(44, '生成HTML', '生成HTML', 'member', '20', 'option-html.php', '0', 'ok'),
(44, '管理后右api', '后台Ajax返回值管理模块', 'member', '36', 'api.php', '0', 'ok');
#<--break-->
INSERT INTO `yiqi_settings` (`sid`, `varname`, `description`, `value`) VALUES
(1, 'sitename', '网站名称', '易企内容管理系统'),
(3, 'sitetemplets', '网站模板', '1'),
(4, 'siteicp', '网站备案号码', '-'),
(5, 'sitestat', '网站统计代码', '-'),
(6, 'sitecopy', '网站版权信息', '© 2009-2010 <a href="http://www.yiqicms.com">易企科技</a>'),
(7, 'titlekeywords', '网站标题关键词', '易企内容管理系统'),
(8, 'metakeywords', 'META关键词', '-'),
(9, 'metadescription', 'META描述', '-'),
(10, 'urlrewrite', '是否开始URL重写', 'false'),
(11, 'companysummary', '公司简介', '<p>易企CMS是为国内用户专门定制的一套企业建站系统,操作简单,管理方便,对搜索引擎更友好,使您网站排名变得更轻松</p>'),
(12, 'companyname', '公司名称', '易企科技'),
(13, 'companyphone', '公司电话', '请填写您的联系电话'),
(14, 'companymobile', '移动电话', '请填写您的移动电话'),
(15, 'companyfax', '传真', '请填写您的传真'),
(16, 'companyaddr', '地址', '请填写您的地址'),
(17, 'companyemail', '电子邮箱', '请填写您的电子邮箱'),
(18, 'companyurl', '网站地址', '-'),
(19, 'companyqq', '联系QQ', '请填写您的QQ'),
(20, 'companymsn', 'MSN', '请填写您的MSN'),
(21, 'companycontact', '联系人', '请填写您的姓名'),
(21, 'redefine', '网站301重定向', '');
#<--break-->
INSERT INTO `yiqi_templets` (`tid`, `name`, `directory`, `thumb`, `author`, `copyright`, `adddate`, `status`) VALUES
(1, '默认模板', 'default', '../templets/default/preview.gif', 'YIQICMS', 'Copyright 2009 YIQICMS.com all rights reserved.', now(), 'ok'),
(2, '红粉之家', 'redpink', '../templets/redpink/preview.gif', 'YIQICMS', 'Copyright 2009 YIQICMS.com all rights reserved.', now(), 'ok');