/*
 Navicat Premium Data Transfer

 Source Server         : 1
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : localhost:3306
 Source Schema         : music_platform

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 03/04/2023 00:14:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for albums
-- ----------------------------
DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `singer_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `release_time` date NOT NULL,
  `status` enum('normal','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `singer_id`(`singer_id`) USING BTREE,
  CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`singer_id`) REFERENCES `singers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of albums
-- ----------------------------

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `object_type` enum('music','singer','playlist') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `object_id` int(10) UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('normal','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2023_04_01_043914_create_playlist_song_table', 1);

-- ----------------------------
-- Table structure for music_albums
-- ----------------------------
DROP TABLE IF EXISTS `music_albums`;
CREATE TABLE `music_albums`  (
  `music_id` int(10) UNSIGNED NOT NULL,
  `album_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`music_id`, `album_id`) USING BTREE,
  INDEX `album_id`(`album_id`) USING BTREE,
  CONSTRAINT `music_albums_ibfk_1` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `music_albums_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of music_albums
-- ----------------------------

-- ----------------------------
-- Table structure for music_tags
-- ----------------------------
DROP TABLE IF EXISTS `music_tags`;
CREATE TABLE `music_tags`  (
  `music_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`music_id`, `tag_id`) USING BTREE,
  INDEX `tag_id`(`tag_id`) USING BTREE,
  CONSTRAINT `music_tags_ibfk_1` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `music_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of music_tags
-- ----------------------------

-- ----------------------------
-- Table structure for musics
-- ----------------------------
DROP TABLE IF EXISTS `musics`;
CREATE TABLE `musics`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `singer_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `duration` int(10) UNSIGNED NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `music_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `play_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('normal','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `singer_id`(`singer_id`) USING BTREE,
  CONSTRAINT `musics_ibfk_1` FOREIGN KEY (`singer_id`) REFERENCES `singers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of musics
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for playlist_songs
-- ----------------------------
DROP TABLE IF EXISTS `playlist_songs`;
CREATE TABLE `playlist_songs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `playlist_id` bigint(20) UNSIGNED NOT NULL,
  `song_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `playlist_song_playlist_id_foreign`(`playlist_id`) USING BTREE,
  INDEX `playlist_song_song_id_foreign`(`song_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 68 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of playlist_songs
-- ----------------------------
INSERT INTO `playlist_songs` VALUES (53, 1, 1, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (67, 1, 16, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (66, 1, 15, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (65, 1, 14, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (64, 1, 13, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (63, 1, 12, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (62, 1, 11, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (61, 1, 10, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (60, 1, 9, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (59, 1, 8, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (58, 1, 7, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (57, 1, 6, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (56, 1, 5, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (55, 1, 4, NULL, NULL);
INSERT INTO `playlist_songs` VALUES (54, 1, 3, NULL, NULL);

-- ----------------------------
-- Table structure for playlist_tags
-- ----------------------------
DROP TABLE IF EXISTS `playlist_tags`;
CREATE TABLE `playlist_tags`  (
  `playlist_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`playlist_id`, `tag_id`) USING BTREE,
  INDEX `tag_id`(`tag_id`) USING BTREE,
  CONSTRAINT `playlist_tags_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `playlist_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of playlist_tags
-- ----------------------------

-- ----------------------------
-- Table structure for playlists
-- ----------------------------
DROP TABLE IF EXISTS `playlists`;
CREATE TABLE `playlists`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `favorite_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('normal','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of playlists
-- ----------------------------
INSERT INTO `playlists` VALUES (1, 2, '默认试听列表', NULL, NULL, 0, 'normal', '2023-04-01 04:24:38', '2023-04-01 04:24:38');

-- ----------------------------
-- Table structure for replies
-- ----------------------------
DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `reply_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('normal','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comment_id`(`comment_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of replies
-- ----------------------------

-- ----------------------------
-- Table structure for reports
-- ----------------------------
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `object_type` enum('comment','reply') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `object_id` int(10) UNSIGNED NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `report_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','processed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reports
-- ----------------------------

-- ----------------------------
-- Table structure for singer_tags
-- ----------------------------
DROP TABLE IF EXISTS `singer_tags`;
CREATE TABLE `singer_tags`  (
  `singer_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`singer_id`, `tag_id`) USING BTREE,
  INDEX `tag_id`(`tag_id`) USING BTREE,
  CONSTRAINT `singer_tags_ibfk_1` FOREIGN KEY (`singer_id`) REFERENCES `singers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `singer_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of singer_tags
-- ----------------------------

-- ----------------------------
-- Table structure for singers
-- ----------------------------
DROP TABLE IF EXISTS `singers`;
CREATE TABLE `singers`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `introduction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('normal','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of singers
-- ----------------------------

-- ----------------------------
-- Table structure for songs
-- ----------------------------
DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `songid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `artist` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `album` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `duration` int(10) UNSIGNED NULL DEFAULT NULL,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('normal','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of songs
-- ----------------------------
INSERT INTO `songs` VALUES (1, '27907401', '玩具塔塔外', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-01 17:26:40', '2023-04-01 17:26:40');
INSERT INTO `songs` VALUES (3, '30482578', '魔法密林', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-01 17:44:41', '2023-04-01 17:44:41');
INSERT INTO `songs` VALUES (4, '33856223', 'MapleStory', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-01 17:44:47', '2023-04-01 17:44:47');
INSERT INTO `songs` VALUES (5, '29572578', '时间神殿', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-01 17:44:49', '2023-04-01 17:44:49');
INSERT INTO `songs` VALUES (6, '27907392', '天空之城', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-01 17:44:54', '2023-04-01 17:44:54');
INSERT INTO `songs` VALUES (7, '29572363', '明珠港', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-02 05:10:24', '2023-04-02 05:10:24');
INSERT INTO `songs` VALUES (8, '27907398', '玩具城', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-02 05:10:32', '2023-04-02 05:10:32');
INSERT INTO `songs` VALUES (9, '29810786', '魔法密林怪物地带', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-02 05:10:48', '2023-04-02 05:10:48');
INSERT INTO `songs` VALUES (10, '27907395', '通天塔组队任务', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-02 05:11:32', '2023-04-02 05:11:32');
INSERT INTO `songs` VALUES (11, '27907411', '勇士部落', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-02 05:12:14', '2023-04-02 05:12:14');
INSERT INTO `songs` VALUES (12, '27907390', '台湾不夜城', 'StudioEIM', NULL, NULL, NULL, NULL, 'normal', '2023-04-02 05:18:05', '2023-04-02 05:18:05');
INSERT INTO `songs` VALUES (13, '29810752', '游戏商城', 'StudioEIM', NULL, NULL, NULL, 'http://m7.music.126.net/20230402134806/253ea2986ea920f8edb52413192b4d7e/ymusic/775f/b5e9/2168/43fdbf306a417cb9108b5aa414338759.mp3', 'normal', '2023-04-02 05:23:05', '2023-04-02 05:23:05');
INSERT INTO `songs` VALUES (14, '30482580', '魔法密林-树洞', 'StudioEIM', NULL, NULL, NULL, 'http://m7.music.126.net/20230402144002/83f41fe924e2e81bb1a58a67a4d0107a/ymusic/c7cc/2cdd/d82b/dfc2897d7867e27a4050ae2ffd911bcb.mp3', 'normal', '2023-04-02 06:15:01', '2023-04-02 06:15:01');
INSERT INTO `songs` VALUES (15, '167827', '素颜', '许嵩', NULL, NULL, NULL, 'http://m801.music.126.net/20230402164101/3ef43d1fd50617be42768f7895f593a1/jdymusic/obj/wo3DlMOGwrbDjj7DisKw/14080948558/766a/a28b/ff92/6558894fc94f8f7b641d774149a088db.mp3', 'normal', '2023-04-02 08:16:01', '2023-04-02 08:16:01');
INSERT INTO `songs` VALUES (16, '167655', '幻听', '许嵩', NULL, NULL, NULL, 'http://m801.music.126.net/20230402233055/2022ca7a4dce3230730c077f0e87e22f/jdymusic/obj/wo3DlMOGwrbDjj7DisKw/14096602465/4884/6d96/3e49/0f565432c77fabdc0ff003cbab478687.mp3', 'normal', '2023-04-02 15:05:55', '2023-04-02 15:05:55');

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tags
-- ----------------------------

-- ----------------------------
-- Table structure for user_favorites
-- ----------------------------
DROP TABLE IF EXISTS `user_favorites`;
CREATE TABLE `user_favorites`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `favorite_type` enum('music','playlist') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `object_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `favorite_type`, `object_id`) USING BTREE,
  CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_favorites
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `register_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_time` timestamp NULL DEFAULT NULL,
  `status` enum('normal','banned') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'normal',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Princehens', '000012', '546788464@qq.com', NULL, '2023-03-26 16:04:35', NULL, 'normal', '');
INSERT INTO `users` VALUES (2, 'Crutithne', '$2y$10$993soBrKwUcaBsxhoQsQbuTMN0SkRPO2JPlwNcxfy2ENuYUZjOhCW', '2543488789@qq.com', NULL, '2023-03-28 18:11:24', NULL, 'normal', 'rtTIXlX0NF4HQQ8TXhmN1sFUjq2aCQg3N1GKS6OhNiLVYEpi7jTeOLN7RcSQ');

SET FOREIGN_KEY_CHECKS = 1;
