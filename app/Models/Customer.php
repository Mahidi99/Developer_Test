<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    protected $table = 'add_customer_details';
    protected $fillable = ['customer_account_number', 'date', 'meter_reading_value'];

    public $previous_date;
    public $previous_meter_reading;
}
