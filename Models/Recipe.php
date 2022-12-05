<?php declare(strict_types=1);

require_once(__DIR__.'/../Database/Database.php');

class Recipe {
    public static function getRecipeById(int $id) : object {
        $row = Database::getRow($id);
        return $row;
    }

    public static function getHomeItemColumns(array $ids) {
        $rows = Database::homeItemColumns($ids);
        return $rows;
    }

    public static function getMaxId() {
        return Database::getMaxId();
    }
}