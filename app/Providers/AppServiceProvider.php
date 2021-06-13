<?php

namespace App\Providers;

use App\Clients\Emails\EmailClientPool;
use App\Clients\Emails\EmailClientPoolInterface;
use App\DataTransferObjects\Builders\MessageDTOBuilder;
use App\DataTransferObjects\Builders\MessageDTOBuilderInterface;
use App\DataTransferObjects\Factories\MessageStoreDTOFactory;
use App\DataTransferObjects\Factories\MessageStoreDTOFactoryInterface;
use App\Clients\Emails\MailjetClient;
use App\Clients\Emails\MailjetClientInterface;
use App\Handlers\Emails\EmailHandlerPool;
use App\Handlers\Emails\EmailHandlerPoolInterface;
use App\Handlers\Emails\UserChangePasswordEmailHandler;
use App\Managers\MessageManager;
use App\Managers\MessageManagerInterface;
use App\Models\Builders\MessageModelCreatorBuilder;
use App\Models\Builders\MessageModelCreatorBuilderInterface;
use App\Models\Factories\MessageModelFactory;
use App\Models\Factories\MessageModelFactoryInterface;
use App\Models\MessageModel;
use App\Services\Emails\EmailNotificationService;
use App\Services\Emails\EmailNotificationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClientInterface::class,
            function (Container $container) {
                return new Client();
            }
        );
        $this->app->bind(
            MessageStoreDTOFactoryInterface::class,
            function (Container $container) {
                return new MessageStoreDTOFactory();
            }
        );

        $this->app->bind(
            MessageManagerInterface::class,
            function (Container $container) {
                $queueName = $container->get(Repository::class)->get('queues.queue_send_email');

                return new MessageManager($queueName);
            }
        );

        $this->app->bind(
            MessageModelCreatorBuilderInterface::class,
            function (Container $container) {
                return new MessageModelCreatorBuilder(
                    $container->get(MessageModel::class),
                );
            }
        );

        $this->app->bind(
            MessageModelFactoryInterface::class,
            function (Container $container) {
                return new MessageModelFactory();
            }
        );

        $this->app->bind(
            MailjetClientInterface::class,
            function (Container $container) {
                return new MailjetClient(
                    $container->get(ClientInterface::class),
                    $container->get(LoggerInterface::class),
                    $container->get(Repository::class),
                );
            }
        );

        $this->app->bind(
            MessageDTOBuilderInterface::class,
            function (Container $container) {
                return new MessageDTOBuilder(
                    $container->get(Factory::class),
                    $container->get(Str::class),
                    $container->get(Repository::class),
                );
            }
        );

        $this->app->bind(
            UserChangePasswordEmailHandler::class,
            function (Container $container) {
                $appUrl = $container->get(Repository::class)->get('app.url');

                return new UserChangePasswordEmailHandler(
                    $container->get(MessageDTOBuilderInterface::class),
                    $appUrl
                );
            }
        );

        $this->app->bind(
            EmailHandlerPoolInterface::class,
            function (Container $container) {
                $pool = new EmailHandlerPool();

                $pool->add($container->get(UserChangePasswordEmailHandler::class), 'user.change-password');

                return $pool;
            }
        );

        $this->app->bind(
            EmailClientPoolInterface::class,
            function (Container $container) {
                $pool = new EmailClientPool();

                $pool->add($container->get(MailjetClientInterface::class));

                return $pool;
            }
        );

        $this->app->bind(
            EmailNotificationServiceInterface::class,
            function (Container $container) {
                return new EmailNotificationService(
                    $container->get(EmailHandlerPoolInterface::class),
                    $container->get(EmailClientPoolInterface::class),
                    $container->get(MessageModelCreatorBuilderInterface::class),
                    $container->get(LoggerInterface::class),
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
