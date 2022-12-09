<?php declare(strict_types=1);

require_once(__DIR__.'/../Database/Database.php');

class Recipe {
    public static function getRecipeById(int $id) : object {
        return Database::getRow($id);
    }

    public static function getHomeItemColumns(array $ids) : array {
        return Database::homeItemColumns($ids);
    }

    public static function getMaxId() : int {
        return Database::getMaxId();
    }

    public static function getPaginationItems(int $page) : array {
        return Database::getPaginationItems($page);
    }
}