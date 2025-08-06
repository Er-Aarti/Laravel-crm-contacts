<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ContactCustomField;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone', 
        'gender',
        'profile_image',
        'document',
        'is_merged',
        'merged_into_id', 
    ];
    
    public function customFieldValues()
    {
        return $this->hasMany(ContactCustomField::class);
    }
    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }
    public function mergedInto()
    {
        return $this->belongsTo(Contact::class, 'merged_into_id');
    }
}
