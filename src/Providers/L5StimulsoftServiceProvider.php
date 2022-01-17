<?php

/**
 * Класс содержит описание регистрации пакета в приложении
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\Providers;

use Illuminate\Support\ServiceProvider;
use DRVAS\L5Stimulsoft\Repositories\ReportRepository;
use DRVAS\Stimulsoft\Infrastructure\Repository\ReportRepositoryInterface;

/**
 * Класс содержит описание регистрации пакета в приложении
 *
 * Class NsiClsServiceProvider
 * @package DRVAS\L5Stimulsoft\Providers
 */
class L5StimulsoftServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/l5-stimulsoft.php', 'l5-stimulsoft');
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    /**
     * @return void
     */
    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('l5-stimulsoft.php')], 'config');
    }

    /**
     * @return void
     */
    private function publishMigrations()
    {
        $path = $this->getMigrationsPath();
        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    /**
     * @param string $path
     * @param string $key
     *
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set(
            $key,
            array_merge(require $path, $config)
        );
    }

    /**
     * @return string
     */
    private function getConfigPath()
    {
        return __DIR__ . '/../../config/l5-stimulsoft.php';
    }

    /**
     * @return string
     */
    private function getMigrationsPath()
    {
        return __DIR__ . '/../../database/migrations/';
    }
}
