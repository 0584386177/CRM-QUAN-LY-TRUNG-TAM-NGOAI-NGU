<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserServiceInterface
{
    public function paginate(array $params);
    public function create(array $request);
    public function update($id, array $request);
    public function delete(int $id);
}
