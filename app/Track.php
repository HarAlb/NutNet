<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{

    protected $fillable = [ 'title' , 'description' , 'slug' , 'file_path' , 'thumb' , 'u_id' ];

    public function creator()
    {
        return $this->belongsTo('App\User' , 'u_id' , 'id');
    }

    public function authorName(){
        return $this->creator->name;
    }

    public function authorEmail(){
        return $this->creator->email;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

}
