<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
	const CREATED_AT = 'CreatedDateTime';
    const UPDATED_AT = 'UpdatedDateTime';
	protected $table = 'Order';
	protected $primaryKey = 'OrderId';
}