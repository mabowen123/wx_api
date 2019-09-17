<?php


namespace App\Models;


class Article extends BaseModel
{
    const INDEX = 1;//首页
    const RECOMMEND = 2;//热门
    const ATTENTION = 3;//关注

    public static $types = [
        self::INDEX,
        self::RECOMMEND,
        self::ATTENTION
    ];

    public function scopeUserId($query, int $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeWithType($query, string $type, int $userId = null)
    {
        switch ($type) {
            case self::INDEX:
                $query->orderBy('created_at');
                break;
            case  self::RECOMMEND:
                $query->orderBy('clicks');
                break;
            case self::ATTENTION:
                $query->whereHas('attention', function ($query) use ($userId) {
                    $query->where('attention_user_id', $userId);
                });
                break;
            default:
                break;
        }

        return $query;
    }

    public function attention()
    {
        return $this->hasMany(Attention::class, 'followed_user_id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
