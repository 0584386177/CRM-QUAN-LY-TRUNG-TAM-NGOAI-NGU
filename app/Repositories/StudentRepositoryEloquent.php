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

        $keyword = $filter['keyword'];

        if (isset($keyword) && !empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
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
