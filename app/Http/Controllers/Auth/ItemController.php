<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Item;
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
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ItemController extends Controller
{
    use ResponseTrait;

    private $canView;
    private $canEdit;
    private $canDelete;
    private $canPrint;

    public function __construct()
    {
        $this->canView   = Gate::allows('item', 'view');
        $this->canEdit   = Gate::allows('item', 'edit');
        $this->canDelete = Gate::allows('item', 'delete');
        $this->canPrint = Gate::allows('item', 'print');
    }

    public function index()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.items');
    }

    public function dt_items(Request $request)
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

        $item = Item::with('employee:id,fullname')
                // ->join('divisions', 'deliveries.req_office', '=', 'divisions.id')
                ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
                ->join('articles', 'items.article_id', '=', 'articles.id')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->where($filter);

        $filteredCount = $item->count();
        $filteredData  = $item->skip($start)
                            ->take($perPage)
                            ->orderBy('deliveries.ref_no', 'DESC', 'items.created_at', 'DESC')
                            ->get([
                                'items.*',
                                'items.id as item_id',
                                'articles.*',
                                'categories.*',
                                'deliveries.*',
                                // 'suppliers.supplier_name',
                                // 'suppliers.supplier_address',
                                // 'divisions.division_name',
                                // 'divisions.abbre'
                            ]);

        if($filteredCount > 0) {

            foreach ($filteredData as $key => $dt) {

                $action  = '';
                $buttons = '';

                if($this->canEdit || $this->canDelete) {

                    if($this->canEdit) {
                        $buttons .= '<div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3" data-action="edit-item" data-row="'. $key .'">
                                            Edit
                                        </a>
                                    </div>';
                    }

                    if($this->canPrint) {
                        $buttons .= '<div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3" data-action="print-item" data-row="'. $key .'">
                                            Print
                                        </a>
                                    </div>';
                        $buttons .= '<div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3" data-action="print-qr" data-row="'. $key .'">
                                            QR Code
                                        </a>
                                    </div>';
                    }

                    if($this->canDelete) {
                        $buttons .= '<div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3 text-danger" data-action="delete-item" data-row="'. $key .'">
                                            Delete
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

    public function store(StoreItemRequest $request): Response
    {
        try {

            $curYear    = date('Y');
            $curMonth   = date('m');
            $seriesCode = '';
            $accNo      = $curYear . '-' . $curMonth;
            $itemSN     = Item::select(DB::raw("LPAD(IFNULL(MAX(SUBSTRING_INDEX(property_no, '-', -1)), 0) + 1, 5, 0) series"))
                        // ->where('series_no', 'LIKE', '%' . $seriesCode . '%')
                          ->first();

            $propertyNo = $itemSN->series;

            $accountabilityType = null;
            $accountabilityNo = null;

            if ($request->purchase_price < 50000) {
                $accountabilityType = 'ICS';
                $accNo = $accountabilityType . '-' . $curYear . '-' . $curMonth;
                $accNo2 = $curYear . '-' . $curMonth;
                $ACN                = Item::select(DB::raw("LPAD(IFNULL(MAX(SUBSTRING_INDEX(accountability_no, '-', -1)), 0) + 1, 5, 0) series"))
                                      ->where('accountability_no', 'LIKE', '%' . $accNo . '%')
                                      ->first();

                $accountabilityNo = $accNo . '-' .  $ACN->series;
            }
            else {
                $accountabilityType = 'PAR';
                $accNo = $accountabilityType . '-' . $curYear . '-' . $curMonth;
                $accNo2 = $curYear . '-' . $curMonth;
                $ACN   = Item::select(DB::raw("LPAD(IFNULL(MAX(SUBSTRING_INDEX(accountability_no, '-', -1)), 0) + 1, 5, 0) series"))
                         ->where('accountability_no', 'LIKE', '%' . $accNo . '%')
                         ->first();

                $accountabilityNo = $accNo . '-' .  $ACN->series;
            }

            $userId = auth()->id();

            Item::create([
                'delivery_id' => $request->delivery_id,
                  // 'item_quantity'       => $request->item_quantity,
                'unit_of_measure'     => $request->unit_of_measure,
                'article_id'          => $request->article_id,
                'description'         => $request->description,
                'purchase_price'      => $request->purchase_price,
                'category_id'         => $request->category_id,
                'property_no'         => $propertyNo,
                'serial_no'           => $request->serial_no,
                'accountability_type' => $accountabilityType,
                'accountability_no'   => $accountabilityNo,
                'mr_to'               => $request->mr_to,
                'ass_to'              => $request->ass_to,
                'status'              => $request->status,
                'created_by'          => $userId
            ]);

            $delivery = Delivery::find($request->delivery_id);
                $delivery->item_count = $delivery->item_count + 1;

                $delivery->save();

            return $this->successResponse('Item successfully added.');
        }
        catch(Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function edit($id, Request $request)
    {
        try {

            $item = Item::find($id);

            if($request->filled('article_id')) {
                $item->article_id = $request->article_id;
            }

            if($request->filled('category_id')) {
                $item->category_id = $request->category_id;
            }

            // if($request->filled('item_quantity')) {
            //     $item->item_quantity = $request->item_quantity;
            // }

            if($request->filled('unit_of_measure')) {
                $item->unit_of_measure = $request->unit_of_measure;
            }

            if($request->filled('description')) {
                $item->description = $request->description;
            }

            if($request->filled('purchase_price')) {
                $item->purchase_price = $request->purchase_price;
            }

            if($request->filled('property_no')) {
                $item->property_no = $request->property_no;
            }

            $item->push();

            return $this->successResponse('Item successfully updated.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $item = Item::find($id);

            // soft delete
            // $user->delete();

            // hard delete
            $item->forceDelete();

            return $this->successResponse('Item deleted.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function print_items($id)
    {
        $item = Item::query()
                ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
                ->join('articles', 'items.article_id', '=', 'articles.id')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->join('users', 'items.created_by', '=', 'users.id')
                ->where('items.id', $id)
                ->first([
                    'items.accountability_type',
                    'items.accountability_no',
                    'items.item_quantity',
                    'items.unit_of_measure',
                    'items.description',
                    'items.property_no',
                    'items.purchase_price',
                    'items.mr_to',
                    'users.lastname',
                    'users.firstname',
                    'users.designate',
                    'deliveries.invoice_date',
                    'articles.*',
                    'categories.*'
                ]);

        if($item->mr_to) {
            $employees = DB::connection('mysql_hris')
                ->table('employees')
                ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
                // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
                ->leftJoin('plantilla_owners', function($join) {
                    $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                    $join->on('plantilla_owners.status', '=', DB::raw("1"));
                })
                ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
                ->where('employees.id', $item->mr_to)
                ->first([
                    'employees.fullname',
                    'plantillas.position'
                ]);
        } else {
            $employees = null;
        }

                    // dd($employees);

        $qrCode = QrCode::size(64)->generate($item->article_name);

        return view('printables.print-layout', compact('qrCode','item', 'employees'));
    }

    public function generateQrCode($id)
    {
        $item = Item::query()
                // ->join('divisions', 'deliveries.req_office', '=', 'divisions.id')
                ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
                ->join('articles', 'items.article_id', '=', 'articles.id')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->where('items.id', $id)
                ->first([
                    'items.*',
                    'articles.*',
                    'categories.*',
                    'deliveries.*'
                ]);

        $qrCode = QrCode::size(100)->generate($item->article_name);

        return view('qrcode', compact('qrCode'));
    }

    public function ptr_det($id)
    {
        $item = Item::query()
                // ->join('divisions', 'deliveries.req_office', '=', 'divisions.id')
                ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
                ->join('articles', 'items.article_id', '=', 'articles.id')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->where('items.id', $id)
                ->first([
                    'items.*',
                    'articles.*',
                    'categories.*',
                    'deliveries.*'
                ]);

        return response()->json(['data' => $item]);
    }

    public function getProperties(Request $request)
    {

        $searchVal = $request->get('search');
        $filter = [];

        // If there is a search value, filter the results
        if (!empty($searchVal)) {
            $filter[] = function($query) use ($searchVal) {
                $query->where('property_no', 'LIKE', "%" . $searchVal . "%");
            };
        }

        // Fetch the properties from the database with optional filtering
        $properties = Item::where($filter)
                        ->orderBy('property_no', 'ASC')
                        ->get(['property_no']);

        // Add additional data processing if needed, similar to the dt_items function

        return response()->json($properties);
    }

    public function get_employee(Request $request)
    {
        $divisionId = $request->query('n'); // Use 'query' to get query parameters

        $employees = DB::connection('mysql_hris')
                        ->table('employees')
                        ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
                        ->where('employee_jurisdictions.division_id', $divisionId)
                        ->where('employees.id', '!=', 1)
                        ->get(['employees.id', 'employees.fullname']); // Use correct column names

        return response()->json($employees);
    }



}
