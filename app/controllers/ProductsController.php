<?php

Class ProductsController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('admin');
    }

    public function getIndex() {
        $categories = array();

        foreach (Category::all() as $category) {
            $categories[$category->id] = $category->name;
        }

        return View::make('products.index')
            ->with('products', Product::all())
            ->with('categories', $categories);
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), Product::$rules);

        if ($validator->passes()) {
            $product = new Product();
            $product->category_id = Input::get('category_id');
            $product->title = Input::get('title');
            $product->description = Input::get('description');
            $product->price = Input::get('price');
            $product->availability = Input::get('availability');

            $image = Input::file('image');
            $filename = date("c") . '-' . $image->getClientOriginalName();
            $imageFolder = 'img/products/';
            Image::make($image->getRealPath())
                ->resize(468,249)
                ->save($imageFolder . $filename);
            $product->image = $imageFolder . $filename;

            $product->save();

            return Redirect::to('admin/products/index')
                ->with('message', 'Product Created!');
        }

        return Redirect::to('admin/products/index')
            ->with('message', 'Failed to create product.')
            ->withErrors($validator)
            ->withInput();
    }

    public function postDestroy() {
        $product = Product::find(Input::get('id'));

        if ($product) {
            File::delete($product->image);
            $product->delete();

            return Redirect::to('admin/products/index')
                ->with('message', 'Product deleted.');
        }

        return Redirect::to('admin/products/index')
            ->with('message', 'Failed to delete product.');
    }

    public function postToggleAvailability() {
        $product = Product::find(Input::get('id'));

        if ($product) {
            $availability = Input::get('availability');
            $product->availability = $availability;
            $product->save();

            return Redirect::to('admin/products/index')
                ->with('message', 'Product availability updated.');
        }

        return Redirect::to('admin/products/index')
            ->with('message', 'Failed to update product availability.');
    }
}

?>
