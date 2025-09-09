<?php

namespace App\Services;

use App\Repositories\StudentRepositoryEloquent;
use App\Services\Interfaces\StudentServiceInterface;
use App\Trait\UploadFileTrait;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class StudentService
 * @package App\Services
 */
class StudentService implements StudentServiceInterface
{
    use UploadFileTrait;
    protected $studentRepo;

    public function __construct(StudentRepositoryEloquent $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }
    public function paginate(array $params)
    {
        // Nếu có limit và > 0 thì dùng, ngược lại lấy mặc định từ config
        $limit = (!empty($params['limit']) && (int)$params['limit'] > 0)
            ? (int)$params['limit']
            : config('repository.pagination.limit', 15);

        // Giới hạn max
        $params['limit'] = $limit > 100 ? 100 : $limit;
        return $this->studentRepo->with(['classes', 'teachers', 'subjects'])->paginate($params['limit']);
    }


    public function create(array $payload)
    {
        DB::beginTransaction();
        try {

            $student = $this->studentRepo->create($payload);
            $student->classes()->sync($payload['class_id']);
            $student->subjects()->sync($payload['subject_id']);
            $student->teachers()->sync($payload['teacher_id']);
            DB::commit();
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollback();
            exit();
            return false;
        }
    }
    public function update($id, $payload)
    {

        $student = $this->studentRepo->find($id);
        DB::beginTransaction();
        try {
            if ($student) {
                $payload = $payload->except(['_token']);
                $student->subjects()->sync($payload['subject_id']);
                $this->studentRepo->update($payload, $id);
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
