<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DirectorDebuteController;

class DdPdfCommand extends Command
{
    protected $signature = 'app:dd-pdf-command';

    protected $description = 'Generate a PDF using the specified controller function for Director Bebute';

    public function handle()
    {
        try {
            $controller = new DirectorDebuteController();
            $controller->pdfGenerator();
            $this->info('PDF generated successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error generating PDF: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
