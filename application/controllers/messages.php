<?php

class Messages_Controller extends Base_Controller {

    public $restful = true;

    public function get_read($message_id)
    {
        $message = Message::find($message_id);

        if ($message) {

            if ($message->recipient->id === Auth::user()->id) {
                $message->read = true;
                $message->save();
                return View::make('messages.view')->with('message', $message);

            } elseif ($message->sender->id === Auth::user()->id) {
                if ($message->read == false) {
                    return View::make('messages.edit')->with('message', $message);
                } else {
                    return $this->get_thread($message->parent_id);
                }
            }
                return View::make('common.error')->with('error_message', 'You cannot read this message');   
        }
        return View::make('common.error')->with('error_message', 'Message does not exist');

    }

    public function get_thread($parent_id)
    {
        $messages = Message::thread($parent_id);
        return View::make('messages.thread')->with('messages', $messages);
    }

    public function get_send($recipient_id = null, $parent_id = null)
    {

        if ($recipient_id) {
            $recipient = User::find($recipient_id);
        } else {
            $recipient = false;
        }
        return View::make('messages.send')
            ->with('recipient', $recipient)
            ->with('parent_id', $parent_id);

    }

    public function get_group_send($group_id = null)
    {

        if ($group_id) {

            $group = true;

        } else {

            $group = false;
        }

        return View::make('messages.group_send')->with('group', $group);

    }

    public function get_inbox()
    {

        $read = Message::where('recipient_id', '=', Auth::user()->id)
        ->where('read', '=', '1')
        ->get();
        $unread = Message::where('recipient_id', '=', Auth::user()->id)
        ->where('read', '=', '0')
        ->get();
        return View::make('messages.inbox')
        ->with('read', $read)
        ->with('unread', $unread);

    }

    public function get_outbox()
    {

        $read = Message::where('sender_id', '=', Auth::user()->id)
        ->where('read', '=', '1')
        ->get();
        $unread = Message::where('sender_id', '=', Auth::user()->id)
        ->where('read', '=', '0')
        ->get();
        return View::make('messages.outbox')
        ->with('read', $read)
        ->with('unread', $unread);

    }

    public function get_index()
    {
        $unread_in = Message::where('recipient_id', '=', Auth::user()->id)
        ->where('read', '=', '0')
        ->get();
        $unread_out = Message::where('sender_id', '=', Auth::user()->id)
        ->where('read', '=', '0')
        ->get();
        return View::make('messages.index')
        ->with('inbox', $unread_in)
        ->with('outbox', $unread_out);
    }

    public function post_send()
    {

        $message_data = array(
            'sender_id' => Auth::user()->id,
            'group_id' => 0,
            'subject' => Input::get('subject'),
            'recipient_id' => Input::get('recipient_id'),
            'body' => Input::get('body'),
            'parent_id' => Input::get('parent_id', 0),
            'message_type' => 0,
            'read' => false
            );
        $rules = array(
            'body' => 'required',
            'subject' => 'max:128'
            );

        $validation = Validator::make($message_data, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
            ->with('error_message', 'Form validation errors');
        } else {

            $new_message = new Message;
            $new_message->fill($message_data);
            $new_message->save();
        }

    }
    public function post_change()
    {
        $message_data = array(
            'sender_id' => Auth::user()->id,
            'subject' => Input::get('subject'),
            'recipient_id' => Input::get('recipient_id'),
            'body' => Input::get('body')
        );
        $rules = array(
            'body' => 'required',
            'subject' => 'max:128');
        $validation = Validator::make($message_data, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
            ->with('error_message', 'Form validation errors');
        } else {
            $message = Message::find(Input::get('message_id'));
            if ($message->read == false) {
                $message->fill($message_data);
                $message->save();
                return Redirect::to('/messages');
            } else {
                return View::make('common.error')->with('error_message', 'Cannot alter a read message');
            }
        }
    }

}