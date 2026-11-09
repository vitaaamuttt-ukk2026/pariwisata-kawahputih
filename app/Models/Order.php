<?php

   namespace App\Models;
   use Illuminate\Database\Eloquent\Model;

   class Order extends Model
   {
       protected $fillable = ['user_id', 'order_code', 'qr_string', 'total_amount', 'visit_date', 'status'];

       // Satu Order milik satu User
       public function user() {
           return $this->belongsTo(User::class);
       }
   }
