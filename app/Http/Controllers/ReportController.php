<?php

namespace App\Http\Controllers;

use App\Events\ReportEvent;
use App\Http\Controllers\Traits\DatatableValidation;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Resources\ReportResource;
use App\MyHelper\ResponseHelper;
use App\Models\Report;
use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Http\Request;

class ReportController extends Controller
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
            $query = Report::funcReportEmployee($search);

            $recordsTotal = $query->count();

            $data = ReportResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    public function store(StoreReportRequest $request)
    {

        try {
            $data = Report::create($request->validated());

            event(new ReportEvent($data, 'created'));

            return ResponseHelper::success('Successfully create Report', $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function update(UpdateReportRequest $request, $id)
    {
        try {
            $data = Report::findBy('id', $id)->first();

            $data->update($request->validated());

            event(new ReportEvent($data, 'updated'));

            return ResponseHelper::success('Successfully create Report', $data);
        } catch (\Throwable $th) {

            return ResponseHelper::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Report::findBy('id', $id)->first();

            if (!$data) {
                return ResponseHelper::error('Report not found', HttpStatusCodes::HTTP_NOT_FOUND);
            }

            event(new ReportEvent($data, 'deleted'));

            $data->delete();

            return ResponseHelper::success('Successfully delete Report');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function checkTypes(Request $request)
    {

        $validated = $this->validateDatatable($request, [
            // 'exampleExtraRule' => 'required|string',
        ]);

        $draw   = $validated['draw'];
        $start  = $validated['start'] ?? 0;
        $length = $validated['length'] ?? 10;
        $search = $validated['search'] ?? null;


        try {
            $checkType = $request->input('check_type');

            $query = Report::funcReportEmployeeByCheckType($search, $checkType);

            $recordsTotal = $query->count();

            $data = $query->offset($start)->limit($length)->get();

            $data = ReportResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function status(Request $request)
    {

        $validated = $this->validateDatatable($request, [
            // 'exampleExtraRule' => 'required|string',
        ]);

        $draw   = $validated['draw'];
        $start  = $validated['start'] ?? 0;
        $length = $validated['length'] ?? 10;
        $search = $validated['search'] ?? null;

        try {
            $status = $request->input('status');

            $query = Report::funcReportEmployeeByStatus($status, $search);

            $recordsTotal = $query->count();

            $data = $query->offset($start)->limit($length)->get();

            $data = ReportResource::collection($query->skip($start)->take($length)->get());

            return ResponseHelper::datatable($draw, $recordsTotal, $data);
        } catch (\Throwable $th) {

            return ResponseHelper::error($th->getMessage());
        }
    }
}
