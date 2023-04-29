<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VkTitle extends Model
{
    use HasFactory;
    
    protected $table = 'vk_titles';

    //const STATUS_ON = '1';
    //const STATUS_OFF = '0';

    

    protected $fillable = ['status', 'title', 'id_sublink', 'id_name', 'description'];


    public function Header(){
        return $this->hasOne(VkHeader::class, 'id_header', 'id');
	}

    public function Body(){
        return $this->hasOne(VkBody::class, 'id_body', 'id');
        }

    public function Footer(){
        return $this->hasOne(VkFooter::class, 'id_footer', 'id');
        }

    public function Images(){
        return $this->hasMany(VkImage::class, 'id_image', 'id');
        }

     public function Category(){
        return $this->hasMany(VkCategory::class, 'id', 'id_name');
    }

    public function subCategories(){
        return $this->hasMany(VkSubCategory::class, 'id', 'id_sublink');
    }
  

}
