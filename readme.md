## 关于zApi


```
CREATE TABLE `dy_cookies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cookies` varchar(255) COLLATE utf8mb4_bin DEFAULT '',
  `err_times` tinyint(3) unsigned DEFAULT '0',
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='缓存cookies';
```
