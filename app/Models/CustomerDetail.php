<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    //ถ้าใช้ fillable ต้องระบุชื่อคอลัมน์ที่อนุญาตให้กำหนดค่าเท่านั้น
}
