<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilamentPhoneInputContact extends Model
{
    protected $table = 'filament_phone_input_contacts';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(FilamentPhoneInputUser::class, 'user_id');
    }
}
