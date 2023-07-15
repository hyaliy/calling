<?php

namespace Database\Factories;

use App\Enums\PhoneCallStatus;
use App\Models\PhoneCall;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<PhoneCall>
 */
class PhoneCallFactory extends Factory
{
    public function definition(): array
    {
        return [
            'caller_user_id' => User::factory()->create(),
            'receiver_user_id' => User::factory()->create(),
            'status' => Arr::random(PhoneCallStatus::cases()),
            'called_at' => Carbon::now(),
            'talk_started_at' => null,
            'finished_at' => null,
            'call_charge' => 0,
        ];
    }
}
