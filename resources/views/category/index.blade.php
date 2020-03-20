@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-end">
    <h3>{{ __('app.category.title') }}</h3>
    <b-button-toolbar aria-label="Toolbar for categories">
      <b-button-group class="mx-1">
        <p-create-button component="p-category-form">+ {{ __('app.create.button') }}</p-create-button>
      </b-button-group>
    </b-button-toolbar>
  </div>
  <div class="card-body">
    <p-categories-table
            description="{{ __('app.category.description') }}"
            name="{{ __('app.category.name') }}"
            updated_at="{{ __('app.category.updatedAt') }}"
    ></p-categories-table>
  </div>
  @include('layouts.__create_modal', [
    'item' => trans('app.category.item'),
    'gender' => 1,
    'action' => '/categories',
  ])
</div>
@endsection