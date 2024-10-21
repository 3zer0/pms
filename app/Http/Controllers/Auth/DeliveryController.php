<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Delivery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserPrivilege;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Models\UserJurisdiction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreDeliveryRequest;

class DeliveryController extends Controller
{
    use ResponseTrait;

    private $canView;
    private $canEdit;
    private $canDelete;
    private $canItem;

    public function __construct()
    {
        $this->canView   = Gate::allows('delivery', 'view');
        $this->canEdit   = Gate::allows('delivery', 'edit');
        $this->canDelete = Gate::allows('delivery', 'delete');
        $this->canItem    = Gate::allows('delivery', 'item');
    }

    public function index()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.deliveries');
    }

    public function dt_deliveries(Request $request)
    {
        $draw    = $request->get('draw');
        $start   = $request->get('start');
        $perPage = $request->get('length');

        // additional condition
        $filter = [];

        // search
        if($request->has('searchCols')) {
            $searchCols = $request->get('searchCols');
            $searchVal  = $request->get('search');

            if(!empty($searchVal)) {
                $filter[] = [ function($query) use ($searchCols, $searchVal) {
                    foreach ($searchCols as $key => $col) {
                        $query->orWhere($col, 'LIKE', "%" . $searchVal . "%");
                    }
                } ];
            }
        }

        $delivery = Delivery::query()
                ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
                ->join('offices', 'divisions.office_id', '=', 'offices.id')
                ->join('clusters', 'offices.cluster_id', '=', 'clusters.id')
                ->join('suppliers', 'deliveries.supplier_id', '=', 'suppliers.id')
                ->where($filter);

        $filteredCount = $delivery->count();
        $filteredData  = $delivery->skip($start)
                            ->take($perPage)
                            ->orderBy('deliveries.created_at', 'desc')
                            ->get([
                                'clusters.*',
                                'offices.*',
                                'deliveries.*',
                                DB::raw("(SELECT COUNT(items.id) FROM items WHERE items.delivery_id = deliveries.id) as itemCount"),
                                'suppliers.supplier_name',
                                'suppliers.supplier_address',
                                'divisions.division_name',
                                'divisions.abbre'
                            ]);

        if($filteredCount > 0) {

            foreach ($filteredData as $key => $dt) {

                $action  = '';
                $buttons = '';

                if($this->canEdit || $this->canDelete || $this->canItem) {

                    if($this->canEdit) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3" data-action="edit-delivery" data-row="'. $key .'">
                                        Edit Delivery
                                    </a>
                                </div>';
                    }
                    if($dt->del_quantity > $dt->itemCount) {
                        if($this->canItem) {
                            $buttons .= '<div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3" data-action="add-item" data-row="'. $key .'">
                                            Add Item
                                        </a>
                                    </div>';
                        }
                    }

                    if($this->canDelete) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3 text-danger" data-action="delete-delivery" data-row="'. $key .'">
                                        Delete Delivery
                                    </a>
                                </div>';
                    }


                    $action = '<a href="#" class="btn btn-icon btn-light h-35px w-35px pulse pulse-primary mb-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-flip="top-start">
                                    <i class="ki-outline ki-setting-2 text-primary fs-3"></i>
                                <span class="pulse-ring"></span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                '. $buttons .'
                            </div>';
                }

                $filteredData[$key]['action'] = $action;
            }
        }

        return [
            'draw'                 => $draw,
            'iTotalRecords'        => $filteredCount,
            'iTotalDisplayRecords' => $filteredCount,
            'data'                 => $filteredData
        ];
    }

    public function store(StoreDeliveryRequest $request): Response
    {
        try {

            // Generate Series No.
            // $regionSn   = $request->region_sn;
            // $officeSn   = $request->office_sn;
            // $curYear    = date('Y');
            // $curMonth   = date('m');
            $seriesCode = 'DRN-';
            $DRN   = Delivery::select(DB::raw("LPAD(IFNULL(MAX(SUBSTRING_INDEX(ref_no, '-', -1)), 0) + 1, 5, 0) series"))
                        ->where('ref_no', 'LIKE', '%' . $seriesCode . '%')
                        ->first();

            Delivery::create([
                'ref_no'       => $seriesCode . $DRN->series,
                'supplier_id'  => $request->supplier_id,
                'invoice_no'   => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'pojo'         => $request->pojo,
                'del_quantity' => $request->del_quantity,
                'office_id'    => $request->office_id,
                'division_id'  => $request->division_id
            ]);

            return $this->successResponse('Delivery details successfully added.');
        }
        catch(Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    // public function item(StoreDeliveryRequest $request): Response
    // {
    //     try {

    //         Delivery::create([
    //             'supplier_id'  => $request->supplier_id,
    //             'invoice_no'   => $request->invoice_no,
    //             'invoice_date' => $request->invoice_date,
    //             'pojo'         => $request->pojo,
    //             'del_quantity' => $request->del_quantity,
    //             'req_office'   => $request->req_office
    //         ]);

    //         return $this->successResponse('Delivery details successfully added.');
    //     }
    //     catch(Exception $e) {
    //         return $this->errorResponse('Processing Failed!', $e->getMessage());
    //     }
    // }

    public function edit($id, Request $request)
    {
        try {

            $delivery = Delivery::find($id);

            if($request->filled('supplier_id')) {
                $delivery->supplier_id = $request->supplier_id;
            }

            if($request->filled('invoice_no')) {
                $delivery->invoice_no = $request->invoice_no;
            }

            if($request->filled('invoice_date')) {
                $delivery->invoice_date = $request->invoice_date;
            }

            if($request->filled('pojo')) {
                $delivery->pojo = $request->pojo;
            }

            if($request->filled('del_quantity')) {
                $delivery->del_quantity = $request->del_quantity;
            }

            if($request->filled('office_id')) {
                $delivery->office_id = $request->office_id;
            }

            if($request->filled('division_id')) {
                $delivery->division_id = $request->division_id;
            }

            $delivery->push();

            return $this->successResponse('Delivery successfully updated.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $delivery = Delivery::find($id);

            // soft delete
            // $user->delete();

            // hard delete
            $delivery->forceDelete();

            return $this->successResponse('Delivery deleted.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }
}
