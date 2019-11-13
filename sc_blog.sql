/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : sc_blog

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 13/11/2019 14:17:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sc_admins
-- ----------------------------
DROP TABLE IF EXISTS `sc_admins`;
CREATE TABLE `sc_admins`  (
  `uid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `imgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像地址',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '邮箱',
  `power` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1' COMMENT '权限',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  `udat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '最近登录时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_admins
-- ----------------------------
INSERT INTO `sc_admins` VALUES (1, 'scarecrow', '$2y$10$CYEVPBDrZJIxfJpvRBl/TORcJfHAfTYO0JzvcC57CUfLewXnImWD2', NULL, '', 'admin', 1, '1532807110', '1532807110');

-- ----------------------------
-- Table structure for sc_articles
-- ----------------------------
DROP TABLE IF EXISTS `sc_articles`;
CREATE TABLE `sc_articles`  (
  `aid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `cid` int(10) NOT NULL DEFAULT 0 COMMENT '分类id',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章标题',
  `keyword` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'seo关键词',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'seo描述',
  `readnum` int(10) NULL DEFAULT 0 COMMENT '阅读数量',
  `likenum` int(10) NULL DEFAULT 0 COMMENT '点赞数量',
  `author` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章作者',
  `remark` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章摘要',
  `vid` int(10) NOT NULL DEFAULT 0 COMMENT '博客内容表id',
  `openlevel` int(1) NOT NULL DEFAULT 2 COMMENT '公开权限，1公开，2隐藏',
  `recommend` int(1) NOT NULL DEFAULT 2 COMMENT '推荐',
  `imgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片url',
  `fileid` int(10) NULL DEFAULT NULL COMMENT '附件id',
  `uid` int(10) NULL DEFAULT NULL COMMENT '所属用户ID',
  `nian` int(4) NOT NULL DEFAULT 0 COMMENT '年',
  `yue` int(2) NOT NULL DEFAULT 0 COMMENT '月',
  `ri` int(2) NOT NULL DEFAULT 0 COMMENT '日',
  `udat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '修改时间',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`aid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 88 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_articles
-- ----------------------------
INSERT INTO `sc_articles` VALUES (1, 5, '欢迎使用ScarecrowBlog', '开源,Scarecrow开源,openCode', 'ScarecrowBlog博客开源', 1, 0, 'Scarecrow', 'ScarecrowBlog博客开源', 1, 1, 1, '/assets/frontend/images/common/default_fm.jpg', NULL, 1, 2019, 10, 24, '1573562229', '1571883840');

-- ----------------------------
-- Table structure for sc_categorys
-- ----------------------------
DROP TABLE IF EXISTS `sc_categorys`;
CREATE TABLE `sc_categorys`  (
  `cid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类标题',
  `sort` int(3) NOT NULL DEFAULT 1 COMMENT '排序id',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_categorys
-- ----------------------------
INSERT INTO `sc_categorys` VALUES (1, '默认分类', 1, '1532807040');
INSERT INTO `sc_categorys` VALUES (2, '编程代码', 2, '1535460216');
INSERT INTO `sc_categorys` VALUES (3, '情感吐槽', 3, '1535460224');
INSERT INTO `sc_categorys` VALUES (4, '生活琐事', 4, '1535460233');
INSERT INTO `sc_categorys` VALUES (5, '杂七杂八', 5, '1535460242');

-- ----------------------------
-- Table structure for sc_commentator
-- ----------------------------
DROP TABLE IF EXISTS `sc_commentator`;
CREATE TABLE `sc_commentator`  (
  `uid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮箱',
  `nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '昵称',
  `homeurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户的首页地址',
  `imgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像地址',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 1:正常2:禁止评论',
  `hftip` tinyint(1) NOT NULL DEFAULT 1 COMMENT '回复邮件提醒 1:正常2:禁止',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 116 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_commentator
-- ----------------------------
INSERT INTO `sc_commentator` VALUES (105, '1366635163@qq.com', 'Scarecrow', 'http://blog.scarecrow.top', 'http://q2.qlogo.cn/headimg_dl?bs=1366635163&dst_uin=1366635163&dst_uin=1366635163&dst_uin=1366635163&spec=100&url_enc=0&referer=bu_interface&term_type=PC', 1, 1, '1571579235');

-- ----------------------------
-- Table structure for sc_comments
-- ----------------------------
DROP TABLE IF EXISTS `sc_comments`;
CREATE TABLE `sc_comments`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `zan` int(10) NULL DEFAULT 0 COMMENT '赞',
  `bs` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标识',
  `sort` int(10) NOT NULL DEFAULT 1 COMMENT '排序id',
  `uid` int(10) NOT NULL COMMENT '评论人uid',
  `hf_uid` int(10) NULL DEFAULT NULL COMMENT '回复人uid',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 332 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sc_links
-- ----------------------------
DROP TABLE IF EXISTS `sc_links`;
CREATE TABLE `sc_links`  (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '网站名称',
  `url` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网站url',
  `pic` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片地址',
  `texts` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简单说明',
  `sort` int(5) NOT NULL DEFAULT 1 COMMENT '排序id',
  `spread_id` int(5) NOT NULL DEFAULT 0 COMMENT '父类id',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态,1为显示,2为隐藏',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_links
-- ----------------------------
INSERT INTO `sc_links` VALUES (1, '程序猿们~大佬集中营', '', '', '', 1, 0, 1, '1512398195');
INSERT INTO `sc_links` VALUES (2, 'ScarecrowBlog', 'http://blog.scarecrow.top', 'http://blog.scarecrow.top/scarecrow.png', 'Coding change world!', 1, 1, 1, '1571885829');

-- ----------------------------
-- Table structure for sc_musics
-- ----------------------------
DROP TABLE IF EXISTS `sc_musics`;
CREATE TABLE `sc_musics`  (
  `mid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '歌曲名称',
  `author` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '歌曲作者',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '歌曲地址',
  `pic` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '歌曲封面图片',
  `spread_id` int(10) NOT NULL DEFAULT 0 COMMENT '父类id',
  PRIMARY KEY (`mid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 42 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_musics
-- ----------------------------
INSERT INTO `sc_musics` VALUES (1, '默认分类', NULL, NULL, NULL, 0);
INSERT INTO `sc_musics` VALUES (40, '不谓侠', '萧忆情', 'https://music.163.com/song/media/outer/url?id=475530855', 'http://p2.music.126.net/OM6prM7Fg07e9oLHY2HsTQ==/18823639069522222.jpg?param=130y130', 1);
INSERT INTO `sc_musics` VALUES (19, '寂寞在唱歌', '阿桑', 'https://music.163.com/song/media/outer/url?id=205267.mp3', 'https://p2.music.126.net/SpovasHBud2A1qXXADXsBg==/109951163167455610.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (20, '花与剑', 'JS', 'https://music.163.com/song/media/outer/url?id=4875308.mp3', 'https://p2.music.126.net/4tTN8CnR7wG4E1cauIPCvQ==/109951163240682406.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (18, '半糖主义', 'S.H.E', 'https://music.163.com/song/media/outer/url?id=375774.mp3', 'https://p2.music.126.net/Lpt_Z6D40G5kZPXug8govg==/109951163543283302.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (17, '恋爱达人', '罗志祥', 'https://music.163.com/song/media/outer/url?id=5253734.mp3', 'https://p2.music.126.net/n4YTVSO7QK1VRQMCEeOPqA==/80264348845281.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (15, '不属于我的爱', '张静', 'https://music.163.com/song/media/outer/url?id=32063259.mp3', 'https://p1.music.126.net/YxD_myfUZopizGp_1LcKDw==/109951163825862462.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (16, '雪', '杜婧荧', 'https://music.163.com/song/media/outer/url?id=227012.mp3', 'https://p1.music.126.net/d2aFi3K9W58uu8m1rWFmjA==/109951163093089271.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (22, '谢谢你的温柔', 'S.H.E', 'https://music.163.com/song/media/outer/url?id=375090.mp3', 'https://p2.music.126.net/YT4I6_21Z3XQwgpGkvX_jA==/109951163249810217.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (23, '看不见', 'By2', 'https://music.163.com/song/media/outer/url?id=344393.mp3', 'https://p2.music.126.net/msVjqNOc0VWK_Ov-UiO1eA==/109951163200171191.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (24, '曾经的约定', 'By2', 'https://music.163.com/song/media/outer/url?id=344398.mp3', 'https://p2.music.126.net/-tpxCu1rVduusF2Pg4IsUA==/61572651167786.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (25, '大冒险', 'By2', 'https://music.163.com/song/media/outer/url?id=344405.mp3', 'https://p2.music.126.net/XMD4lvPozlr7EjpNZ5OBSA==/34084860473130.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (26, '心如止水', 'Ice Paper', 'https://music.163.com/song/media/outer/url?id=1349292048.mp3', 'https://p2.music.126.net/MLQl_7poLz2PTON6_JZZRQ==/109951163938219545.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (27, '绿色', '陈雪凝', 'https://music.163.com/song/media/outer/url?id=1345848098.mp3', 'https://p2.music.126.net/R4ZP3AJ9xV0vvw8LX7AbMA==/109951163860425334.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (28, '绿洲', '颜小健', 'https://music.163.com/song/media/outer/url?id=562675760.mp3', 'https://p2.music.126.net/x7IbpoY-7UPq_u6I-A4_LQ==/109951163355955457.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (29, '化身孤岛的鲸', '不才', 'https://music.163.com/song/media/outer/url?id=505446396.mp3', 'https://p2.music.126.net/Za_wWwp1CRCMAesBbE994A==/109951163023780798.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (30, '樱吹雪', '周传雄', 'https://music.163.com/song/media/outer/url?id=29572046.mp3', 'https://p2.music.126.net/8FaINzPb3xj1S9tyG16Ang==/6650945837921965.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (31, '给自己的情书', '王菲', 'https://music.163.com/song/media/outer/url?id=299604.mp3', 'https://p2.music.126.net/E0ynLFbtqou5cu1iJrvUEQ==/109951163081327547.jpg?param=200y200', 1);
INSERT INTO `sc_musics` VALUES (41, 'Star sky', 'Hell', 'https://music.163.com/song/media/outer/url?id=31654478.mp3', 'http://p2.music.126.net/n41bSTrQwG_lQzkXz7cygg==/109951163892182787.jpg', 1);

-- ----------------------------
-- Table structure for sc_users
-- ----------------------------
DROP TABLE IF EXISTS `sc_users`;
CREATE TABLE `sc_users`  (
  `uid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `login_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录标识',
  `login_mode` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录方式github,coding',
  `login_token` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录access_token',
  `home_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户的首页地址',
  `sid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密匙',
  `imgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像地址',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态1:正常0:禁止评论',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '授权时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sc_views
-- ----------------------------
DROP TABLE IF EXISTS `sc_views`;
CREATE TABLE `sc_views`  (
  `vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '文章内容',
  `aid` int(10) NOT NULL DEFAULT 0 COMMENT '所属文章id',
  PRIMARY KEY (`vid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 90 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sc_views
-- ----------------------------
INSERT INTO `sc_views` VALUES (1, '<p>欢迎使用ScarecrowBlog博客，本博客开源欢迎各位朋友使用！但是本作者不负责任何的更新一集维护，需要的朋友可以自己进行后续的开发！本系统采用Laravel开发，也没有留有任何后门!</p>', 1);

-- ----------------------------
-- Table structure for sc_weiyu
-- ----------------------------
DROP TABLE IF EXISTS `sc_weiyu`;
CREATE TABLE `sc_weiyu`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态,1为显示,2为隐藏',
  `cdat` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 57 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Triggers structure for table sc_articles
-- ----------------------------
DROP TRIGGER IF EXISTS `sc_view`;
delimiter ;;
CREATE TRIGGER `sc_view` AFTER INSERT ON `sc_articles` FOR EACH ROW INSERT INTO sc_views(aid) 
VALUES (
new.aid
)
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table sc_articles
-- ----------------------------
DROP TRIGGER IF EXISTS `sc_view_dele`;
delimiter ;;
CREATE TRIGGER `sc_view_dele` AFTER DELETE ON `sc_articles` FOR EACH ROW DELETE from sc_views WHERE aid=old.aid
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
