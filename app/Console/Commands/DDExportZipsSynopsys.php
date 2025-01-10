<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\IpApplicationForm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\IpDirector;
use App\Models\IpCoProducer;

use ZipArchive;

class DDExportZipsSynopsys extends Command
{

    protected $signature = 'app:export-data1-dd';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        // $this->info('Running my custom command!');
        // return Command::SUCCESS;
        $ips = IpApplicationForm::with('documents')->where(['step' => 9, 'status' => 1])->get();
        $zip = new ZipArchive;
        // $filePath = storage_path('app/ip/');
        // File::makeDirectory($filePath, 0755, true, true);
        $filePath =  'dd-zip-synopsis.zip';
        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {

            foreach ($ips as $ip) {

                $count = 0;
                $folder =  '';
                $hasFiles = false;
                // echo "<pre>";
                //print_r($ip);
                //die();
                $storage_url = env('STORAGE_URL', '/var/www/html/api/');
                foreach ($ip->documents as $document) {
                    if ($document->type != 7) continue;
                    $documentPath = ($storage_url . 'storage/app/dd/' . $ip->id . '/' . $document->file);
                    //    echo $documentPath;
                    //   die();
                    //  $documentPath = storage_path('app/ott/' . $ottForm->id . '/' . $document->file);
                    $newFileName = ++$count . ". " . $document->name;
                    //  echo "hdhd";

                    if (file_exists($documentPath)) {
                        //  die("data");
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                    //die("ddd");
                }
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($filePath);
    }
}
