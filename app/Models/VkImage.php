<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VkImage extends Model
{
    use HasFactory;

   protected $table = 'vk_images';
   protected $fillable = ['title', 'description'];

   public function Title()
    {
        return $this->belongsTo(VkTitle::class);
    }
}
