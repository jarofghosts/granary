<?php

class Ignores_Controller extends Base_Controller {

    public $restful = true;

    public function get_jerk($jerk_id = null)
    {

        if ($jerk_id) {

            $ignore = new Ignore(array('jerk_id' => $jerk_id));

            Auth::user()->ignore()->insert($ignore);

            Cache::forget(Auth::user()->username . '&jerk_ignores');

            return Redirect::to('users/' . $jerk_id);
        }

        return Redirect::to('/');

    }

    public function get_un($jerk_id = null)
    {

        $ignore = Ignore::where('user_id', '=', Auth::user()->id)
                ->where('jerk_id', '=', $jerk_id)
                ->get();
        if ($ignore) {

            $ignore[0]->delete();
            Cache::forget(Auth::user()->username . '&jerk_ignores');

            return Redirect::to('users/' . $jerk_id);
        }

        return Redirect::to('/');

    }

    public function get_exclude($category_id = null)
    {

        if ($category_id) {
            $exclude = new Exclusion(array('category_id' => $category_id));

            Auth::user()->exclusions()->insert($exclude);

            $handle = Category::where('id', '=', $category_id)
            ->take(1)
            ->only('handle');

            Cache::forget(Auth::user()->username . '&cat_excludes');

            return Redirect::to('/!' . $handle);

        }

        return Redirect::to('/');
    }

    public function get_de($category_id = null)
    {

        $exclude = Exclusion::where('user_id', '=', Auth::user()->id)
                ->where('category_id', '=', $category_id)
                ->get();
        if ($exclude) {

            $exclude[0]->delete();

            $handle = Category::where('id', '=', $category_id)
            ->take(1)
            ->only('handle');

            Cache::forget(Auth::user()->username . '&cat_excludes');

            return Redirect::to('/!' . $handle);

        }

        return Redirect::to('/');

    }



}