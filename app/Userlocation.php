<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userlocation extends Model {
	protected $table = 'users_locations';
	protected $fillable = ['id', 'user_id', 'city_id', 'latitude', 'longitude'];

}
