<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    protected $types = ['category', 'product', 'stakeholder', 'invoice'];
    protected $actions = ['index', 'store', 'update', 'show', 'delete'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->types as $type) {
            foreach ($this->actions as $action) {
                $method = sprintf('get%sDescription', ucfirst($action));
                DB::table('permissions')->insert([
                    'code' => "$type.$action",
                    'description' => $this->$method($type)
                ]);
            }
        }
    }

    protected function getIndexDescription($type)
    {
        return "User can access $type's group";
    }

    protected function getStoreDescription($type)
    {
        return "User can create a new $type";
    }

    protected function getUpdateDescription($type)
    {
        return "User can update a $type";
    }

    protected function getShowDescription($type)
    {
        return "User can access details of a $type";
    }

    protected function getDeleteDescription($type)
    {
        return "User can delete a $type";
    }
}
