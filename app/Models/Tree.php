<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Tree
 *
 * @package App\Models
 *
 * @property $parent_id
 *
 * @property $position
 *
 * @property $text
 */
class Tree extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'trees';

    /**
     * @var string[]
     */
    protected $fillable = [
        'parent_id',

        'position',

        'text'
    ];

    /**
     * @return \Illuminate\Support\HigherOrderCollectionProxy|mixed|null
     */
    public static function getRandomId()
    {
        $tree_item = Tree::all();

        if($tree_item->count() > 0)
            return $tree_item->random()->id;

        return null;
    }
}
