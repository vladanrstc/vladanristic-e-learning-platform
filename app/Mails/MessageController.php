<?php

namespace App\Mails;

use App\DTOs\FileDTO;
use App\Enums\Modules;
use App\Exceptions\MessageTranslationNotFoundException;
use App\Lang\LangHelper;
use App\Mails\Builders\MailDTOBuilder;
use App\Mails\IMailHandler;
use App\Mails\Requests\MessageRequest;
use App\Models\Course;
use App\Modules\Course\Requests\CourseStoreRequest;
use App\Modules\Course\Requests\CourseUpdateRequest;
use App\Modules\Course\Services\CourseService;
use App\Modules\Course\Services\ICourseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{

    /**
     * @var IMailHandler
     */
    private IMailHandler $mailHandler;

    public function __construct(IMailHandler $mailHandler)
    {
        $this->mailHandler = $mailHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function sendMessage(MessageRequest $request)
    {
        $mailDtoBuilder = new MailDTOBuilder();


        $this->mailHandler->sendMail(
            $mailDtoBuilder
                ->addSubject("New message from {$request->name} {$request->last_name}")
                ->addBody("From: $request->email . <hr> " . $request->message)
                ->addTo(env("ADMIN_MAIL"))
                ->build()
        );

        return response()->json("success", 200);
    }

}
