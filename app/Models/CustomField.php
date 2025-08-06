<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ContactCustomField;

class CustomField extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type','contact_id'];

    public function fieldValues()
    {
        return $this->hasMany(ContactCustomField::class);
    }
}
