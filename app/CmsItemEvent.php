<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsItemEvent extends Model
{
    protected $table = 'cms_item_event';
    public $timestamps = false;

    protected $fillable = [
        'location_id', 'name','description','photo','price',
        'start_date','end_date','created_at','created_by','remark',
        'teacher_id','item_id','currency','duration','quota','status',
        'auto_accept','code','parent_id','permalink'
    ];
}
