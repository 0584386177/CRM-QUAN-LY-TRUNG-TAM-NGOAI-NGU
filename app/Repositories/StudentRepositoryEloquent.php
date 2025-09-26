<?php

namespace App\Repositories;

use App\Models\Student;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\StudentRepository;
use App\Validators\StudentValidator;

/**
 * Class StudentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StudentRepositoryEloquent extends BaseRepository implements StudentRepository
{
    /**`
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Student::class;
    }

    public function filter(array $filter = [])
    {
        $query = $this->model->query();

        $search = $filter['search'];

        if (isset($search) && !empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $tuition = $filter['filter_tuition'];
        if ($tuition !== '' && !empty($tuition)) {
            $query->where(function ($q) use ($tuition) {
                $q->withWhereRelation('payments', 'fee_status', '=', $tuition);
            });
        }

        return $query->paginate(10);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
