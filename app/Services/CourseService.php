<?php

namespace App\Services;

use App\Models\Classroom;
use App\Repositories\CourseRepositoryEloquent;
use App\Services\Interfaces\CourseServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;


class CourseService implements CourseServiceInterface
{
    protected $courseRepo;

    public function __construct(CourseRepositoryEloquent $courseRepo)
    {
        $this->courseRepo = $courseRepo;
    }
    public function paginate(array $params)
    {

        $limit = (!empty($params['limit']) && (int) $params['limit'] > 0) ? (int) $params['limit'] : config("repository.pagination.limit");

        $params['limit'] = $limit > 100 ? 100 : $limit;

        return $this->courseRepo->with(['teachers', 'students'])->paginate($params['limit']);
    }
    public function create(array $payload)
    {
        return DB::transaction(function () use ($payload) {

            if (isset($payload) && !empty($payload)) {
                $course = $this->courseRepo->create($payload);
                $course->teachers()->attach($payload['teacher_id']);
                return true;
            }
        });
    }

    public function update($id, array $payload)
    {

        if (isset($payload['fee']) || !empty($payload['fee'])) {
            // \D = chỉ lấy số
            $payload['fee'] = preg_replace('/\D/', '', $payload['fee']);
        }
        DB::beginTransaction();
        try {
            $course = $this->courseRepo->find($id);
            if ($course) {
                $teacher = $course->teachers()->sync($payload['teacher_id']);
                $this->courseRepo->update($payload, $id);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            exit();
            return false;
        }
    }
    public function delete($id)
    {

        return DB::transaction(function () use ($id) {
            $course = $this->courseRepo->find($id);

            if (!$course) {
                throw new Exception('Không tìm thấy thông tin khóa học này ');
            }

            if (Classroom::where('course_id', $course->id)->exists()) {
                throw new Exception("Hiện đang còn lớp học đang học khóa . Thử lại sau khi lớp đã hoàn thành khóa học.");
            }
            $course->teachers()->detach();
            return $this->courseRepo->delete($id);
        });
    }
}
