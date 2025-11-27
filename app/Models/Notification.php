<?php

namespace App\Models;

use App\Models\Scopes\NotificationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ScopedBy([NotificationScope::class])]
class Notification extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function notifiable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NotificationLog::class, 'notification_id');
    }
}
