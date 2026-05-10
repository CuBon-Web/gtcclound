<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    protected $table = 'process_steps';

    protected $fillable = [
        'title',
        'icon',
        'position',
        'status',
    ];

    public function saveProcessStep($request)
    {
        $id = $request->id;

        if ($id != '') {
            $query = ProcessStep::where(['id' => $id])->first();
            if (!$query) {
                $query = new ProcessStep();
            }
        } else {
            $query = new ProcessStep();
        }

        $query->title = $request->title;
        $query->icon = $request->icon;
        $query->position = (int) ($request->position ?? 0);
        $query->status = (int) ($request->status ?? 1);
        $query->save();

        return $query;
    }
}
