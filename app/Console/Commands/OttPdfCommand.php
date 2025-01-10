<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\OttformController;

class OttPdfCommand extends Command
{
    protected $signature = 'app:ott-pdf-command';

    protected $description = 'Generate a PDF using the specified controller function for OTT';

    public function handle()
    {
        try {
            $controller = new OttformController();
            $controller->ottPdfGenerator();
            $this->info('PDF generated successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error generating PDF: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
