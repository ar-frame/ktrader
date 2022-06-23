/*
 Navicat Premium Data Transfer

 Source Server         : atrader
 Source Server Type    : MySQL
 Source Server Version : 80029
 Source Host           : 192.168.101.177:19002
 Source Schema         : trader

 Target Server Type    : MySQL
 Target Server Version : 80029
 File Encoding         : 65001

 Date: 16/06/2022 18:50:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for price_BTC-USDT
-- ----------------------------
DROP TABLE IF EXISTS `price_BTC-USDT`;
CREATE TABLE `price_BTC-USDT`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `pair` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '品种',
  `price` decimal(10, 4) NOT NULL COMMENT '价格',
  `timedate` datetime(0) NOT NULL COMMENT '时间日期',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产生类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3576866 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for price_EOS-USDT
-- ----------------------------
DROP TABLE IF EXISTS `price_EOS-USDT`;
CREATE TABLE `price_EOS-USDT`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `pair` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '品种',
  `price` decimal(10, 4) NOT NULL COMMENT '价格',
  `timedate` datetime(0) NOT NULL COMMENT '时间日期',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产生类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3576866 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for price_ETH-USDT
-- ----------------------------
DROP TABLE IF EXISTS `price_ETH-USDT`;
CREATE TABLE `price_ETH-USDT`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `pair` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '品种',
  `price` decimal(10, 4) NOT NULL COMMENT '价格',
  `timedate` datetime(0) NOT NULL COMMENT '时间日期',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产生类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3139910 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for record_BTC-USDT
-- ----------------------------
DROP TABLE IF EXISTS `record_BTC-USDT`;
CREATE TABLE `record_BTC-USDT`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timedate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `complete` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `suc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profit` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15425 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for record_EOS-USDT
-- ----------------------------
DROP TABLE IF EXISTS `record_EOS-USDT`;
CREATE TABLE `record_EOS-USDT`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timedate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `complete` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `suc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profit` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15425 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for record_ETH-USDT
-- ----------------------------
DROP TABLE IF EXISTS `record_ETH-USDT`;
CREATE TABLE `record_ETH-USDT`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timedate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `complete` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `suc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profit` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23337 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
