CREATE TABLE IF NOT EXISTS `secret`
(
    `hash`           varchar(32)  NOT NULL,
    `secretText`     varchar(256) NOT NULL,
    `createdAt`      timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    `expiresAt`      timestamp(6) NULL     DEFAULT NULL,
    `remainingViews` int(32)               DEFAULT '0',
    PRIMARY KEY (`hash`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
