<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function roomListCreator($room_number = null){
        $user = Auth::user();
        $all_lines = DB::table('messages')->where('sender_id',$user->user_id)->orWhere('receiver_id',$user->user_id)->get();
        $rooms = [];
        foreach ($all_lines as $line) {
            array_push($rooms, $line->chat_room);
        }
        $rooms = array_unique($rooms);
        $modified_rooms = [];
        foreach ($rooms as $room) {
            $all_lines_in_room = Message::where('chat_room',$room)->get();
            $sender = User::where('user_id',$all_lines_in_room[0]->sender_id)->first();
            $receiver = User::where('user_id',$all_lines_in_room[0]->receiver_id)->first();
            $other_end_user = '';
            if($sender->user_id == $user->user_id){
                $other_end_user = $receiver;
                $is_read = false;
            }else if($receiver->user_id == $user->user_id){
                $other_end_user = $sender;
                $unread_message_count = 0;
                foreach ($all_lines_in_room as $line) {
                    if(!$line->is_read){
                        $unread_message_count++;
                    }
                }
                if($unread_message_count != 0){
                    $is_read = true;
                }
            }
            $last_text = $all_lines_in_room[$all_lines_in_room->count()-1]->message;
            $is_active = $room_number ? ($room == $room_number) : false;
            $new_room = (object) [
                'room_number'=>$room,
                'other_end_user'=>$other_end_user,
                'last_text'=>$last_text,
                'is_read'=>$is_read,
                'is_active'=>$is_active
            ];
            $modified_rooms[] = $new_room;
        }
        return $modified_rooms;
    }

    public function roomNumberFinder($end_user, $other_end_user){
        $room_number = null;
        $messages_from_end_user = DB::table('messages')->where('sender_id',$end_user)->orWhere('receiver_id',$end_user)->get();
        foreach ($messages_from_end_user as $message) {
            if($message->sender_id == $other_end_user || $message->receiver_id == $other_end_user){
                $room_number = $message->chat_room;
            }
        }
        if(!$room_number){
            $all_messages = Message::all();
            $rooms = [];
            foreach ($all_messages as $message) {
                array_push($rooms,$message->chat_room);
            }
            $rooms = array_unique($rooms);
            sort($rooms);
            if(count($rooms)>0){
                $next_room = $rooms[count($rooms)-1]+1;
            }else{
                $next_room = [];
            }
            return ([
                'room_number'=>$next_room,
                'new'=>true,
            ]);
        }
        return ([
            'room_number'=>$room_number,
            'new'=>false,
        ]);
    }

    public function index($room_number = null)
    {
        //none selected chat
        if($room_number==null){
            $modified_rooms = $this->roomListCreator();
            return view('front.message')->with([
                'rooms'=>$modified_rooms,
                'lines'=>[],
                'active_chat'=>null,
                'default_message'=>null
            ]);
        }
        //selected chat
        $user = Auth::user();
        $modified_rooms = $this->roomListCreator($room_number);
        $all_lines_in_room = Message::where('chat_room',$room_number)->get();
        $modified_lines = [];
        if($room_number!=null){
            foreach ($all_lines_in_room as $key => $line) {
                if($line->sender_id == $user->user_id){
                    $is_right = true;
                }else{
                    $is_right = false;
                }
                $new_line = (object) [
                    'is_right'=>$is_right,
                    'chat'=>$all_lines_in_room[$key]
                ];
                $modified_lines[] = $new_line;
            }
        }
        if($all_lines_in_room[0]->sender_id == $user->user_id){
            $active_chat = User::where('user_id',$all_lines_in_room[0]->receiver_id)->first();
        }else{
            $active_chat = User::where('user_id',$all_lines_in_room[0]->sender_id)->first();
        }
        return view('front.message')->with([
            'rooms'=>$modified_rooms,
            'lines'=>$modified_lines,
            'active_chat'=>$active_chat,
            'default_message'=>null
        ]);
    }

    public function indexProduct($id){
        $product = Product::where('product_id',$id)->first();
        $user = Auth::user();
        if($user->user_id == $product->user_id){
            return redirect()->back()->with([
                'error'=>"This is your product"
            ]);
        }
        $receiver = User::where('user_id',$product->user_id)->first();
        $room_number_result = $this->roomNumberFinder($user->user_id,$receiver->user_id);
        $room_number = $room_number_result['room_number'];
        $new_room = $room_number_result['new'];
        if($new_room){
            $rooms = $this->roomListCreator();
            $active_chat = $receiver;
            $modified_lines = [];
        }else{
            $rooms = $this->roomListCreator($room_number);
            $active_chat = $receiver;
            $all_lines_in_room = Message::where('chat_room',$room_number)->get();
            $modified_lines = [];
            if($room_number!=null){
                foreach ($all_lines_in_room as $key => $line) {
                    if($line->sender_id == $user->user_id){
                        $is_right = true;
                    }else{
                        $is_right = false;
                    }
                    $new_line = (object) [
                        'is_right'=>$is_right,
                        'chat'=>$all_lines_in_room[$key]
                    ];
                    $modified_lines[] = $new_line;
                }
            }
        }
        $default_message = 'Apakah '.$product->product_name.' masih tersedia?';
        return view('front.message')->with([
            'rooms'=>$rooms,
            'lines'=>$modified_lines,
            'active_chat'=>$active_chat,
            'default_message'=>$default_message
        ]);
    }

    public function indexTransaction($id){
        $user = Auth::user();
        $receiver = User::where('user_id',$id)->first();
        $room_number_result = $this->roomNumberFinder($user->user_id,$receiver->user_id);
        $room_number = $room_number_result['room_number'];
        $new_room = $room_number_result['new'];
        if($new_room){
            $rooms = $this->roomListCreator();
            $active_chat = $receiver;
            $modified_lines = [];
        }else{
            $rooms = $this->roomListCreator($room_number);
            $active_chat = $receiver;
            $all_lines_in_room = Message::where('chat_room',$room_number)->get();
            $modified_lines = [];
            if($room_number!=null){
                foreach ($all_lines_in_room as $key => $line) {
                    if($line->sender_id == $user->user_id){
                        $is_right = true;
                    }else{
                        $is_right = false;
                    }
                    $new_line = (object) [
                        'is_right'=>$is_right,
                        'chat'=>$all_lines_in_room[$key]
                    ];
                    $modified_lines[] = $new_line;
                }
            }
        }
        $default_message = '';
        return view('front.message')->with([
            'rooms'=>$rooms,
            'lines'=>$modified_lines,
            'active_chat'=>$active_chat,
            'default_message'=>$default_message
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $receiver_id = $request->receiver_id;
        $user = Auth::user();
        $room_number = $this->roomNumberFinder($user->user_id, $receiver_id);
        if($room_number['room_number'] == null){
            $new_message = Message::create([
                'chat_room'=>1,
                'receiver_id'=>$receiver_id,
                'sender_id'=>$user->user_id,
                'message'=>$request->text,
                'is_read'=>false,
            ]);
            return redirect()->route('message.index',[
                'room_number'=>1,
                'new'=>true
            ]);
        }else{
            $new_message = Message::create([
                'chat_room'=>$room_number['room_number'],
                'receiver_id'=>$receiver_id,
                'sender_id'=>$user->user_id,
                'message'=>$request->text,
                'is_read'=>false,
            ]);
            return redirect()->route('message.index',$room_number);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
