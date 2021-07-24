<?php

namespace Database\Factories;

use App\Models\Tree;

use Faker\Provider\Lorem;

use Illuminate\Database\Eloquent\Factories\Factory;

class TreeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tree::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomId = Tree::getRandomId();

        $position = Tree::query()->where('parent_id', '=', $randomId)->count() + 1;

        return [
            'text' => Lorem::sentence(2, true),

            'position' => $position,

            'parent_id' => $randomId
        ];
    }
}
