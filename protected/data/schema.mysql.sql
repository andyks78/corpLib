CREATE DATABASE `corp_lib`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

	
CREATE TABLE `author` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` TEXT COLLATE utf8_general_ci NOT NULL,
  `date_create` INTEGER(11) NOT NULL,
  `date_edit` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE `author` ADD UNIQUE `uniq_name` (`name`(1));


CREATE TABLE `book` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` TEXT COLLATE utf8_general_ci NOT NULL,
  `date_create` INTEGER(11) NOT NULL,
  `date_edit` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE `book` ADD UNIQUE `uniq_name` (`name`(1));


CREATE TABLE `reader` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` TEXT COLLATE utf8_general_ci NOT NULL,
  `date_create` INTEGER(11) NOT NULL,
  `date_edit` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE `reader` ADD UNIQUE `uniq_name` (`name`(1));


CREATE TABLE `book_author` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `book` BIGINT(20) NOT NULL,
  `author` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE `book_author` ADD INDEX  (`book`);
ALTER TABLE `book_author` ADD CONSTRAINT `book_author_fk2book` FOREIGN KEY (`book`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `book_author` ADD INDEX  (`author`);
ALTER TABLE `book_author` ADD CONSTRAINT `book_author_fk2author` FOREIGN KEY (`author`) REFERENCES `author` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


CREATE TABLE `book_reader` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `book` BIGINT(20) NOT NULL,
  `reader` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
ALTER TABLE `book_reader` ADD INDEX  (`book`);
ALTER TABLE `book_reader` ADD CONSTRAINT `book_reader_fk2book` FOREIGN KEY (`book`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `book_reader` ADD INDEX  (`reader`);
ALTER TABLE `book_reader` ADD CONSTRAINT `book_reader_fk2reader` FOREIGN KEY (`reader`) REFERENCES `reader` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;