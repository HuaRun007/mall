/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : mall

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-28 10:57:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `num` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cart
-- ----------------------------
INSERT INTO `cart` VALUES ('23', '35', '13', '2');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `preview` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '摆件', '/images/2019-05-02_1556775730_5cca833293c97.jpg', '0', '1', null, '2019-04-24 12:23:03');
INSERT INTO `category` VALUES ('2', '壁挂', '/images/2019-05-05_1557033104_5cce70908c5f2.jpg', '0', '2', null, '2019-05-05 05:11:46');
INSERT INTO `category` VALUES ('4', '花艺', null, '1', '1,4', '0000-00-00 00:00:00', '2019-04-24 12:23:09');
INSERT INTO `category` VALUES ('5', '桌饰', null, '1', '1,5', null, '2019-04-24 12:23:25');
INSERT INTO `category` VALUES ('6', '仿真花束', null, '1', '1,6', null, '2019-04-24 12:24:03');
INSERT INTO `category` VALUES ('10', '动物壁挂', null, '2', '2.10', null, '2019-04-24 12:24:22');
INSERT INTO `category` VALUES ('15', '风景壁挂', null, '2', '2,15', '2019-04-24 12:24:39', '2019-04-24 12:24:39');
INSERT INTO `category` VALUES ('19', '花花意', null, '4', '1,4,19', '2019-04-30 02:36:05', '2019-04-30 02:36:05');
INSERT INTO `category` VALUES ('20', '窗帘', '/images/2019-05-05_1557033126_5cce70a61ffe0.jpg', '0', '20', '2019-04-30 02:36:37', '2019-05-05 05:12:07');
INSERT INTO `category` VALUES ('21', '欧式风格', '/images/2019-05-02_1556776084_5cca849466ab8.jpg', '0', '21', '2019-05-02 05:48:06', '2019-05-02 05:48:06');
INSERT INTO `category` VALUES ('22', '创意装饰', '/images/2019-05-05_1557033343_5cce717fac653.jpg', '0', '22', '2019-05-05 05:15:44', '2019-05-05 05:15:44');

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('1', '35', '12', '哈哈哈哈，好东西', '2019-05-19 14:29:59', '2019-05-19 14:29:59');
INSERT INTO `comment` VALUES ('2', '35', '25', 'asdfsfd', '2019-05-25 15:09:37', '2019-05-25 15:09:37');

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `integral` int(255) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1开启0禁用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('14', '啦啦啦', '15212119220', '12340@qq.com', '1', 'adc3949ba59abbe56e05', '1', '0', '2019-05-24 21:30:54', '2019-05-24 13:30:54', '2019-05-24 13:30:54');
INSERT INTO `member` VALUES ('15', '哦哦哦', null, '2830857612@qq.com', '0', 'adc3949ba59abbe56e05', '1', '1', '2019-03-20 19:14:52', '2019-03-20 11:14:52', null);
INSERT INTO `member` VALUES ('16', '娃哈哈', null, '232857612@qq.com', '0', 'adc3949ba59abbe56e05', '1', '1', '2019-03-20 00:25:53', '2018-10-26 07:40:04', null);
INSERT INTO `member` VALUES ('17', '啊啊啊', '15212119221', null, '0', 'adc3949ba59abbe56e05', '0', '1', '2019-04-30 00:54:21', '2018-10-26 07:40:04', null);
INSERT INTO `member` VALUES ('18', '防守打法', '15212119229', null, '0', 'adc3949ba59abbe56e05', '0', '1', '2019-03-20 00:27:33', '2018-10-26 07:40:04', null);
INSERT INTO `member` VALUES ('19', '萨芬的', '15212119255', null, '0', 'adc3949ba59abbe56e05', '0', '0', '2019-05-24 21:29:48', '2019-05-24 13:29:48', '2019-05-24 13:29:48');
INSERT INTO `member` VALUES ('20', '按时发生', '15212119299', null, '0', 'adc3949ba59abbe56e05', '0', '0', '2019-05-24 21:29:27', '2019-05-24 13:29:27', '2019-05-24 13:29:27');
INSERT INTO `member` VALUES ('21', '发23', '15212119200', null, '0', 'adc3949ba59abbe56e05', '0', '1', '2019-03-20 00:27:34', '2018-10-26 07:40:04', null);
INSERT INTO `member` VALUES ('22', '沙发大哥', '15212119333', null, '0', 'adc3949ba59abbe56e05', '0', '1', '2019-03-20 00:27:34', '2018-10-26 07:40:04', null);
INSERT INTO `member` VALUES ('23', '在V型从', '15212119011', null, '0', 'adc3949ba59abbe56e05', '0', '1', '2019-04-13 14:48:08', '2019-04-13 06:48:08', null);
INSERT INTO `member` VALUES ('24', '哈人', '15212119888', '', '0', 'adc3949ba59abbe56e05', '0', '1', '2019-04-12 18:27:49', '2019-04-12 10:27:49', null);
INSERT INTO `member` VALUES ('25', '安定坊', '15212119227', '777777', '0', '$2y$10$VugUMpe0dym.f6ac9JgE6etMZZMbPmvNYV7woEmB4Ikajk6sQ.TUa', '0', '1', '2019-05-24 21:46:55', '2019-05-24 13:46:55', null);
INSERT INTO `member` VALUES ('35', '打发斯蒂3', null, '1132296440@qq.com', '1', '$2y$10$knEeUtSW2gK5SHmcNecble1uQojpLahwVYc8y4zOP9rZ9t9jbZUUi', '1', '1', '2019-05-25 17:29:40', '2019-05-25 09:29:40', null);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2019_03_29_080400_entrust_setup_tables', '1');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `member_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '冗余字段 ',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL COMMENT '订单总金额',
  `paystatus` tinyint(1) NOT NULL DEFAULT '2' COMMENT '2未支付 1 已支付',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '订单备注',
  `payment_method` tinyint(1) DEFAULT '1' COMMENT '支付方式 1支付宝 2微信',
  `payment_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '支付平台订单号',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态 1提交订单 2 已发货 3 已到货 4完成订单',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no` (`no`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('2', '201904171650299083228318', '24', '哈人', '15212119888', '随便填', '2000.00', '2', '随便1', '1', null, '2', '2019-04-17 16:51:19', '2019-05-08 07:48:06');
INSERT INTO `orders` VALUES ('8', '201905062146121210806043', '35', '大范德萨', null, '暂无', '78.00', '1', '', '1', '2019050622001462451000024557', '2', '2019-05-06 13:46:14', '2019-05-11 08:49:06');
INSERT INTO `orders` VALUES ('16', '201905072101009969650820', '35', '大范德萨', null, '暂无', '1121.00', '1', '', '1', '2019050722001462451000027971', '2', '2019-05-07 13:01:03', '2019-05-17 08:13:45');
INSERT INTO `orders` VALUES ('17', '201905072106404850345034', '35', '大范德萨', null, '暂无', '156.00', '1', null, '1', '2019050722001462451000027972', '1', '2019-05-07 13:06:42', '2019-05-07 14:14:19');
INSERT INTO `orders` VALUES ('18', '201905081638101014690926', '35', '大范德萨', null, '暂无', '78.00', '1', '', '1', '2019050822001462451000029061', '2', '2019-05-08 08:38:19', '2019-05-11 08:30:22');
INSERT INTO `orders` VALUES ('19', '201905112011323419875134', '35', '大范德萨', null, '暂无', '79.11', '2', null, '1', null, '1', '2019-05-11 12:11:35', '2019-05-11 12:11:35');
INSERT INTO `orders` VALUES ('20', '201905112014251904961433', '35', '大范德萨', null, '暂无', '562.00', '1', '', '1', '2019051722001462451000038228', '4', '2019-05-11 12:14:27', '2019-05-19 03:37:46');
INSERT INTO `orders` VALUES ('21', '201905222015383573148029', '35', '大范德萨', null, '暂无', '79.11', '1', null, '1', '2019052222001462451000039552', '2', '2019-05-22 12:15:40', '2019-05-22 12:16:29');
INSERT INTO `orders` VALUES ('22', '201905242143435347187322', '35', '打发斯蒂3', null, '暂无', '336.00', '1', null, '1', '2019052422001462451000041371', '2', '2019-05-24 13:43:59', '2019-05-24 13:45:40');
INSERT INTO `orders` VALUES ('23', '201905251453077575617018', '35', '打发斯蒂3', null, '暂无', '2508.00', '2', null, '1', null, '1', '2019-05-25 06:53:13', '2019-05-25 06:53:13');
INSERT INTO `orders` VALUES ('24', '201905251457519753270812', '35', '打发斯蒂3', null, '暂无', '555.00', '1', '', '1', '2019052522001462451000043203', '4', '2019-05-25 06:57:55', '2019-05-25 07:00:11');
INSERT INTO `orders` VALUES ('25', '201905251728286494959399', '35', '打发斯蒂3', null, '暂无', '12.00', '1', null, '1', '2019052522001462451000044600', '2', '2019-05-25 09:28:34', '2019-05-25 09:29:40');

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00',
  `rating` int(10) DEFAULT NULL,
  `review` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of order_detail
-- ----------------------------
INSERT INTO `order_detail` VALUES ('3', '8', '13', '七头美丽玫瑰仿真花束2', '1', '78.00', '0.00', null, null, null);
INSERT INTO `order_detail` VALUES ('7', '16', '14', '七头美丽玫瑰仿真花束3', '4', '123.00', '492.00', null, null, null);
INSERT INTO `order_detail` VALUES ('8', '16', '12', '七头美丽玫瑰仿真花束', '5', '79.11', '395.55', null, null, null);
INSERT INTO `order_detail` VALUES ('9', '16', '13', '七头美丽玫瑰仿真花束2', '3', '78.00', '234.00', null, null, null);
INSERT INTO `order_detail` VALUES ('10', '17', '13', '七头美丽玫瑰仿真花束2', '2', '78.00', '156.00', null, null, null);
INSERT INTO `order_detail` VALUES ('11', '18', '13', '七头美丽玫瑰仿真花束2', '1', '78.00', '78.00', null, null, null);
INSERT INTO `order_detail` VALUES ('12', '19', '12', '七头美丽玫瑰仿真花束', '1', '79.11', '79.11', null, null, null);
INSERT INTO `order_detail` VALUES ('13', '20', '14', '七头美丽玫瑰仿真花束3', '4', '123.00', '316.44', null, null, null);
INSERT INTO `order_detail` VALUES ('14', '20', '12', '七头美丽玫瑰仿真花束', '2', '79.11', '246.00', '5', '哈哈哈哈，好东西', '2019-05-19 14:29:59');
INSERT INTO `order_detail` VALUES ('15', '21', '12', '七头美丽玫瑰仿真花束', '1', '79.11', '79.11', null, null, null);
INSERT INTO `order_detail` VALUES ('16', '22', '24', '彩虹', '3', '112.00', '336.00', null, null, null);
INSERT INTO `order_detail` VALUES ('17', '23', '26', '噢噢噢噢', '2', '555.00', '156.00', null, null, null);
INSERT INTO `order_detail` VALUES ('18', '23', '24', '彩虹', '21', '112.00', '2352.00', null, null, null);
INSERT INTO `order_detail` VALUES ('19', '24', '25', '按时缴费卡', '1', '555.00', '555.00', '5', 'asdfsfd', '2019-05-25 15:09:37');
INSERT INTO `order_detail` VALUES ('20', '25', '16', '哇哈哈哈', '1', '12.00', '12.00', null, null, null);

-- ----------------------------
-- Table structure for pdt_content
-- ----------------------------
DROP TABLE IF EXISTS `pdt_content`;
CREATE TABLE `pdt_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(20000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pdt_content
-- ----------------------------
INSERT INTO `pdt_content` VALUES ('1', 'Node.js让JavaScript在服务器端焕发生机，这是一本带着文艺调调的好看的技术书，书中详细阐述了Node.js的方方面面。如果你是前端工程师，这会是你迈向全端工程师的关键一步。<br>　　——玉伯，支付宝高级技术专家<br><br>　　通过学习Node.js，你可以接触到新的开发模式与协作思想。通过阅读这本书，你可以在软件开发领域获得广泛而又有深度的收获！所以，我很推荐这本书！<br>　　——庄表伟<br><br>　　从未读过这么让人想一翻到底的Node.js技术读物，看完 “内存控制”这一章后，重新写代码的时候，仿佛都能看到V8是如何进行垃圾回收的。如果你还在纠结callback带来的}}}}}}}嵌套问题，那么推荐你阅读“异步编程”这一章，保证让你大开眼界。世界上本没有嵌套回调，写的人多了，也便有了}}}}}}}。JavaScript已经不仅仅是在浏览器上运行的玩具语言, 它正在通过Node.js进军所有领域。<br>　　阅读本书，开启你人生的Node节点吧。<br>　　——Python发烧友，阿里巴巴数据平台技术专家', '1', null, null);

-- ----------------------------
-- Table structure for pdt_images
-- ----------------------------
DROP TABLE IF EXISTS `pdt_images`;
CREATE TABLE `pdt_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_no` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `pdt_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pdt_images
-- ----------------------------
INSERT INTO `pdt_images` VALUES ('13', '/images/2019-04-24_1556095755_5cc0230b2ceb1.jpg', null, '13', '2019-04-24 12:02:09', '2019-04-24 12:02:09');
INSERT INTO `pdt_images` VALUES ('15', '/images/2019-04-24_1556095705_5cc022d966787.jpg', null, '12', '2019-04-24 12:25:07', '2019-04-24 12:25:07');
INSERT INTO `pdt_images` VALUES ('76', '/images/2019-05-14_1557829068_5cda95cc6897c.jpg', null, '25', '2019-05-14 10:17:49', '2019-05-14 10:17:49');
INSERT INTO `pdt_images` VALUES ('77', '/images/2019-05-14_1557829068_5cda95cc7db93.jpg', null, '25', '2019-05-14 10:17:49', '2019-05-14 10:17:49');
INSERT INTO `pdt_images` VALUES ('78', '/images/2019-05-14_1557829068_5cda95cc93eda.jpg', null, '25', '2019-05-14 10:17:49', '2019-05-14 10:17:49');
INSERT INTO `pdt_images` VALUES ('83', '/images/2019-04-24_1556119932_5cc0817cb4b82.jpg', null, '15', '2019-05-14 11:31:33', '2019-05-14 11:31:33');
INSERT INTO `pdt_images` VALUES ('84', '/images/2019-04-24_1556119932_5cc0817ccad20.jpg', null, '15', '2019-05-14 11:31:33', '2019-05-14 11:31:33');
INSERT INTO `pdt_images` VALUES ('85', '/images/2019-04-24_1556119932_5cc0817ce12f8.jpg', null, '15', '2019-05-14 11:31:33', '2019-05-14 11:31:33');
INSERT INTO `pdt_images` VALUES ('86', '/images/2019-04-24_1556119933_5cc0817d01f76.jpg', null, '15', '2019-05-14 11:31:33', '2019-05-14 11:31:33');
INSERT INTO `pdt_images` VALUES ('92', '/images/2019-05-08_1557304358_5cd294267ff97.jpg', null, '16', '2019-05-14 13:21:23', '2019-05-14 13:21:23');
INSERT INTO `pdt_images` VALUES ('93', '/images/2019-05-08_1557304358_5cd29426932e2.jpg', null, '16', '2019-05-14 13:21:23', '2019-05-14 13:21:23');
INSERT INTO `pdt_images` VALUES ('94', '/images/2019-05-08_1557304358_5cd29426a4333.jpg', null, '16', '2019-05-14 13:21:23', '2019-05-14 13:21:23');
INSERT INTO `pdt_images` VALUES ('116', '/images/2019-05-14_1557833441_5cdaa6e174d87.jpg', null, '26', '2019-05-14 13:25:03', '2019-05-14 13:25:03');
INSERT INTO `pdt_images` VALUES ('117', '/images/2019-05-14_1557833441_5cdaa6e18a0b9.jpg', null, '26', '2019-05-14 13:25:03', '2019-05-14 13:25:03');
INSERT INTO `pdt_images` VALUES ('118', '/images/2019-05-14_1557833441_5cdaa6e1a19e4.jpg', null, '26', '2019-05-14 13:25:03', '2019-05-14 13:25:03');
INSERT INTO `pdt_images` VALUES ('119', '/images/2019-05-14_1557824012_5cda820c5f29a.jpg', null, '24', '2019-05-14 13:25:14', '2019-05-14 13:25:14');
INSERT INTO `pdt_images` VALUES ('120', '/images/2019-05-14_1557824012_5cda820c75a38.jpg', null, '24', '2019-05-14 13:25:14', '2019-05-14 13:25:14');
INSERT INTO `pdt_images` VALUES ('121', '/images/2019-05-14_1557824012_5cda820c8cc53.jpg', null, '24', '2019-05-14 13:25:14', '2019-05-14 13:25:14');
INSERT INTO `pdt_images` VALUES ('122', '/images/2019-05-14_1557824012_5cda820ca556f.jpg', null, '24', '2019-05-14 13:25:14', '2019-05-14 13:25:14');
INSERT INTO `pdt_images` VALUES ('123', '/images/2019-05-14_1557824012_5cda820cba99f.jpg', null, '24', '2019-05-14 13:25:14', '2019-05-14 13:25:14');
INSERT INTO `pdt_images` VALUES ('128', '/images/2019-05-24_1558704741_5ce7f26522653.jpg', null, '27', '2019-05-24 13:33:48', '2019-05-24 13:33:48');
INSERT INTO `pdt_images` VALUES ('129', '/images/2019-05-24_1558704741_5ce7f26535331.jpg', null, '27', '2019-05-24 13:33:48', '2019-05-24 13:33:48');
INSERT INTO `pdt_images` VALUES ('131', '/images/2019-04-24_1556096822_5cc02736076c9.jpg', null, '14', '2019-05-25 01:10:23', '2019-05-25 01:10:23');
INSERT INTO `pdt_images` VALUES ('132', '/images/2019-05-25_1558769006_5ce8ed6eb2348.jpg', null, '28', '2019-05-25 07:23:28', '2019-05-25 07:23:28');
INSERT INTO `pdt_images` VALUES ('133', '/images/2019-05-25_1558769006_5ce8ed6ecb736.jpg', null, '28', '2019-05-25 07:23:28', '2019-05-25 07:23:28');
INSERT INTO `pdt_images` VALUES ('134', '/images/2019-05-25_1558769006_5ce8ed6ee6933.jpg', null, '28', '2019-05-25 07:23:28', '2019-05-25 07:23:28');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'system.manage', '系统管理', 'create new blog posts', '0', '2019-04-02 15:45:17', '2019-04-02 15:45:17');
INSERT INTO `permissions` VALUES ('2', 'system.user', '用户管理', 'users', '1', '2019-04-02 15:45:17', '2019-04-02 15:45:17');
INSERT INTO `permissions` VALUES ('3', 'system.user.create', '添加用户', '', '2', '2019-04-12 09:45:43', '2019-04-12 09:45:43');
INSERT INTO `permissions` VALUES ('4', 'member.manage', '会员管理', '', '0', '2019-04-12 10:23:59', '2019-04-12 10:44:35');
INSERT INTO `permissions` VALUES ('5', 'member.manage.create', '添加会员', '', '10', '2019-04-12 10:24:26', '2019-04-12 10:45:00');
INSERT INTO `permissions` VALUES ('6', 'system.user.del', '删除用户', '', '2', '2019-04-12 10:31:42', '2019-04-12 10:31:42');
INSERT INTO `permissions` VALUES ('7', 'system.user.edit', '编辑用户', '', '2', '2019-04-12 10:32:20', '2019-04-12 10:38:23');
INSERT INTO `permissions` VALUES ('8', 'member.manage.edit', '会员编辑', '', '10', '2019-04-12 10:39:32', '2019-04-12 10:45:12');
INSERT INTO `permissions` VALUES ('9', 'member.manage.del', '会员删除', '', '10', '2019-04-12 10:40:13', '2019-04-12 10:45:23');
INSERT INTO `permissions` VALUES ('10', 'member.member', '账号管理', '', '4', '2019-04-12 10:43:36', '2019-04-12 10:43:36');
INSERT INTO `permissions` VALUES ('11', 'system.role', '角色管理', '', '1', '2019-05-11 12:19:03', '2019-05-20 03:19:36');
INSERT INTO `permissions` VALUES ('12', 'system.role.create', '添加角色', '', '11', '2019-05-11 12:19:38', '2019-05-11 12:19:38');
INSERT INTO `permissions` VALUES ('13', 'system.role.del', '角色删除', '', '11', '2019-05-11 12:19:59', '2019-05-11 12:19:59');
INSERT INTO `permissions` VALUES ('14', 'system.role.edit', '编辑角色', '', '11', '2019-05-11 12:20:24', '2019-05-11 12:20:24');
INSERT INTO `permissions` VALUES ('15', 'category.manage', '分类管理', '', '0', '2019-05-20 03:20:14', '2019-05-20 03:20:14');
INSERT INTO `permissions` VALUES ('16', 'category.create', '添加分类', '', '21', '2019-05-20 03:21:02', '2019-05-20 03:52:54');
INSERT INTO `permissions` VALUES ('17', 'category.edit', '修改分类', '', '21', '2019-05-20 03:21:20', '2019-05-20 03:53:02');
INSERT INTO `permissions` VALUES ('18', 'category.del', '删除分类', '', '21', '2019-05-20 03:21:40', '2019-05-20 03:53:11');
INSERT INTO `permissions` VALUES ('19', 'product.manage', '商品管理', '', '0', '2019-05-20 03:51:15', '2019-05-20 03:51:15');
INSERT INTO `permissions` VALUES ('20', 'product.manage.list', '商品列表', '', '19', '2019-05-20 03:52:09', '2019-05-20 03:52:09');
INSERT INTO `permissions` VALUES ('21', 'category.manage.list', '分类列表', '', '15', '2019-05-20 03:52:42', '2019-05-20 03:52:42');
INSERT INTO `permissions` VALUES ('22', 'product.manage.create', '添加商品', '', '20', '2019-05-20 03:57:15', '2019-05-20 03:57:15');
INSERT INTO `permissions` VALUES ('23', 'product.manage.edit', '修改商品', '', '20', '2019-05-23 08:42:57', '2019-05-23 08:42:57');
INSERT INTO `permissions` VALUES ('24', 'product.manage.del', '删除商品', '', '20', '2019-05-23 08:43:26', '2019-05-23 08:43:26');
INSERT INTO `permissions` VALUES ('25', 'order.manage', '订单管理', '', '0', '2019-05-24 12:28:41', '2019-05-24 12:28:41');
INSERT INTO `permissions` VALUES ('26', 'site.manage', '站点管理', '', '0', '2019-05-24 12:29:01', '2019-05-24 12:29:01');
INSERT INTO `permissions` VALUES ('27', 'order.manage.list', '订单列表', '', '25', '2019-05-24 12:44:31', '2019-05-24 12:44:31');
INSERT INTO `permissions` VALUES ('28', 'order.manage.look', '查看订单', '', '27', '2019-05-24 12:45:15', '2019-05-24 12:55:30');
INSERT INTO `permissions` VALUES ('29', 'order.manage.edit', '编辑订单', '', '27', '2019-05-24 12:45:39', '2019-05-24 12:55:39');
INSERT INTO `permissions` VALUES ('30', 'site.manage.slide', '轮播图列表', '', '26', '2019-05-24 12:47:03', '2019-05-24 12:47:03');
INSERT INTO `permissions` VALUES ('31', 'site.manage.slide.create', '添加轮播图', '', '30', '2019-05-24 12:47:44', '2019-05-24 12:47:44');
INSERT INTO `permissions` VALUES ('32', 'site.manage.slide.del', '删除轮播图', '', '30', '2019-05-24 12:48:23', '2019-05-24 12:48:23');
INSERT INTO `permissions` VALUES ('33', 'member.manage.change', '会员状态编辑', '', '10', '2019-05-24 12:54:22', '2019-05-24 12:54:22');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');
INSERT INTO `permission_role` VALUES ('2', '1');
INSERT INTO `permission_role` VALUES ('3', '1');
INSERT INTO `permission_role` VALUES ('4', '1');
INSERT INTO `permission_role` VALUES ('5', '1');
INSERT INTO `permission_role` VALUES ('6', '1');
INSERT INTO `permission_role` VALUES ('7', '1');
INSERT INTO `permission_role` VALUES ('8', '1');
INSERT INTO `permission_role` VALUES ('9', '1');
INSERT INTO `permission_role` VALUES ('10', '1');
INSERT INTO `permission_role` VALUES ('11', '1');
INSERT INTO `permission_role` VALUES ('12', '1');
INSERT INTO `permission_role` VALUES ('13', '1');
INSERT INTO `permission_role` VALUES ('14', '1');
INSERT INTO `permission_role` VALUES ('15', '1');
INSERT INTO `permission_role` VALUES ('16', '1');
INSERT INTO `permission_role` VALUES ('17', '1');
INSERT INTO `permission_role` VALUES ('18', '1');
INSERT INTO `permission_role` VALUES ('19', '1');
INSERT INTO `permission_role` VALUES ('20', '1');
INSERT INTO `permission_role` VALUES ('21', '1');
INSERT INTO `permission_role` VALUES ('22', '1');
INSERT INTO `permission_role` VALUES ('23', '1');
INSERT INTO `permission_role` VALUES ('24', '1');
INSERT INTO `permission_role` VALUES ('26', '1');
INSERT INTO `permission_role` VALUES ('30', '1');
INSERT INTO `permission_role` VALUES ('31', '1');
INSERT INTO `permission_role` VALUES ('32', '1');
INSERT INTO `permission_role` VALUES ('33', '1');
INSERT INTO `permission_role` VALUES ('4', '3');
INSERT INTO `permission_role` VALUES ('5', '3');
INSERT INTO `permission_role` VALUES ('8', '3');
INSERT INTO `permission_role` VALUES ('9', '3');
INSERT INTO `permission_role` VALUES ('10', '3');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `preview` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_sale` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在卖 0 否 1是',
  `rating` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '商品平均平分',
  `sold_count` int(10) NOT NULL DEFAULT '0' COMMENT '销量',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('12', '4', '七头美丽玫瑰仿真花束', '', '79.11', '/images/2019-04-24_1556107321_5cc05039510cb.jpg', '1', '0.00', '0', '2019-04-24 08:48:26', '2019-04-24 12:25:07');
INSERT INTO `product` VALUES ('13', '4', '七头美丽玫瑰仿真花束2', '123', '78.00', '/images/2019-04-24_1556107328_5cc050402b37c.jpg', '1', '1.00', '1', '2019-04-24 08:49:16', '2019-04-24 12:02:09');
INSERT INTO `product` VALUES ('14', '4', '七头美丽玫瑰仿真花束3', '', '123.00', '/images/2019-05-25_1558746620_5ce895fcd2337.jpg', '1', '1.00', '23', '2019-04-24 09:07:03', '2019-05-25 01:10:23');
INSERT INTO `product` VALUES ('15', '4', '七头美丽玫瑰仿真花束4', '【破损补寄】【适合放室内、卧室、书房、餐桌、办公室、客厅、电视柜等地方】【无理由退换货】【包邮】【白色现代简约花瓶】', '22.00', '/images/2019-04-24_1556107195_5cc04fbbc614f.jpg', '1', '23.00', '23', '2019-04-24 11:55:56', '2019-05-14 11:31:33');
INSERT INTO `product` VALUES ('16', '4', '哇哈哈哈', '非常好的商品', '12.00', '/images/2019-05-08_1557304343_5cd29417b4a84.jpg', '1', '123.00', '123', '2019-05-08 08:35:23', '2019-05-14 13:21:23');
INSERT INTO `product` VALUES ('24', '5', '彩虹', '无敌的彩虹工艺', '112.00', '/images/2019-05-14_1557825895_5cda8967b08a5.jpg', '1', '12.00', '123', '2019-05-14 08:53:33', '2019-05-14 13:25:14');
INSERT INTO `product` VALUES ('25', '4', '按时缴费卡', '我发哈数据库电话', '555.00', '/images/2019-05-14_1557829061_5cda95c5bcc14.jpg', '1', '0.00', '0', '2019-05-14 10:17:49', '2019-05-14 10:17:49');
INSERT INTO `product` VALUES ('26', '5', '噢噢噢噢', '好看的', '555.00', '/images/2019-05-14_1557833434_5cdaa6da8c78e.jpg', '1', '10.00', '23', '2019-05-14 11:30:43', '2019-05-14 13:25:03');
INSERT INTO `product` VALUES ('27', '21', '农夫山泉', '好东西', '1111.00', '/images/2019-05-24_1558704733_5ce7f25d70020.jpg', '1', '1.00', '1', '2019-05-24 13:32:22', '2019-05-24 13:33:48');
INSERT INTO `product` VALUES ('28', '5', '桌是1', '1', '123.00', '/images/2019-05-25_1558768999_5ce8ed67f28f8.jpg', '1', '1.00', '1', '2019-05-25 07:23:28', '2019-05-25 07:23:28');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'root', '超级管理员', '至高无上的权限1', '2019-04-12 19:37:54', '2019-04-13 06:47:28');
INSERT INTO `roles` VALUES ('3', 'user', '会员管理员', '', '2019-05-11 12:34:16', '2019-05-11 12:34:16');
INSERT INTO `roles` VALUES ('4', 'order', '订单管理员', '', '2019-05-24 13:29:07', '2019-05-24 13:29:07');

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1');
INSERT INTO `role_user` VALUES ('6', '3');
INSERT INTO `role_user` VALUES ('7', '4');

-- ----------------------------
-- Table structure for site
-- ----------------------------
DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of site
-- ----------------------------

-- ----------------------------
-- Table structure for site_image
-- ----------------------------
DROP TABLE IF EXISTS `site_image`;
CREATE TABLE `site_image` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of site_image
-- ----------------------------
INSERT INTO `site_image` VALUES ('1', '/img/banner1.jpg', '0', '2019-04-24 15:09:18', '2019-04-24 15:09:20');
INSERT INTO `site_image` VALUES ('7', '/images/2019-04-24_1556093382_5cc019c65472d.jpg', '2', '2019-04-24 16:09:43', '2019-04-24 16:23:34');
INSERT INTO `site_image` VALUES ('9', '/images/2019-04-24_1556093668_5cc01ae4044fd.jpg', '0', '2019-04-24 16:14:29', '2019-04-24 16:14:29');

-- ----------------------------
-- Table structure for temp_email
-- ----------------------------
DROP TABLE IF EXISTS `temp_email`;
CREATE TABLE `temp_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deadline` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of temp_email
-- ----------------------------
INSERT INTO `temp_email` VALUES ('4', '14', 'c1341f52-ad5d-4c1b-7347-74f7f084e1c6', '2018-10-27 07:25:30');
INSERT INTO `temp_email` VALUES ('5', '15', '66ff2736-df93-4c35-926a-e9c97291a1be', '2018-10-27 07:38:57');
INSERT INTO `temp_email` VALUES ('6', '28', 'be59e6e5-891d-25dc-9532-e449b5bd80ab', '2019-04-30 17:14:14');
INSERT INTO `temp_email` VALUES ('7', '29', 'd5ed854d-1088-0f21-50f0-375336d808d7', '2019-04-30 17:14:53');
INSERT INTO `temp_email` VALUES ('8', '30', 'add2f08b-56f1-b611-eb0e-3fe7b9b1aa79', '2019-04-30 17:15:57');
INSERT INTO `temp_email` VALUES ('9', '31', '4d8eef18-130f-327e-3c2f-1388533db165', '2019-04-30 17:16:09');
INSERT INTO `temp_email` VALUES ('10', '32', '6eea17d9-7a60-fdba-f012-411ec78b11c6', '2019-04-30 17:19:59');
INSERT INTO `temp_email` VALUES ('11', '34', '9ae393d8-6430-ba5d-e746-b29edc8dad6b', '2019-04-30 17:21:59');
INSERT INTO `temp_email` VALUES ('12', '35', 'f1c6770b-840d-41bf-13a0-ad18f333304e', '2019-04-30 17:22:27');

-- ----------------------------
-- Table structure for temp_phone
-- ----------------------------
DROP TABLE IF EXISTS `temp_phone`;
CREATE TABLE `temp_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(6) NOT NULL,
  `deadline` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of temp_phone
-- ----------------------------
INSERT INTO `temp_phone` VALUES ('1', '15212119227', '933841', '2018-10-24 13:34:57');
INSERT INTO `temp_phone` VALUES ('2', '15212119227', '715095', '2018-10-25 01:31:51');
INSERT INTO `temp_phone` VALUES ('3', '15212119227', '414942', '2018-10-25 02:21:27');
INSERT INTO `temp_phone` VALUES ('4', '15212119227', '255594', '2018-10-25 11:33:13');
INSERT INTO `temp_phone` VALUES ('5', '15212119227', '699260', '2018-10-25 11:39:04');
INSERT INTO `temp_phone` VALUES ('6', '15212119227', '119224', '2019-03-14 11:40:59');
INSERT INTO `temp_phone` VALUES ('7', '15212119227', '143362', '2019-03-14 11:52:54');
INSERT INTO `temp_phone` VALUES ('8', '15212119227', '781422', '2019-03-14 11:53:13');
INSERT INTO `temp_phone` VALUES ('9', '15212119227', '293024', '2019-03-14 11:55:17');
INSERT INTO `temp_phone` VALUES ('10', '15212119227', '338470', '2019-03-14 11:56:51');
INSERT INTO `temp_phone` VALUES ('11', '15212119227', '213212', '2019-04-29 06:03:25');
INSERT INTO `temp_phone` VALUES ('12', '15212119227', '481093', '2019-04-29 16:49:14');
INSERT INTO `temp_phone` VALUES ('13', '15212119227', '646686', '2019-04-29 17:03:09');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0禁用1启用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'root', '15212119227', '超超级管理员', 'aaaaa@qq.com', '$2y$10$VR2I/Bq/SjPsEHuL7kJWkenYvSudQl.F7cjzb.x/JDicFM1wq3cUy', 'Iod8ji5RNwmvZ53YHwl3fIYceQvdRI8DLxEUSZI7YAODgx2k6TEcOHDmnHWF', '1', '2019-04-10 11:16:27', '2019-05-25 07:24:00', null);
INSERT INTO `users` VALUES ('6', 'hua', '15212119211', 'hahaha', 'afa@qq.com', '$2y$10$GNxCbYTAWmXfMH.zt7OR3uaWpXH340BhrvSNYdRzNowwi.g9sIcEC', 'FIFyUTOoq0C4Ksjhhg0evDJWxuAaF82QcoinqNYuKNNq8V46uSgNSEGlZA8j', '1', '2019-04-10 10:52:51', '2019-05-24 13:27:56', null);
INSERT INTO `users` VALUES ('7', 'admin', '15212119222', '管理员', '123412@qq.com', '$2y$10$CayItrFX9RnZeYdPckTLrejdA035IC1hkjinzu/LcVriSolPFte4q', null, '1', '2019-05-24 13:28:33', '2019-05-24 13:28:33', null);
