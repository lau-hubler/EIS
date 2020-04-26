<?php

namespace App\Http\Controllers\Api;

use App\Actions\Categories\DeleteCategoryAction;
use App\Actions\Categories\StoreCategoryAction;
use App\Actions\Categories\UpdateCategoryAction;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Add policy to controller.
     */
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Category[]|Collection|Response
     */
    public function index()
    {
        return Category::paginate(env('ITEMS_PER_PAGE'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Category[]|Collection|Response
     */
    public function all()
    {
        Gate::authorize('viewAny', Category::class);
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @param StoreCategoryAction $action
     * @return Model|Response
     */
    public function store(CategoryRequest $request, Category $category, StoreCategoryAction $action)
    {
        return $action->execute($category, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Category|Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @param UpdateCategoryAction $action
     * @return Model|Response
     */
    public function update(CategoryRequest $request, Category $category, UpdateCategoryAction $action)
    {
        return $action->execute($category, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return array|Response|string
     */
    public function destroy(Category $category, DeleteCategoryAction $action)
    {
        return $action->execute($category);
    }
}
