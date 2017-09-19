<?php namespace FelipeeDev\Preferences\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

class PreferenceTablesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'preferences:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the preference tables';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new preferences tables command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer    $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->replaceMigration(
            $this->createBaseMigration(),
            config('preferences.tables.preferences'),
            config('preferences.tables.preference_values')
        );

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        return $this->laravel['migration.creator']->create(
            'create_preferences_tables',
            $this->laravel->databasePath().'/migrations'
        );
    }

    /**
     * Replace the generated migration with the job table stub.
     *
     * @param  string $path
     * @param $preferencesTable
     * @param $preferenceValuesTable
     */
    protected function replaceMigration($path, $preferencesTable, $preferenceValuesTable)
    {
        $stub = str_replace(
            ['{{preferencesTable}}', '{{preferenceValuesTable}}'],
            [$preferencesTable, $preferenceValuesTable],
            $this->files->get(__DIR__.'/stubs/preferences.stub')
        );

        $this->files->put($path, $stub);
    }
}
