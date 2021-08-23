<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use LogicException;
use Throwable;

class ServerlessOptimizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:serverless';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the application for serverless environments';

    /**
     * Class instance.
     */
    public function __construct(protected Filesystem $fs)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('config:clear');

        $localConfiguration = json_encode(config()->all(), JSON_UNESCAPED_SLASHES);

        $serverlessConfiguration = json_decode(json: Str::replace(
            search: base_path(),
            replace: config('serverless.path.base'),
            subject: $localConfiguration
        ), associative: true, flags: JSON_UNESCAPED_SLASHES);

        $path = $this->laravel->getCachedConfigPath();

        $this->fs->put(
            $path,
            '<?php return '.var_export($serverlessConfiguration, true).';'.PHP_EOL
        );

        try {
            require $path;
        } catch (Throwable $e) {
            $this->files->delete($path);
            throw new LogicException('Your configuration files are not serializable.', 0, $e);
        }

        $this->call('route:cache');

        $this->info('Your application is optimized for serverless environments!');
        $this->warn('Remember to run `php artisan optimize:clear` after deploy!');

        return 0;
    }
}
