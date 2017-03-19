<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
	use SoftDeletes;
    //Default: DB_table_name is plural form of model   
    //Else have to specify table name.
    //protected $table = 'the_name_of_the_table';

    //Method 2
    protected $fillable = [
    	'user_id', 'content', 'live', 'post_on' //this is whitelisted fields
    ];

    //Use either $fillable or $guarded to prevent Mass Assignment
    //protected $guarded = ['id'];

    protected $dates = ['post_on','deleted_at'];

    //Mutator for 'live' field
    public function setLiveAttribute($value){
    	$this->attributes['live'] = (boolean)($value);
    }

    public function setPostOnAttribute($value){
    	$this->attributes['post_on'] = Carbon::parse($value);
    }

    //Accessor for new attribute short Content (from content)
    public function getShortContentAttribute(){
    	return substr($this->content, 0, random_int(60, 150)) . '...';
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
