<?php

namespace app\core;

abstract class Migration {

    abstract public function up();

    abstract public function down();

    protected static function exec(string $sql) {
        Application::$app->db->pdo->exec($sql);
    }

}