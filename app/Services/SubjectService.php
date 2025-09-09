<?php

namespace App\Services;

use App\Repositories\SubjectRepositoryEloquent;
use App\Services\Interfaces\SubjectServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class SubjectService
 * @package App\Services
 */
class SubjectService implements SubjectServiceInterface
{
    protected $subjectRepo;

    public function __construct(SubjectRepositoryEloquent $subjectRepo)
    {
        $this->subjectRepo = $subjectRepo;
    }
    public function paginate(array $params)
    {

        $limit = (!empty($params['limit']) && (int)$params['limit'] > 0) ? (int) $params['limit'] : config("repository.pagination.limit");

        $params['limit'] = $limit > 100 ? 100 : $limit;

        return $this->subjectRepo->with(['teachers', 'students'])->paginate($params['limit']);
    }
    public function create(array $payload)
    {
        DB::beginTransaction();
        try {
            if (isset($payload) && !empty($payload)) {
                $subject = $this->subjectRepo->create($payload);
                $subject->teachers()->attach($payload['teacher_id']);
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

        if (isset($payload['fee']) || !empty($payload['fee'])) {
            // \D = mọi thứ KHÔNG phải số
            $payload['fee'] =  preg_replace('/\D/', '', $payload['fee']);
        }
        DB::beginTransaction();
        try {
            $subject = $this->subjectRepo->find($id);
            if ($subject) {
                $teacher = $subject->teachers()->sync($payload['teacher_id']);
                $this->subjectRepo->update($payload, $id);
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

        DB::beginTransaction();

        try {
            $subject = $this->subjectRepo->find($id);
            if ($subject) {
                $subject->teachers()->detach();
            }
            $this->subjectRepo->delete($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            exit();
            return false;
        }
    }
}
