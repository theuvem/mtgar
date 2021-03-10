<?php

use app\core\Migration;

class m0000_init extends Migration {

    public function up() {
        $this->pdo->exec("
            CREATE TABLE `users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(16) NOT NULL UNIQUE,
                `password` CHAR(60) NOT NULL,
                `email` VARCHAR(255) NOT NULL UNIQUE,
                `status` TINYINT NOT NULL
            ) ENGINE=INNODB;
        ");
    }

    public function down() {
        $this->pdo->exec("DROP TABLE `users`;");
    }

}