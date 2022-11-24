<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    use HasFactory;
    public $table = "services";
    // public $timestamps = false;
    public $primaryKey = "services_id";
    protected $fillable = [
        "service_type",
        "date_of_service",
        "price",
        "operator_id ",
        "image_path"
    ];

    public function operator() {
        return $this->belongsTo('App\Models\operator');
    }
}
