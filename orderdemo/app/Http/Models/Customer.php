<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model{
	const CREATED_AT = 'AddedTime';
    const UPDATED_AT = 'UpdatedTime';
	protected $table = 'Customer';
    protected $primaryKey = 'CustomerId';
    
    public function CustomerStatus(){
		return $this->hasOne('App\Http\Models\CustomerStatus','CustomerStatusId','CustomerStatusId');
	}
}