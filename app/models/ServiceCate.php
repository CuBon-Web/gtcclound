<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Services;
class ServiceCate extends Model
{
    protected $table = "service_category";

    protected $casts = [
        'pricing_plans' => 'array',
        'linked_product_categories' => 'array',
    ];
    public function services()
    {
        return $this->hasMany(Services::class,'cate_id','id');
    }
    public function saveCate($request)
    {
        $id = $request->id;
        if($id != "" ){
            $query = ServiceCate::where([
                'id' => $id
             ])->first();
            if ($query) {
                $query->name = $request->name;
                $query->slug = to_slug($request->name);
                $query->content = $request->content;
                $query->description = $request->description;
                $query->status = $request->status;
                $query->image = $request->image;
                $query->pricing_plans = $request->input('pricing_plans', []);
                $query->linked_product_categories = $request->input('linked_product_categories', []);
                $query->save();
            }else{
                $query = new ServiceCate();
                $query->name = $request->name;
                $query->slug = to_slug($request->name);
                $query->content = $request->content;
                $query->status = $request->status;
                $query->description = $request->description;
                $query->image = $request->image;
                $query->pricing_plans = $request->input('pricing_plans', []);
                $query->linked_product_categories = $request->input('linked_product_categories', []);
                $query->save();
            }
            
        }else{
            $query = new ServiceCate();
            $query->name = $request->name;
            $query->slug = to_slug($request->name);
            $query->content = $request->content;
            $query->status = $request->status;
            $query->description = $request->description;
            $query->image = $request->image;
            $query->pricing_plans = $request->input('pricing_plans', []);
            $query->linked_product_categories = $request->input('linked_product_categories', []);
            $query->save();
            
        }
        return $query;
    }
}
