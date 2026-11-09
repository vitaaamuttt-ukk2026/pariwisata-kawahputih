<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoContent extends Model
{
    protected $table = 'info_contents';
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = '')
    {
        $content = self::where('key', $key)->first();
        return $content ? $content->value : $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}