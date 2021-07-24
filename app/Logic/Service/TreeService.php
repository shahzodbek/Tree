<?php

namespace App\Logic\Service;


use Faker\Provider\Lorem;
use Illuminate\Http\Request;

class TreeService
{

    /**
     * @param $node
     *
     * @return mixed
     */
    public function treeToArray($node)
    {
        $result = $node->toArray();

        $result['data'] = [
            'id' => $node->id
        ];

        return $result;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function update(Request $request)
    {
        return [
            'text' => $request->text,
        ];
    }

    /**
     * @param $parentTree
     *
     * @param $lastChildTree
     *
     * @return array
     */
    public function create($parentTree, $lastChildTree)
    {
        return[
            'text' => Lorem::sentence(2, true),

            'parent_id' => $parentTree->id,

            'position' => $lastChildTree ? $lastChildTree->position + 1 : 1,
        ];
    }

    /**
     * @param $position
     *
     * @param $parentId
     *
     * @return array
     */
    public function updatePosition($position, $parentId)
    {
        return[
            'position' => $position,

            'parent_id' => $parentId,
        ];
    }

    public function toArray($data)
    {
        return $data->toArray();
    }
}
