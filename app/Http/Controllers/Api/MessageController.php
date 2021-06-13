<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Factories\MessageStoreDTOFactoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Managers\MessageManagerInterface;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    /**
     * @var MessageManagerInterface
     */
    private MessageManagerInterface $manager;

    /**
     * MessageController constructor.
     * @param MessageManagerInterface $manager
     */
    public function __construct(MessageManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param MessageStoreRequest $request
     * @param MessageStoreDTOFactoryInterface $factory
     * @return JsonResponse
     */
    public function store(MessageStoreRequest $request, MessageStoreDTOFactoryInterface $factory): JsonResponse
    {
        $dataObject = $factory->create($request->all());

        $this->manager->store($dataObject);

        return (new JsonResponse())->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
