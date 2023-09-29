<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Hash;
use App\Models\Scopes\SoftDeleteOfIsDeleteScope;

class Lead extends Model
{
    use HasFactory, HasUuids;
    public $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['name', 'email','password','cellphone','phone_ext','phone','address1','address2','city','state','country','status','created','updated','is_deleted'];
    
    // unique field is either email or phon. According to requirement change the value of variable.
    const UNIQUE_FIELD = 'email';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated';



      /**
     *  add global scope to do not show deleted record
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SoftDeleteOfIsDeleteScope);
    }

    public function setPasswordAttribute($value)
    {

        $this->attributes['password'] = Hash::make($value);
    }


}
