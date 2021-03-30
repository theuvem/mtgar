<?php

use app\core\Migration;

class m0002_verifications extends Migration {

    public function up() {
        self::exec("
            CREATE TABLE `verifications` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user` INT NOT NULL,
                `type` TINYINT NOT NULL,
                `code` CHAR(32) NOT NULL,
                `used` BIT DEFAULT 0,
                `expired` BIT DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                FOREIGN KEY (`user`) REFERENCES `users`(`id`)
            ) ENGINE=INNODB;
        ");
    }

    public function down() {
        self::exec("DROP TABLE `verifications`;");
    }

}