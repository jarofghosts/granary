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
            'handle' => 'required|alpha_dash|unique:categories|min:1|max:32',
            'description' => 'required|min:3'

        );

        $rules['logo'] = $input['logo_switch'] == 0 ? $rules['logo'] = 'url' : $rules['logo'] = 'image';

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {

            return View::make('common.error')->with('errors', $validation->errors)
                        ->with('error_message', 'Form validation errors');

        } else {

            if ($input['logo_switch'] == 0)
            {

                $logo_uri = Input::get('logo');

                $logo_bernie = new Bernie;

                $new_logo = $logo_bernie->migrate($logo_uri, "attic/categories/");

                $input['logo'] = $new_logo;

                Bernie::format($new_logo);

            } else {

                //@todo file upload

            }

            unset($input['logo_switch']);

            $new_category = new Category;
            $new_category->fill($input);
            $new_category->save();

            return Redirect::to_action('categories@view', array('id' => $new_category->id));

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

        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {

            return View::make('common.error')->with('errors', $validation->errors)
                        ->with('error_message', 'Form validation errors');

        } else {

            $category = Category::find(Input::get('id'));
            $category->fill($input);
            $category->save();

            return Redirect::to_action('categories@view', array('id' => $input['id']));

        }

    }

    public function post_change_logo()
    {
            if ( Input::file('avatar-upload', FALSE )) {

                $new_name = Bernie::generate_filename(Input::get('avatar-upload'));

                Input::upload('avatar-upload', './public/attic/categories', $new_name);
                
                $new_avatar = '/attic/categories/' . $new_name;

            } else if (Input::get('logo', FALSE) !== FALSE) {

                $new_avatar = Bernie::migrate(Input::get('logo'), "attic/categories/");

            } else {

                return Response::json(array('success' => false));

            }

            Bernie::format($new_avatar);
            $response = array(
                'img_src' => $new_avatar,
                'success' => true
            );

            return Response::json($response);

    }


    public function get_index()
    {
        $categories = Category::where('active', '=', 1)
                            ->get();

        return View::make('categories.list')->with('categories', $categories);

    }

    public function get_view($category_id = null)
    {

        if ($category_id != null) {

            $category = Category::find($category_id);

            return View::make('categories.single')->with('category', $category);

        }

        return View::make('common.error')->with('error_message', 'No category specified to view');

    }

    public function get_edit_by_handle($category_handle) {
        $category_id = Category::where('handle', '=', $category_handle)
        ->take(1)->only('id');

        if ($category_id) {
            return $this->get_edit($category_id);
        }
    }


    public function post_edit_by_handle($category_handle) {
        $category_id = Category::where('handle', '=', $category_handle)
        ->take(1)->only('id');

        if ($category_id) {
            return $this->post_edit($category_id);
        }
    }

    public function get_by_handle($category_handle = null)
    {

        $category_id = Category::where('handle', '=', $category_handle)
        ->take(1)
        ->only('id');

        if ($category_id) {

            return $this->get_view($category_id);

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

    public function get_posts_by_handle($category_handle = null)
    {
        $category_id = Category::where('handle', '=', $category_handle)
        ->take(1)
        ->only('id');

        if ($category_id)
        {
        
            $query = Post::where('category_id', '=', $category_id)
            ->where('active', '=', 1)
            ->order_by('default_order', 'desc')
            ->take(15);

            if (Auth::check() && $ignored_users = Auth::user()->ignored_users())
            {
                $query->where_not_in('author_id', $ignored_users);
            }

            $posts = $query->get();

            return View::make('posts.list')->with('posts', $posts)->with('category', Category::find($category_id));

        }

        return View::make('common.error')->with('error_message', 'Invalid category');
    }

}