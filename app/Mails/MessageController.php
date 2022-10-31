<?php

namespace App\Mails;

use App\Mails\Builders\IMailDTOBuilder;
use App\Mails\Requests\MessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{

    /**
     * @var IMailHandler
     */
    private IMailHandler $mailHandler;

    /**
     * @var IMailDTOBuilder
     */
    private IMailDTOBuilder $mailDTOBuilder;

    public function __construct(IMailHandler $mailHandler, IMailDTOBuilder $mailDTOBuilder)
    {
        $this->mailHandler    = $mailHandler;
        $this->mailDTOBuilder = $mailDTOBuilder;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  MessageRequest  $request
     * @return JsonResponse
     */
    public function sendMessage(MessageRequest $request): JsonResponse
    {

        $this->mailHandler->sendMail(
            $this->mailDTOBuilder
                ->addSubject("New message from {$request->name} {$request->last_name}")
                ->addBody("From: $request->email . <hr> " . $request->message)
                ->addTo(env("ADMIN_MAIL"))
                ->build()
        );

        return response()->json("success");
    }

}
