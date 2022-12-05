<?php declare(strict_types=1);

require_once(__DIR__.'/../Database/Database.php');

class Recipe {
    public static function getRecipeById(int $id) : object {
        $row = Database::getRow(1);

        return $row;
    }

}