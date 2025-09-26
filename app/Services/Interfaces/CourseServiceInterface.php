<?php

namespace App\Services\Interfaces;


interface CourseServiceInterface
{

    public function paginate(array $params);

    public function create(array $payload);

    public function update($id, array $payload);
    public function delete($id);
}
