<?php

class Smilies_Controller extends Base_Controller {

	public $restful = true;

    public function get_index($id = null)
    {

    }

    public function get_new()
    {
    	return View::make('smilies.new');
    }

    public function post_image_upload()
    {
    	if (Input::get('image_file', FALSE) !== FALSE) {
            $new_name = Bernie::generate_filename(Input::get('image_file'));

            Input::upload('image_file', './public/smilies', $new_name);
                
            $location = '/smilies/' . $new_name;
    	}
    	if (Input::get('image_link', FALSE) !== FALSE) {

    		$location = Bernie::migrate(Input::get('image_link'), "smilies/");

    	}

    	return Response::json(array('success' => 'success','location' =>$location));
    }

    public function post_new()
    {
    	$smiley = array(
    		'replacement' => Input::get('replacement'),
    		'trigger' => Input::get('trigger'),
    		'author_id' => Auth::user()->id
    	);
    	$rules = array(
    		'replacement'	=> 'required|max:128',
    		'trigger'	=> 'required|max|24'
    	);
    	$validation = Validator::make($reply, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
       	 } else {
    		if (Input::get('resize', FALSE)) {
    		Bernie::load(Input::get('replacement'));
    		Bernie::resizeToHeight(20);
    		Bernie::save();
    		}
    	}
    }
}