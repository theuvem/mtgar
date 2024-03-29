<?php

use app\core\Migration;

class m0004_decks extends Migration {

    public function up() {
        self::exec(<<<'SQL'
            CREATE TABLE `decks` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `display_id` CHAR(8) COLLATE 'utf8mb4_bin' UNIQUE NOT NULL,
                `user` INT NOT NULL,
                `title` VARCHAR(48) NOT NULL,
                `description` VARCHAR(128) NOT NULL,
                `colors` VARCHAR(5) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                FOREIGN KEY (`user`)
                    REFERENCES `users`(`id`)
                    ON DELETE CASCADE
            ) ENGINE=INNODB;
        SQL);
    }

    public function down() {
        self::exec(<<<'SQL'
            DROP TABLE `decks`;
        SQL);
    }

}