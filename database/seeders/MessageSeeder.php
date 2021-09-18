<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Message::create([
            'chat_room'=>1,
            'receiver_id'=>2,
            'sender_id'=>1,
            'message'=>'room 1 from cust to seller',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>1,
            'receiver_id'=>1,
            'sender_id'=>2,
            'message'=>'room 1 from seller to cust',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>1,
            'receiver_id'=>2,
            'sender_id'=>1,
            'message'=>'room 1 from cust to seller',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>1,
            'receiver_id'=>2,
            'sender_id'=>1,
            'message'=>'room 1 from cust to seller',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>1,
            'receiver_id'=>1,
            'sender_id'=>2,
            'message'=>'room 1 from seller to cust',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>1,
            'receiver_id'=>1,
            'sender_id'=>2,
            'message'=>'room 1 from seller to cust',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>2,
            'receiver_id'=>1,
            'sender_id'=>3,
            'message'=>'room 1 from cust to admin',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>2,
            'receiver_id'=>3,
            'sender_id'=>1,
            'message'=>'room 2 from admin to cust',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>2,
            'receiver_id'=>1,
            'sender_id'=>3,
            'message'=>'room 2 from cust to admin',
            'is_read'=>false,
        ]);
        Message::create([
            'chat_room'=>2,
            'receiver_id'=>3,
            'sender_id'=>1,
            'message'=>'room 2 from admin to cust',
            'is_read'=>false,
        ]);
    }
}
