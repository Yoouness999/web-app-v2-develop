<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {

    protected $table = "report";

    protected $fillable = [
        'file',
        'note',
        'created_by',
        'created_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo(ArxminUser::class, 'created_by');
    }
}
