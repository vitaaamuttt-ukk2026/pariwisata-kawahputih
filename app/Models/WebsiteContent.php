<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteContent extends Model
{
    protected $table = 'website_contents';
    
    protected $fillable = [
        'section', 'key', 'type', 'value', 'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function get($section, $key = null, $default = '')
    {
        if ($key) {
            $content = self::where('section', $section)
                ->where('key', $key)
                ->where('is_active', true)
                ->first();
            return $content ? $content->value : $default;
        }
        
        return self::where('section', $section)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public static function set($section, $key, $value, $type = 'text', $order = 0)
    {
        return self::updateOrCreate(
            ['section' => $section, 'key' => $key],
            ['value' => $value, 'type' => $type, 'order' => $order, 'is_active' => true]
        );
    }

    public static function getJson($section, $key)
    {
        $content = self::where('section', $section)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();
        
        return $content ? json_decode($content->value, true) : [];
    }

    public static function setJson($section, $key, $data)
    {
        return self::updateOrCreate(
            ['section' => $section, 'key' => $key],
            ['value' => json_encode($data), 'type' => 'json', 'is_active' => true]
        );
    }
}