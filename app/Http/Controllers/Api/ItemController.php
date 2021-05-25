<?php
namespace App\Http\Controllers\Api;

use App\Item;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;

class ItemController extends \App\Http\Controllers\Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    private function getValidationRules() {
        return [
            'expansion_id' => 'integer|min:1|max:99',
            'query'        => 'string|min:1|max:40',
        ];
    }

    /**
     * Lookup items similar to a given query.
     *
     * @param $query The name to search for.
     * @return \Illuminate\Http\Response
     */
    public function query($expansionId, $language, $query)
    {
        $validator = Validator::make([
            'expansion_id' => $expansionId,
            'query'        => $query
        ], $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json(['error' => 'Query did not pass validation. Query must be between 1 and 40 characters. Expansion ID must be between 1 and 99.'], 403);
        } else {
            if ($query && $query != " ") {
                $results = Item::whereHas('languages', function ($sql) use ($query, $language){
                    return $sql->where([
                        ['name', 'like', '%' . trim($query) . '%'],
                        ['language', $language]
                    ]);
                })->where('expansion_id', $expansionId)
                    ->orderByDesc('weight')
                    ->limit(15)
                    ->get();

                /*
                $results = Item::select(['name', 'item_id'])
                    ->where([
                        ['name', 'like', '%' . trim($query) . '%'],
                        ['expansion_id', $expansionId],
                    ])
                    // For a more performant/powerful query...
                    // ->whereRaw(
                    //     "MATCH(`items`.`name`) AGAINST(? IN BOOLEAN MODE)",
                    //     ['+' . $query . ''] // note the prefixed or suffixed character(s) https://dev.mysql.com/doc/refman/5.5/en/fulltext-boolean.html
                    // )
                    ->orderByDesc('weight')
                    ->limit(15)
                    ->get();
                */

                // For testing the query time:
                // $start = microtime(true);
                // $results = $results->get();
                // $end = microtime(true);
                // Log::debug($query . " (FULLTEXT): " . round(($end - $start) * 1000, 3) . "ms");

                // We just want the names in a plain old array; not key:value.
                $results = $results->transform(function ($item) use ($language) {
                    return ['value' => $item['item_id'], 'label' => $item->translate($language)->first()->name];
                });
            } else {
                return response()->json([], 200);
            }

            return response()->json($results, 200);
        }
    }
}
