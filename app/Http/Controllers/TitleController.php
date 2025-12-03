<?php

namespace App\Http\Controllers;

use App\Events\TitleEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreTitleRequest;
use App\Http\Requests\UpdateTitleRequest;
use App\Http\Resources\TitleResource;
use App\Models\Title;
use App\MyHelper\Constants\HttpStatusCodes;
use App\MyHelper\ResponseHelper;
use Illuminate\Http\Request;

class TitleController extends Controller
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
            $query = Title::funcTitleSearch($search);
            $recordsTotal = $query->count();

            $data = TitleResource::collection($query->skip($start)->take($length)->get());


            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => true,
                'message' => $th->getMessage()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreTitleRequest $request)
    {
        try {
            $data = Title::create($request->validated());

            event(new TitleEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Title', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateTitleRequest $request, $id)
    {
        try {
            $data = Title::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Title not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            $data->update($request->validated());

            event(new TitleEvent($data, 'updated'));

            return ResponseHelper::success('Successfully update Title', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Title::findBy('id', $id)->first();
            if (!$data) {
                return ResponseHelper::error('Title not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }
            event(new TitleEvent($data, 'deleted'));
            $data->delete();
            return ResponseHelper::success('Successfully delete Title');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
