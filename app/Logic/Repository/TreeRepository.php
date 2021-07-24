<?php


namespace App\Logic\Repository;

use App\Models\Tree;

class TreeRepository
{
    /**
     * @param array $credentials
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $credentials)
    {
        return Tree::query()->create($credentials);
    }

    /**
     * @param $node
     *
     * @param array $credentials
     *
     * @return mixed
     */
    public function update($node, array $credentials)
    {
        return $node->update($credentials);
    }

    /**
     * @param $id
     *
     * @return array|null
     */
    public function getChild($id)
    {
        $data = [];

        $childs = $this->getByParentId($id);

        if (!$childs)
        {
            return null;
        }

        foreach ($childs as $child) {
            $data[] = [
                'id' => $child->id,

                'data' => [
                    'id' => $child->id
                ],

                'text' => $child->text,

                'children' => $this->getChild($child->id),
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function createTree()
    {
        $root = $this->findMainTree();

        return [
            'id' => $root->id,

            'data' => [
                'id' => $root->id
            ],

            'text' => $root->text,

            'children' => $this->getChild($root->id),
        ];
    }

    /**
     * @param int $parentId
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */

    public function getByParentId(int $parentId)
    {
        return Tree::query()
            ->where('parent_id', '=', $parentId)
            ->orderBy('position')
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findMainTree()
    {
        $tree = Tree::query()
            ->where('parent_id', '=', null)
            ->first();

        return $tree;
    }

    /**
     * @param int $parentId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getLastChildTree(int $parentId)
    {
        return Tree::query()
            ->where('parent_id', '=', $parentId)
            ->orderBy('position', 'DESC')
            ->first();
    }

    /**
     * @param $parentId
     *
     * @param $position
     */
    public function incrementPosition($parentId, $position)
    {
        Tree::query()
            ->where('parent_id', '=', $parentId)
            ->where('position', '>=', $position)
            ->increment('position');
    }

    /**
     * @param int $id
     *
     * @return Tree
     */
    public function findNode(int $id): Tree
    {
        $node = Tree::query()->findOrFail($id);

        return $node;
    }

    /**
     * @param int $id
     */
    public function destroy(int $id)
    {
        Tree::query()->findOrFail($id)->delete();
    }
}
