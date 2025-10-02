<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use App\Models\ContactUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactUsController extends Controller
{
    public function send(ContactRequest $request): JsonResponse
    {

        $data = ContactUs::create(
            $request->only(['name', 'email', 'phone', 'website', 'message'])
        );

        try {
            $toAddress = 'menniablaise@gmail.com';
            $toName    = config('mail.from.name');

            Mail::to($toAddress)->send(new ContactMessage($data));

            return response()->json([
                'ok' => true,
                'message' => 'Message sent successfully.',
            ], 200);
        } catch (Throwable $e) {
            // Log for debugging
            report($e);

            return response()->json([
                'ok' => false,
                'message' => 'Could not send message at this time.',
            ], 500);
        }
    }
}
