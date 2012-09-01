<?php

class Ignores_Controller extends Base_Controller {

    public $restful = true;

    public function get_index( $jerk_id = null )
    {
        if ($jerk_id) {
            
            return $this->get_jerk($jerk_id);
        }

    }

    public function get_jerk($jerk_id = null)
    {

        if ($jerk_id) {

            $ignore = new Ignore(array('jerk_id' => $jerk_id));

            Auth::user()->ignore()->insert($ignore);

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
        }

        return Redirect::to('users/' . $jerk_id);

    }

}