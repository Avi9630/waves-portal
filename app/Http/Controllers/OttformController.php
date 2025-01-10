<?php

namespace App\Http\Controllers;

use App\Models\OttInternationalCompetition;
use Illuminate\Database\Eloquent\Builder;
use App\Models\OttThreatricalScreening;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use App\Exports\OttCoproducerExport;
use App\Models\OttStreamedCountry;
use App\Models\OttCreatorsDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OttBroadcasted;
use App\Models\OttCoProducer;
use App\Exports\OttExportBy;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Exports\OttExport;
use App\Models\OttEpisode;
use App\Models\Language;
use App\Models\Document;
use App\Models\OttForm;
use App\Models\Country;
use App\Models\Client;
use App\Models\Genre;
use ZipArchive;
use Mpdf\Mpdf;


class OttformController extends Controller
{
    public function __construct()
    {
        $this->user     =   Auth::user();
    }

    public function index(Request $request)
    {
        $payload    =   $request->all();
        $count      =   OttForm::count();
        $ottRecords =   OttForm::where('step', 8)->paginate(10);
        $clientList =   Client::get();
        $genre      =   Genre::get();
        $language   =   Language::get();
        session()->put('ottRecords', $ottRecords);
        return view(
            'ott.index',
            [
                'count'      => $count,
                'ottlist'    => $ottRecords,
                'payload'    => $payload,
                'clientList' => $clientList,
                'genre'      => $genre,
                'language'   => $language,
            ]
        );
    }

    public function search(Request $request)
    {
        $payload    =   $request->all();
        
        // V-1
        // $fromDate       =   !empty($payload['created_at_start']) ? $payload['created_at_start'] : '';
        // $toDate         =   !empty($payload['created_at_end']) ? $payload['created_at_end'] : '';
        // $genre          =   !empty($payload['genre_id']) ? $payload['genre_id'] : '';
        // $paymentStatus  =   !empty($payload['payment_status']) ? $payload['payment_status'] : '';
        // $step           =   !empty($payload['step']) ? $payload['step'] : '';

        // $query = OttForm::query();
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
        // if (!empty($genre)) {
        //     $query->where('genre_id', $genre);
        // }
        // if (!empty($paymentStatus)) {
        //     if ($paymentStatus === "8") {
        //         $query->where('step', $paymentStatus);
        //     }
        //     if ($paymentStatus === "1") {
        //         if (!empty($step)) {
        //             $query->where('step', $step);
        //         }
        //     }
        // }

        // V-2
        $query = OttForm::query();
        $query->when($payload, function (Builder $builder) use ($payload) {

            if (!empty($payload['created_at_start']) && !empty($payload['created_at_end'])) {
                $builder->whereDate('created_at', '>=', $payload['created_at_start']);
                $builder->whereDate('created_at', '<=', $payload['created_at_end']);
            } elseif (empty($payload['created_at_start']) && !empty($payload['created_at_end'])) {
                $todayDate = date('Y-m-d');
                $builder->whereDate('created_at', '>=', $todayDate);
                $builder->whereDate('created_at', '<=', $payload['created_at_end']);
            } elseif (!empty($payload['created_at_start']) && empty($payload['created_at_end'])) {
                $todayDate = date('Y-m-d');
                $builder->whereDate('created_at', '>=', $payload['created_at_start']);
                $builder->whereDate('created_at', '<=', $todayDate);
            }

            if (!empty($payload['genre_id'])) {
                $builder->where('genre_id', $payload['genre_id']);
            }

            if (!empty($payload['payment_status'])) {
                if ($payload['payment_status'] === '8') {
                    $builder->where('step', $payload['payment_status']);
                } elseif ($payload['payment_status'] === '1') {
                    if (!empty($payload['step'])) {
                        $builder->where('step', $payload['step']);
                    } else {
                        $builder->whereIn('step', range(1, 7));
                    }
                }
            } else {
                $builder->where('step', 8);
            }
        });

        $filteredData = $query->get();
        session()->put('ottRecords', $filteredData);
        $count      =   $query->count();
        $ottlist    =   $query->paginate(10);
        $clientList =   Client::get();
        $genre      =   Genre::get();
        $language   =   Language::get();
        return view(
            'ott.index',
            [
                'ottlist'       =>  $ottlist,
                'payload'       =>  $payload,
                'clientList'    =>  $clientList,
                'genre'         =>  $genre,
                'language'      =>  $language,
                'count'         =>  $count,
            ]
        );
    }

    public function exportBySearch()
    {
        if (session()->has('ottRecords')) {
            $ottRecords  =   session()->get('ottRecords');
            $fileName   =   'OttBySearch.xls';
            return Excel::download(new OttExportBy($ottRecords), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function downloadDocumentsAsZip(Request $request, $id)
    {
        $ottForms = OttForm::with('documents')->where('id', $id)->get();

        $zip = new ZipArchive;
        $filePath = storage_path('app/ott/' . $ottForms[0]->id . '/'); // Simplify path for demonstration
        File::makeDirectory($filePath, 0755, true, true); // Create the directory recursively

        $filePath = $filePath . $ottForms[0]->title . '.zip';
        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
            $count = 0;
            foreach ($ottForms as $ottForm) {
                $ottFolder = $ottForm->title . '/';
                $hasFiles = false;
                $storage_url = env('STORAGE_URL', '/var/www/html/api/');
                foreach ($ottForm->documents as $document) {
                    $documentPath = ($storage_url . 'storage/app/ott/' . $ottForm->id . '/' . $document->file);

                    //  $documentPath = storage_path('app/ott/' . $ottForm->id . '/' . $document->file);
                    $newFileName = ++$count . "- " . $document->name;
                    //  echo "hdhd";

                    if (file_exists($documentPath)) {
                        //  die("data");
                        $zip->addFile($documentPath, $ottFolder . $newFileName);
                        $hasFiles = true;
                    }
                    //die("ddd");
                }

                // Add directory to zip even if no files found
                if (!$hasFiles) {
                    $zip->addEmptyDir($ottFolder);
                }

                // Co-producers
                $OttCoProducers = OttCoProducer::with('documents')->where('ott_form_id', $ottForm->id)->get();

                foreach ($OttCoProducers as $OttCoProducer) {
                    foreach ($OttCoProducer->documents as $document) {

                        //  $documentPath = storage_path('app/ott/' . $ottForm->id . '/' . $document->file);
                        $documentPath = ($storage_url . 'storage/app/ott/' . $ottForm->id . '/' . $document->file);

                        $newFileName = ++$count . "- " . $document->name;

                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $ottFolder . $newFileName);
                            $hasFiles = true;
                        }
                        $documentPath = ($storage_url . 'storage/app/ott/' . $OttCoProducer->id . '/' . $document->file);
                        $newFileName = ++$count . "- " . $document->name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $ottFolder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                }

                // Add directory to zip even if no files found
                if (!$hasFiles) {
                    $zip->addEmptyDir($ottFolder);
                }
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($filePath); //->deleteFileAfterSend(true);
    }

    public function downloadDocumentsAsZip1()
    {
        $ottForms = OttForm::with('documents')->get();

        $zip = new ZipArchive;
        $fileName = 'ott_documents.zip';
        $filePath = 'ott_documents.zip';
        // $filePath = storage_path('app/' . $fileName);
        // if (!is_dir(storage_path('app'))) {
        //     mkdir(storage_path('app'), 0755, true);
        // }
        //echo $filePath;
        // die();

        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {

            foreach ($ottForms as $ottForm) {
                $ottFolder = $ottForm->title . '/';
                $zip->addEmptyDir($ottFolder);
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($filePath);
    }

    public function list(Request $request)
    {
        $payload = $request->all();
        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('order', 'asc');
        $query = OttForm::orderBy($sortField, $sortOrder);

        // if (!$request->has('showall') && $request->showall != 1) {
        //     $query->where('step', '8');
        // }

        // if ($request->has('title') && $request->title != '') {
        //     $query->where('title', 'like', '%' . $request->title . '%');
        // }

        // if ($request->has('title_in_english') && $request->title_in_english != '') {

        //     $query->where('title_in_english', 'like', '%' . $request->title_in_english . '%');
        // }

        if ($request->has('client_id') && $request->client_id != '') {

            $query->where('client_id', $request->client_id);
        }

        if ($request->has('genre_id') && !empty($request->genre_id)) {
            $query->where('genre_id', $request->genre_id);
            // $query->whereIn('genre_id', $request->genre_id);
        }

        // if ($request->has('language_id') && $request->language_id != '') {
        //     $query->where('language_id', $request->language_id);
        // }

        if ($request->has('created_at_start') && $request->created_at_start != '') {
            $query->whereDate('created_at', '>=', $request->created_at_start);
        }
        if ($request->has('created_at_end') && $request->created_at_end != '') {
            $query->whereDate('created_at', '<=', $request->created_at_end);
        }
        $paymentStatus = !empty($request->payment_status) ? $request->payment_status : null;
        if (!empty($paymentStatus)) {
            if ($paymentStatus === "8") {
                $query->where('step', $paymentStatus);
            } elseif ($paymentStatus === "1") {
                $query->where('step', '<', 8);
            }
        } else {
            $query->where('step', 8);
        }
        $query->where('status', '!=', 2);

        $ottlist = $query->paginate(10);

        $clientList = Client::get();
        $genre = Genre::get();
        $language = Language::get();
        return view(
            'ott.list',
            compact('ottlist', 'sortField', 'sortOrder', 'clientList', 'genre', 'language')
        );
    }

    public function export(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('order', 'asc');
        return Excel::download(new OttExport($sortOrder, $sortField, $request), 'ott_list.xlsx');
    }

    public function exportCoproducer(Request $request)
    {
        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('order', 'asc');
        return Excel::download(new OttCoproducerExport($sortOrder, $sortField, $request), 'coproducer_list.xlsx');
    }

    public function ottview(Request $request, $id)
    {
        $datas = OttForm::select(
            'ott_forms.*',
            'doc1.name as documents_name',
            'doc1.type as documents_type',
            'doc1.file as file'
        )
            ->leftJoin('documents as doc1', function ($join) {
                $join->on('doc1.context_id', '=', 'ott_forms.id')
                    ->where('doc1.website_type', 2);
            })
            ->where(['ott_forms.id' => $id])
            ->get();
        // echo "<pre>";print_r($datas);
        if ($datas->isEmpty()) {
            return null; // Or handle the case where no data is found
        }

        $data = $datas->first(); //->toArray();
        $data_array = $datas->first()->toArray();
        $data_array['documents'] = [];

        $data_array['payment_response']   =   Transaction::where([
            'website_type' => 2,
            'context_id' => $id,
            'auth_status' => '0300',
        ])->first();


        $OttCoProducer = OttCoProducer::with('documents')->where('ott_form_id', $id)->get(); //->toArray();
        $OttEpisode = OttEpisode::where('ott_form_id', $id)->get();
        $createrDetails = OttCreatorsDetail::where('ott_form_id', $id)->where('type', 1)->get();
        $Country = Country::pluck('country_name', 'id')->toArray();
        $OttStreamedCountry = OttStreamedCountry::where('ott_form_id', $id)->get();
        $OttThreatricalScreening = OttThreatricalScreening::where('ott_form_id', $id)->get();
        $OttBroadcasted = OttBroadcasted::where('ott_form_id', $id)->get();
        $OttInternationalCompetition = OttInternationalCompetition::where('ott_form_id', $id)->get();

        $OttDirectorDetail = OttCreatorsDetail::where('ott_form_id', $id)->where('type', 2)->get();
        $OttDocs = Document::where(['context_id' => $id, "website_type" => 2])->get()->toArray();
        $OttDoc = [];
        foreach ($OttDocs as $document) $OttDoc[$document['type']] = [
            'name' => $document['name'],
            'file' => $document['file']
        ];
        // echo "<pre>";
        // print_r($createrDetails);
        // die();
        return view(
            'ott.view',
            compact('data', 'data_array', 'OttCoProducer', 'OttStreamedCountry', 'Country', 'OttThreatricalScreening', 'OttInternationalCompetition', 'OttBroadcasted', 'OttEpisode', 'createrDetails', 'OttDirectorDetail', 'OttDoc')
        );
    }

    public function ottpdf(Request $request, $id)
    {
        $datas = OttForm::select(
            'ott_forms.*',
            'doc1.name as documents_name',
            'doc1.type as documents_type',
            'doc1.file as file'
        )
            ->leftJoin('documents as doc1', function ($join) {
                $join->on('doc1.context_id', '=', 'ott_forms.id')
                    ->where('doc1.website_type', 2);
            })
            ->where(['ott_forms.id' => $id])
            ->get();

        if ($datas->isEmpty()) {
            return null; // Or handle the case where no data is found
        }

        $data = $datas->first(); //->toArray();
        $data_array = $datas->first()->toArray();
        $data_array['documents'] = [];

        $data_array['payment_response'] = Transaction::where([
            'website_type' => 2,
            'context_id' => $id,
            'auth_status' => '0300',
        ])->first();

        $OttCoProducer = OttCoProducer::with('documents')->where('ott_form_id', $id)->get();
        $OttEpisode = OttEpisode::where('ott_form_id', $id)->get();
        $createrDetails = OttCreatorsDetail::where('ott_form_id', $id)->where('type', 1)->get();
        $Country = Country::pluck('country_name', 'id')->toArray();
        $OttStreamedCountry = OttStreamedCountry::where('ott_form_id', $id)->get();
        $OttThreatricalScreening = OttThreatricalScreening::where('ott_form_id', $id)->get();
        $OttBroadcasted = OttBroadcasted::where('ott_form_id', $id)->get();
        $OttInternationalCompetition = OttInternationalCompetition::where('ott_form_id', $id)->get();

        $OttDirectorDetail = OttCreatorsDetail::where('ott_form_id', $id)->where('type', 2)->get();
        $OttDocs = Document::where(['context_id' => $id, "website_type" => 2])->get()->toArray();
        $OttDoc = [];
        foreach ($OttDocs as $document) {
            $OttDoc[$document['type']] = [
                'name' => $document['name'],
                'file' => $document['file'],
            ];
        }

        // $pdf = PDF::loadView('ott.pdf', compact('data', 'data_array', 'OttCoProducer', 'OttStreamedCountry', 'Country', 'OttThreatricalScreening', 'OttInternationalCompetition', 'OttBroadcasted', 'OttEpisode', 'createrDetails', 'OttDirectorDetail', 'OttDoc'));
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';

        // Ensure the temp directory exists
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $mpdf = new Mpdf([
            'tempDir' => $tempDir,
        ]);
        $html = view(
            'ott.pdf',
            compact(
                'data',
                'data_array',
                'OttCoProducer',
                'OttStreamedCountry',
                'Country',
                'OttThreatricalScreening',
                'OttInternationalCompetition',
                'OttBroadcasted',
                'OttEpisode',
                'createrDetails',
                'OttDirectorDetail',
                'OttDoc'
            )
        );
        //  echo $html;
        // die();
        $mpdf->WriteHTML($html);

        $pdfFilePath = $data_array['title'] . '.pdf';
        $mpdf->Output($pdfFilePath, 'D'); // 'D' for download, 'I' for inline view

        //   return $pdf->download('ott_view.pdf');
    }

    public function pdfGenerator()
    {
        $otts    =   OttForm::where('step', 8)->limit(2)->get();
        $outputDirectory = public_path('pdfs/OTT');
        if (!File::exists($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0777, true, true);
        }
        foreach ($otts as $ott) {
            $datas = OttForm::select(
                'ott_forms.*',
                'doc1.name as documents_name',
                'doc1.type as documents_type',
                'doc1.file as file'
            )
                ->leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'ott_forms.id')
                        ->where('doc1.website_type', 2);
                })
                ->where(['ott_forms.id' => $ott->id])
                ->get();

            if ($datas->isEmpty()) {
                return null;
            }

            $data = $datas->first(); //->toArray();
            $data_array = $datas->first()->toArray();
            $data_array['documents'] = [];
            $data_array['payment_response'] = Transaction::where([
                'website_type' => 2,
                'context_id' => $ott->id,
                'auth_status' => '0300',
            ])->first();
            $OttCoProducer = OttCoProducer::with('documents')->where('ott_form_id', $ott->id)->get();
            $OttEpisode = OttEpisode::where('ott_form_id', $ott->id)->get();
            $createrDetails = OttCreatorsDetail::where('ott_form_id', $ott->id)->where('type', 1)->get();
            $Country = Country::pluck('country_name', 'id')->toArray();
            $OttStreamedCountry = OttStreamedCountry::where('ott_form_id', $ott->id)->get();
            $OttThreatricalScreening = OttThreatricalScreening::where('ott_form_id', $ott->id)->get();
            $OttBroadcasted = OttBroadcasted::where('ott_form_id', $ott->id)->get();
            $OttInternationalCompetition = OttInternationalCompetition::where('ott_form_id', $ott->id)->get();

            $OttDirectorDetail = OttCreatorsDetail::where('ott_form_id', $ott->id)->where('type', 2)->get();
            $OttDocs = Document::where(['context_id' => $ott->id, "website_type" => 2])->get()->toArray();
            $OttDoc = [];
            foreach ($OttDocs as $document) {
                $OttDoc[$document['type']] = [
                    'name' => $document['name'],
                    'file' => $document['file'],
                ];
            }

            $data = [
                'title' => 'OTT',
                'date'  => date('M-d-y H:i:s'),
                'data_array' => $data_array,
                'OttCoProducer' => $OttCoProducer,
                'OttStreamedCountry' => $OttStreamedCountry,
                'Country' => $Country,
                'OttThreatricalScreening' => $OttThreatricalScreening,
                'OttInternationalCompetition' => $OttInternationalCompetition,
                'OttBroadcasted' => $OttBroadcasted,
                'OttEpisode' => $OttEpisode,
                'createrDetails' => $createrDetails,
                'OttDirectorDetail' => $OttDirectorDetail,
                'OttDoc' => $OttDoc
            ];

            // $fileName = $ipForm->english_translation_of_film . $ipForm->id  . '.pdf';
            $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data_array->title) . $data_array->title . '.pdf';
            $filePath = $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
            $pdf = Pdf::loadView('ips.pdf', $data);
            $pdf->save($filePath);
        }
        return response()->json([
            'message' => 'PDFs generated successfully!',
            'directory' => $outputDirectory,
        ]);
    }

    public function ottPdfGenerator()
    {
        // $otts    =   OttForm::where('step', 8)->get();
        // $otts    =   OttForm::where('step', 8)->limit(1)->get();
        $otts    =   OttForm::where('step', 8)->get();
        $outputDirectory = storage_path('app/public/pdfs/OTT');
        if (!File::exists($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0777, true, true);
        }
        foreach ($otts as $ott) {

            $datas = OttForm::select(
                'ott_forms.*',
                'doc1.name as documents_name',
                'doc1.type as documents_type',
                'doc1.file as file'
            )
                ->leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'ott_forms.id')
                        ->where('doc1.website_type', 2);
                })
                ->where(['ott_forms.id' => $ott->id])
                ->get();
            if ($datas->isEmpty()) {
                return null;
            }
            $data                       =   $datas->first();
            $data_array                 =   $datas->first()->toArray();
            $data_array['documents']    =   [];

            $data_array['payment_response'] = Transaction::where([
                'website_type' => 2,
                'context_id' => $ott->id,
                'auth_status' => '0300',
            ])->first();

            $OttCoProducer                  =   OttCoProducer::with('documents')->where('ott_form_id', $ott->id)->get();
            $OttEpisode                     =   OttEpisode::where('ott_form_id', $ott->id)->get();
            $createrDetails                 =   OttCreatorsDetail::where('ott_form_id', $ott->id)->where('type', 1)->get();
            $Country                        =   Country::pluck('country_name', 'id')->toArray();
            $OttStreamedCountry             =   OttStreamedCountry::where('ott_form_id', $ott->id)->get();
            $OttThreatricalScreening        =   OttThreatricalScreening::where('ott_form_id', $ott->id)->get();
            $OttBroadcasted                 =   OttBroadcasted::where('ott_form_id', $ott->id)->get();
            $OttInternationalCompetition    =   OttInternationalCompetition::where('ott_form_id', $ott->id)->get();
            $OttDirectorDetail              =   OttCreatorsDetail::where('ott_form_id', $ott->id)->where('type', 2)->get();
            $OttDocs                        =   Document::where(['context_id' => $ott->id, "website_type" => 2])->get()->toArray();
            $OttDoc = [];
            foreach ($OttDocs as $document) {
                $OttDoc[$document['type']] = [
                    'name' => $document['name'],
                    'file' => $document['file'],
                ];
            }
            $data = [
                'title'                         =>  'OTT',
                'date'                          =>  date('M-d-y H:i:s'),
                'data_array'                    =>  $data_array,
                'OttCoProducer'                 =>  $OttCoProducer,
                'OttStreamedCountry'            =>  $OttStreamedCountry,
                'Country'                       =>  $Country,
                'OttThreatricalScreening'       =>  $OttThreatricalScreening,
                'OttInternationalCompetition'   =>  $OttInternationalCompetition,
                'OttBroadcasted'                =>  $OttBroadcasted,
                'OttEpisode'                    =>  $OttEpisode,
                'createrDetails'                =>  $createrDetails,
                'OttDirectorDetail'             =>  $OttDirectorDetail,
                'OttDoc'                        =>  $OttDoc
            ];
            $fileName   =   preg_replace('/[^A-Za-z0-9_\-]/', '_', $data_array['title']) . '.pdf';
            $filePath   =   $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
            $pdf        =   Pdf::loadView('ott.myPdf', $data);
            $pdf->save($filePath);
            // return $pdf->stream($filePath);
        }
        // return response()->json([
        //     'message' => 'PDFs generated successfully!',
        //     'directory' => $outputDirectory,
        // ]);
    }
}
