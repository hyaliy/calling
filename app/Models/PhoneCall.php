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
 * @property-read User $caller
 * @property-read User $receiver
 */
class PhoneCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'caller_user_id',
        'receiver_user_id',
        'status',
        'called_at',
        'talkStarted_at',
        'finished_at',
        'call_charge',
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
    public function caller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caller_user_id');
    }

    /**
     * @return BelongsTo<User,PhoneCall>
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }
}
