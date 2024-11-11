<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSwaggerDocs extends Command
{
    protected $signature = 'swagger:generate';
    protected $description = 'Generate swagger documentation';

    public function handle()
    {
        $swagger = \OpenApi\Generator::scan([app_path()]);

        $swagger->saveAs(storage_path('api-docs/swagger.json'));

        $this->info('Swagger documentation generated successfully.');
    }
}