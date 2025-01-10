<?php

namespace App\Http\Controllers;

use App\Models\DdInternationalCompetition;
use App\Models\DdInternationalFilmFestival;
use App\Models\DdCommerciallyOutsideIndia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportNonFeature;
use App\Models\IpApplicationForm;
use App\Models\DdApplicationForm;
use App\Exports\DdExportSearch;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExportFeature;
use Illuminate\Http\Request;
use App\Models\DdCoProducer;
use App\Exports\ExportAllDd;
use App\Models\DdDirectors;
use App\Models\Transaction;
use App\Models\Document;
use App\Models\OttForm;
use App\Models\DdAward;
use ZipArchive;
use Mpdf\Mpdf;
class DirectorDebuteController extends Controller
{
    public function index(Request $request)
    {
        $payload    =   $request->all();        
        $ddRecords  =   DdApplicationForm::where('step', 9)->paginate(10);
        $count      =   DdApplicationForm::count();
        $paids = [
            9 => 'Paid',
            1 => 'Unpaid',
        ];
        return view('director-debute.index', [
            'dds'       =>  $ddRecords,
            'payload'   =>  $payload,
            'paids'     =>  $paids,
            'count'     =>  $count,
        ]);
    }

    public function search(Request $request)
    {
        $payload = $request->all();
        // New Version of Code
        $query      =   DdApplicationForm::query();
        $query->when($payload, function (Builder $builder) use ($payload) {

            if (!empty($payload['from_date']) && !empty($payload['to_date'])) {
                $builder->whereDate('created_at', '>=', $payload['from_date']);
                $builder->whereDate('created_at', '<=', $payload['to_date']);
            } elseif (empty($payload['from_date']) && !empty($payload['to_date'])) {
                $todayDate = date('Y-m-d');
                $builder->whereDate('created_at', '>=', $todayDate);
                $builder->whereDate('created_at', '<=', $payload['to_date']);
            } elseif (!empty($payload['from_date']) && empty($payload['to_date'])) {
                $todayDate = date('Y-m-d');
                $builder->whereDate('created_at', '>=', $payload['from_date']);
                $builder->whereDate('created_at', '<=', $todayDate);
            }

            if (!empty($payload['payment_status'])) {
                if ($payload['payment_status'] === '9') {
                    $builder->where('step', $payload['payment_status']);
                } elseif ($payload['payment_status'] === '1') {
                    if (!empty($payload['step'])) {
                        $builder->where('step', $payload['step']);
                    } else {
                        $builder->whereIn('step', range(1, 8));
                    }
                }
            } else {
                $builder->where('step', 9);
            }
            
        });

        // old Version of code
        // $payload = $request->all();
        // $fromDate = !empty($payload['from_date']) ? $payload['from_date'] : '';
        // $toDate = !empty($payload['to_date']) ? $payload['to_date'] : '';
        // $paymentStatus = !empty($payload['payment_status']) ? $payload['payment_status'] : '';
        // $step = !empty($payload['step']) ? $payload['step'] : '';
        // $query = DdApplicationForm::query();
        // if (!empty($fromDate) && !empty($toDate)) {
        //     $query->whereDate('created_at', '>=', $fromDate);
        //     $query->whereDate('created_at', '<=', $toDate);
        // } elseif (empty($fromDate) && !empty($toDate)) {
        //     $todayDate = date('Y-m-d');
        //     $query->whereDate('created_at', '>=', $todayDate);
        //     $query->whereDate('created_at', '<=', $toDate);
        // } elseif (!empty($fromDate) && empty($toDate)) {
        //     $todayDate = date('Y-m-d');
        //     $query->whereDate('created_at', '>=', $fromDate);
        //     $query->whereDate('created_at', '<=', $todayDate);
        // }
        // if (!empty($paymentStatus)) {
        //     if ($paymentStatus === '9') {
        //         $query->where('step', $paymentStatus);
        //     } elseif ($paymentStatus === '1') {
        //         if (!empty($step)) {
        //             $query->where('step', $step);
        //         } else {
        //             $query->where('step', '!=', 9);
        //         }
        //     }
        // }

        $filteredData   =   $query->get();
        session()->put('ddRecords', $filteredData);
        $count      =   $query->count();
        $ddRecords  =   $query->paginate(10);
        $paids = [
            9 => 'Paid',
            1 => 'Unpaid',
        ];
        return view('director-debute.index', [
            'dds'       =>  $ddRecords,
            'payload'   =>  $payload,
            'paids'     =>  $paids,
            'count'     =>  $count,
        ]);
    }

    public function titleOfFilm(Request $request)
    {
        $payload = $request->all();
        $validatorArray = [
            'id' => 'required',
        ];
        $messagesArray = [];

        $validator = Validator::make($request->all(), $validatorArray, $messagesArray);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $titleOfFilm = IpApplicationForm::where('id', $payload['id'])->first();
            if (is_null($titleOfFilm)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Records not found.!!',
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'data' => $titleOfFilm,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function featureExport()
    {
        return Excel::download(new ExportFeature(), 'feature.xls'); //true, ['X-Vapor-Base64-Encode' => 'True']
    }

    public function nonFeatureExport()
    {
        return Excel::download(new ExportNonFeature(), 'non_feature.xls'); //true, ['X-Vapor-Base64-Encode' => 'True']
    }

    public function excellReport()
    {
        $ddRecords = DdApplicationForm::select('*')->where('step', 9)->get();
        $fileName = 'director-debut.xls';
        return Excel::download(new ExportAllDd($ddRecords), $fileName);
    }

    public function exportBySearch()
    {
        if (session()->has('ddRecords')) {
            $ddRecords = session()->get('ddRecords');
            $fileName = 'DdSearch.xls';
            return Excel::download(new DdExportSearch($ddRecords), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function ottview(Request $request)
    {
        $id = 53;
        $datas = OttForm::select('ott_forms.*', 'doc1.name as documents_name', 'doc1.type as documents_type', 'doc1.file as file')
            ->leftJoin('documents as doc1', function ($join) {
                $join->on('doc1.context_id', '=', 'ott_forms.id')->where('doc1.website_type', 2);
            })
            ->where(['ott_forms.id' => $id])
            ->get();
        if ($datas->isEmpty()) {
            return null;
        }
        $data = $datas->first(); //->toArray();
        $data_array = $datas->first()->toArray();
        $data_array['documents'] = [];
        $data_array['payment_response'] = Transaction::where([
            'website_type' => 2,
            'context_id' => $id,
            'auth_status' => '0300',
        ])->first();
        $response = [
            'data' => $data,
        ];
        return view('ott.view', compact('data', 'data_array', 'OttCoProducer'));
    }

    public function downloadDocumentsAsZip(Request $request, $id)
    {
        $ips = DdApplicationForm::with('documents')->where('id', $id)->get();
        $zip = new ZipArchive();
        $filePath = storage_path('app/dd/' . $ips[0]->id . '/');

        File::makeDirectory($filePath, 0755, true, true);

        $filePath = $filePath . $ips[0]->english_translation_of_film . '.zip';

        if ($zip->open($filePath, ZipArchive::CREATE) === true) {
            foreach ($ips as $ip) {
                $count = 0;
                $folder = $ip->english_translation_of_film . '/';
                $hasFiles = false;
                $storage_url = env('STORAGE_URL', '/var/www/html/api/');
                // storage_path('app/public')
                // $storage_url    =   env('STORAGE_URL', '/var/www/html/api/');
                // $storage_url = storage_path('app/DD/');
                // dd($storage_url);
                foreach ($ip->documents as $document) {
                    $documentPath = $storage_url . 'storage/app/DD/' . $ip->id . '/' . $document->file;
                    $newFileName = ++$count . '. ' . $document->name;

                    if (file_exists($documentPath)) {
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                }

                if (!$hasFiles) {
                    $zip->addEmptyDir($folder);
                }
                $IpDirectors = DdDirectors::with('documents')
                    ->where('dd_application_form_id', $ip->id)
                    ->get();
                foreach ($IpDirectors as $IpDirector) {
                    foreach ($IpDirector->documents as $document) {
                        $documentPath = $storage_url . 'storage/app/DD/' . $ip->id . '/' . $document->file;

                        $newFileName = ++$count . '. ' . $document->name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        } else {
                            $documentPath = $storage_url . 'storage/app/dd/' . $ip->id . '/' . $document->file;
                            $newFileName = $document->name;
                            if (file_exists($documentPath)) {
                                $zip->addFile($documentPath, $folder . $newFileName);
                                $hasFiles = true;
                            }
                        }
                    }
                }
                $IpCoProducers = DdCoProducer::leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'dd_co_producers.id')->whereIn('doc1.type', [17]);
                })
                    ->leftJoin('documents as doc2', function ($join) {
                        $join->on('doc2.context_id', '=', 'dd_co_producers.id')->whereIn('doc2.type', [18]);
                    })
                    ->where('dd_application_form_id', $ip->id)
                    ->select('dd_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
                    ->get();

                foreach ($IpCoProducers as $IpCoProducer) {
                    if ($IpCoProducer->documents_name) {
                        $documentPath = $storage_url . 'storage/app/DD/' . $ip->id . '/' . $IpCoProducer->file;
                        $newFileName = ++$count . '. ' . $IpCoProducer->documents_name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                    if ($IpCoProducer->documents_name1) {
                        $documentPath = $storage_url . 'storage/app/DD/' . $ip->id . '/' . $IpCoProducer->file1;

                        $newFileName = $IpCoProducer->documents_name1;
                        $newFileName = ++$count . '. ' . $IpCoProducer->documents_name1;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                }
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

    public function ddPdf(Request $request, $id)
    {
        $ipForm = DdApplicationForm::with('documents')
            ->where(['id' => $id])
            ->first();
        $documents = Document::where(['context_id' => $id, 'website_type' => 4])->get();
        $IpCoProducer = DdCoProducer::leftJoin('documents as doc1', function ($join) {
            $join->on('doc1.context_id', '=', 'dd_co_producers.id')->whereIn('doc1.type', [17]);
        })
            ->leftJoin('documents as doc2', function ($join) {
                $join->on('doc2.context_id', '=', 'dd_co_producers.id')->whereIn('doc2.type', [18]);
            })
            ->where('dd_application_form_id', $id)
            ->select('dd_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
            ->get();

        $IpInternationalFilmFestival = DdInternationalFilmFestival::where('dd_application_form_id', $id)->get();
        $IpCommerciallyOutsideIndia = DdCommerciallyOutsideIndia::where('dd_application_form_id', $id)->get();
        $IpInternationalCompetition = DdInternationalCompetition::where('dd_application_form_id', $id)->get();
        $IpAward = DdAward::where('dd_application_form_id', $id)->get();
        $IpDirector = DdDirectors::with('documents')->where('dd_application_form_id', $id)->get();
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        $mpdf = new Mpdf([
            'tempDir' => $tempDir,
        ]);
        $data = [];
        $html = view('director-debute.pdf', compact('ipForm', 'IpCoProducer', 'IpInternationalFilmFestival', 'IpCommerciallyOutsideIndia', 'IpInternationalCompetition', 'IpAward', 'IpDirector', 'documents'));
        $html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . $html;

        mb_convert_encoding($html, 'UTF-8');

        $mpdf->WriteHTML($html);
        //echo $html;
        // die();
        $pdfFilePath = $ipForm->english_translation_of_film . '.pdf';
        $mpdf->Output($pdfFilePath, 'I'); // 'D' for download, 'I' for inline view
    }

    public function pdfGenerator()
    {
        $dds = DdApplicationForm::where('step', 9)->get();
        // $dds                =   DdApplicationForm::limit(1)->get();
        $outputDirectory = storage_path('app/public/pdfs/director-debute');

        if (!File::exists($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0777, true, true);
        }

        foreach ($dds as $dd) {
            $ipForm = DdApplicationForm::with('documents')
                ->where(['id' => $dd->id])
                ->first();
            $documents = Document::where(['context_id' => $ipForm->id, 'website_type' => 4])->get();
            $IpCoProducer = DdCoProducer::leftJoin('documents as doc1', function ($join) {
                $join->on('doc1.context_id', '=', 'dd_co_producers.id')->whereIn('doc1.type', [17]);
            })
                ->leftJoin('documents as doc2', function ($join) {
                    $join->on('doc2.context_id', '=', 'dd_co_producers.id')->whereIn('doc2.type', [18]);
                })
                ->where('dd_application_form_id', $ipForm->id)
                ->select('dd_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
                ->get();
            $IpInternationalFilmFestival = DdInternationalFilmFestival::where('dd_application_form_id', $ipForm->id)->get();
            $IpCommerciallyOutsideIndia = DdCommerciallyOutsideIndia::where('dd_application_form_id', $ipForm->id)->get();
            $IpInternationalCompetition = DdInternationalCompetition::where('dd_application_form_id', $ipForm->id)->get();
            $IpAward = DdAward::where('dd_application_form_id', $ipForm->id)->get();
            $IpDirector = DdDirectors::with('documents')
                ->where('dd_application_form_id', $ipForm->id)
                ->get();

            $data = [
                'title' => 'Debute Director',
                'date' => date('M-d-y H:i:s'),
                'ipForm' => $ipForm,
                'IpCoProducer' => $IpCoProducer,
                'IpInternationalFilmFestival' => $IpInternationalFilmFestival,
                'IpCommerciallyOutsideIndia' => $IpCommerciallyOutsideIndia,
                'IpInternationalCompetition' => $IpInternationalCompetition,
                'IpAward' => $IpAward,
                'IpDirector' => $IpDirector,
                'documents' => $documents,
            ];
            // $fileName   =   preg_replace('/[^A-Za-z0-9_\-]/', '_', $ipForm->english_translation_of_film) . $ipForm->id . '.pdf';
            $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $ipForm->english_translation_of_film) . $ipForm->id . '.pdf';
            $filePath = $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
            $pdf = Pdf::loadView('director-debute.myPdf', $data);
            $pdf->save($filePath);
        }
        // return response()->json([
        //     'message' => 'PDFs generated successfully!',
        //     'directory' => $outputDirectory,
        // ]);
    }
}
