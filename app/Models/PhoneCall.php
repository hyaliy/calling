<?php

namespace App\Models;

use App\Enums\PhoneCallStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $callerUserId
 * @property int $receiverUserId
 * @property PhoneCallStatus $status
 * @property Carbon $calledAt
 * @property ?Carbon $talkStartedAt
 * @property ?Carbon $finishedAt
 * @property int $callCharge
 * @property-read User $user
 */
class PhoneCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'callerUserId',
        'receiverUserId',
        'status',
        'calledAt',
        'talkStartedAt',
        'finishedAt',
        'callCharge',
    ];

    protected $casts = [
        'status' => PhoneCallStatus::class,
        'calledAt' => 'immutable_datetime',
        'talkStartedAt' => 'immutable_datetime',
        'finishedAt' => 'immutable_datetime',
    ];

    /**
     * @return BelongsTo<User,PhoneCall>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
