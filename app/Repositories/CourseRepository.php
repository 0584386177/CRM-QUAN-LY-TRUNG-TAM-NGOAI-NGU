<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;


interface CourseRepository extends RepositoryInterface
{
    public function filter(array $filter);
}
