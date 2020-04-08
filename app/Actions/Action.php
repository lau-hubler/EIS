<?php


namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Action implements ActionContract
{
    public function execute(Model $model, Request $request)
    {
        return $this->storeModel($model, $request);
    }

    abstract public function storeModel(Model $model, Request $data): Model;
}
