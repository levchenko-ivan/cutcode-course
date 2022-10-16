CREATE DATABASE IF NOT EXISTS `cutcode_shop`;
CREATE DATABASE IF NOT EXISTS `cutcode_shop_test`;

CREATE USER IF NOT EXISTS 'cutcode_shop'@'%' IDENTIFIED BY '12345';

GRANT ALL PRIVILEGES ON `cutcode_shop`.* TO 'cutcode_shop'@'%';
GRANT ALL PRIVILEGES ON `cutcode_shop_test`.* TO 'cutcode_shop'@'%';

GRANT SELECT  ON `information\_schema`.* TO 'cutcode_shop'@'%';
FLUSH PRIVILEGES;

SET GLOBAL time_zone = 'Europe/Moscow';
