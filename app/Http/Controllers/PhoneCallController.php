<?php

namespace App\Http\Controllers;

use App\Enums\PhoneCallStatus;
use App\Http\Requests\PhoneCallStoreRequest;
use App\Models\PhoneCall;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PhoneCallController extends Controller
{
    public function store(PhoneCallStoreRequest $request): JsonResponse
    {
        /** @var User $caller */
        $caller = Auth::user();
        /** @var User $receiver */
        $receiver = User::query()->findOrFail($request->user_id);

        /** @var PhoneCall $phoneCall */
        $phoneCall = DB::transaction(function () use ($caller, $receiver) {
            return PhoneCall::query()->create([
                'caller_user_id' => $caller->id,
                'receiver_user_id' => $receiver->id,
                'status' => PhoneCallStatus::WaitingReceiver,
                'called_at' => CarbonImmutable::now(),
            ]);
        });

        return response()->json([
            'data' => [
                'phone_call_id' => $phoneCall->id
            ]
        ], Response::HTTP_CREATED);
    }
}
