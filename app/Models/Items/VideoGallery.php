<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $table = 'video_gallery';
    protected $fillable = ['title', 'file', 'item_id', 'user_id'];

    public function item(){
        return $this->belongsTo('App\Models\Items\Items', 'item_id', 'id');
    }

}
