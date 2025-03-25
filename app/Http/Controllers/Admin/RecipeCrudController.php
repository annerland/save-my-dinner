<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\RecipeRequest;
use Illuminate\Support\Facades\Log;
/**
 * Class RecipeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RecipeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Recipe::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/recipe');
        CRUD::setEntityNameStrings('recipe', 'recipes');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('name');
        CRUD::column('description');
        CRUD::column('prep_time');

        CRUD::addColumn([
            'name' => 'ingredients',
            'label' => 'Ingredients',
            'type' => 'json',
            'limit' => 100,
            'wrapper' => [
                'element' => 'span',
                'class' => 'text-wrap',
            ],
            'escaped' => false,
            'value' => function($entry) {
                if (is_array($entry->ingredients)) {
                    return collect($entry->ingredients)->map(function($ingredient) {
                        return $ingredient['name'] . ': ' . $ingredient['quantity'];
                    })->implode(', ');
                }
                return '';
            },
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RecipeRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field('name');
        CRUD::field('description');
        CRUD::field('prep_time');

        CRUD::addField([
            'name' => 'ingredients',
            'label' => 'Ingredients',
            'type' => 'textarea',
            'hint' => 'Enter ingredients as JSON. Example: [{"name": "Sugar", "quantity": "1 cup"}]',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
