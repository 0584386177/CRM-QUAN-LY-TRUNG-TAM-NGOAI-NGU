<?php

namespace App\Services\Interfaces;

/**
 * Interface StudentServiceInterface
 * @package App\Services\Interfaces
 */
interface StudentServiceInterface
{
    public function paginate(array $params);
    public function create(array $payload);
    public function update(int $id, array $request);
    public function updateTuition(int $id, $payload);
}
