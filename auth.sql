/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.117
Source Server Version : 50617
Source Host           : 192.168.0.117:3306
Source Database       : shanpao_race

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-12-08 11:07:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `admin_auth_group`;
CREATE TABLE `admin_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '组别名称',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_manage` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1需要验证权限 2 不需要验证权限',
  `rules` char(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of admin_auth_group
-- ----------------------------
INSERT INTO `admin_auth_group` VALUES ('27', '超级管理员', '1', '1', '2,36,14,21,24,25,26,27,22,28,29,30,31,23,32,33,34,35');
INSERT INTO `admin_auth_group` VALUES ('28', '编辑', '1', '1', '14,23,32,33');

-- ----------------------------
-- Table structure for `admin_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `admin_auth_group_access`;
CREATE TABLE `admin_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of admin_auth_group_access
-- ----------------------------
INSERT INTO `admin_auth_group_access` VALUES ('15', '27');
INSERT INTO `admin_auth_group_access` VALUES ('16', '28');

-- ----------------------------
-- Table structure for `admin_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `admin_auth_rule`;
CREATE TABLE `admin_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) DEFAULT '' COMMENT '图标',
  `menu_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一标识Controller/action',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `pid` tinyint(5) NOT NULL DEFAULT '0' COMMENT '菜单ID ',
  `is_menu` tinyint(1) DEFAULT '1' COMMENT '1:是主菜单 2 否',
  `is_race_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:是 2:不是',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of admin_auth_rule
-- ----------------------------
INSERT INTO `admin_auth_rule` VALUES ('2', '', '', '基本管理', '0', '1', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('4', '&amp;#xe613;', 'User/index', '用户管理', '2', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('7', 'asdasd', 'asd/asdasd', '三级菜单', '4', '2', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('14', '', '', '权限管理', '0', '1', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('9', 'qwe', 'qwe/qweq', 'qwe', '2', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('10', 'dfgdf', 'dfgdfg/dfgdfg', 'gdfg', '2', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('11', 'ghjg', 'ghjghj/ghjghjghj', 'hjghj', '0', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('12', 'sa', 'as/as', 'as', '0', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('13', '权限管理', '阿萨打算的/阿萨打算的', '阿斯顿', '0', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('15', '阿斯顿', 'constrolls/constrolls', '名称吗', '4', '2', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('16', '按时大大', '大阿斯顿阿斯顿/阿斯顿阿斯顿按时', '阿萨打算的', '2', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('17', '阿斯顿', '阿斯顿阿斯顿asd/阿萨打算的', '阿萨打算的asd', '16', '2', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('18', '阿斯顿', '阿萨打算的/阿萨打算的', '阿斯顿a', '16', '2', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('19', '', '', '阿萨打算的', '0', '1', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('20', 'asd', 'User/addUser', '添加用户', '4', '2', '1', '1', '2', '');
INSERT INTO `admin_auth_rule` VALUES ('21', '&amp;#xe624;', 'Menu/index', '菜单管理', '14', '1', '2', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('22', '&amp;#xe612;', 'AuthGroup/authGroupList', '角色管理', '14', '1', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('23', '&amp;#xe613;', 'User/index', '用户管理', '14', '1', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('24', '13', 'Menu/addMenu', '添加菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('25', '213', 'Menu/editMenu', '编辑菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('26', '435', 'Menu/deleteMenu', '删除菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('27', '13', 'Menu/viewOpt', '查看三级菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('28', '123', 'AuthGroup/addGroup', '添加角色', '22', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('29', '35', 'AuthGroup/editGroup', '编辑角色', '22', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('30', '345', 'AuthGroup/deleteGroup', '删除角色', '22', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('31', 'asd', 'AuthGroup/ruleGroup', '分配权限', '22', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('32', '13', 'User/addUser', '添加用户', '23', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('33', '324', 'User/editUser', '编辑用户', '23', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('34', '435', 'User/deleterUser', '删除用户', '23', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('35', '234', 'AuthGroup/giveRole', '分配角色', '23', '2', '1', '1', '1', '');
INSERT INTO `admin_auth_rule` VALUES ('36', '&amp;#xe600;', 'Race/index', '赛事管理', '2', '1', '1', '1', '1', '');

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '数据编号',
  `user_name` varchar(20) NOT NULL COMMENT '登录名',
  `password` varchar(32) NOT NULL COMMENT '登录密码',
  `lastlogin_time` int(11) unsigned DEFAULT NULL COMMENT '最后一次登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许用户登录(1是  2否)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='后台用户表';

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('11', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1480572245', '2');
INSERT INTO `admin_user` VALUES ('15', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1481164845', '1');
INSERT INTO `admin_user` VALUES ('16', 'test', '098f6bcd4621d373cade4e832627b4f6', '1480667348', '1');
INSERT INTO `admin_user` VALUES ('17', 'wuyawnen', '90b18287d7aab11bb2caee3e0c39fd08', '1480668214', '1');
