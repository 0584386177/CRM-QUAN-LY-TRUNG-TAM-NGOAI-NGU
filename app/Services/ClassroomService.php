<?php

namespace App\Services;

use App\Repositories\ClassroomRepository;
use App\Services\Interfaces\ClassroomServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ClassroomService
 * @package App\Services
 */
class ClassroomService implements ClassroomServiceInterface
{

    protected $classroomRepo;
    public function __construct(ClassroomRepository $classroomRepo)
    {
        $this->classroomRepo = $classroomRepo;
    }
    public function paginate(array $params)
    {

        $limit = (!empty($params['limit']) && (int) $params['limit'] > 0) ? (int) $params['limit'] : config("repository.pagination.limit");
        return $this->classroomRepo->with(['subject', 'teachers'])->paginate($limit);
    }


    public function create(array $payload)
    {

        DB::beginTransaction();

        try {
            if (isset($payload) && !empty($payload)) {
                if (!$payload['teacher_id']) return false;

                $classroom = $this->classroomRepo->create($payload);
                $classroom->teachers()->attach($payload['teacher_id']);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollBack();
            exit();
            return false;
        }
    }


    public function update($id, array $payload)
    {

        DB::beginTransaction();

        try {
            if ($this->classroomRepo->find($id)) {
                $this->classroomRepo->update($payload, $id);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
    
    public function delete($id)
    {
        $classroom = $this->classroomRepo->find($id);
        DB::beginTransaction();

        try {
            if ($classroom) {
                $detach =  $classroom->subject_id->detach();
                $this->classroomRepo->delete($id);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
