<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebPhotos extends Model
{
    use HasFactory;

    protected $table = 'web_photos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'section',
        'caption',
        'content1',
        'content2',
        'content3',
        'author_id',
        'file_path',
    ];

    public function photos(){
        return $this->belongsTo(WebContents::class,'photo_id','id');
    }
}
