<?php

namespace App\Repositories;

use App\Models\Course;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


class CourseRepositoryEloquent extends BaseRepository implements CourseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Course::class;
    }

    public function filter(array $filter = [])
    {

        $query = $this->model->query();

        $search = $filter['search'];

        $courses = $query->when($search, function ($q) use ($search) {
            $q
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhereRelation('teachers', 'fullname', 'LIKE', "{$search}");
        });

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
