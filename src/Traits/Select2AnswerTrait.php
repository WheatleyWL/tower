<?php


namespace App\Admin\Traits;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Select2AnswerTrait
{
    protected function select2Answer(Builder $query, Request $request, $searchByField, $showField, $limit = 10)
    {
        $q = $request->input('q');
//        $type = $request->input('_type');
        $page = $request->input('page');

        $query->take($limit);

        if($q !== null) {
            $query->fullTextSearch($searchByField, $q);
        }


        $count = $query->count();
        $skip = $limit * intval($page);

        if($page !== null) {
            $query->skip($skip);
        }

        $items = $query->get()->map(function ($item, $key) use ($showField) {
            return [
                'id' => $item->id,
                'text' => $item->$showField,
            ];
        });

        $answer = [
            'results' => $items,
            'pagination' => ['more' => $count > $skip ]
        ];

        return $answer;

    }

}
