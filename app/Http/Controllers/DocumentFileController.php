<?php

namespace App\Http\Controllers;

use App\Events\DocumentFileEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreDocumentFileRequest;
use App\Http\Resources\DocumentFileResource;
use App\Models\DocumentFile;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class DocumentFileController extends Controller
{
    use DatatableValidation;

    public function index(Request $request)
    {
        $validated = $this->validateDatatable($request, [
            // 'exampleExtraRule' => 'required|string',
        ]);

        $draw   = $validated['draw'];
        $start  = $validated['start'] ?? 0;
        $length = $validated['length'] ?? 10;
        $search = $validated['search'] ?? null;
        // $exampleExtraRule = $validated['exampleExtraRule'];

        try {
            $query = DocumentFile::funcDocumentFileSearch($search);
            $recordsTotal = $query->count();

            $data = DocumentFileResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function store(StoreDocumentFileRequest $request)
    {
        try {
            $data = DocumentFile::create($request->validated() + [
                'fileurl' => $request->fileurl
            ]);
            event(new DocumentFileEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Document File', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
