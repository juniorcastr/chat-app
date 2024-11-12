<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['user_1_id', 'user_2_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'user_1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user_2_id');
    }

    public static function getOrCreateChat($user1, $user2)
    {
        $chat = self::where(function ($query) use ($user1, $user2) {
            $query->where('user_1_id', $user1->id)
                ->where('user_2_id', $user2->id);
        })
            ->orWhere(function ($query) use ($user1, $user2) {
                $query->where('user_1_id', $user2->id)
                    ->where('user_2_id', $user1->id);
            })
            ->first();

        if (!$chat) {
            $chat = self::create([
                'user_1_id' => $user1->id,
                'user_2_id' => $user2->id
            ]);
        }

        return $chat;
    }

}
