CREATE TABLE `#__xcideveloper_projects` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`component`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`com_name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`extension_type`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`params`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`published`  tinyint(4) NULL DEFAULT NULL ,
`manifest`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
);