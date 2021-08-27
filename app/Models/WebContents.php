<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebContents extends Model
{
    use HasFactory;

    protected $table = 'web_contents';
    protected $primaryKey = 'id';

    protected $fillable = [
        'section',
        'content1',
        'content2',
        'content3',
        'content4',
        'content5',
        'photo_id',
        'author_id',
    ];

    public function photos(){
        return $this->hasOne(WebPhotos::class,'id','photo_id');
    }
}
