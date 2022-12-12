<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

abstract class BaseRepository
{
    protected $entity;
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     *
     * General function to handle select cases
     *
     * @param select Array Pass array of columns to be selected
     * @param with String or Array of Relations to be selectd
     * @param withCount String or Array of Related count to be selected
     * @param join String or Array of table to be joined
     * eg $join = 'countries,countries.id,=,salary_ranges.country_id'
     * @param id return a single record
     * @param where key value array to add condition to query
     * @param order_by sorting on column name
     * @param order asc or desc
     * @param per_page if passed will return paginated response or all records
     *
     */
    public function getByParams($params, $tosql = false)
    {
        $records = [];

        $query = $this->entity::whereRaw('1=1');
        if (isset($params['select'])) {
            $query->select($params['select']);
        }

        // add relation to main object
        if (isset($params['with'])) {
            $withes = Arr::wrap($params['with']);
            foreach ($withes as $with) {
                $query->with($with);
            }
        }

        if (isset($params['withCount'])) {
            $withCounts = Arr::wrap($params['withCount']);
            foreach ($withCounts as $withCount) {
                $query->withCount($withCount);
            }
        }

        // add joins to main object
        if (isset($params['join'])) {
            $joins = Arr::wrap($params['join']);
            foreach ($joins as $join) {
                $parts = explode(',', $join);
                $query->leftJoin($parts[0], $parts[1], $parts[2], $parts[3]);
            }
        }

        // add joins to main object
        if (isset($params['leftjoin'])) {
            $joins = Arr::wrap($params['leftjoin']);
            foreach ($joins as $join) {
                $parts = explode(',', $join);
                $query->leftjoin($parts[0], $parts[1], $parts[2], $parts[3]);
            }
        }
        // return if single object is needed
        if (isset($params['id'])) {
            $query->where('id', $params['id']);
            $records = $query->first();
            return $records;
        }

        if (isset($params['where'])) {
            foreach ($params['where'] as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (isset($params['whereNot'])) {
            foreach ($params['whereNot'] as $key => $value) {
                $query->where($key, '!=', $value);
            }
        }

        if (isset($params['in'])) {
            foreach ($params['in'] as $key => $value) {
                $query->whereIn($key, $value);
            }
        }

        if (isset($params['not_in'])) {
            foreach ($params['not_in'] as $key => $value) {
                $query->whereNotIn($key, $value);
            }
        }

        if (isset($params['whereNull'])) {
            $query->whereNull($params['whereNull']);
        }

        if (isset($params['whereNotNull'])) {
            $query->whereNotNull($params['whereNotNull']);
        }

        if (isset($params['like'])) {
            $query->where(function ($query) use ($params) {
                foreach ($params['like'] as $key => $value) {
                    $query->orwhere($key, 'like', $value);
                }
            });
        }

        if (isset($params['OrLike'])) {
            $query->where(function ($query) use ($params) {
                foreach ($params['OrLike'] as $key => $value) {
                    $query->orwhere($value['column_name'], 'like', $value['value']);
                }
            });
        }

        if (isset($params['date_range'])) {
            $index = 0;
            foreach ($params['date_range'] as $key => $value) {
                if ($index == '1') {
                    $query->orWhereBetween($key, $value);
                } else {
                    $query->whereBetween($key, $value);
                }
                $index++;
            }
        }
        if (isset($params['whereDate'])) {
            foreach ($params['whereDate'] as $key => $value) {
                    $query->whereDate($key, '>=', $value[0]);
                    $query->whereDate($key, '<=', $value[1]);
            }
        }
        if (!empty($params['withTrashed'])) {
            $query->withTrashed();
        }
        if (isset($params['count'])) {
            $records = $query->count();
            return $records;
        }

        if (isset($params['order_by'])) {
            $order = isset($params['order']) ? $params['order'] : 'asc';
            $query->orderBy($params['order_by'], $order);
            // $query->orderBy('c.order_no', $order);
        }
        if (isset($params['order_by_other'])) {
            $order = isset($params['order']) ? $params['order'] : 'asc';
            $query->orderBy($params['order_by_other'], $order);
        }
        if (isset($params['order_by_value'])) {
            // dd($params);
            // $params['order_by_value'][1] = '111,112,4';
            $order = isset($params['order']) ? $params['order'] : 'asc';
            // $query->orderByRaw(DB::FIELD(".$params['order_by_value'][0].", ".$params['order_by_value'][1]." )), $order);
            $query->orderByRaw(DB::raw("FIELD(categories.id, ".$params['order_by_value'][1]." )"));
        }
        if (isset($params['group_by'])) {
            $query->groupby($params['group_by']);
        }
        if (isset($params['limit_by'])) {
            $query->limit($params['limit_by']);
        }
        if (isset($params['take']) && isset($params['skip'])) {
            $records = $query->skip($params['skip'])->take($params['take'])->get();
        }
        if (isset($params['per_page']) && is_numeric($params['per_page'])) {
            $records = $query->paginate($params['per_page']);
        } else {
            $records = $query->get();
        }
        if ($tosql) {
            dd($query->toSql());
        }
        return $records;
    }

    public function delete($id)
    {
        if (!is_numeric($id)) {
            abort(500);
        }
        $entity = $this->entity->find($id);
        
        if (!$entity)
            abort(404);

        try {
            $entity->delete();
            return true;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }

    public function save($params)
    {
        if (isset($params['id'])) {
            $entity = $this->entity->where(['id' => $params['id']])->update($params);
            return $entity;
        } else {
            $entity = $this->entity->insert($params);
            return $entity;
        }
    }
}