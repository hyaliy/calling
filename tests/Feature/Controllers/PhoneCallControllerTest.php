<?php

namespace Feature\Controllers;

use App\Enums\PhoneCallStatus;
use App\Models\PhoneCall;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PhoneCallControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_正常系_電話をかけることができる(): void
    {
        // given
        $now = now();
        CarbonImmutable::setTestNow($now);

        /** @var User $me */
        $me = User::factory()->create();
        $this->actingAs($me);

        /** @var User $receiver */
        $receiver = User::factory()->create();

        // when
        $actual = $this->postJson('/api/phone_calls', [
            'user_id' => $receiver->id
        ]);

        // then
        $actual->assertCreated();

        /** @var PhoneCall $latestPhoneCall */
        $latestPhoneCall = PhoneCall::query()->latest()->first();
        $actual->assertJsonFragment(['phone_call_id' => $latestPhoneCall->id]);

        $this->assertDatabaseHas(PhoneCall::class, [
            'caller_user_id' => $me->id,
            'receiver_user_id' => $receiver->id,
            'status' => PhoneCallStatus::WaitingReceiver->value,
            'called_at' => $now
        ]);
    }
}
