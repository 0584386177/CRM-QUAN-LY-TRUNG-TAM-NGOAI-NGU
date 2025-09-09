<?php

namespace App\Services\Interfaces;

/**
 * Interface SubjectServiceInterface
 * @package App\Services\Interfaces
 */
interface SubjectServiceInterface
{

    public function paginate(array $params);

    public function create(array $payload);

    public function update($id, array $payload);
    public function delete($id);
}
