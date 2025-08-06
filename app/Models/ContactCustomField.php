<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\CustomField;
use App\Models\Contact;

class ContactCustomField extends Model
{
    use HasFactory;
    protected $fillable = ['contact_id', 'custom_field_id', 'value'];

    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
