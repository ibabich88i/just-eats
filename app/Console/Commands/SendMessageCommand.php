<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataTransferObjects\Factories\MessageStoreDTOFactoryInterface;
use App\Http\Requests\MessageStoreRequest;
use App\Managers\MessageManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;

class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send
                            {rec : Recipient of email}
                            {module : Module name for example "user"}
                            {action : Action for example "change-password"}
                            {data?* : Data for email for example - \'token\':\'token text\' \'name\':\'name text\'}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending email message by module and action';

    /**
     * @var MessageManagerInterface
     */
    private MessageManagerInterface $messageManager;

    /**
     * @var MessageStoreDTOFactoryInterface
     */
    private MessageStoreDTOFactoryInterface $factory;

    /**
     * @var Factory
     */
    private Factory $validator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        MessageManagerInterface $messageManager,
        MessageStoreDTOFactoryInterface $factory,
        Factory $validator
    ) {
        parent::__construct();

        $this->messageManager = $messageManager;
        $this->factory = $factory;
        $this->validator = $validator;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payload = $this->arguments();
        $data = [
            'recipients' => [['email' => $payload['rec']]],
            'data' => $this->getData($payload['data'] ?? []),
            'module' => $payload['module'],
            'action' => $payload['action']
        ];

        $validator = $this->validator->make($data, (new MessageStoreRequest())->rules());

        if ($validator->fails()) {
            $this->output->error($validator->errors());
        }

        $dataObject = $this->factory->create($data);

        $this->messageManager->store($dataObject);

        $this->output->success('Your message was sending to queue.');

        return 0;
    }

    /**
     * @param array $params
     * @return array
     */
    private function getData(array $params): array
    {
        $result = [];

        foreach ($params as $param) {
            $row = explode(':', $param);
            $result[$row[0]] = $row[1];
        }

        return $result;
    }
}
