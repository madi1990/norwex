<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model{
	public $timestamps = false;
	protected $table = 'CustomerStatus';
	protected $primaryKey = 'CustomerStatusId';
}