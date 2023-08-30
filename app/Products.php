<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Jobs\ProcessCsvUpload;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasSlug;
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
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Vendor', 'vendor_id','id');
    }


}
