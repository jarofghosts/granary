<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of groups
 *
 * @author jarofghosts
 */
class Groups_Controller extends Base_Controller {

    public $restful = true;

    public function get_new()
    {

        return View::make('groups.new');

    }

    public function post_new()
    {

        $creator_id = Auth::check() ? Auth::user()->id : 0;

        $group = array(
            'title' => Input::get('title'),
            'handle' => Input::get('handle'),
            'description' => Input::get('description'),
            'creator_id' => $creator_id
        );

        $rules = array(
            'title' => 'required|max:128',
            'description' => 'required',
            'handle' => 'alpha_dash'
        );

        $validation = Validator::make($group, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $new_group = new Group();
            $new_group->fill($group);
            $new_group->save();

            // add the creator to the group

            $new_group->members()->attach(Auth::user()->id);
            $new_group->creator->add_experience(2);


            return View::make('groups.single')->with('group', $new_group);
        }

    }

    public function get_edit($id = null)
    {

        if ($id != null) {

            $group = Group::find($id);

            if ($group) {

                return View::make('group.edit')->with('group', $group);
            } else {

                return View::make('common.error')->with('error_message', 'Group does not exist');
            }
        } else {

            return View::make('common.error')->with('error_message', 'Internal error, no group specified');
        }

    }

    public function get_view($id = null)
    {

        if ($id != null) {
            $group = Group::find($id);
            if ($group) {
                return View::make('groups.single')->with('group', $group);
            }
        }

    }

}

?>
