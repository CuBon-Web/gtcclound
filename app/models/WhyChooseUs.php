<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUs extends Model
{
    protected $table = 'why_choose_us';

    protected $fillable = [
        'title',
        'icon',
        'description',
        'position',
        'status',
    ];

    public function saveWhyChooseUs($request)
    {
        $id = $request->id;

        if ($id != '') {
            $query = WhyChooseUs::where(['id' => $id])->first();
            if (!$query) {
                $query = new WhyChooseUs();
            }
        } else {
            $query = new WhyChooseUs();
        }

        $query->title = $request->title;
        $query->icon = $request->icon;
        $query->description = $request->description;
        $query->position = (int) ($request->position ?? 0);
        $query->status = (int) ($request->status ?? 1);
        $query->save();

        return $query;
    }
}
