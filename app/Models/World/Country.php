<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'Code';

    protected $keyType = 'string';

    protected $table = 'world_country';

    public $timestamps = false;

    public static $continents = ['亚洲','欧洲','北美洲','非洲','大洋洲','南极洲','南美洲'];

    public function city()
    {
        return $this->belongsTo(City::class, 'Capital', 'ID');
    }

    public static function options($id)
    {
        return static::where('Code', $id)->get()->map(function ($country) {

            return [$country->Code => $country->Name];

        })->flatten();
    }
}
