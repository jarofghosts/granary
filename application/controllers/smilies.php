<?php

class Smilies_Controller extends Base_Controller {

	public $restful = true;

	public function get_index( $id = null ) {

	}

	public function get_new() {
		return View::make( 'smilies.new' );
	}

	public function post_upload_image() {
		if ( Input::get( 'image_file', FALSE ) !== FALSE ) {

			$new_name = Bernie::generate_filename( Input::get( 'image_file' ) );

			Input::upload( 'image_file', './public/attic/smilies', $new_name );

			$location = '/attic/smilies/' . $new_name;

		}
		if ( Input::get( 'image_link', FALSE ) !== FALSE ) {

			$location = Bernie::migrate( Input::get( 'image_link' ), "attic/smilies/" );

		}

		return Response::json( array( 'success' => 'success', 'img_src' =>$location ) );
	}

	public function post_new() {
		$smiley = array(
			'replacement' => Input::get( 'replacement' ),
			'trigger' => Input::get( 'trigger' ),
			'author_id' => Auth::user()->id
		);
		$rules = array(
			'replacement' => 'required|max:128',
			'trigger' => 'required|max:24'
		);
		$validation = Validator::make( $smiley, $rules );

		if ( $validation->fails() ) {
			return View::make( 'common.error' )->with( 'errors', $validation->errors )
			->with( 'error_message', 'Form validation errors' );
		} else {
			if ( Input::get( 'resize', FALSE ) ) {
				Bernie::formatSmiley(Input::get('replacement'));
			}

			$new_smiley = new Smiley;
			$new_smiley->fill($smiley);
			$new_smiley->save();
		}
	}
}
