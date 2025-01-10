<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\DdApplicationForm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\DdDirectors;
use App\Models\DdCoProducer;

use ZipArchive;

class DDExportZip extends Command
{

    protected $signature = 'app:export-zip-dd';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        // $this->info('Running my custom command!');
        // return Command::SUCCESS;
        $ips = DdApplicationForm::with('documents')->where(['step' => 9, 'status' => 1])->get();
        $zip = new ZipArchive;
        $filePath = storage_path('app/DD/');
        File::makeDirectory($filePath, 0755, true, true);
        $filePath =  'overallDDZip.zip';
        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {

            foreach ($ips as $ip) {
                $count = 0;
                $folder = $ip->id.".".$ip->english_translation_of_film . '/';
                $hasFiles = false;
                // echo "<pre>";
                //print_r($ip);
                //die();
                $storage_url = env('STORAGE_URL', '/var/www/html/api/');
                foreach ($ip->documents as $document) {

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

                // Add directory to zip even if no files found
                if (!$hasFiles) {
                    $zip->addEmptyDir($folder);
                }

                // Co-producers
                $IpDirectors = DdDirectors::with('documents')->where('dd_application_form_id', $ip->id)->get();

                foreach ($IpDirectors as $IpDirector) {
                    foreach ($IpDirector->documents as $document) {
                        //  $documentPath = storage_path('app/ott/' . $ottForm->id . '/' . $document->file);
                        $documentPath = ($storage_url . 'storage/app/dd/' . $ip->id . '/' . $document->file);
                        $newFileName = ++$count . ". " . $document->name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        } else {
                            $documentPath = ($storage_url . 'storage/app/dd/' . $ip->id . '/' . $document->file);
                            $newFileName = $document->name;
                            if (file_exists($documentPath)) {
                                $zip->addFile($documentPath, $folder . $newFileName);
                                $hasFiles = true;
                            }
                        }
                    }
                }
                $IpCoProducers = DdCoProducer::leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'dd_co_producers.id')
                        ->whereIn('doc1.type', [17])
                        ->where('doc1.website_type', 4)
                    ;
                })->leftJoin('documents as doc2', function ($join) {
                    $join->on('doc2.context_id', '=', 'dd_co_producers.id')
                        ->where('doc1.website_type', 4)
                        ->whereIn('doc2.type', [18]);
                })
                    // ->where('documents.type', [17, 18]) ss
                    ->where('dd_application_form_id', $ip->id)
                    ->select(
                        'dd_co_producers.*',
                        'doc1.name as documents_name',
                        'doc1.file as file',
                        'doc2.file as file1',
                        'doc2.name as documents_name1'
                    )
                    ->get();

                foreach ($IpCoProducers as $IpCoProducer) {
                    if ($IpCoProducer->documents_name) {
                        $documentPath = ($storage_url . 'storage/app/dd/' . $ip->id . '/' .  $IpCoProducer->file);


                        $newFileName = ++$count . ". " . $IpCoProducer->documents_name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                    if ($IpCoProducer->documents_name1) {
                        $documentPath = ($storage_url . 'storage/app/dd/' . $ip->id . '/' .  $IpCoProducer->file1);

                        $newFileName = $IpCoProducer->documents_name1;
                        $newFileName = ++$count . ". " . $IpCoProducer->documents_name1;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                }

                // Add directory to zip even if no files found
                if (!$hasFiles) {
                    $zip->addEmptyDir($folder);
                }
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($filePath);
    }
}
