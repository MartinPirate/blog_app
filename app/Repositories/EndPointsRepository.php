<?php

namespace App\Repositories;

class EndPointsRepository
{

    /**
     * @return string
     */
    public static function getArticlesUrl(): string
    {
        return 'https://candidate-test.sq1.io/api.php';
    }
}
