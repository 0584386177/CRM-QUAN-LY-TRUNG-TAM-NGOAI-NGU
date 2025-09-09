<?php

namespace App\Services\Interfaces;

/**
 * Interface ClassroomServiceInterface
 * @package App\Services\Interfaces
 */
interface ClassroomServiceInterface
{

    public function paginate(array $params);
    public function create(array $payload);
    public function update(int $id, array $payload);

    public function delete(int $id);
}
