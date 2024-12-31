<?php

namespace App\Services;

use App\Models\Param;
use Illuminate\Support\Collection;

class ParamService
{
    public static function store(array $data): Param
    {
        return Param::create($data);
    }

    public static function update(Param $param, array $data): Param
    {
        $param->update($data);
        return $param->fresh();
    }


    public static function indexByCategories(Collection $categoryChildren): Collection
    {

//        $arr = collect([]);
//        $categoryChildren->pluck('paramProducts')->each(function ($coll) use ($arr) {
//            $coll->each(function ($c)  use ($arr) {
//                $arr->push($c);
//            });
//        });

        $arr = [];
        foreach ($categoryChildren->load('paramProducts')->pluck('paramProducts') as $paramProducts) {
            $arr = array_merge($arr,  $paramProducts->toArray());
        }
        $arr = collect($arr);

        $params = Param::whereIn('id', $arr->pluck('param_id')->unique())->get();
        $arr = $arr->groupBy('param_id');

        foreach ($params as $param) {
            $param->param_values = $arr[$param->id]->unique('value')->sortBy('value')->pluck('value')->toArray();
        }

        return $params;

    }
}
