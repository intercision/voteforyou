
-- ----------------------------
-- Table structure for `vforyou_api_accesses_by_day`
-- ----------------------------
DROP TABLE IF EXISTS `vforyou_api_accesses_by_day`;
CREATE TABLE `vforyou_api_accesses_by_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_date` date DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_date` (`access_date`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
