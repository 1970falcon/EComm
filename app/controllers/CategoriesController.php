<?php

Class CategoriesController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('admin');
    }

    public function getIndex() {
        return View::make('categories.index')
            ->with('categories', Category::all());
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), Category::$rules);

        if ($validator->passes()) {
            $category = new Category();
            $category->name = Input::get('name');
            $category->save();

            return Redirect::to('admin/categories/index')
                ->with('message', 'Category Created!');
        }

        return Redirect::to('admin/categories/index')
            ->with('message', 'Failed to create category.')
            ->withErrors($validator)
            ->withInput();
    }

    public function postDestroy() {
        $category = Category::find(Input::get('id'));

        if ($category) {
            $category->delete();

            return Redirect::to('admin/categories/index')
                ->with('message', 'Category deleted.');
        }

        return Redirect::to('admin/categories/index')
            ->with('message', 'Failed to delete category.');
    }
}

?>
