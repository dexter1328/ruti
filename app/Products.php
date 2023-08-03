<?php

namespace App;

use App\Jobs\ProcessCsvUpload;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $guarded = [];
    // protected $fillable = ['vendor_id', 'store_id', 'category_id', 'subcategory_id', 'brand_id', 'type', 'title','description','status'];

    public function importToDb()
    {
    	$path = resource_path('pending_files/*.csv');

    	$files = glob($path);

    	foreach ($files as $file) {

			ProcessCsvUpload::dispatch($file);

    	}
    }

}
