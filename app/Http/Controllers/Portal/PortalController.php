<?php

namespace App\Http\Controllers\Portal;

use App\Http\Requests\Portal\CreateContactMessageRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PortalController
{

    /**
     * Create a New ContactMessage Record
     * @param CreateContactMessageRequest $request
     */

    public function createContactMessage(CreateContactMessageRequest $request)
    {
        try {
            ContactMessage::create([
                'name' => $request->name,
                'country_code' => $request->country_code,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'message' => $request->message,
                'project_id' => $request->project_id,
                'status' => 'in_progress'
            ]);

            // send email to admin
            // Mail::to(env('ADMIN_EMAIL'))->send(new ContactMessageMail($request->validated()));

            return apiResponse(
                true,
                trans('messages.created_successfully'),
                Response::HTTP_OK,
            );
        } catch (\Throwable $th) {
            return failResponse($th);
        }
    }

}
