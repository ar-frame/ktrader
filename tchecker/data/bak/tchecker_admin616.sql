/*
 Navicat Premium Data Transfer

 Source Server         : atrader
 Source Server Type    : MySQL
 Source Server Version : 80029
 Source Host           : 192.168.101.177:19002
 Source Schema         : tchecker_admin

 Target Server Type    : MySQL
 Target Server Version : 80029
 File Encoding         : 65001

 Date: 16/06/2022 18:48:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cz_admin_developer
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_developer`;
CREATE TABLE `cz_admin_developer`  (
  `id` int unsigned NOT NULL COMMENT '开发者表id，自增',
  `uid` int(0) DEFAULT NULL COMMENT '关联cz_admin_user表的id字段',
  `addtime` int(0) DEFAULT NULL COMMENT '加入时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_developer
-- ----------------------------
INSERT INTO `cz_admin_developer` VALUES (2, 2, 1588151456);

-- ----------------------------
-- Table structure for cz_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_group`;
CREATE TABLE `cz_admin_group`  (
  `id` int unsigned NOT NULL COMMENT '管理员组表id，自增',
  `group_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员组名称',
  `status` int(0) DEFAULT 1 COMMENT '能否删除 0不可删除 1可以删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_group
-- ----------------------------
INSERT INTO `cz_admin_group` VALUES (1, '超级管理员', 0);
INSERT INTO `cz_admin_group` VALUES (2, '普通管理员', 0);
INSERT INTO `cz_admin_group` VALUES (3, '运营', 1);

-- ----------------------------
-- Table structure for cz_admin_group_func
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_group_func`;
CREATE TABLE `cz_admin_group_func`  (
  `id` int(0) NOT NULL AUTO_INCREMENT COMMENT '管理员组-功能权限中间表id',
  `gid` int(0) DEFAULT NULL COMMENT '管理员组id',
  `mid` int(0) DEFAULT NULL COMMENT '模型id',
  `fid` int(0) DEFAULT NULL COMMENT '功能id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 586 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_group_func
-- ----------------------------
INSERT INTO `cz_admin_group_func` VALUES (9, 1, 2, 9);
INSERT INTO `cz_admin_group_func` VALUES (10, 1, 2, 10);
INSERT INTO `cz_admin_group_func` VALUES (11, 1, 2, 11);
INSERT INTO `cz_admin_group_func` VALUES (12, 1, 2, 12);
INSERT INTO `cz_admin_group_func` VALUES (13, 1, 2, 13);
INSERT INTO `cz_admin_group_func` VALUES (14, 1, 2, 14);
INSERT INTO `cz_admin_group_func` VALUES (15, 1, 2, 15);
INSERT INTO `cz_admin_group_func` VALUES (16, 1, 2, 16);
INSERT INTO `cz_admin_group_func` VALUES (17, 1, 3, 17);
INSERT INTO `cz_admin_group_func` VALUES (18, 1, 3, 18);
INSERT INTO `cz_admin_group_func` VALUES (19, 1, 3, 19);
INSERT INTO `cz_admin_group_func` VALUES (20, 1, 3, 20);
INSERT INTO `cz_admin_group_func` VALUES (21, 1, 3, 21);
INSERT INTO `cz_admin_group_func` VALUES (22, 1, 3, 22);
INSERT INTO `cz_admin_group_func` VALUES (23, 1, 3, 23);
INSERT INTO `cz_admin_group_func` VALUES (24, 1, 3, 24);
INSERT INTO `cz_admin_group_func` VALUES (25, 1, 4, 25);
INSERT INTO `cz_admin_group_func` VALUES (26, 1, 4, 26);
INSERT INTO `cz_admin_group_func` VALUES (27, 1, 4, 27);
INSERT INTO `cz_admin_group_func` VALUES (28, 1, 4, 28);
INSERT INTO `cz_admin_group_func` VALUES (29, 1, 4, 29);
INSERT INTO `cz_admin_group_func` VALUES (30, 1, 4, 30);
INSERT INTO `cz_admin_group_func` VALUES (31, 1, 4, 31);
INSERT INTO `cz_admin_group_func` VALUES (32, 1, 4, 32);
INSERT INTO `cz_admin_group_func` VALUES (33, 1, 5, 33);
INSERT INTO `cz_admin_group_func` VALUES (34, 1, 5, 34);
INSERT INTO `cz_admin_group_func` VALUES (35, 1, 5, 35);
INSERT INTO `cz_admin_group_func` VALUES (36, 1, 5, 36);
INSERT INTO `cz_admin_group_func` VALUES (37, 1, 5, 37);
INSERT INTO `cz_admin_group_func` VALUES (38, 1, 5, 38);
INSERT INTO `cz_admin_group_func` VALUES (39, 1, 5, 39);
INSERT INTO `cz_admin_group_func` VALUES (40, 1, 5, 40);
INSERT INTO `cz_admin_group_func` VALUES (41, 1, 6, 41);
INSERT INTO `cz_admin_group_func` VALUES (42, 1, 6, 42);
INSERT INTO `cz_admin_group_func` VALUES (43, 1, 6, 43);
INSERT INTO `cz_admin_group_func` VALUES (44, 1, 6, 44);
INSERT INTO `cz_admin_group_func` VALUES (45, 1, 6, 45);
INSERT INTO `cz_admin_group_func` VALUES (46, 1, 6, 46);
INSERT INTO `cz_admin_group_func` VALUES (47, 1, 6, 47);
INSERT INTO `cz_admin_group_func` VALUES (48, 1, 6, 48);
INSERT INTO `cz_admin_group_func` VALUES (49, 1, 7, 49);
INSERT INTO `cz_admin_group_func` VALUES (50, 1, 7, 50);
INSERT INTO `cz_admin_group_func` VALUES (51, 1, 7, 51);
INSERT INTO `cz_admin_group_func` VALUES (52, 1, 7, 52);
INSERT INTO `cz_admin_group_func` VALUES (53, 1, 7, 53);
INSERT INTO `cz_admin_group_func` VALUES (54, 1, 7, 54);
INSERT INTO `cz_admin_group_func` VALUES (55, 1, 7, 55);
INSERT INTO `cz_admin_group_func` VALUES (56, 1, 7, 56);
INSERT INTO `cz_admin_group_func` VALUES (57, 1, 8, 57);
INSERT INTO `cz_admin_group_func` VALUES (58, 1, 8, 58);
INSERT INTO `cz_admin_group_func` VALUES (59, 1, 8, 59);
INSERT INTO `cz_admin_group_func` VALUES (60, 1, 8, 60);
INSERT INTO `cz_admin_group_func` VALUES (61, 1, 8, 61);
INSERT INTO `cz_admin_group_func` VALUES (62, 1, 8, 62);
INSERT INTO `cz_admin_group_func` VALUES (63, 1, 8, 63);
INSERT INTO `cz_admin_group_func` VALUES (64, 1, 8, 64);
INSERT INTO `cz_admin_group_func` VALUES (65, 1, 9, 65);
INSERT INTO `cz_admin_group_func` VALUES (66, 1, 9, 66);
INSERT INTO `cz_admin_group_func` VALUES (67, 1, 9, 67);
INSERT INTO `cz_admin_group_func` VALUES (68, 1, 9, 68);
INSERT INTO `cz_admin_group_func` VALUES (69, 1, 9, 69);
INSERT INTO `cz_admin_group_func` VALUES (70, 1, 9, 70);
INSERT INTO `cz_admin_group_func` VALUES (71, 1, 9, 71);
INSERT INTO `cz_admin_group_func` VALUES (72, 1, 9, 72);
INSERT INTO `cz_admin_group_func` VALUES (73, 1, 10, 73);
INSERT INTO `cz_admin_group_func` VALUES (74, 1, 10, 74);
INSERT INTO `cz_admin_group_func` VALUES (75, 1, 10, 75);
INSERT INTO `cz_admin_group_func` VALUES (76, 1, 10, 76);
INSERT INTO `cz_admin_group_func` VALUES (77, 1, 10, 77);
INSERT INTO `cz_admin_group_func` VALUES (78, 1, 10, 78);
INSERT INTO `cz_admin_group_func` VALUES (79, 1, 10, 79);
INSERT INTO `cz_admin_group_func` VALUES (80, 1, 10, 80);
INSERT INTO `cz_admin_group_func` VALUES (81, 1, 11, 81);
INSERT INTO `cz_admin_group_func` VALUES (82, 1, 11, 82);
INSERT INTO `cz_admin_group_func` VALUES (83, 1, 11, 83);
INSERT INTO `cz_admin_group_func` VALUES (84, 1, 11, 84);
INSERT INTO `cz_admin_group_func` VALUES (85, 1, 11, 85);
INSERT INTO `cz_admin_group_func` VALUES (86, 1, 11, 86);
INSERT INTO `cz_admin_group_func` VALUES (87, 1, 11, 87);
INSERT INTO `cz_admin_group_func` VALUES (88, 1, 11, 88);
INSERT INTO `cz_admin_group_func` VALUES (89, 1, 12, 89);
INSERT INTO `cz_admin_group_func` VALUES (90, 1, 12, 90);
INSERT INTO `cz_admin_group_func` VALUES (91, 1, 12, 91);
INSERT INTO `cz_admin_group_func` VALUES (92, 1, 12, 92);
INSERT INTO `cz_admin_group_func` VALUES (93, 1, 12, 93);
INSERT INTO `cz_admin_group_func` VALUES (94, 1, 12, 94);
INSERT INTO `cz_admin_group_func` VALUES (95, 1, 12, 95);
INSERT INTO `cz_admin_group_func` VALUES (96, 1, 12, 96);
INSERT INTO `cz_admin_group_func` VALUES (97, 1, 13, 97);
INSERT INTO `cz_admin_group_func` VALUES (98, 1, 13, 98);
INSERT INTO `cz_admin_group_func` VALUES (99, 1, 13, 99);
INSERT INTO `cz_admin_group_func` VALUES (100, 1, 13, 100);
INSERT INTO `cz_admin_group_func` VALUES (101, 1, 13, 101);
INSERT INTO `cz_admin_group_func` VALUES (102, 1, 13, 102);
INSERT INTO `cz_admin_group_func` VALUES (103, 1, 13, 103);
INSERT INTO `cz_admin_group_func` VALUES (104, 1, 13, 104);
INSERT INTO `cz_admin_group_func` VALUES (105, 1, 14, 105);
INSERT INTO `cz_admin_group_func` VALUES (106, 1, 14, 106);
INSERT INTO `cz_admin_group_func` VALUES (107, 1, 14, 107);
INSERT INTO `cz_admin_group_func` VALUES (108, 1, 14, 108);
INSERT INTO `cz_admin_group_func` VALUES (109, 1, 14, 109);
INSERT INTO `cz_admin_group_func` VALUES (110, 1, 14, 110);
INSERT INTO `cz_admin_group_func` VALUES (111, 1, 14, 111);
INSERT INTO `cz_admin_group_func` VALUES (112, 1, 14, 112);
INSERT INTO `cz_admin_group_func` VALUES (113, 1, 15, 113);
INSERT INTO `cz_admin_group_func` VALUES (114, 1, 15, 114);
INSERT INTO `cz_admin_group_func` VALUES (115, 1, 15, 115);
INSERT INTO `cz_admin_group_func` VALUES (116, 1, 15, 116);
INSERT INTO `cz_admin_group_func` VALUES (117, 1, 15, 117);
INSERT INTO `cz_admin_group_func` VALUES (118, 1, 15, 118);
INSERT INTO `cz_admin_group_func` VALUES (119, 1, 15, 119);
INSERT INTO `cz_admin_group_func` VALUES (120, 1, 15, 120);
INSERT INTO `cz_admin_group_func` VALUES (121, 1, 16, 121);
INSERT INTO `cz_admin_group_func` VALUES (122, 1, 16, 122);
INSERT INTO `cz_admin_group_func` VALUES (123, 1, 16, 123);
INSERT INTO `cz_admin_group_func` VALUES (124, 1, 16, 124);
INSERT INTO `cz_admin_group_func` VALUES (125, 1, 16, 125);
INSERT INTO `cz_admin_group_func` VALUES (126, 1, 16, 126);
INSERT INTO `cz_admin_group_func` VALUES (127, 1, 16, 127);
INSERT INTO `cz_admin_group_func` VALUES (128, 1, 16, 128);
INSERT INTO `cz_admin_group_func` VALUES (129, 1, 17, 129);
INSERT INTO `cz_admin_group_func` VALUES (130, 1, 17, 130);
INSERT INTO `cz_admin_group_func` VALUES (131, 1, 17, 131);
INSERT INTO `cz_admin_group_func` VALUES (132, 1, 17, 132);
INSERT INTO `cz_admin_group_func` VALUES (133, 1, 17, 133);
INSERT INTO `cz_admin_group_func` VALUES (134, 1, 17, 134);
INSERT INTO `cz_admin_group_func` VALUES (135, 1, 17, 135);
INSERT INTO `cz_admin_group_func` VALUES (136, 1, 17, 136);
INSERT INTO `cz_admin_group_func` VALUES (137, 1, 18, 137);
INSERT INTO `cz_admin_group_func` VALUES (138, 1, 18, 138);
INSERT INTO `cz_admin_group_func` VALUES (139, 1, 18, 139);
INSERT INTO `cz_admin_group_func` VALUES (140, 1, 18, 140);
INSERT INTO `cz_admin_group_func` VALUES (141, 1, 18, 141);
INSERT INTO `cz_admin_group_func` VALUES (142, 1, 18, 142);
INSERT INTO `cz_admin_group_func` VALUES (143, 1, 18, 143);
INSERT INTO `cz_admin_group_func` VALUES (144, 1, 18, 144);
INSERT INTO `cz_admin_group_func` VALUES (145, 1, 19, 145);
INSERT INTO `cz_admin_group_func` VALUES (146, 1, 19, 146);
INSERT INTO `cz_admin_group_func` VALUES (147, 1, 19, 147);
INSERT INTO `cz_admin_group_func` VALUES (148, 1, 19, 148);
INSERT INTO `cz_admin_group_func` VALUES (149, 1, 19, 149);
INSERT INTO `cz_admin_group_func` VALUES (150, 1, 19, 150);
INSERT INTO `cz_admin_group_func` VALUES (151, 1, 19, 151);
INSERT INTO `cz_admin_group_func` VALUES (152, 1, 19, 152);
INSERT INTO `cz_admin_group_func` VALUES (153, 1, 20, 153);
INSERT INTO `cz_admin_group_func` VALUES (154, 1, 20, 154);
INSERT INTO `cz_admin_group_func` VALUES (155, 1, 20, 155);
INSERT INTO `cz_admin_group_func` VALUES (156, 1, 20, 156);
INSERT INTO `cz_admin_group_func` VALUES (157, 1, 20, 157);
INSERT INTO `cz_admin_group_func` VALUES (158, 1, 20, 158);
INSERT INTO `cz_admin_group_func` VALUES (159, 1, 20, 159);
INSERT INTO `cz_admin_group_func` VALUES (160, 1, 20, 160);
INSERT INTO `cz_admin_group_func` VALUES (161, 1, 21, 161);
INSERT INTO `cz_admin_group_func` VALUES (162, 1, 21, 162);
INSERT INTO `cz_admin_group_func` VALUES (163, 1, 21, 163);
INSERT INTO `cz_admin_group_func` VALUES (164, 1, 21, 164);
INSERT INTO `cz_admin_group_func` VALUES (165, 1, 21, 165);
INSERT INTO `cz_admin_group_func` VALUES (166, 1, 21, 166);
INSERT INTO `cz_admin_group_func` VALUES (167, 1, 21, 167);
INSERT INTO `cz_admin_group_func` VALUES (168, 1, 21, 168);
INSERT INTO `cz_admin_group_func` VALUES (169, 1, 22, 169);
INSERT INTO `cz_admin_group_func` VALUES (170, 1, 22, 170);
INSERT INTO `cz_admin_group_func` VALUES (171, 1, 22, 171);
INSERT INTO `cz_admin_group_func` VALUES (172, 1, 22, 172);
INSERT INTO `cz_admin_group_func` VALUES (173, 1, 22, 173);
INSERT INTO `cz_admin_group_func` VALUES (174, 1, 22, 174);
INSERT INTO `cz_admin_group_func` VALUES (175, 1, 22, 175);
INSERT INTO `cz_admin_group_func` VALUES (176, 1, 22, 176);
INSERT INTO `cz_admin_group_func` VALUES (177, 1, 23, 177);
INSERT INTO `cz_admin_group_func` VALUES (178, 1, 23, 178);
INSERT INTO `cz_admin_group_func` VALUES (179, 1, 23, 179);
INSERT INTO `cz_admin_group_func` VALUES (180, 1, 23, 180);
INSERT INTO `cz_admin_group_func` VALUES (181, 1, 23, 181);
INSERT INTO `cz_admin_group_func` VALUES (182, 1, 23, 182);
INSERT INTO `cz_admin_group_func` VALUES (183, 1, 23, 183);
INSERT INTO `cz_admin_group_func` VALUES (184, 1, 23, 184);
INSERT INTO `cz_admin_group_func` VALUES (185, 1, 24, 185);
INSERT INTO `cz_admin_group_func` VALUES (186, 1, 24, 186);
INSERT INTO `cz_admin_group_func` VALUES (187, 1, 24, 187);
INSERT INTO `cz_admin_group_func` VALUES (188, 1, 24, 188);
INSERT INTO `cz_admin_group_func` VALUES (189, 1, 24, 189);
INSERT INTO `cz_admin_group_func` VALUES (190, 1, 24, 190);
INSERT INTO `cz_admin_group_func` VALUES (191, 1, 24, 191);
INSERT INTO `cz_admin_group_func` VALUES (192, 1, 24, 192);
INSERT INTO `cz_admin_group_func` VALUES (193, 1, 25, 193);
INSERT INTO `cz_admin_group_func` VALUES (194, 1, 25, 194);
INSERT INTO `cz_admin_group_func` VALUES (195, 1, 25, 195);
INSERT INTO `cz_admin_group_func` VALUES (196, 1, 25, 196);
INSERT INTO `cz_admin_group_func` VALUES (197, 1, 25, 197);
INSERT INTO `cz_admin_group_func` VALUES (198, 1, 25, 198);
INSERT INTO `cz_admin_group_func` VALUES (199, 1, 25, 199);
INSERT INTO `cz_admin_group_func` VALUES (200, 1, 25, 200);
INSERT INTO `cz_admin_group_func` VALUES (201, 1, 26, 201);
INSERT INTO `cz_admin_group_func` VALUES (202, 1, 26, 202);
INSERT INTO `cz_admin_group_func` VALUES (203, 1, 26, 203);
INSERT INTO `cz_admin_group_func` VALUES (204, 1, 26, 204);
INSERT INTO `cz_admin_group_func` VALUES (205, 1, 26, 205);
INSERT INTO `cz_admin_group_func` VALUES (206, 1, 26, 206);
INSERT INTO `cz_admin_group_func` VALUES (207, 1, 26, 207);
INSERT INTO `cz_admin_group_func` VALUES (208, 1, 26, 208);
INSERT INTO `cz_admin_group_func` VALUES (209, 1, 27, 209);
INSERT INTO `cz_admin_group_func` VALUES (210, 1, 27, 210);
INSERT INTO `cz_admin_group_func` VALUES (211, 1, 27, 211);
INSERT INTO `cz_admin_group_func` VALUES (212, 1, 27, 212);
INSERT INTO `cz_admin_group_func` VALUES (213, 1, 27, 213);
INSERT INTO `cz_admin_group_func` VALUES (214, 1, 27, 214);
INSERT INTO `cz_admin_group_func` VALUES (215, 1, 27, 215);
INSERT INTO `cz_admin_group_func` VALUES (216, 1, 27, 216);
INSERT INTO `cz_admin_group_func` VALUES (217, 1, 28, 217);
INSERT INTO `cz_admin_group_func` VALUES (218, 1, 28, 218);
INSERT INTO `cz_admin_group_func` VALUES (219, 1, 28, 219);
INSERT INTO `cz_admin_group_func` VALUES (220, 1, 28, 220);
INSERT INTO `cz_admin_group_func` VALUES (221, 1, 28, 221);
INSERT INTO `cz_admin_group_func` VALUES (222, 1, 28, 222);
INSERT INTO `cz_admin_group_func` VALUES (223, 1, 28, 223);
INSERT INTO `cz_admin_group_func` VALUES (224, 1, 28, 224);
INSERT INTO `cz_admin_group_func` VALUES (225, 1, 29, 225);
INSERT INTO `cz_admin_group_func` VALUES (226, 1, 29, 226);
INSERT INTO `cz_admin_group_func` VALUES (227, 1, 29, 227);
INSERT INTO `cz_admin_group_func` VALUES (228, 1, 29, 228);
INSERT INTO `cz_admin_group_func` VALUES (229, 1, 29, 229);
INSERT INTO `cz_admin_group_func` VALUES (230, 1, 29, 230);
INSERT INTO `cz_admin_group_func` VALUES (231, 1, 29, 231);
INSERT INTO `cz_admin_group_func` VALUES (232, 1, 29, 232);
INSERT INTO `cz_admin_group_func` VALUES (233, 1, 30, 233);
INSERT INTO `cz_admin_group_func` VALUES (234, 1, 30, 234);
INSERT INTO `cz_admin_group_func` VALUES (235, 1, 30, 235);
INSERT INTO `cz_admin_group_func` VALUES (236, 1, 30, 236);
INSERT INTO `cz_admin_group_func` VALUES (237, 1, 30, 237);
INSERT INTO `cz_admin_group_func` VALUES (238, 1, 30, 238);
INSERT INTO `cz_admin_group_func` VALUES (239, 1, 30, 239);
INSERT INTO `cz_admin_group_func` VALUES (240, 1, 30, 240);
INSERT INTO `cz_admin_group_func` VALUES (241, 1, 31, 241);
INSERT INTO `cz_admin_group_func` VALUES (242, 1, 31, 242);
INSERT INTO `cz_admin_group_func` VALUES (243, 1, 31, 243);
INSERT INTO `cz_admin_group_func` VALUES (244, 1, 31, 244);
INSERT INTO `cz_admin_group_func` VALUES (245, 1, 31, 245);
INSERT INTO `cz_admin_group_func` VALUES (246, 1, 31, 246);
INSERT INTO `cz_admin_group_func` VALUES (247, 1, 31, 247);
INSERT INTO `cz_admin_group_func` VALUES (248, 1, 31, 248);
INSERT INTO `cz_admin_group_func` VALUES (249, 1, 32, 249);
INSERT INTO `cz_admin_group_func` VALUES (250, 1, 32, 250);
INSERT INTO `cz_admin_group_func` VALUES (251, 1, 32, 251);
INSERT INTO `cz_admin_group_func` VALUES (252, 1, 32, 252);
INSERT INTO `cz_admin_group_func` VALUES (253, 1, 32, 253);
INSERT INTO `cz_admin_group_func` VALUES (254, 1, 32, 254);
INSERT INTO `cz_admin_group_func` VALUES (255, 1, 32, 255);
INSERT INTO `cz_admin_group_func` VALUES (256, 1, 32, 256);
INSERT INTO `cz_admin_group_func` VALUES (257, 1, 33, 257);
INSERT INTO `cz_admin_group_func` VALUES (258, 1, 33, 258);
INSERT INTO `cz_admin_group_func` VALUES (259, 1, 33, 259);
INSERT INTO `cz_admin_group_func` VALUES (260, 1, 33, 260);
INSERT INTO `cz_admin_group_func` VALUES (261, 1, 33, 261);
INSERT INTO `cz_admin_group_func` VALUES (262, 1, 33, 262);
INSERT INTO `cz_admin_group_func` VALUES (263, 1, 33, 263);
INSERT INTO `cz_admin_group_func` VALUES (264, 1, 33, 264);
INSERT INTO `cz_admin_group_func` VALUES (265, 1, 34, 265);
INSERT INTO `cz_admin_group_func` VALUES (266, 1, 34, 266);
INSERT INTO `cz_admin_group_func` VALUES (267, 1, 34, 267);
INSERT INTO `cz_admin_group_func` VALUES (268, 1, 34, 268);
INSERT INTO `cz_admin_group_func` VALUES (269, 1, 34, 269);
INSERT INTO `cz_admin_group_func` VALUES (270, 1, 34, 270);
INSERT INTO `cz_admin_group_func` VALUES (271, 1, 34, 271);
INSERT INTO `cz_admin_group_func` VALUES (272, 1, 34, 272);
INSERT INTO `cz_admin_group_func` VALUES (273, 1, 35, 273);
INSERT INTO `cz_admin_group_func` VALUES (274, 1, 35, 274);
INSERT INTO `cz_admin_group_func` VALUES (275, 1, 35, 275);
INSERT INTO `cz_admin_group_func` VALUES (276, 1, 35, 276);
INSERT INTO `cz_admin_group_func` VALUES (277, 1, 35, 277);
INSERT INTO `cz_admin_group_func` VALUES (278, 1, 35, 278);
INSERT INTO `cz_admin_group_func` VALUES (279, 1, 35, 279);
INSERT INTO `cz_admin_group_func` VALUES (280, 1, 35, 280);
INSERT INTO `cz_admin_group_func` VALUES (281, 1, 36, 281);
INSERT INTO `cz_admin_group_func` VALUES (282, 1, 36, 282);
INSERT INTO `cz_admin_group_func` VALUES (283, 1, 36, 283);
INSERT INTO `cz_admin_group_func` VALUES (284, 1, 36, 284);
INSERT INTO `cz_admin_group_func` VALUES (285, 1, 36, 285);
INSERT INTO `cz_admin_group_func` VALUES (286, 1, 36, 286);
INSERT INTO `cz_admin_group_func` VALUES (287, 1, 36, 287);
INSERT INTO `cz_admin_group_func` VALUES (288, 1, 36, 288);
INSERT INTO `cz_admin_group_func` VALUES (289, 1, 37, 289);
INSERT INTO `cz_admin_group_func` VALUES (290, 1, 37, 290);
INSERT INTO `cz_admin_group_func` VALUES (291, 1, 37, 291);
INSERT INTO `cz_admin_group_func` VALUES (292, 1, 37, 292);
INSERT INTO `cz_admin_group_func` VALUES (293, 1, 37, 293);
INSERT INTO `cz_admin_group_func` VALUES (294, 1, 37, 294);
INSERT INTO `cz_admin_group_func` VALUES (295, 1, 37, 295);
INSERT INTO `cz_admin_group_func` VALUES (296, 1, 37, 296);
INSERT INTO `cz_admin_group_func` VALUES (297, 1, 38, 297);
INSERT INTO `cz_admin_group_func` VALUES (298, 1, 38, 298);
INSERT INTO `cz_admin_group_func` VALUES (299, 1, 38, 299);
INSERT INTO `cz_admin_group_func` VALUES (300, 1, 38, 300);
INSERT INTO `cz_admin_group_func` VALUES (301, 1, 38, 301);
INSERT INTO `cz_admin_group_func` VALUES (302, 1, 38, 302);
INSERT INTO `cz_admin_group_func` VALUES (303, 1, 38, 303);
INSERT INTO `cz_admin_group_func` VALUES (304, 1, 38, 304);
INSERT INTO `cz_admin_group_func` VALUES (305, 1, 39, 305);
INSERT INTO `cz_admin_group_func` VALUES (306, 1, 39, 306);
INSERT INTO `cz_admin_group_func` VALUES (307, 1, 39, 307);
INSERT INTO `cz_admin_group_func` VALUES (308, 1, 39, 308);
INSERT INTO `cz_admin_group_func` VALUES (309, 1, 39, 309);
INSERT INTO `cz_admin_group_func` VALUES (310, 1, 39, 310);
INSERT INTO `cz_admin_group_func` VALUES (311, 1, 39, 311);
INSERT INTO `cz_admin_group_func` VALUES (312, 1, 39, 312);
INSERT INTO `cz_admin_group_func` VALUES (313, 1, 40, 313);
INSERT INTO `cz_admin_group_func` VALUES (314, 1, 40, 314);
INSERT INTO `cz_admin_group_func` VALUES (315, 1, 40, 315);
INSERT INTO `cz_admin_group_func` VALUES (316, 1, 40, 316);
INSERT INTO `cz_admin_group_func` VALUES (317, 1, 40, 317);
INSERT INTO `cz_admin_group_func` VALUES (318, 1, 40, 318);
INSERT INTO `cz_admin_group_func` VALUES (319, 1, 40, 319);
INSERT INTO `cz_admin_group_func` VALUES (320, 1, 40, 320);
INSERT INTO `cz_admin_group_func` VALUES (321, 1, 41, 321);
INSERT INTO `cz_admin_group_func` VALUES (322, 1, 41, 322);
INSERT INTO `cz_admin_group_func` VALUES (323, 1, 41, 323);
INSERT INTO `cz_admin_group_func` VALUES (324, 1, 41, 324);
INSERT INTO `cz_admin_group_func` VALUES (325, 1, 41, 325);
INSERT INTO `cz_admin_group_func` VALUES (326, 1, 41, 326);
INSERT INTO `cz_admin_group_func` VALUES (327, 1, 41, 327);
INSERT INTO `cz_admin_group_func` VALUES (328, 1, 41, 328);
INSERT INTO `cz_admin_group_func` VALUES (329, 1, 42, 329);
INSERT INTO `cz_admin_group_func` VALUES (330, 1, 42, 330);
INSERT INTO `cz_admin_group_func` VALUES (331, 1, 42, 331);
INSERT INTO `cz_admin_group_func` VALUES (332, 1, 42, 332);
INSERT INTO `cz_admin_group_func` VALUES (333, 1, 42, 333);
INSERT INTO `cz_admin_group_func` VALUES (334, 1, 42, 334);
INSERT INTO `cz_admin_group_func` VALUES (335, 1, 42, 335);
INSERT INTO `cz_admin_group_func` VALUES (336, 1, 42, 336);
INSERT INTO `cz_admin_group_func` VALUES (337, 1, 43, 337);
INSERT INTO `cz_admin_group_func` VALUES (338, 1, 43, 338);
INSERT INTO `cz_admin_group_func` VALUES (339, 1, 43, 339);
INSERT INTO `cz_admin_group_func` VALUES (340, 1, 43, 340);
INSERT INTO `cz_admin_group_func` VALUES (341, 1, 43, 341);
INSERT INTO `cz_admin_group_func` VALUES (342, 1, 43, 342);
INSERT INTO `cz_admin_group_func` VALUES (343, 1, 43, 343);
INSERT INTO `cz_admin_group_func` VALUES (344, 1, 43, 344);
INSERT INTO `cz_admin_group_func` VALUES (345, 1, 44, 345);
INSERT INTO `cz_admin_group_func` VALUES (346, 1, 44, 346);
INSERT INTO `cz_admin_group_func` VALUES (347, 1, 44, 347);
INSERT INTO `cz_admin_group_func` VALUES (348, 1, 44, 348);
INSERT INTO `cz_admin_group_func` VALUES (349, 1, 44, 349);
INSERT INTO `cz_admin_group_func` VALUES (350, 1, 44, 350);
INSERT INTO `cz_admin_group_func` VALUES (351, 1, 44, 351);
INSERT INTO `cz_admin_group_func` VALUES (352, 1, 44, 352);
INSERT INTO `cz_admin_group_func` VALUES (353, 1, 45, 353);
INSERT INTO `cz_admin_group_func` VALUES (354, 1, 45, 354);
INSERT INTO `cz_admin_group_func` VALUES (355, 1, 45, 355);
INSERT INTO `cz_admin_group_func` VALUES (356, 1, 45, 356);
INSERT INTO `cz_admin_group_func` VALUES (357, 1, 45, 357);
INSERT INTO `cz_admin_group_func` VALUES (358, 1, 45, 358);
INSERT INTO `cz_admin_group_func` VALUES (359, 1, 45, 359);
INSERT INTO `cz_admin_group_func` VALUES (360, 1, 45, 360);
INSERT INTO `cz_admin_group_func` VALUES (361, 1, 46, 361);
INSERT INTO `cz_admin_group_func` VALUES (362, 1, 46, 362);
INSERT INTO `cz_admin_group_func` VALUES (363, 1, 46, 363);
INSERT INTO `cz_admin_group_func` VALUES (364, 1, 46, 364);
INSERT INTO `cz_admin_group_func` VALUES (365, 1, 46, 365);
INSERT INTO `cz_admin_group_func` VALUES (366, 1, 46, 366);
INSERT INTO `cz_admin_group_func` VALUES (367, 1, 46, 367);
INSERT INTO `cz_admin_group_func` VALUES (368, 1, 46, 368);
INSERT INTO `cz_admin_group_func` VALUES (369, 1, 47, 369);
INSERT INTO `cz_admin_group_func` VALUES (370, 1, 47, 370);
INSERT INTO `cz_admin_group_func` VALUES (371, 1, 47, 371);
INSERT INTO `cz_admin_group_func` VALUES (372, 1, 47, 372);
INSERT INTO `cz_admin_group_func` VALUES (373, 1, 47, 373);
INSERT INTO `cz_admin_group_func` VALUES (374, 1, 47, 374);
INSERT INTO `cz_admin_group_func` VALUES (375, 1, 47, 375);
INSERT INTO `cz_admin_group_func` VALUES (376, 1, 47, 376);
INSERT INTO `cz_admin_group_func` VALUES (377, 1, 48, 377);
INSERT INTO `cz_admin_group_func` VALUES (378, 1, 48, 378);
INSERT INTO `cz_admin_group_func` VALUES (379, 1, 48, 379);
INSERT INTO `cz_admin_group_func` VALUES (380, 1, 48, 380);
INSERT INTO `cz_admin_group_func` VALUES (381, 1, 48, 381);
INSERT INTO `cz_admin_group_func` VALUES (382, 1, 48, 382);
INSERT INTO `cz_admin_group_func` VALUES (383, 1, 48, 383);
INSERT INTO `cz_admin_group_func` VALUES (384, 1, 48, 384);
INSERT INTO `cz_admin_group_func` VALUES (385, 1, 49, 385);
INSERT INTO `cz_admin_group_func` VALUES (386, 1, 49, 386);
INSERT INTO `cz_admin_group_func` VALUES (387, 1, 49, 387);
INSERT INTO `cz_admin_group_func` VALUES (388, 1, 49, 388);
INSERT INTO `cz_admin_group_func` VALUES (389, 1, 49, 389);
INSERT INTO `cz_admin_group_func` VALUES (390, 1, 49, 390);
INSERT INTO `cz_admin_group_func` VALUES (391, 1, 49, 391);
INSERT INTO `cz_admin_group_func` VALUES (392, 1, 49, 392);
INSERT INTO `cz_admin_group_func` VALUES (393, 1, 50, 393);
INSERT INTO `cz_admin_group_func` VALUES (394, 1, 50, 394);
INSERT INTO `cz_admin_group_func` VALUES (395, 1, 50, 395);
INSERT INTO `cz_admin_group_func` VALUES (396, 1, 50, 396);
INSERT INTO `cz_admin_group_func` VALUES (397, 1, 50, 397);
INSERT INTO `cz_admin_group_func` VALUES (398, 1, 50, 398);
INSERT INTO `cz_admin_group_func` VALUES (399, 1, 50, 399);
INSERT INTO `cz_admin_group_func` VALUES (400, 1, 50, 400);
INSERT INTO `cz_admin_group_func` VALUES (401, 1, 51, 401);
INSERT INTO `cz_admin_group_func` VALUES (402, 1, 51, 402);
INSERT INTO `cz_admin_group_func` VALUES (403, 1, 51, 403);
INSERT INTO `cz_admin_group_func` VALUES (404, 1, 51, 404);
INSERT INTO `cz_admin_group_func` VALUES (405, 1, 51, 405);
INSERT INTO `cz_admin_group_func` VALUES (406, 1, 51, 406);
INSERT INTO `cz_admin_group_func` VALUES (407, 1, 51, 407);
INSERT INTO `cz_admin_group_func` VALUES (408, 1, 51, 408);
INSERT INTO `cz_admin_group_func` VALUES (409, 1, 52, 409);
INSERT INTO `cz_admin_group_func` VALUES (410, 1, 52, 410);
INSERT INTO `cz_admin_group_func` VALUES (411, 1, 52, 411);
INSERT INTO `cz_admin_group_func` VALUES (412, 1, 52, 412);
INSERT INTO `cz_admin_group_func` VALUES (413, 1, 52, 413);
INSERT INTO `cz_admin_group_func` VALUES (414, 1, 52, 414);
INSERT INTO `cz_admin_group_func` VALUES (415, 1, 52, 415);
INSERT INTO `cz_admin_group_func` VALUES (416, 1, 52, 416);
INSERT INTO `cz_admin_group_func` VALUES (417, 1, 53, 417);
INSERT INTO `cz_admin_group_func` VALUES (418, 1, 53, 418);
INSERT INTO `cz_admin_group_func` VALUES (419, 1, 53, 419);
INSERT INTO `cz_admin_group_func` VALUES (420, 1, 53, 420);
INSERT INTO `cz_admin_group_func` VALUES (421, 1, 53, 421);
INSERT INTO `cz_admin_group_func` VALUES (422, 1, 53, 422);
INSERT INTO `cz_admin_group_func` VALUES (423, 1, 53, 423);
INSERT INTO `cz_admin_group_func` VALUES (424, 1, 53, 424);
INSERT INTO `cz_admin_group_func` VALUES (425, 1, 54, 425);
INSERT INTO `cz_admin_group_func` VALUES (426, 1, 54, 426);
INSERT INTO `cz_admin_group_func` VALUES (427, 1, 54, 427);
INSERT INTO `cz_admin_group_func` VALUES (428, 1, 54, 428);
INSERT INTO `cz_admin_group_func` VALUES (429, 1, 54, 429);
INSERT INTO `cz_admin_group_func` VALUES (430, 1, 54, 430);
INSERT INTO `cz_admin_group_func` VALUES (431, 1, 54, 431);
INSERT INTO `cz_admin_group_func` VALUES (432, 1, 54, 432);
INSERT INTO `cz_admin_group_func` VALUES (433, 1, 55, 433);
INSERT INTO `cz_admin_group_func` VALUES (434, 1, 55, 434);
INSERT INTO `cz_admin_group_func` VALUES (435, 1, 55, 435);
INSERT INTO `cz_admin_group_func` VALUES (436, 1, 55, 436);
INSERT INTO `cz_admin_group_func` VALUES (437, 1, 55, 437);
INSERT INTO `cz_admin_group_func` VALUES (438, 1, 55, 438);
INSERT INTO `cz_admin_group_func` VALUES (439, 1, 55, 439);
INSERT INTO `cz_admin_group_func` VALUES (440, 1, 55, 440);
INSERT INTO `cz_admin_group_func` VALUES (441, 1, 56, 441);
INSERT INTO `cz_admin_group_func` VALUES (442, 1, 56, 442);
INSERT INTO `cz_admin_group_func` VALUES (443, 1, 56, 443);
INSERT INTO `cz_admin_group_func` VALUES (444, 1, 56, 444);
INSERT INTO `cz_admin_group_func` VALUES (445, 1, 56, 445);
INSERT INTO `cz_admin_group_func` VALUES (446, 1, 56, 446);
INSERT INTO `cz_admin_group_func` VALUES (447, 1, 56, 447);
INSERT INTO `cz_admin_group_func` VALUES (448, 1, 56, 448);
INSERT INTO `cz_admin_group_func` VALUES (457, 1, 58, 457);
INSERT INTO `cz_admin_group_func` VALUES (458, 1, 58, 458);
INSERT INTO `cz_admin_group_func` VALUES (459, 1, 58, 459);
INSERT INTO `cz_admin_group_func` VALUES (460, 1, 58, 460);
INSERT INTO `cz_admin_group_func` VALUES (461, 1, 58, 461);
INSERT INTO `cz_admin_group_func` VALUES (462, 1, 58, 462);
INSERT INTO `cz_admin_group_func` VALUES (463, 1, 58, 463);
INSERT INTO `cz_admin_group_func` VALUES (464, 1, 58, 464);
INSERT INTO `cz_admin_group_func` VALUES (466, 1, 59, 466);
INSERT INTO `cz_admin_group_func` VALUES (467, 1, 59, 467);
INSERT INTO `cz_admin_group_func` VALUES (468, 1, 59, 468);
INSERT INTO `cz_admin_group_func` VALUES (469, 1, 59, 469);
INSERT INTO `cz_admin_group_func` VALUES (470, 1, 59, 470);
INSERT INTO `cz_admin_group_func` VALUES (471, 1, 59, 471);
INSERT INTO `cz_admin_group_func` VALUES (472, 1, 59, 472);
INSERT INTO `cz_admin_group_func` VALUES (473, 1, 60, 473);
INSERT INTO `cz_admin_group_func` VALUES (474, 1, 60, 474);
INSERT INTO `cz_admin_group_func` VALUES (475, 1, 60, 475);
INSERT INTO `cz_admin_group_func` VALUES (476, 1, 60, 476);
INSERT INTO `cz_admin_group_func` VALUES (477, 1, 60, 477);
INSERT INTO `cz_admin_group_func` VALUES (478, 1, 60, 478);
INSERT INTO `cz_admin_group_func` VALUES (479, 1, 60, 479);
INSERT INTO `cz_admin_group_func` VALUES (480, 1, 60, 480);
INSERT INTO `cz_admin_group_func` VALUES (481, 1, 61, 481);
INSERT INTO `cz_admin_group_func` VALUES (482, 1, 61, 482);
INSERT INTO `cz_admin_group_func` VALUES (483, 1, 61, 483);
INSERT INTO `cz_admin_group_func` VALUES (484, 1, 61, 484);
INSERT INTO `cz_admin_group_func` VALUES (485, 1, 61, 485);
INSERT INTO `cz_admin_group_func` VALUES (486, 1, 61, 486);
INSERT INTO `cz_admin_group_func` VALUES (487, 1, 61, 487);
INSERT INTO `cz_admin_group_func` VALUES (488, 1, 61, 488);
INSERT INTO `cz_admin_group_func` VALUES (489, 1, 62, 489);
INSERT INTO `cz_admin_group_func` VALUES (490, 1, 62, 490);
INSERT INTO `cz_admin_group_func` VALUES (491, 1, 62, 491);
INSERT INTO `cz_admin_group_func` VALUES (492, 1, 62, 492);
INSERT INTO `cz_admin_group_func` VALUES (493, 1, 62, 493);
INSERT INTO `cz_admin_group_func` VALUES (494, 1, 62, 494);
INSERT INTO `cz_admin_group_func` VALUES (495, 1, 62, 495);
INSERT INTO `cz_admin_group_func` VALUES (496, 1, 62, 496);
INSERT INTO `cz_admin_group_func` VALUES (497, 1, 63, 497);
INSERT INTO `cz_admin_group_func` VALUES (498, 1, 63, 498);
INSERT INTO `cz_admin_group_func` VALUES (499, 1, 63, 499);
INSERT INTO `cz_admin_group_func` VALUES (500, 1, 63, 500);
INSERT INTO `cz_admin_group_func` VALUES (501, 1, 63, 501);
INSERT INTO `cz_admin_group_func` VALUES (502, 1, 63, 502);
INSERT INTO `cz_admin_group_func` VALUES (503, 1, 63, 503);
INSERT INTO `cz_admin_group_func` VALUES (504, 1, 63, 504);
INSERT INTO `cz_admin_group_func` VALUES (505, 1, 64, 505);
INSERT INTO `cz_admin_group_func` VALUES (506, 1, 64, 506);
INSERT INTO `cz_admin_group_func` VALUES (507, 1, 64, 507);
INSERT INTO `cz_admin_group_func` VALUES (508, 1, 64, 508);
INSERT INTO `cz_admin_group_func` VALUES (509, 1, 64, 509);
INSERT INTO `cz_admin_group_func` VALUES (510, 1, 64, 510);
INSERT INTO `cz_admin_group_func` VALUES (511, 1, 64, 511);
INSERT INTO `cz_admin_group_func` VALUES (512, 1, 64, 512);
INSERT INTO `cz_admin_group_func` VALUES (513, 1, 65, 513);
INSERT INTO `cz_admin_group_func` VALUES (514, 1, 65, 514);
INSERT INTO `cz_admin_group_func` VALUES (515, 1, 65, 515);
INSERT INTO `cz_admin_group_func` VALUES (516, 1, 65, 516);
INSERT INTO `cz_admin_group_func` VALUES (517, 1, 65, 517);
INSERT INTO `cz_admin_group_func` VALUES (518, 1, 65, 518);
INSERT INTO `cz_admin_group_func` VALUES (519, 1, 65, 519);
INSERT INTO `cz_admin_group_func` VALUES (520, 1, 65, 520);
INSERT INTO `cz_admin_group_func` VALUES (521, 1, 66, 521);
INSERT INTO `cz_admin_group_func` VALUES (522, 1, 66, 522);
INSERT INTO `cz_admin_group_func` VALUES (523, 1, 66, 523);
INSERT INTO `cz_admin_group_func` VALUES (524, 1, 66, 524);
INSERT INTO `cz_admin_group_func` VALUES (525, 1, 66, 525);
INSERT INTO `cz_admin_group_func` VALUES (526, 1, 66, 526);
INSERT INTO `cz_admin_group_func` VALUES (527, 1, 66, 527);
INSERT INTO `cz_admin_group_func` VALUES (528, 1, 66, 528);
INSERT INTO `cz_admin_group_func` VALUES (529, 1, 67, 529);
INSERT INTO `cz_admin_group_func` VALUES (530, 1, 67, 530);
INSERT INTO `cz_admin_group_func` VALUES (531, 1, 67, 531);
INSERT INTO `cz_admin_group_func` VALUES (532, 1, 67, 532);
INSERT INTO `cz_admin_group_func` VALUES (533, 1, 67, 533);
INSERT INTO `cz_admin_group_func` VALUES (534, 1, 67, 534);
INSERT INTO `cz_admin_group_func` VALUES (535, 1, 67, 535);
INSERT INTO `cz_admin_group_func` VALUES (536, 1, 67, 536);
INSERT INTO `cz_admin_group_func` VALUES (537, 2, 59, 466);
INSERT INTO `cz_admin_group_func` VALUES (538, 3, 59, 466);
INSERT INTO `cz_admin_group_func` VALUES (541, 1, 68, 537);
INSERT INTO `cz_admin_group_func` VALUES (542, 1, 68, 538);
INSERT INTO `cz_admin_group_func` VALUES (543, 1, 68, 539);
INSERT INTO `cz_admin_group_func` VALUES (544, 1, 68, 540);
INSERT INTO `cz_admin_group_func` VALUES (545, 1, 68, 541);
INSERT INTO `cz_admin_group_func` VALUES (546, 1, 68, 542);
INSERT INTO `cz_admin_group_func` VALUES (547, 1, 68, 543);
INSERT INTO `cz_admin_group_func` VALUES (548, 1, 68, 544);
INSERT INTO `cz_admin_group_func` VALUES (549, 1, 59, 465);
INSERT INTO `cz_admin_group_func` VALUES (550, 2, 59, 465);
INSERT INTO `cz_admin_group_func` VALUES (551, 3, 59, 465);
INSERT INTO `cz_admin_group_func` VALUES (553, 1, 69, 545);
INSERT INTO `cz_admin_group_func` VALUES (554, 1, 69, 546);
INSERT INTO `cz_admin_group_func` VALUES (555, 1, 69, 547);
INSERT INTO `cz_admin_group_func` VALUES (556, 1, 69, 548);
INSERT INTO `cz_admin_group_func` VALUES (557, 1, 69, 549);
INSERT INTO `cz_admin_group_func` VALUES (558, 1, 69, 550);
INSERT INTO `cz_admin_group_func` VALUES (559, 1, 69, 551);
INSERT INTO `cz_admin_group_func` VALUES (560, 1, 69, 552);
INSERT INTO `cz_admin_group_func` VALUES (586, 1, 73, 578);
INSERT INTO `cz_admin_group_func` VALUES (587, 1, 73, 579);
INSERT INTO `cz_admin_group_func` VALUES (588, 1, 73, 580);
INSERT INTO `cz_admin_group_func` VALUES (589, 1, 73, 581);
INSERT INTO `cz_admin_group_func` VALUES (590, 1, 73, 582);
INSERT INTO `cz_admin_group_func` VALUES (591, 1, 73, 583);
INSERT INTO `cz_admin_group_func` VALUES (592, 1, 73, 584);
INSERT INTO `cz_admin_group_func` VALUES (593, 1, 73, 585);
INSERT INTO `cz_admin_group_func` VALUES (594, 1, 74, 586);
INSERT INTO `cz_admin_group_func` VALUES (595, 1, 74, 587);
INSERT INTO `cz_admin_group_func` VALUES (596, 1, 74, 588);
INSERT INTO `cz_admin_group_func` VALUES (597, 1, 74, 589);
INSERT INTO `cz_admin_group_func` VALUES (598, 1, 74, 590);
INSERT INTO `cz_admin_group_func` VALUES (599, 1, 74, 591);
INSERT INTO `cz_admin_group_func` VALUES (600, 1, 74, 592);
INSERT INTO `cz_admin_group_func` VALUES (601, 1, 74, 593);
INSERT INTO `cz_admin_group_func` VALUES (602, 1, 75, 594);
INSERT INTO `cz_admin_group_func` VALUES (603, 1, 75, 595);
INSERT INTO `cz_admin_group_func` VALUES (604, 1, 75, 596);
INSERT INTO `cz_admin_group_func` VALUES (605, 1, 75, 597);
INSERT INTO `cz_admin_group_func` VALUES (606, 1, 75, 598);
INSERT INTO `cz_admin_group_func` VALUES (607, 1, 75, 599);
INSERT INTO `cz_admin_group_func` VALUES (608, 1, 75, 600);
INSERT INTO `cz_admin_group_func` VALUES (609, 1, 75, 601);
INSERT INTO `cz_admin_group_func` VALUES (610, 1, 76, 602);
INSERT INTO `cz_admin_group_func` VALUES (611, 1, 76, 603);
INSERT INTO `cz_admin_group_func` VALUES (612, 1, 76, 604);
INSERT INTO `cz_admin_group_func` VALUES (613, 1, 76, 605);
INSERT INTO `cz_admin_group_func` VALUES (614, 1, 76, 606);
INSERT INTO `cz_admin_group_func` VALUES (615, 1, 76, 607);
INSERT INTO `cz_admin_group_func` VALUES (616, 1, 76, 608);
INSERT INTO `cz_admin_group_func` VALUES (617, 1, 76, 609);
INSERT INTO `cz_admin_group_func` VALUES (618, 1, 77, 610);
INSERT INTO `cz_admin_group_func` VALUES (619, 1, 77, 611);
INSERT INTO `cz_admin_group_func` VALUES (620, 1, 77, 612);
INSERT INTO `cz_admin_group_func` VALUES (621, 1, 77, 613);
INSERT INTO `cz_admin_group_func` VALUES (622, 1, 77, 614);
INSERT INTO `cz_admin_group_func` VALUES (623, 1, 77, 615);
INSERT INTO `cz_admin_group_func` VALUES (624, 1, 77, 616);
INSERT INTO `cz_admin_group_func` VALUES (625, 1, 77, 617);
INSERT INTO `cz_admin_group_func` VALUES (626, 1, 78, 618);
INSERT INTO `cz_admin_group_func` VALUES (627, 1, 78, 619);
INSERT INTO `cz_admin_group_func` VALUES (628, 1, 78, 620);
INSERT INTO `cz_admin_group_func` VALUES (629, 1, 78, 621);
INSERT INTO `cz_admin_group_func` VALUES (630, 1, 78, 622);
INSERT INTO `cz_admin_group_func` VALUES (631, 1, 78, 623);
INSERT INTO `cz_admin_group_func` VALUES (632, 1, 78, 624);
INSERT INTO `cz_admin_group_func` VALUES (633, 1, 78, 625);
INSERT INTO `cz_admin_group_func` VALUES (634, 1, 79, 626);
INSERT INTO `cz_admin_group_func` VALUES (635, 1, 79, 627);
INSERT INTO `cz_admin_group_func` VALUES (636, 1, 79, 628);
INSERT INTO `cz_admin_group_func` VALUES (637, 1, 79, 629);
INSERT INTO `cz_admin_group_func` VALUES (638, 1, 79, 630);
INSERT INTO `cz_admin_group_func` VALUES (639, 1, 79, 631);
INSERT INTO `cz_admin_group_func` VALUES (640, 1, 79, 632);
INSERT INTO `cz_admin_group_func` VALUES (641, 1, 79, 633);
INSERT INTO `cz_admin_group_func` VALUES (642, 1, 80, 634);
INSERT INTO `cz_admin_group_func` VALUES (643, 1, 80, 635);
INSERT INTO `cz_admin_group_func` VALUES (644, 1, 80, 636);
INSERT INTO `cz_admin_group_func` VALUES (645, 1, 80, 637);
INSERT INTO `cz_admin_group_func` VALUES (646, 1, 80, 638);
INSERT INTO `cz_admin_group_func` VALUES (647, 1, 80, 639);
INSERT INTO `cz_admin_group_func` VALUES (648, 1, 80, 640);
INSERT INTO `cz_admin_group_func` VALUES (649, 1, 80, 641);
INSERT INTO `cz_admin_group_func` VALUES (650, 1, 81, 642);
INSERT INTO `cz_admin_group_func` VALUES (651, 1, 81, 643);
INSERT INTO `cz_admin_group_func` VALUES (652, 1, 81, 644);
INSERT INTO `cz_admin_group_func` VALUES (653, 1, 81, 645);
INSERT INTO `cz_admin_group_func` VALUES (654, 1, 81, 646);
INSERT INTO `cz_admin_group_func` VALUES (655, 1, 81, 647);
INSERT INTO `cz_admin_group_func` VALUES (656, 1, 81, 648);
INSERT INTO `cz_admin_group_func` VALUES (657, 1, 81, 649);
INSERT INTO `cz_admin_group_func` VALUES (658, 1, 82, 650);
INSERT INTO `cz_admin_group_func` VALUES (659, 1, 82, 651);
INSERT INTO `cz_admin_group_func` VALUES (660, 1, 82, 652);
INSERT INTO `cz_admin_group_func` VALUES (661, 1, 82, 653);
INSERT INTO `cz_admin_group_func` VALUES (662, 1, 82, 654);
INSERT INTO `cz_admin_group_func` VALUES (663, 1, 82, 655);
INSERT INTO `cz_admin_group_func` VALUES (664, 1, 82, 656);
INSERT INTO `cz_admin_group_func` VALUES (665, 1, 82, 657);
INSERT INTO `cz_admin_group_func` VALUES (666, 1, 83, 658);
INSERT INTO `cz_admin_group_func` VALUES (667, 1, 83, 659);
INSERT INTO `cz_admin_group_func` VALUES (668, 1, 83, 660);
INSERT INTO `cz_admin_group_func` VALUES (669, 1, 83, 661);
INSERT INTO `cz_admin_group_func` VALUES (670, 1, 83, 662);
INSERT INTO `cz_admin_group_func` VALUES (671, 1, 83, 663);
INSERT INTO `cz_admin_group_func` VALUES (672, 1, 83, 664);
INSERT INTO `cz_admin_group_func` VALUES (673, 1, 83, 665);
INSERT INTO `cz_admin_group_func` VALUES (674, 1, 84, 666);
INSERT INTO `cz_admin_group_func` VALUES (675, 1, 84, 667);
INSERT INTO `cz_admin_group_func` VALUES (676, 1, 84, 668);
INSERT INTO `cz_admin_group_func` VALUES (677, 1, 84, 669);
INSERT INTO `cz_admin_group_func` VALUES (678, 1, 84, 670);
INSERT INTO `cz_admin_group_func` VALUES (679, 1, 84, 671);
INSERT INTO `cz_admin_group_func` VALUES (680, 1, 84, 672);
INSERT INTO `cz_admin_group_func` VALUES (681, 1, 84, 673);

-- ----------------------------
-- Table structure for cz_admin_group_nav
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_group_nav`;
CREATE TABLE `cz_admin_group_nav`  (
  `id` int unsigned NOT NULL COMMENT '后台管理员分组-后台菜单中间表id，自增',
  `gid` int(0) DEFAULT NULL COMMENT '关联后台管理员分组表主键id',
  `nid` int(0) DEFAULT NULL COMMENT '关联后台菜单表主键id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_group_nav
-- ----------------------------
INSERT INTO `cz_admin_group_nav` VALUES (2, 1, 14);
INSERT INTO `cz_admin_group_nav` VALUES (8, 3, 14);
INSERT INTO `cz_admin_group_nav` VALUES (17, 1, 27);
INSERT INTO `cz_admin_group_nav` VALUES (18, 1, 28);
INSERT INTO `cz_admin_group_nav` VALUES (19, 1, 29);
INSERT INTO `cz_admin_group_nav` VALUES (20, 1, 30);
INSERT INTO `cz_admin_group_nav` VALUES (21, 1, 31);
INSERT INTO `cz_admin_group_nav` VALUES (22, 1, 32);
INSERT INTO `cz_admin_group_nav` VALUES (23, 1, 33);
INSERT INTO `cz_admin_group_nav` VALUES (24, 1, 34);
INSERT INTO `cz_admin_group_nav` VALUES (25, 1, 35);

-- ----------------------------
-- Table structure for cz_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_log`;
CREATE TABLE `cz_admin_log`  (
  `id` int unsigned NOT NULL COMMENT '管理员操作日志id',
  `uid` int(0) DEFAULT NULL COMMENT '管理员id',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员登录账号',
  `log_time` int(0) DEFAULT NULL COMMENT '操作时间',
  `login_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '登录ip',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '操作标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '操作内容',
  `is_dev` int(0) DEFAULT 1 COMMENT '是否开发者账号 0否 1是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 761 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cz_admin_model_detail
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_model_detail`;
CREATE TABLE `cz_admin_model_detail`  (
  `id` int unsigned NOT NULL,
  `tablename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '数据表名字，也是模型名字',
  `colname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '字段的英文名称',
  `explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '字段说明',
  `isshow` int(0) NOT NULL COMMENT '是否显示',
  `isview` int(0) DEFAULT 1 COMMENT '是否在详情页显示 1显示 0不显示',
  `isedit` int(0) NOT NULL DEFAULT 1 COMMENT '是否可以编辑，1可编辑，0不可编辑',
  `ordernum` int(0) NOT NULL DEFAULT 1 COMMENT '排序，值越小，就显示在越前面',
  `isunique` int(0) DEFAULT 0 COMMENT '是否唯一键 0否 1是',
  `type` int(0) DEFAULT 0 COMMENT '字段类型 0为字符串 1为多个状态值 2为两个状态值 3为文章 4为图片 5为时间戳 6为整数 7为浮点数 8为外键',
  `typeexplain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '字段类型说明',
  `issort` int(0) DEFAULT 0 COMMENT '是否支持排序 0否 1是',
  `isrequire` int(0) DEFAULT 1 COMMENT '是否必填 0否 1是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 806 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_model_detail
-- ----------------------------
INSERT INTO `cz_admin_model_detail` VALUES (806, 'trader.price_BTC-USDT', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (807, 'trader.price_BTC-USDT', 'pair', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (808, 'trader.price_BTC-USDT', 'price', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (809, 'trader.price_BTC-USDT', 'timedate', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (810, 'trader.price_BTC-USDT', 'type', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (811, 'trader.price_EOS-USDT', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (812, 'trader.price_EOS-USDT', 'pair', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (813, 'trader.price_EOS-USDT', 'price', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (814, 'trader.price_EOS-USDT', 'timedate', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (815, 'trader.price_EOS-USDT', 'type', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (816, 'trader.price_ETH-USDT', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (817, 'trader.price_ETH-USDT', 'pair', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (818, 'trader.price_ETH-USDT', 'price', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (819, 'trader.price_ETH-USDT', 'timedate', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (820, 'trader.price_ETH-USDT', 'type', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (821, 'trader.record_BTC-USDT', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (822, 'trader.record_BTC-USDT', 'type', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (823, 'trader.record_BTC-USDT', 'currency', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (824, 'trader.record_BTC-USDT', 'price', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (825, 'trader.record_BTC-USDT', 'timedate', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (826, 'trader.record_BTC-USDT', 'code', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (827, 'trader.record_BTC-USDT', 'complete', '', 1, 1, 1, 7, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (828, 'trader.record_BTC-USDT', 'suc', '', 1, 1, 1, 8, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (829, 'trader.record_BTC-USDT', 'profit', '', 1, 1, 1, 9, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (830, 'trader.record_EOS-USDT', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (831, 'trader.record_EOS-USDT', 'type', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (832, 'trader.record_EOS-USDT', 'currency', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (833, 'trader.record_EOS-USDT', 'price', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (834, 'trader.record_EOS-USDT', 'timedate', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (835, 'trader.record_EOS-USDT', 'code', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (836, 'trader.record_EOS-USDT', 'complete', '', 1, 1, 1, 7, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (837, 'trader.record_EOS-USDT', 'suc', '', 1, 1, 1, 8, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (838, 'trader.record_EOS-USDT', 'profit', '', 1, 1, 1, 9, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (839, 'trader.record_ETH-USDT', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (840, 'trader.record_ETH-USDT', 'type', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (841, 'trader.record_ETH-USDT', 'currency', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (842, 'trader.record_ETH-USDT', 'price', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (843, 'trader.record_ETH-USDT', 'timedate', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (844, 'trader.record_ETH-USDT', 'code', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (845, 'trader.record_ETH-USDT', 'complete', '', 1, 1, 1, 7, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (846, 'trader.record_ETH-USDT', 'suc', '', 1, 1, 1, 8, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (847, 'trader.record_ETH-USDT', 'profit', '', 1, 1, 1, 9, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (848, 'tchecker_paint.records', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (849, 'tchecker_paint.records', 'pair', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (850, 'tchecker_paint.records', 'addtime', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (851, 'tchecker_paint.records', 'time_sep', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (852, 'tchecker_paint.records', 'command_params', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (853, 'tchecker_paint.records', 'result_str', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (854, 'tchecker.tchecker_eventlog', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (855, 'tchecker.tchecker_eventlog', 'content', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (856, 'tchecker.tchecker_eventlog', 'add_date', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (857, 'tchecker.tchecker_eventlog', 'bind_mark', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (858, 'tchecker.tchecker_pushlog', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (859, 'tchecker.tchecker_pushlog', 'type', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (860, 'tchecker.tchecker_pushlog', 'currency', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (861, 'tchecker.tchecker_pushlog', 'price', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (862, 'tchecker.tchecker_pushlog', 'timedate', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (863, 'tchecker.tchecker_pushlog', 'code', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (864, 'tchecker.tchecker_pushlog', 'complete', '', 1, 1, 1, 7, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (865, 'tchecker.tchecker_pushlog', 'suc', '', 1, 1, 1, 8, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (866, 'tchecker.tchecker_pushlog', 'profit', '', 1, 1, 1, 9, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (867, 'tchecker.tchecker_pushlog', 'wx_token', '', 1, 1, 1, 10, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (868, 'tchecker.tchecker_pushlog', 'status', '', 1, 1, 1, 11, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (869, 'tchecker.tchecker_pushlog', 'msg', '', 1, 1, 1, 12, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (870, 'tchecker.tchecker_pushlog', 'pair', '', 1, 1, 1, 13, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (871, 'tchecker.tchecker_pushlog', 'level', '', 1, 1, 1, 14, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (872, 'tchecker.tchecker_registercode', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (873, 'tchecker.tchecker_registercode', 'status', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (874, 'tchecker.tchecker_registercode', 'bind_mac', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (875, 'tchecker.tchecker_registercode', 'bind_pm', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (876, 'tchecker.tchecker_registercode', 'used_time', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (877, 'tchecker.tchecker_registercode', 'used_date', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (878, 'tchecker.tchecker_registercode', 'service_name', '', 1, 1, 1, 7, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (879, 'tchecker.tchecker_registercode', 'day', '', 1, 1, 1, 8, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (880, 'tchecker.tchecker_registercode', 'create_date', '', 1, 1, 1, 9, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (881, 'tchecker.tchecker_registercode', 'rcode', '', 1, 1, 1, 10, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (882, 'tchecker.tchecker_registercode', 'bind_uid', '', 1, 1, 1, 11, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (883, 'tchecker.tchecker_registercode', 'is_vip', '', 1, 1, 1, 12, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (884, 'tchecker.tchecker_service', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (885, 'tchecker.tchecker_service', 'name', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (886, 'tchecker.tchecker_service', 'phone', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (887, 'tchecker.tchecker_service', 'info', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (888, 'tchecker.tchecker_service', 'create_date', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (889, 'tchecker.tchecker_service', 'version_name', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (890, 'tchecker.tchecker_user', 'id', '', 1, 1, 0, 1, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (891, 'tchecker.tchecker_user', 'mac', '', 1, 1, 1, 2, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (892, 'tchecker.tchecker_user', 'service_name', '', 1, 1, 1, 3, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (893, 'tchecker.tchecker_user', 'expire_time', '', 1, 1, 1, 4, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (894, 'tchecker.tchecker_user', 'last_register_code', '', 1, 1, 1, 5, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (895, 'tchecker.tchecker_user', 'register_date', '', 1, 1, 1, 6, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (896, 'tchecker.tchecker_user', 'last_login_ip', '', 1, 1, 1, 7, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (897, 'tchecker.tchecker_user', 'status', '', 1, 1, 1, 8, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (898, 'tchecker.tchecker_user', 'pm', '', 1, 1, 1, 9, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (899, 'tchecker.tchecker_user', 'os', '', 1, 1, 1, 10, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (900, 'tchecker.tchecker_user', 'last_login_date', '', 1, 1, 1, 11, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (901, 'tchecker.tchecker_user', 'last_login_time', '', 1, 1, 1, 12, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (902, 'tchecker.tchecker_user', 'expire_date', '', 1, 1, 1, 13, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (903, 'tchecker.tchecker_user', 'register_time', '', 1, 1, 1, 14, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (904, 'tchecker.tchecker_user', 'uid', '', 1, 1, 1, 15, 0, 0, NULL, 0, 1);
INSERT INTO `cz_admin_model_detail` VALUES (905, 'tchecker.tchecker_user', 'is_vip', '', 1, 1, 1, 16, 0, 0, NULL, 0, 1);

-- ----------------------------
-- Table structure for cz_admin_model_fk
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_model_fk`;
CREATE TABLE `cz_admin_model_fk`  (
  `id` int unsigned NOT NULL COMMENT '模型外键关联表id',
  `mid` int(0) DEFAULT NULL COMMENT '主表id',
  `mtablename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '主表表名',
  `mmodelname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '主表模型名',
  `mcolname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '主表字段英文名',
  `mexplain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '主表字段说明',
  `fid` int(0) DEFAULT NULL COMMENT '关联表id',
  `ftablename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '关联表表名',
  `fmodelname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '关联表模型名',
  `funival` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '关联表映射字段名称',
  `fcolname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '关联表字段英文名',
  `fexplain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '关联表字段说明',
  `updatetime` int(0) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cz_admin_model_menufunc
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_model_menufunc`;
CREATE TABLE `cz_admin_model_menufunc`  (
  `id` int unsigned NOT NULL COMMENT '模型菜单功能表id',
  `mid` int(0) DEFAULT NULL COMMENT '模型id',
  `menuid` int(0) DEFAULT NULL COMMENT '菜单id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '功能按钮名称',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '功能代号(英文)',
  `type` int(0) DEFAULT 0 COMMENT '类型 0自定义功能 1添加 2编辑 3删除 4显示详情 5搜索 6自定义显示列 7导出Excel 8打印列表 9导出excel',
  `apiaddr` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '接口地址',
  `status` int(0) DEFAULT 1 COMMENT '状态 0关闭 1为开启',
  `updatetime` int(0) DEFAULT NULL COMMENT '修改时间',
  `type_window` int(0) DEFAULT 0 COMMENT '自定义功能打开方式类型 0新页面 1弹窗',
  `type_button` int(0) DEFAULT 0 COMMENT '功能按钮位置 0列表操作 1顶端',
  `type_multi` int(0) DEFAULT 0 COMMENT '是否多状态按钮 0否 1是',
  `model_detail_id` int(0) DEFAULT 0 COMMENT '多状态功能关联模型字段id',
  `model_detail_colname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '多功能状态关联模型字段名称',
  `model_detail_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '多状态功能关联模型字段值',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 578 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_model_menufunc
-- ----------------------------
INSERT INTO `cz_admin_model_menufunc` VALUES (9, 2, 0, '添加', 'add', 1, NULL, 0, 1588151702, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (10, 2, 0, '编辑', 'edit', 2, NULL, 1, 1588151702, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (11, 2, 0, '删除', 'del', 3, NULL, 1, 1588151702, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (12, 2, 0, '显示详情', 'view', 4, NULL, 1, 1588151702, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (13, 2, 0, '搜索', 'search', 5, NULL, 1, 1588151702, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (14, 2, 0, '自定义显示列', 'costom', 6, NULL, 1, 1588151702, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (15, 2, 0, '导出Excel', 'loadexcel', 7, NULL, 1, 1588151702, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (16, 2, 0, '打印列表', 'print', 8, NULL, 1, 1588151702, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (17, 3, NULL, '添加', 'add', 1, NULL, 1, 1588154048, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (18, 3, NULL, '编辑', 'edit', 2, NULL, 1, 1588154048, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (19, 3, NULL, '删除', 'del', 3, NULL, 1, 1588154048, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (20, 3, NULL, '显示详情', 'view', 4, NULL, 1, 1588154048, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (21, 3, NULL, '搜索', 'search', 5, NULL, 1, 1588154048, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (22, 3, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154048, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (23, 3, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154048, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (24, 3, NULL, '打印列表', 'print', 8, NULL, 1, 1588154048, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (25, 4, NULL, '添加', 'add', 1, NULL, 1, 1588154103, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (26, 4, NULL, '编辑', 'edit', 2, NULL, 1, 1588154103, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (27, 4, NULL, '删除', 'del', 3, NULL, 1, 1588154103, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (28, 4, NULL, '显示详情', 'view', 4, NULL, 1, 1588154103, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (29, 4, NULL, '搜索', 'search', 5, NULL, 1, 1588154103, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (30, 4, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154103, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (31, 4, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154103, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (32, 4, NULL, '打印列表', 'print', 8, NULL, 1, 1588154103, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (33, 5, NULL, '添加', 'add', 1, NULL, 1, 1588154114, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (34, 5, NULL, '编辑', 'edit', 2, NULL, 1, 1588154114, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (35, 5, NULL, '删除', 'del', 3, NULL, 1, 1588154114, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (36, 5, NULL, '显示详情', 'view', 4, NULL, 1, 1588154114, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (37, 5, NULL, '搜索', 'search', 5, NULL, 1, 1588154114, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (38, 5, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154114, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (39, 5, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154114, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (40, 5, NULL, '打印列表', 'print', 8, NULL, 1, 1588154114, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (41, 6, NULL, '添加', 'add', 1, NULL, 1, 1588154119, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (42, 6, NULL, '编辑', 'edit', 2, NULL, 1, 1588154119, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (43, 6, NULL, '删除', 'del', 3, NULL, 1, 1588154119, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (44, 6, NULL, '显示详情', 'view', 4, NULL, 1, 1588154119, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (45, 6, NULL, '搜索', 'search', 5, NULL, 1, 1588154119, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (46, 6, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154119, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (47, 6, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154119, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (48, 6, NULL, '打印列表', 'print', 8, NULL, 1, 1588154119, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (49, 7, NULL, '添加', 'add', 1, NULL, 1, 1588154130, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (50, 7, NULL, '编辑', 'edit', 2, NULL, 1, 1588154130, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (51, 7, NULL, '删除', 'del', 3, NULL, 1, 1588154130, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (52, 7, NULL, '显示详情', 'view', 4, NULL, 1, 1588154130, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (53, 7, NULL, '搜索', 'search', 5, NULL, 1, 1588154130, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (54, 7, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154130, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (55, 7, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154130, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (56, 7, NULL, '打印列表', 'print', 8, NULL, 1, 1588154130, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (57, 8, NULL, '添加', 'add', 1, NULL, 1, 1588154135, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (58, 8, NULL, '编辑', 'edit', 2, NULL, 1, 1588154135, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (59, 8, NULL, '删除', 'del', 3, NULL, 1, 1588154135, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (60, 8, NULL, '显示详情', 'view', 4, NULL, 1, 1588154135, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (61, 8, NULL, '搜索', 'search', 5, NULL, 1, 1588154135, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (62, 8, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154135, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (63, 8, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154135, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (64, 8, NULL, '打印列表', 'print', 8, NULL, 1, 1588154135, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (65, 9, NULL, '添加', 'add', 1, NULL, 1, 1588154144, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (66, 9, NULL, '编辑', 'edit', 2, NULL, 1, 1588154144, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (67, 9, NULL, '删除', 'del', 3, NULL, 1, 1588154144, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (68, 9, NULL, '显示详情', 'view', 4, NULL, 1, 1588154144, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (69, 9, NULL, '搜索', 'search', 5, NULL, 1, 1588154144, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (70, 9, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154144, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (71, 9, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154144, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (72, 9, NULL, '打印列表', 'print', 8, NULL, 1, 1588154144, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (73, 10, NULL, '添加', 'add', 1, NULL, 1, 1588154152, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (74, 10, NULL, '编辑', 'edit', 2, NULL, 1, 1588154152, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (75, 10, NULL, '删除', 'del', 3, NULL, 1, 1588154152, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (76, 10, NULL, '显示详情', 'view', 4, NULL, 1, 1588154152, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (77, 10, NULL, '搜索', 'search', 5, NULL, 1, 1588154152, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (78, 10, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154152, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (79, 10, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154152, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (80, 10, NULL, '打印列表', 'print', 8, NULL, 1, 1588154152, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (81, 11, NULL, '添加', 'add', 1, NULL, 1, 1588154165, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (82, 11, NULL, '编辑', 'edit', 2, NULL, 1, 1588154165, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (83, 11, NULL, '删除', 'del', 3, NULL, 1, 1588154165, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (84, 11, NULL, '显示详情', 'view', 4, NULL, 1, 1588154165, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (85, 11, NULL, '搜索', 'search', 5, NULL, 1, 1588154165, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (86, 11, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154165, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (87, 11, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154165, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (88, 11, NULL, '打印列表', 'print', 8, NULL, 1, 1588154165, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (89, 12, NULL, '添加', 'add', 1, NULL, 1, 1588154173, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (90, 12, NULL, '编辑', 'edit', 2, NULL, 1, 1588154173, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (91, 12, NULL, '删除', 'del', 3, NULL, 1, 1588154173, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (92, 12, NULL, '显示详情', 'view', 4, NULL, 1, 1588154173, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (93, 12, NULL, '搜索', 'search', 5, NULL, 1, 1588154173, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (94, 12, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154173, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (95, 12, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154173, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (96, 12, NULL, '打印列表', 'print', 8, NULL, 1, 1588154173, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (97, 13, NULL, '添加', 'add', 1, NULL, 1, 1588154181, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (98, 13, NULL, '编辑', 'edit', 2, NULL, 1, 1588154181, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (99, 13, NULL, '删除', 'del', 3, NULL, 1, 1588154181, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (100, 13, NULL, '显示详情', 'view', 4, NULL, 1, 1588154181, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (101, 13, NULL, '搜索', 'search', 5, NULL, 1, 1588154181, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (102, 13, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154181, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (103, 13, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154181, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (104, 13, NULL, '打印列表', 'print', 8, NULL, 1, 1588154181, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (105, 14, NULL, '添加', 'add', 1, NULL, 1, 1588154193, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (106, 14, NULL, '编辑', 'edit', 2, NULL, 1, 1588154193, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (107, 14, NULL, '删除', 'del', 3, NULL, 1, 1588154193, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (108, 14, NULL, '显示详情', 'view', 4, NULL, 1, 1588154193, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (109, 14, NULL, '搜索', 'search', 5, NULL, 1, 1588154193, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (110, 14, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154193, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (111, 14, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154193, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (112, 14, NULL, '打印列表', 'print', 8, NULL, 1, 1588154193, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (113, 15, NULL, '添加', 'add', 1, NULL, 1, 1588154205, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (114, 15, NULL, '编辑', 'edit', 2, NULL, 1, 1588154205, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (115, 15, NULL, '删除', 'del', 3, NULL, 1, 1588154205, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (116, 15, NULL, '显示详情', 'view', 4, NULL, 1, 1588154205, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (117, 15, NULL, '搜索', 'search', 5, NULL, 1, 1588154205, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (118, 15, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154205, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (119, 15, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154205, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (120, 15, NULL, '打印列表', 'print', 8, NULL, 1, 1588154205, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (121, 16, NULL, '添加', 'add', 1, NULL, 1, 1588154243, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (122, 16, NULL, '编辑', 'edit', 2, NULL, 1, 1588154243, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (123, 16, NULL, '删除', 'del', 3, NULL, 1, 1588154243, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (124, 16, NULL, '显示详情', 'view', 4, NULL, 1, 1588154243, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (125, 16, NULL, '搜索', 'search', 5, NULL, 1, 1588154243, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (126, 16, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154243, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (127, 16, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154243, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (128, 16, NULL, '打印列表', 'print', 8, NULL, 1, 1588154243, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (129, 17, NULL, '添加', 'add', 1, NULL, 1, 1588154253, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (130, 17, NULL, '编辑', 'edit', 2, NULL, 1, 1588154253, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (131, 17, NULL, '删除', 'del', 3, NULL, 1, 1588154253, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (132, 17, NULL, '显示详情', 'view', 4, NULL, 1, 1588154253, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (133, 17, NULL, '搜索', 'search', 5, NULL, 1, 1588154253, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (134, 17, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154253, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (135, 17, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154253, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (136, 17, NULL, '打印列表', 'print', 8, NULL, 1, 1588154253, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (137, 18, NULL, '添加', 'add', 1, NULL, 1, 1588154275, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (138, 18, NULL, '编辑', 'edit', 2, NULL, 1, 1588154275, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (139, 18, NULL, '删除', 'del', 3, NULL, 1, 1588154275, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (140, 18, NULL, '显示详情', 'view', 4, NULL, 1, 1588154275, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (141, 18, NULL, '搜索', 'search', 5, NULL, 1, 1588154275, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (142, 18, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154275, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (143, 18, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154275, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (144, 18, NULL, '打印列表', 'print', 8, NULL, 1, 1588154275, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (145, 19, NULL, '添加', 'add', 1, NULL, 1, 1588154294, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (146, 19, NULL, '编辑', 'edit', 2, NULL, 1, 1588154294, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (147, 19, NULL, '删除', 'del', 3, NULL, 1, 1588154294, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (148, 19, NULL, '显示详情', 'view', 4, NULL, 1, 1588154294, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (149, 19, NULL, '搜索', 'search', 5, NULL, 1, 1588154294, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (150, 19, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154294, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (151, 19, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154294, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (152, 19, NULL, '打印列表', 'print', 8, NULL, 1, 1588154294, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (153, 20, NULL, '添加', 'add', 1, NULL, 1, 1588154319, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (154, 20, NULL, '编辑', 'edit', 2, NULL, 1, 1588154319, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (155, 20, NULL, '删除', 'del', 3, NULL, 1, 1588154319, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (156, 20, NULL, '显示详情', 'view', 4, NULL, 1, 1588154319, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (157, 20, NULL, '搜索', 'search', 5, NULL, 1, 1588154319, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (158, 20, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154319, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (159, 20, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154319, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (160, 20, NULL, '打印列表', 'print', 8, NULL, 1, 1588154319, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (161, 21, NULL, '添加', 'add', 1, NULL, 1, 1588154324, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (162, 21, NULL, '编辑', 'edit', 2, NULL, 1, 1588154324, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (163, 21, NULL, '删除', 'del', 3, NULL, 1, 1588154324, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (164, 21, NULL, '显示详情', 'view', 4, NULL, 1, 1588154324, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (165, 21, NULL, '搜索', 'search', 5, NULL, 1, 1588154324, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (166, 21, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154324, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (167, 21, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154324, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (168, 21, NULL, '打印列表', 'print', 8, NULL, 1, 1588154324, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (169, 22, NULL, '添加', 'add', 1, NULL, 1, 1588154388, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (170, 22, NULL, '编辑', 'edit', 2, NULL, 1, 1588154388, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (171, 22, NULL, '删除', 'del', 3, NULL, 1, 1588154388, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (172, 22, NULL, '显示详情', 'view', 4, NULL, 1, 1588154388, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (173, 22, NULL, '搜索', 'search', 5, NULL, 1, 1588154388, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (174, 22, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154388, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (175, 22, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154388, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (176, 22, NULL, '打印列表', 'print', 8, NULL, 1, 1588154388, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (177, 23, NULL, '添加', 'add', 1, NULL, 1, 1588154392, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (178, 23, NULL, '编辑', 'edit', 2, NULL, 1, 1588154392, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (179, 23, NULL, '删除', 'del', 3, NULL, 1, 1588154392, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (180, 23, NULL, '显示详情', 'view', 4, NULL, 1, 1588154392, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (181, 23, NULL, '搜索', 'search', 5, NULL, 1, 1588154392, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (182, 23, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154392, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (183, 23, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154392, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (184, 23, NULL, '打印列表', 'print', 8, NULL, 1, 1588154392, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (185, 24, NULL, '添加', 'add', 1, NULL, 1, 1588154397, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (186, 24, NULL, '编辑', 'edit', 2, NULL, 1, 1588154397, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (187, 24, NULL, '删除', 'del', 3, NULL, 1, 1588154397, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (188, 24, NULL, '显示详情', 'view', 4, NULL, 1, 1588154397, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (189, 24, NULL, '搜索', 'search', 5, NULL, 1, 1588154397, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (190, 24, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154397, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (191, 24, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154397, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (192, 24, NULL, '打印列表', 'print', 8, NULL, 1, 1588154397, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (193, 25, NULL, '添加', 'add', 1, NULL, 1, 1588154457, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (194, 25, NULL, '编辑', 'edit', 2, NULL, 1, 1588154457, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (195, 25, NULL, '删除', 'del', 3, NULL, 1, 1588154457, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (196, 25, NULL, '显示详情', 'view', 4, NULL, 1, 1588154457, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (197, 25, NULL, '搜索', 'search', 5, NULL, 1, 1588154457, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (198, 25, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154457, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (199, 25, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154457, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (200, 25, NULL, '打印列表', 'print', 8, NULL, 1, 1588154457, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (201, 26, NULL, '添加', 'add', 1, NULL, 1, 1588154465, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (202, 26, NULL, '编辑', 'edit', 2, NULL, 1, 1588154465, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (203, 26, NULL, '删除', 'del', 3, NULL, 1, 1588154465, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (204, 26, NULL, '显示详情', 'view', 4, NULL, 1, 1588154465, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (205, 26, NULL, '搜索', 'search', 5, NULL, 1, 1588154465, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (206, 26, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154465, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (207, 26, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154465, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (208, 26, NULL, '打印列表', 'print', 8, NULL, 1, 1588154465, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (209, 27, NULL, '添加', 'add', 1, NULL, 1, 1588154471, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (210, 27, NULL, '编辑', 'edit', 2, NULL, 1, 1588154471, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (211, 27, NULL, '删除', 'del', 3, NULL, 1, 1588154471, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (212, 27, NULL, '显示详情', 'view', 4, NULL, 1, 1588154471, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (213, 27, NULL, '搜索', 'search', 5, NULL, 1, 1588154471, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (214, 27, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154471, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (215, 27, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154471, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (216, 27, NULL, '打印列表', 'print', 8, NULL, 1, 1588154471, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (217, 28, NULL, '添加', 'add', 1, NULL, 1, 1588154480, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (218, 28, NULL, '编辑', 'edit', 2, NULL, 1, 1588154480, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (219, 28, NULL, '删除', 'del', 3, NULL, 1, 1588154480, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (220, 28, NULL, '显示详情', 'view', 4, NULL, 1, 1588154480, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (221, 28, NULL, '搜索', 'search', 5, NULL, 1, 1588154480, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (222, 28, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154480, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (223, 28, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154480, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (224, 28, NULL, '打印列表', 'print', 8, NULL, 1, 1588154480, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (225, 29, NULL, '添加', 'add', 1, NULL, 1, 1588154489, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (226, 29, NULL, '编辑', 'edit', 2, NULL, 1, 1588154489, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (227, 29, NULL, '删除', 'del', 3, NULL, 1, 1588154489, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (228, 29, NULL, '显示详情', 'view', 4, NULL, 1, 1588154489, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (229, 29, NULL, '搜索', 'search', 5, NULL, 1, 1588154489, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (230, 29, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154489, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (231, 29, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154489, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (232, 29, NULL, '打印列表', 'print', 8, NULL, 1, 1588154489, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (233, 30, NULL, '添加', 'add', 1, NULL, 1, 1588154501, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (234, 30, NULL, '编辑', 'edit', 2, NULL, 1, 1588154501, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (235, 30, NULL, '删除', 'del', 3, NULL, 1, 1588154501, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (236, 30, NULL, '显示详情', 'view', 4, NULL, 1, 1588154501, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (237, 30, NULL, '搜索', 'search', 5, NULL, 1, 1588154501, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (238, 30, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154501, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (239, 30, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154501, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (240, 30, NULL, '打印列表', 'print', 8, NULL, 1, 1588154501, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (241, 31, NULL, '添加', 'add', 1, NULL, 1, 1588154507, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (242, 31, NULL, '编辑', 'edit', 2, NULL, 1, 1588154507, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (243, 31, NULL, '删除', 'del', 3, NULL, 1, 1588154507, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (244, 31, NULL, '显示详情', 'view', 4, NULL, 1, 1588154507, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (245, 31, NULL, '搜索', 'search', 5, NULL, 1, 1588154507, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (246, 31, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154507, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (247, 31, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154507, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (248, 31, NULL, '打印列表', 'print', 8, NULL, 1, 1588154507, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (249, 32, NULL, '添加', 'add', 1, NULL, 1, 1588154518, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (250, 32, NULL, '编辑', 'edit', 2, NULL, 1, 1588154518, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (251, 32, NULL, '删除', 'del', 3, NULL, 1, 1588154518, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (252, 32, NULL, '显示详情', 'view', 4, NULL, 1, 1588154518, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (253, 32, NULL, '搜索', 'search', 5, NULL, 1, 1588154518, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (254, 32, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154518, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (255, 32, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154518, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (256, 32, NULL, '打印列表', 'print', 8, NULL, 1, 1588154518, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (257, 33, NULL, '添加', 'add', 1, NULL, 1, 1588154539, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (258, 33, NULL, '编辑', 'edit', 2, NULL, 1, 1588154539, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (259, 33, NULL, '删除', 'del', 3, NULL, 1, 1588154539, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (260, 33, NULL, '显示详情', 'view', 4, NULL, 1, 1588154539, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (261, 33, NULL, '搜索', 'search', 5, NULL, 1, 1588154539, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (262, 33, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154539, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (263, 33, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154539, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (264, 33, NULL, '打印列表', 'print', 8, NULL, 1, 1588154539, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (265, 34, NULL, '添加', 'add', 1, NULL, 1, 1588154545, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (266, 34, NULL, '编辑', 'edit', 2, NULL, 1, 1588154545, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (267, 34, NULL, '删除', 'del', 3, NULL, 1, 1588154545, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (268, 34, NULL, '显示详情', 'view', 4, NULL, 1, 1588154545, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (269, 34, NULL, '搜索', 'search', 5, NULL, 1, 1588154545, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (270, 34, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154545, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (271, 34, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154545, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (272, 34, NULL, '打印列表', 'print', 8, NULL, 1, 1588154545, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (273, 35, NULL, '添加', 'add', 1, NULL, 1, 1588154553, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (274, 35, NULL, '编辑', 'edit', 2, NULL, 1, 1588154553, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (275, 35, NULL, '删除', 'del', 3, NULL, 1, 1588154553, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (276, 35, NULL, '显示详情', 'view', 4, NULL, 1, 1588154553, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (277, 35, NULL, '搜索', 'search', 5, NULL, 1, 1588154553, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (278, 35, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154553, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (279, 35, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154553, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (280, 35, NULL, '打印列表', 'print', 8, NULL, 1, 1588154553, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (281, 36, NULL, '添加', 'add', 1, NULL, 1, 1588154560, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (282, 36, NULL, '编辑', 'edit', 2, NULL, 1, 1588154560, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (283, 36, NULL, '删除', 'del', 3, NULL, 1, 1588154560, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (284, 36, NULL, '显示详情', 'view', 4, NULL, 1, 1588154560, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (285, 36, NULL, '搜索', 'search', 5, NULL, 1, 1588154560, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (286, 36, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154560, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (287, 36, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154560, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (288, 36, NULL, '打印列表', 'print', 8, NULL, 1, 1588154560, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (289, 37, NULL, '添加', 'add', 1, NULL, 1, 1588154567, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (290, 37, NULL, '编辑', 'edit', 2, NULL, 1, 1588154567, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (291, 37, NULL, '删除', 'del', 3, NULL, 1, 1588154567, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (292, 37, NULL, '显示详情', 'view', 4, NULL, 1, 1588154567, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (293, 37, NULL, '搜索', 'search', 5, NULL, 1, 1588154567, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (294, 37, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154567, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (295, 37, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154567, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (296, 37, NULL, '打印列表', 'print', 8, NULL, 1, 1588154567, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (297, 38, NULL, '添加', 'add', 1, NULL, 1, 1588154577, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (298, 38, NULL, '编辑', 'edit', 2, NULL, 1, 1588154577, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (299, 38, NULL, '删除', 'del', 3, NULL, 1, 1588154577, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (300, 38, NULL, '显示详情', 'view', 4, NULL, 1, 1588154577, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (301, 38, NULL, '搜索', 'search', 5, NULL, 1, 1588154577, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (302, 38, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154577, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (303, 38, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154577, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (304, 38, NULL, '打印列表', 'print', 8, NULL, 1, 1588154577, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (305, 39, NULL, '添加', 'add', 1, NULL, 1, 1588154588, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (306, 39, NULL, '编辑', 'edit', 2, NULL, 1, 1588154588, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (307, 39, NULL, '删除', 'del', 3, NULL, 1, 1588154588, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (308, 39, NULL, '显示详情', 'view', 4, NULL, 1, 1588154588, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (309, 39, NULL, '搜索', 'search', 5, NULL, 1, 1588154588, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (310, 39, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154588, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (311, 39, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154588, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (312, 39, NULL, '打印列表', 'print', 8, NULL, 1, 1588154588, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (313, 40, NULL, '添加', 'add', 1, NULL, 1, 1588154594, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (314, 40, NULL, '编辑', 'edit', 2, NULL, 1, 1588154594, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (315, 40, NULL, '删除', 'del', 3, NULL, 1, 1588154594, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (316, 40, NULL, '显示详情', 'view', 4, NULL, 1, 1588154594, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (317, 40, NULL, '搜索', 'search', 5, NULL, 1, 1588154594, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (318, 40, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154594, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (319, 40, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154594, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (320, 40, NULL, '打印列表', 'print', 8, NULL, 1, 1588154594, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (321, 41, NULL, '添加', 'add', 1, NULL, 1, 1588154604, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (322, 41, NULL, '编辑', 'edit', 2, NULL, 1, 1588154604, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (323, 41, NULL, '删除', 'del', 3, NULL, 1, 1588154604, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (324, 41, NULL, '显示详情', 'view', 4, NULL, 1, 1588154604, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (325, 41, NULL, '搜索', 'search', 5, NULL, 1, 1588154604, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (326, 41, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154604, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (327, 41, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154604, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (328, 41, NULL, '打印列表', 'print', 8, NULL, 1, 1588154604, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (329, 42, NULL, '添加', 'add', 1, NULL, 1, 1588154608, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (330, 42, NULL, '编辑', 'edit', 2, NULL, 1, 1588154608, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (331, 42, NULL, '删除', 'del', 3, NULL, 1, 1588154608, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (332, 42, NULL, '显示详情', 'view', 4, NULL, 1, 1588154608, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (333, 42, NULL, '搜索', 'search', 5, NULL, 1, 1588154608, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (334, 42, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154608, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (335, 42, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154608, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (336, 42, NULL, '打印列表', 'print', 8, NULL, 1, 1588154608, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (337, 43, NULL, '添加', 'add', 1, NULL, 1, 1588154620, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (338, 43, NULL, '编辑', 'edit', 2, NULL, 1, 1588154620, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (339, 43, NULL, '删除', 'del', 3, NULL, 1, 1588154620, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (340, 43, NULL, '显示详情', 'view', 4, NULL, 1, 1588154620, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (341, 43, NULL, '搜索', 'search', 5, NULL, 1, 1588154620, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (342, 43, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154620, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (343, 43, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154620, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (344, 43, NULL, '打印列表', 'print', 8, NULL, 1, 1588154620, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (345, 44, NULL, '添加', 'add', 1, NULL, 1, 1588154624, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (346, 44, NULL, '编辑', 'edit', 2, NULL, 1, 1588154624, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (347, 44, NULL, '删除', 'del', 3, NULL, 1, 1588154624, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (348, 44, NULL, '显示详情', 'view', 4, NULL, 1, 1588154624, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (349, 44, NULL, '搜索', 'search', 5, NULL, 1, 1588154624, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (350, 44, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154624, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (351, 44, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154624, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (352, 44, NULL, '打印列表', 'print', 8, NULL, 1, 1588154624, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (353, 45, NULL, '添加', 'add', 1, NULL, 1, 1588154627, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (354, 45, NULL, '编辑', 'edit', 2, NULL, 1, 1588154627, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (355, 45, NULL, '删除', 'del', 3, NULL, 1, 1588154627, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (356, 45, NULL, '显示详情', 'view', 4, NULL, 1, 1588154627, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (357, 45, NULL, '搜索', 'search', 5, NULL, 1, 1588154627, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (358, 45, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154627, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (359, 45, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154627, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (360, 45, NULL, '打印列表', 'print', 8, NULL, 1, 1588154627, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (361, 46, NULL, '添加', 'add', 1, NULL, 1, 1588154632, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (362, 46, NULL, '编辑', 'edit', 2, NULL, 1, 1588154632, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (363, 46, NULL, '删除', 'del', 3, NULL, 1, 1588154632, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (364, 46, NULL, '显示详情', 'view', 4, NULL, 1, 1588154632, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (365, 46, NULL, '搜索', 'search', 5, NULL, 1, 1588154632, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (366, 46, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154632, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (367, 46, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154632, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (368, 46, NULL, '打印列表', 'print', 8, NULL, 1, 1588154632, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (369, 47, NULL, '添加', 'add', 1, NULL, 1, 1588154649, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (370, 47, NULL, '编辑', 'edit', 2, NULL, 1, 1588154649, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (371, 47, NULL, '删除', 'del', 3, NULL, 1, 1588154649, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (372, 47, NULL, '显示详情', 'view', 4, NULL, 1, 1588154649, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (373, 47, NULL, '搜索', 'search', 5, NULL, 1, 1588154649, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (374, 47, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154649, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (375, 47, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154649, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (376, 47, NULL, '打印列表', 'print', 8, NULL, 1, 1588154649, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (377, 48, NULL, '添加', 'add', 1, NULL, 1, 1588154653, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (378, 48, NULL, '编辑', 'edit', 2, NULL, 1, 1588154653, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (379, 48, NULL, '删除', 'del', 3, NULL, 1, 1588154653, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (380, 48, NULL, '显示详情', 'view', 4, NULL, 1, 1588154653, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (381, 48, NULL, '搜索', 'search', 5, NULL, 1, 1588154653, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (382, 48, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154653, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (383, 48, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154653, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (384, 48, NULL, '打印列表', 'print', 8, NULL, 1, 1588154653, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (385, 49, NULL, '添加', 'add', 1, NULL, 1, 1588154675, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (386, 49, NULL, '编辑', 'edit', 2, NULL, 1, 1588154675, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (387, 49, NULL, '删除', 'del', 3, NULL, 1, 1588154675, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (388, 49, NULL, '显示详情', 'view', 4, NULL, 1, 1588154675, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (389, 49, NULL, '搜索', 'search', 5, NULL, 1, 1588154675, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (390, 49, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154675, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (391, 49, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154675, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (392, 49, NULL, '打印列表', 'print', 8, NULL, 1, 1588154675, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (393, 50, NULL, '添加', 'add', 1, NULL, 1, 1588154679, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (394, 50, NULL, '编辑', 'edit', 2, NULL, 1, 1588154679, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (395, 50, NULL, '删除', 'del', 3, NULL, 1, 1588154679, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (396, 50, NULL, '显示详情', 'view', 4, NULL, 1, 1588154679, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (397, 50, NULL, '搜索', 'search', 5, NULL, 1, 1588154679, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (398, 50, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154679, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (399, 50, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154679, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (400, 50, NULL, '打印列表', 'print', 8, NULL, 1, 1588154679, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (401, 51, NULL, '添加', 'add', 1, NULL, 1, 1588154683, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (402, 51, NULL, '编辑', 'edit', 2, NULL, 1, 1588154683, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (403, 51, NULL, '删除', 'del', 3, NULL, 1, 1588154683, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (404, 51, NULL, '显示详情', 'view', 4, NULL, 1, 1588154683, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (405, 51, NULL, '搜索', 'search', 5, NULL, 1, 1588154683, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (406, 51, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154683, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (407, 51, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154683, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (408, 51, NULL, '打印列表', 'print', 8, NULL, 1, 1588154683, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (409, 52, NULL, '添加', 'add', 1, NULL, 1, 1588154688, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (410, 52, NULL, '编辑', 'edit', 2, NULL, 1, 1588154688, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (411, 52, NULL, '删除', 'del', 3, NULL, 1, 1588154688, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (412, 52, NULL, '显示详情', 'view', 4, NULL, 1, 1588154688, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (413, 52, NULL, '搜索', 'search', 5, NULL, 1, 1588154688, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (414, 52, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154688, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (415, 52, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154688, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (416, 52, NULL, '打印列表', 'print', 8, NULL, 1, 1588154688, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (417, 53, NULL, '添加', 'add', 1, NULL, 1, 1588154705, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (418, 53, NULL, '编辑', 'edit', 2, NULL, 1, 1588154705, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (419, 53, NULL, '删除', 'del', 3, NULL, 1, 1588154705, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (420, 53, NULL, '显示详情', 'view', 4, NULL, 1, 1588154705, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (421, 53, NULL, '搜索', 'search', 5, NULL, 1, 1588154705, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (422, 53, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154705, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (423, 53, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154705, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (424, 53, NULL, '打印列表', 'print', 8, NULL, 1, 1588154705, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (425, 54, 0, '添加', 'add', 1, NULL, 1, 1588154709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (426, 54, 0, '编辑', 'edit', 2, NULL, 1, 1588154709, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (427, 54, 0, '删除', 'del', 3, NULL, 1, 1588154709, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (428, 54, 0, '显示详情', 'view', 4, NULL, 1, 1588154709, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (429, 54, 0, '搜索', 'search', 5, NULL, 1, 1588154709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (430, 54, 0, '自定义显示列', 'costom', 6, NULL, 1, 1588154709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (431, 54, 0, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (432, 54, 0, '打印列表', 'print', 8, NULL, 1, 1588154709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (433, 55, NULL, '添加', 'add', 1, NULL, 1, 1588154727, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (434, 55, NULL, '编辑', 'edit', 2, NULL, 1, 1588154727, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (435, 55, NULL, '删除', 'del', 3, NULL, 1, 1588154727, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (436, 55, NULL, '显示详情', 'view', 4, NULL, 1, 1588154727, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (437, 55, NULL, '搜索', 'search', 5, NULL, 1, 1588154727, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (438, 55, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154727, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (439, 55, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154727, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (440, 55, NULL, '打印列表', 'print', 8, NULL, 1, 1588154727, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (441, 56, NULL, '添加', 'add', 1, NULL, 1, 1588154732, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (442, 56, NULL, '编辑', 'edit', 2, NULL, 1, 1588154732, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (443, 56, NULL, '删除', 'del', 3, NULL, 1, 1588154732, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (444, 56, NULL, '显示详情', 'view', 4, NULL, 1, 1588154732, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (445, 56, NULL, '搜索', 'search', 5, NULL, 1, 1588154732, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (446, 56, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154732, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (447, 56, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154732, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (448, 56, NULL, '打印列表', 'print', 8, NULL, 1, 1588154732, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (457, 58, NULL, '添加', 'add', 1, NULL, 1, 1588154740, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (458, 58, NULL, '编辑', 'edit', 2, NULL, 1, 1588154740, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (459, 58, NULL, '删除', 'del', 3, NULL, 1, 1588154740, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (460, 58, NULL, '显示详情', 'view', 4, NULL, 1, 1588154740, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (461, 58, NULL, '搜索', 'search', 5, NULL, 1, 1588154740, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (462, 58, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154740, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (463, 58, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154740, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (464, 58, NULL, '打印列表', 'print', 8, NULL, 1, 1588154740, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (465, 59, 14, '添加', 'add', 1, NULL, 1, 1588154745, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (466, 59, 14, '编辑', 'edit', 2, NULL, 1, 1588154745, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (467, 59, 14, '删除', 'del', 3, NULL, 1, 1588154745, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (468, 59, 14, '显示详情', 'view', 4, NULL, 1, 1588154745, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (469, 59, 14, '搜索', 'search', 5, NULL, 1, 1588154745, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (470, 59, 14, '自定义显示列', 'costom', 6, NULL, 1, 1588154745, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (471, 59, 14, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154745, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (472, 59, 14, '打印列表', 'print', 8, NULL, 1, 1588154745, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (473, 60, NULL, '添加', 'add', 1, NULL, 1, 1588154749, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (474, 60, NULL, '编辑', 'edit', 2, NULL, 1, 1588154749, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (475, 60, NULL, '删除', 'del', 3, NULL, 1, 1588154749, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (476, 60, NULL, '显示详情', 'view', 4, NULL, 1, 1588154749, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (477, 60, NULL, '搜索', 'search', 5, NULL, 1, 1588154749, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (478, 60, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154749, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (479, 60, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154749, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (480, 60, NULL, '打印列表', 'print', 8, NULL, 1, 1588154749, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (481, 61, NULL, '添加', 'add', 1, NULL, 1, 1588154753, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (482, 61, NULL, '编辑', 'edit', 2, NULL, 1, 1588154753, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (483, 61, NULL, '删除', 'del', 3, NULL, 1, 1588154753, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (484, 61, NULL, '显示详情', 'view', 4, NULL, 1, 1588154753, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (485, 61, NULL, '搜索', 'search', 5, NULL, 1, 1588154753, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (486, 61, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154753, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (487, 61, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154753, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (488, 61, NULL, '打印列表', 'print', 8, NULL, 1, 1588154753, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (489, 62, NULL, '添加', 'add', 1, NULL, 1, 1588154758, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (490, 62, NULL, '编辑', 'edit', 2, NULL, 1, 1588154758, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (491, 62, NULL, '删除', 'del', 3, NULL, 1, 1588154758, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (492, 62, NULL, '显示详情', 'view', 4, NULL, 1, 1588154758, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (493, 62, NULL, '搜索', 'search', 5, NULL, 1, 1588154758, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (494, 62, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154758, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (495, 62, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154758, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (496, 62, NULL, '打印列表', 'print', 8, NULL, 1, 1588154758, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (497, 63, NULL, '添加', 'add', 1, NULL, 1, 1588154762, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (498, 63, NULL, '编辑', 'edit', 2, NULL, 1, 1588154762, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (499, 63, NULL, '删除', 'del', 3, NULL, 1, 1588154762, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (500, 63, NULL, '显示详情', 'view', 4, NULL, 1, 1588154762, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (501, 63, NULL, '搜索', 'search', 5, NULL, 1, 1588154762, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (502, 63, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154762, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (503, 63, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154762, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (504, 63, NULL, '打印列表', 'print', 8, NULL, 1, 1588154762, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (505, 64, NULL, '添加', 'add', 1, NULL, 1, 1588154795, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (506, 64, NULL, '编辑', 'edit', 2, NULL, 1, 1588154795, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (507, 64, NULL, '删除', 'del', 3, NULL, 1, 1588154795, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (508, 64, NULL, '显示详情', 'view', 4, NULL, 1, 1588154795, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (509, 64, NULL, '搜索', 'search', 5, NULL, 1, 1588154795, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (510, 64, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154795, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (511, 64, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154795, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (512, 64, NULL, '打印列表', 'print', 8, NULL, 1, 1588154795, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (513, 65, NULL, '添加', 'add', 1, NULL, 1, 1588154808, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (514, 65, NULL, '编辑', 'edit', 2, NULL, 1, 1588154808, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (515, 65, NULL, '删除', 'del', 3, NULL, 1, 1588154808, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (516, 65, NULL, '显示详情', 'view', 4, NULL, 1, 1588154808, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (517, 65, NULL, '搜索', 'search', 5, NULL, 1, 1588154808, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (518, 65, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154808, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (519, 65, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154808, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (520, 65, NULL, '打印列表', 'print', 8, NULL, 1, 1588154808, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (521, 66, NULL, '添加', 'add', 1, NULL, 1, 1588154812, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (522, 66, NULL, '编辑', 'edit', 2, NULL, 1, 1588154812, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (523, 66, NULL, '删除', 'del', 3, NULL, 1, 1588154812, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (524, 66, NULL, '显示详情', 'view', 4, NULL, 1, 1588154812, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (525, 66, NULL, '搜索', 'search', 5, NULL, 1, 1588154812, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (526, 66, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1588154812, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (527, 66, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1588154812, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (528, 66, NULL, '打印列表', 'print', 8, NULL, 1, 1588154812, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (529, 67, 0, '添加', 'add', 1, NULL, 1, 1611215143, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (530, 67, 0, '编辑', 'edit', 2, NULL, 1, 1611215143, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (531, 67, 0, '删除', 'del', 3, NULL, 1, 1611215143, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (532, 67, 0, '显示详情', 'view', 4, NULL, 1, 1611215143, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (533, 67, 0, '搜索', 'search', 5, NULL, 1, 1611215143, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (534, 67, 0, '自定义显示列', 'costom', 6, NULL, 1, 1611215143, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (535, 67, 0, '导出Excel', 'loadexcel', 7, NULL, 1, 1611215143, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (536, 67, 0, '打印列表', 'print', 8, NULL, 1, 1611215143, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (537, 68, 18, '添加', 'add', 1, NULL, 1, 1611287769, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (538, 68, 18, '编辑', 'edit', 2, NULL, 1, 1611287769, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (539, 68, 18, '删除', 'del', 3, NULL, 1, 1611287769, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (540, 68, 18, '显示详情', 'view', 4, NULL, 1, 1611287769, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (541, 68, 18, '搜索', 'search', 5, NULL, 1, 1611287769, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (542, 68, 18, '自定义显示列', 'costom', 6, NULL, 1, 1611287769, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (543, 68, 18, '导出Excel', 'loadexcel', 7, NULL, 1, 1611287769, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (544, 68, 18, '打印列表', 'print', 8, NULL, 1, 1611287769, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (545, 69, NULL, '添加', 'add', 1, NULL, 1, 1644980754, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (546, 69, NULL, '编辑', 'edit', 2, NULL, 1, 1644980754, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (547, 69, NULL, '删除', 'del', 3, NULL, 1, 1644980754, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (548, 69, NULL, '显示详情', 'view', 4, NULL, 1, 1644980754, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (549, 69, NULL, '搜索', 'search', 5, NULL, 1, 1644980754, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (550, 69, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1644980754, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (551, 69, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1644980754, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (552, 69, NULL, '打印列表', 'print', 8, NULL, 1, 1644980754, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (578, 73, NULL, '添加', 'add', 1, NULL, 1, 1655374706, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (579, 73, NULL, '编辑', 'edit', 2, NULL, 1, 1655374706, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (580, 73, NULL, '删除', 'del', 3, NULL, 1, 1655374706, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (581, 73, NULL, '显示详情', 'view', 4, NULL, 1, 1655374706, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (582, 73, NULL, '搜索', 'search', 5, NULL, 1, 1655374706, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (583, 73, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1655374706, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (584, 73, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1655374706, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (585, 73, NULL, '打印列表', 'print', 8, NULL, 1, 1655374706, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (586, 74, NULL, '添加', 'add', 1, NULL, 1, 1655374709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (587, 74, NULL, '编辑', 'edit', 2, NULL, 1, 1655374709, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (588, 74, NULL, '删除', 'del', 3, NULL, 1, 1655374709, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (589, 74, NULL, '显示详情', 'view', 4, NULL, 1, 1655374709, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (590, 74, NULL, '搜索', 'search', 5, NULL, 1, 1655374709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (591, 74, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1655374709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (592, 74, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1655374709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (593, 74, NULL, '打印列表', 'print', 8, NULL, 1, 1655374709, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (594, 75, NULL, '添加', 'add', 1, NULL, 1, 1655374711, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (595, 75, NULL, '编辑', 'edit', 2, NULL, 1, 1655374711, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (596, 75, NULL, '删除', 'del', 3, NULL, 1, 1655374711, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (597, 75, NULL, '显示详情', 'view', 4, NULL, 1, 1655374711, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (598, 75, NULL, '搜索', 'search', 5, NULL, 1, 1655374711, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (599, 75, NULL, '自定义显示列', 'costom', 6, NULL, 1, 1655374711, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (600, 75, NULL, '导出Excel', 'loadexcel', 7, NULL, 1, 1655374711, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (601, 75, NULL, '打印列表', 'print', 8, NULL, 1, 1655374711, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (602, 76, 29, '添加', 'add', 1, NULL, 1, 1655374714, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (603, 76, 29, '编辑', 'edit', 2, NULL, 1, 1655374714, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (604, 76, 29, '删除', 'del', 3, NULL, 1, 1655374714, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (605, 76, 29, '显示详情', 'view', 4, NULL, 1, 1655374714, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (606, 76, 29, '搜索', 'search', 5, NULL, 1, 1655374714, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (607, 76, 29, '自定义显示列', 'costom', 6, NULL, 1, 1655374714, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (608, 76, 29, '导出Excel', 'loadexcel', 7, NULL, 1, 1655374714, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (609, 76, 29, '打印列表', 'print', 8, NULL, 1, 1655374714, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (610, 77, 28, '添加', 'add', 1, NULL, 1, 1655374717, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (611, 77, 28, '编辑', 'edit', 2, NULL, 1, 1655374717, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (612, 77, 28, '删除', 'del', 3, NULL, 1, 1655374717, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (613, 77, 28, '显示详情', 'view', 4, NULL, 1, 1655374717, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (614, 77, 28, '搜索', 'search', 5, NULL, 1, 1655374717, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (615, 77, 28, '自定义显示列', 'costom', 6, NULL, 1, 1655374717, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (616, 77, 28, '导出Excel', 'loadexcel', 7, NULL, 1, 1655374717, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (617, 77, 28, '打印列表', 'print', 8, NULL, 1, 1655374717, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (618, 78, 27, '添加', 'add', 1, NULL, 1, 1655374720, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (619, 78, 27, '编辑', 'edit', 2, NULL, 1, 1655374720, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (620, 78, 27, '删除', 'del', 3, NULL, 1, 1655374720, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (621, 78, 27, '显示详情', 'view', 4, NULL, 1, 1655374720, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (622, 78, 27, '搜索', 'search', 5, NULL, 1, 1655374720, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (623, 78, 27, '自定义显示列', 'costom', 6, NULL, 1, 1655374720, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (624, 78, 27, '导出Excel', 'loadexcel', 7, NULL, 1, 1655374720, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (625, 78, 27, '打印列表', 'print', 8, NULL, 1, 1655374720, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (626, 79, 30, '添加', 'add', 1, NULL, 1, 1655375933, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (627, 79, 30, '编辑', 'edit', 2, NULL, 1, 1655375933, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (628, 79, 30, '删除', 'del', 3, NULL, 1, 1655375933, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (629, 79, 30, '显示详情', 'view', 4, NULL, 1, 1655375933, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (630, 79, 30, '搜索', 'search', 5, NULL, 1, 1655375933, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (631, 79, 30, '自定义显示列', 'costom', 6, NULL, 1, 1655375933, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (632, 79, 30, '导出Excel', 'loadexcel', 7, NULL, 1, 1655375933, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (633, 79, 30, '打印列表', 'print', 8, NULL, 1, 1655375933, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (634, 80, 35, '添加', 'add', 1, NULL, 1, 1655375944, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (635, 80, 35, '编辑', 'edit', 2, NULL, 1, 1655375944, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (636, 80, 35, '删除', 'del', 3, NULL, 1, 1655375944, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (637, 80, 35, '显示详情', 'view', 4, NULL, 1, 1655375944, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (638, 80, 35, '搜索', 'search', 5, NULL, 1, 1655375944, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (639, 80, 35, '自定义显示列', 'costom', 6, NULL, 1, 1655375944, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (640, 80, 35, '导出Excel', 'loadexcel', 7, NULL, 1, 1655375944, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (641, 80, 35, '打印列表', 'print', 8, NULL, 1, 1655375944, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (642, 81, 34, '添加', 'add', 1, NULL, 1, 1655375948, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (643, 81, 34, '编辑', 'edit', 2, NULL, 1, 1655375948, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (644, 81, 34, '删除', 'del', 3, NULL, 1, 1655375948, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (645, 81, 34, '显示详情', 'view', 4, NULL, 1, 1655375948, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (646, 81, 34, '搜索', 'search', 5, NULL, 1, 1655375948, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (647, 81, 34, '自定义显示列', 'costom', 6, NULL, 1, 1655375948, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (648, 81, 34, '导出Excel', 'loadexcel', 7, NULL, 1, 1655375948, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (649, 81, 34, '打印列表', 'print', 8, NULL, 1, 1655375948, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (650, 82, 33, '添加', 'add', 1, NULL, 1, 1655375951, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (651, 82, 33, '编辑', 'edit', 2, NULL, 1, 1655375951, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (652, 82, 33, '删除', 'del', 3, NULL, 1, 1655375951, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (653, 82, 33, '显示详情', 'view', 4, NULL, 1, 1655375951, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (654, 82, 33, '搜索', 'search', 5, NULL, 1, 1655375951, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (655, 82, 33, '自定义显示列', 'costom', 6, NULL, 1, 1655375951, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (656, 82, 33, '导出Excel', 'loadexcel', 7, NULL, 1, 1655375951, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (657, 82, 33, '打印列表', 'print', 8, NULL, 1, 1655375951, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (658, 83, 32, '添加', 'add', 1, NULL, 1, 1655375955, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (659, 83, 32, '编辑', 'edit', 2, NULL, 1, 1655375955, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (660, 83, 32, '删除', 'del', 3, NULL, 1, 1655375955, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (661, 83, 32, '显示详情', 'view', 4, NULL, 1, 1655375955, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (662, 83, 32, '搜索', 'search', 5, NULL, 1, 1655375955, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (663, 83, 32, '自定义显示列', 'costom', 6, NULL, 1, 1655375955, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (664, 83, 32, '导出Excel', 'loadexcel', 7, NULL, 1, 1655375955, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (665, 83, 32, '打印列表', 'print', 8, NULL, 1, 1655375955, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (666, 84, 31, '添加', 'add', 1, NULL, 1, 1655375958, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (667, 84, 31, '编辑', 'edit', 2, NULL, 1, 1655375958, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (668, 84, 31, '删除', 'del', 3, NULL, 1, 1655375958, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (669, 84, 31, '显示详情', 'view', 4, NULL, 1, 1655375958, 0, 0, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (670, 84, 31, '搜索', 'search', 5, NULL, 1, 1655375958, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (671, 84, 31, '自定义显示列', 'costom', 6, NULL, 1, 1655375958, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (672, 84, 31, '导出Excel', 'loadexcel', 7, NULL, 1, 1655375958, 0, 1, 0, 0, NULL, NULL);
INSERT INTO `cz_admin_model_menufunc` VALUES (673, 84, 31, '打印列表', 'print', 8, NULL, 1, 1655375958, 0, 1, 0, 0, NULL, NULL);

-- ----------------------------
-- Table structure for cz_admin_modellist
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_modellist`;
CREATE TABLE `cz_admin_modellist`  (
  `id` int(0) NOT NULL AUTO_INCREMENT COMMENT '主键,，模型表',
  `modelname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模型名字',
  `tablename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模型对应数据表的名称',
  `dbname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '数据库名',
  `explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明',
  `status` int(0) DEFAULT 0 COMMENT '是否存在 0为否 1为是',
  `menu` int(0) DEFAULT 0 COMMENT '是否存在菜单 0为不存在 存在则显示菜单id',
  `menu_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单名称',
  `isadd` int(0) DEFAULT 1 COMMENT '允许添加功能type值 只能为1',
  `isedit` int(0) DEFAULT 2 COMMENT '允许编辑功能type值 只能为2',
  `isdel` int(0) DEFAULT 3 COMMENT '允许删除功能type值 只能为3',
  `isview` int(0) DEFAULT 4 COMMENT '允许查看详情功能type值 只能为4',
  `issearch` int(0) DEFAULT 5 COMMENT '允许搜索功能type值 只能为5',
  `iscostom` int(0) DEFAULT 6 COMMENT '允许自定义显示列功能type值 只能为6',
  `isloadexcel` int(0) DEFAULT 7 COMMENT '允许导出excel功能type值 只能为7',
  `isprint` int(0) DEFAULT 8 COMMENT '允许打印列表功能type值 只能为8',
  `isaddexcel` int(0) DEFAULT 9 COMMENT '允许导出excel功能type值 只能为9',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_modellist
-- ----------------------------
INSERT INTO `cz_admin_modellist` VALUES (73, 'trader/PriceBTCUSDT', 'trader.price_BTC-USDT', 'trader', NULL, 1, 0, NULL, 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (74, 'trader/PriceEOSUSDT', 'trader.price_EOS-USDT', 'trader', NULL, 1, 0, NULL, 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (75, 'trader/PriceETHUSDT', 'trader.price_ETH-USDT', 'trader', NULL, 1, 0, NULL, 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (76, 'trader/RecordBTCUSDT', 'trader.record_BTC-USDT', 'trader', '记录_BTC', 1, 29, '记录_BTC', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (77, 'trader/RecordEOSUSDT', 'trader.record_EOS-USDT', 'trader', '记录_EOS', 1, 28, '记录_EOS', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (78, 'trader/RecordETHUSDT', 'trader.record_ETH-USDT', 'trader', '记录_ETH', 1, 27, '记录_ETH', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (79, 'tchecker_paint/Records', 'tchecker_paint.records', 'tchecker_paint', '回测记录', 1, 30, '回测记录', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (80, 'tchecker/TcheckerEventlog', 'tchecker.tchecker_eventlog', 'tchecker', '事件记录', 1, 35, '事件记录', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (81, 'tchecker/TcheckerPushlog', 'tchecker.tchecker_pushlog', 'tchecker', '推送管理', 1, 34, '推送管理', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (82, 'tchecker/TcheckerRegistercode', 'tchecker.tchecker_registercode', 'tchecker', '激活码管理', 1, 33, '激活码管理', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (83, 'tchecker/TcheckerService', 'tchecker.tchecker_service', 'tchecker', '代理管理', 1, 32, '代理管理', 1, 2, 3, 4, 5, 6, 7, 8, 9);
INSERT INTO `cz_admin_modellist` VALUES (84, 'tchecker/TcheckerUser', 'tchecker.tchecker_user', 'tchecker', '用户管理', 1, 31, '用户管理', 1, 2, 3, 4, 5, 6, 7, 8, 9);

-- ----------------------------
-- Table structure for cz_admin_nav
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_nav`;
CREATE TABLE `cz_admin_nav`  (
  `id` int unsigned NOT NULL COMMENT '后台菜单表id，自增',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单标题',
  `icon` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单图标',
  `href` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单链接',
  `cate` tinyint(1) DEFAULT 1 COMMENT '分类 1为一级菜单 2为二级菜单 3为三级菜单',
  `fid` int(0) DEFAULT 0 COMMENT '父级id 0为一级分类',
  `children_code` tinyint(1) DEFAULT 0 COMMENT '是否存在子级菜单 0为否 1为是',
  `num` int(0) DEFAULT 0 COMMENT '排序，值越小越靠前',
  `mid` int(0) DEFAULT 0 COMMENT '关联模型id',
  `isdev` tinyint(1) DEFAULT 0 COMMENT '是否为开发者菜单 1为是 0为否',
  `issystem` tinyint(1) DEFAULT 0 COMMENT '是否系统菜单 0为否 1为是',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '菜单说明',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_nav
-- ----------------------------
INSERT INTO `cz_admin_nav` VALUES (1, '系统管理', 'fa fa-cog', 'users', 1, 0, 1, 15, 0, 0, 1, '');
INSERT INTO `cz_admin_nav` VALUES (2, '开发设置', 'fa fa-desktop', 'systems', 1, 0, 1, 10, 0, 1, 1, '');
INSERT INTO `cz_admin_nav` VALUES (3, '管理员管理', 'fa fa-address-card', 'users/adminUser', 2, 1, 1, 3, 0, 0, 1, '');
INSERT INTO `cz_admin_nav` VALUES (4, '后台参数设置', 'fa fa-cogs', 'systems/setSystem', 2, 1, 0, 1, 0, 0, 1, '后台参数设置');
INSERT INTO `cz_admin_nav` VALUES (5, '后台菜单设置', 'fa fa-th', 'systems/menuList', 2, 2, 0, 2, 0, 1, 1, '后台菜单设置');
INSERT INTO `cz_admin_nav` VALUES (6, '数据库表', 'fa fa-list-alt', 'systems/tableList', 2, 2, 0, 3, 0, 1, 1, NULL);
INSERT INTO `cz_admin_nav` VALUES (7, '模型列表', 'fa fa-th-list', 'systems/modelList', 2, 2, 0, 4, 0, 1, 1, '');
INSERT INTO `cz_admin_nav` VALUES (8, '管理员列表', 'fa fa-address-book-o', 'users/userList', 3, 3, 0, 1, 0, 0, 1, NULL);
INSERT INTO `cz_admin_nav` VALUES (9, '管理员组', 'fa fa-sitemap', 'users/userGrade', 3, 3, 0, 2, 0, 0, 1, NULL);
INSERT INTO `cz_admin_nav` VALUES (10, '管理员操作日志', 'fa fa-file', 'systems/adminLogList', 2, 1, 0, 2, 0, 0, 1, '管理员操作日志');
INSERT INTO `cz_admin_nav` VALUES (14, '商品列表', '', 'Data/dlist/mid/59', 2, 13, 0, 0, 59, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (18, '商户列表', '', 'Data/dlist/mid/68', 2, 13, 0, 0, 68, 1, 0, '');
INSERT INTO `cz_admin_nav` VALUES (24, '回测模拟', 'fa fa-cube', '', 1, 0, 1, 0, 0, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (25, '实盘跟踪', 'fa fa-diamond', '', 1, 0, 1, 0, 0, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (26, '上上策', 'fa fa-android', '', 1, 0, 1, 0, 0, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (27, '记录_ETH', '', 'Data/dlist/mid/78', 2, 25, 0, 0, 78, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (28, '记录_EOS', '', 'Data/dlist/mid/77', 2, 25, 0, 0, 77, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (29, '记录_BTC', '', 'Data/dlist/mid/76', 2, 25, 0, 0, 76, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (30, '回测记录', '', 'Data/dlist/mid/79', 2, 24, 0, 0, 79, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (31, '用户管理', '', 'Data/dlist/mid/84', 2, 26, 0, 0, 84, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (32, '代理管理', '', 'Data/dlist/mid/83', 2, 26, 0, 0, 83, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (33, '激活码管理', '', 'Data/dlist/mid/82', 2, 26, 0, 0, 82, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (34, '推送管理', '', 'Data/dlist/mid/81', 2, 26, 0, 0, 81, 0, 0, '');
INSERT INTO `cz_admin_nav` VALUES (35, '事件记录', '', 'Data/dlist/mid/80', 2, 26, 0, 0, 80, 0, 0, '');

-- ----------------------------
-- Table structure for cz_admin_system_setting
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_system_setting`;
CREATE TABLE `cz_admin_system_setting`  (
  `id` int unsigned NOT NULL COMMENT '后台系统配置表id，自增',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '系统标题',
  `simplename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '系统简称',
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '版本号',
  `companyname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '公司名称',
  `copyright` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '版权',
  `copyrightyears` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '版权年限',
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '开发作者',
  `database` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '数据库版本',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '网站logo',
  `loginbg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '登录背景图',
  `loginbgnum` int(0) DEFAULT 1 COMMENT '登录背景主题编号',
  `notice` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '系统公告',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '网站地址',
  `onelogin` int(0) DEFAULT 0 COMMENT '开启单一登录 1开 0关',
  `settime` int(0) DEFAULT NULL COMMENT '上次修改设定时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_system_setting
-- ----------------------------
INSERT INTO `cz_admin_system_setting` VALUES (1, 'KTRADER开源系统', 'KTrader', '2.1', 'KTRADER开源系统', '@cc KTRADER 2022', '2017-2099', 'dpbtrader', NULL, NULL, '/coop2/coop-arcz/arcz/themes/main/cz/images/loginbg/1f5ce9cc4812802862ea9677f85507a3.jpg', 3, 'KTrader即将发布', 'http://192.168.101.177:19006', 0, 1560485535);

-- ----------------------------
-- Table structure for cz_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_user`;
CREATE TABLE `cz_admin_user`  (
  `id` int unsigned NOT NULL COMMENT '管理员表id，自增',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员登录账号',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员登录密码',
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员昵称',
  `realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员真实姓名',
  `age` int(0) DEFAULT 1 COMMENT '年龄',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员电话',
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员邮箱',
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '个人网站',
  `admin_face` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员头像',
  `admin_content` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '管理员简介',
  `qq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'QQ',
  `wx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '微信',
  `weibo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '微博',
  `is_login` tinyint(1) DEFAULT 0 COMMENT '开启单一登录后用于判断是否登录 1是 0否',
  `login_content` int(0) DEFAULT 0 COMMENT '登录次数',
  `login_time` int(0) DEFAULT NULL COMMENT '上次登录时间',
  `login_ip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '上次登录ip',
  `register_time` int(0) DEFAULT NULL COMMENT '管理员添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_user
-- ----------------------------
INSERT INTO `cz_admin_user` VALUES (2, 'adminarcz', '16c3f70369bae55f70eb7856ae22f7fb', 'ktrader', 'ktrader', 3, '18888888888', 'aaa@aaa.com', 'github.com', '/assets/upload/img/20220616/8384163222326155.png', 'null......', '22222', '11', '3333', 0, 36, 1655365341, '192.168.101.9', 1577704654);

-- ----------------------------
-- Table structure for cz_admin_user_group
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_user_group`;
CREATE TABLE `cz_admin_user_group`  (
  `id` int unsigned NOT NULL COMMENT '后台管理员-管理员分组中间表id，自增',
  `uid` int(0) DEFAULT NULL COMMENT '关联后台管理员表主键id',
  `gid` int(0) DEFAULT NULL COMMENT '关联后台管理员分组表主键id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cz_admin_user_group
-- ----------------------------
INSERT INTO `cz_admin_user_group` VALUES (5, 2, 1);
INSERT INTO `cz_admin_user_group` VALUES (6, 2, 3);
INSERT INTO `cz_admin_user_group` VALUES (7, 2, 2);

SET FOREIGN_KEY_CHECKS = 1;
