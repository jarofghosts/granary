<?php

class Categories_Controller extends Base_Controller {

    public $restful = true;

    public function get_new()
    {
        return View::make('categories.new');

    }

    public function post_new()
    {

        $input = Input::all();

        $rules = array(
            'title' => 'required|unique:categories|max:128',
            'logo' => 'url',
            'handle' => 'required|alpha_dash|unique:categories|min:1|max:32',
            'description' => 'required|min:3',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $logo_uri = Input::get('logo');

            $logo_bernie = new Bernie;

            $new_logo = $logo_bernie->migrate($logo_uri, "attic/categories/");

            $input['logo'] = $new_logo;

            if ($logo_bernie->getHeight() > $logo_bernie->getWidth() && $logo_bernie->getHeight() > 320) {
                $logo_bernie->resizeToHeight(320);
            } elseif ($logo_bernie->getWidth() > $logo_bernie->getHeight() && $logo_bernie->getWidth() > 320) {
                $logo_bernie->resizeToWidth(320);
            }

            $logo_bernie->save($new_logo);

            $new_category = new Category;

            $new_category->fill($input);

            $new_category->save();

            $id = $new_category->id;

            return Redirect::to_action('categories@view', array('id' => $id));
        }

    }

    public function get_edit($category_id = null)
    {

        if ($category_id) {

            $category = Category::find($category_id);

            if ($category) {

                return View::make('categories.edit')->with('category', $category);
            }

            return View::make('common.error')->with('error_message', 'Category does not exist.');
        }

        return View::make('common.error')->with('error_message', 'No category specified');

    }

    public function post_edit()
    {

        $input = Input::all();

        $rules = array(
            'title' => 'required|unique:categories,title,' . $input['id'] . '|max:128',
            'description' => 'required|min:3',
            'logo' => 'url',
            'handle' => 'alpha_dash|unique:categories,handle,' . $input['id'] . '|min:1|max:32'
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $logo_uri = Input::get('logo', FALSE);

            $logo_uri = Input::get('logo');

            if ($logo_uri !== FALSE) {
                $logo_bernie = new Bernie;

                $new_logo = $logo_bernie->migrate($logo_uri, "attic/categories/");

                $input['logo'] = $new_logo;

                if ($logo_bernie->getHeight() > $logo_bernie->getWidth() && $logo_bernie->getHeight() > 320) {
                    $logo_bernie->resizeToHeight(320);
                } elseif ($logo_bernie->getWidth() > $logo_bernie->getHeight() && $logo_bernie->getWidth() > 320) {
                    $logo_bernie->resizeToWidth(320);
                }

                $logo_bernie->save($new_logo);
            }

            $category = Category::find(Input::get('id'));

            $category->fill($input);

            $category->save();

            return Redirect::to_action('categories@view', array('id' => $input['id']));
        }

    }

    public function get_index()
    {
        $categories = Category::all();

        return View::make('categories.list')->with('categories', $categories);

    }

    public function get_view($category_id = null)
    {

        if ($category_id != null) {

            $category = Category::find($category_id);
            $posts = $category->posts;
            $posts = $category->posts();

            return View::make('categories.single')->with('category', $category)->with('posts', $posts);
        } else {
            return View::make('common.error')->with('error_message', 'No category specified to view');
        }

    }

    public function get_by_handle($category_handle = null)
    {

        $category = Category::where('handle', '=', $category_handle)->take(1)->get();

        if ($category) {

            return $this->get_view($category[0]->id);
        } else {

            $this->handle = $category_handle;
            $object = $this;

            $search = Category::where('active', '=', 1)->where(function($query) use($object) {
                                $query->where('handle', 'LIKE', "%{$object->handle}%");
                                $query->or_where('title', 'LIKE', "%{$object->handle}%");
                            })->get();

            $results = (count($search) > 0);

            return View::make('categories.not_found')->with('results', $results)->with('possibilities', $search);
        }

    }

}