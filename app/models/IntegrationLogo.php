<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class IntegrationLogo extends Model
{
    protected $table = 'integration_logos';

    protected $fillable = [
        'name',
        'image',
        'link',
        'group_key',
        'position',
        'status',
    ];

    public const GROUPS = [
        'crm'      => 'Tích hợp hệ thống CRM',
        'landline' => 'Tích hợp đầu số cố định',
        'mobile'   => 'Tích hợp đầu số di động',
    ];

    public function saveIntegrationLogo($request)
    {
        $id = $request->id;

        if ($id != '') {
            $query = IntegrationLogo::where(['id' => $id])->first();
            if (!$query) {
                $query = new IntegrationLogo();
            }
        } else {
            $query = new IntegrationLogo();
        }

        $group = $request->group_key;
        if (!array_key_exists($group, self::GROUPS)) {
            $group = 'crm';
        }

        $query->name = $request->name;
        $query->image = $request->image;
        $query->link = $request->link;
        $query->group_key = $group;
        $query->position = (int) ($request->position ?? 0);
        $query->status = (int) ($request->status ?? 1);
        $query->save();

        return $query;
    }
}
