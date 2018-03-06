<?php

namespace Simple\App\Console\Commands;

class MigrationsUp extends Illuminate\Console\Command {

    protected $signature = 'migrations:up';
    protected $description = 'Run migrations up method only';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $path = $this->laravel->databasePath() . DIRECTORY_SEPARATOR . 'migrations';

        $migrations = glob($path . '/*_*.php');
        sort($migrations);

        foreach ($migrations as $file) {
            require_once($file);
        }


        // Once we have the array of migrations, we will spin through them and run the
        // migrations "up" so the changes are made to the databases. We'll then log
        // that the migration was run so we don't repeat it next time we execute.
        foreach ($migrations as $file) {

            $filename = str_replace('.php', '', basename($file));

            $class = Illuminate\Support\Str::studly(implode('_', array_slice(explode('_', $file), 4)));
            $migration = new $class;

            $migration->up();
            echo "\n Migrated: {$filename}";
        }
    }

}
