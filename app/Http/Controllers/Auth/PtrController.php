<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Ptr;
use App\Models\Item;
use App\Models\Article;
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
use App\Http\Requests\StorePtrRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreDeliveryRequest;

class PtrController extends Controller
{
    use ResponseTrait;

    private $canView;
    private $canEdit;
    private $canDelete;
    private $canPrint;

    public function __construct()
    {
        $this->canView   = Gate::allows('ptr', 'view');
        $this->canEdit   = Gate::allows('ptr', 'edit');
        $this->canDelete = Gate::allows('ptr', 'delete');
        $this->canPrint = Gate::allows('ptr', 'print');
    }

    public function index()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.ptrs');
    }

    public function dt_ptr(Request $request)
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

        $ptr = Ptr::query()
                ->join('divisions', 'ptrs.division_id', '=', 'divisions.id')
                ->join('offices', 'ptrs.office_id', '=', 'offices.id')
                ->join('clusters', 'offices.cluster_id', '=', 'clusters.id')
                ->join('items', 'items.id', '=', 'ptrs.item_id')
                ->where($filter);

        $filteredCount = $ptr->count();
        $filteredData  = $ptr->skip($start)
                            ->take($perPage)
                            ->orderBy('ptrs.created_at', 'desc')
                            ->get([
                                'ptrs.*',
                                'offices.id',
                                'offices.office_name',
                                'divisions.office_id',
                                'divisions.division_name',
                                'divisions.abbre',
                                'items.accountability_type'
                            ]);

        if($filteredCount > 0) {

            foreach ($filteredData as $key => $dt) {

                $action  = '';
                $buttons = '';

                if($this->canEdit || $this->canDelete) {

                    if($this->canEdit) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3" data-action="edit-ptr" data-row="'. $key .'">
                                        Edit PTR
                                    </a>
                                </div>';
                    }

                    if($this->canPrint) {
                        $buttons .= '<div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3" data-action="print-rep" data-row="'. $key .'">
                                            Print
                                        </a>
                                    </div>';
                    }

                    if($this->canDelete) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3 text-danger" data-action="delete-ptr" data-row="'. $key .'">
                                        Delete PTR
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

    public function store(Request $request)
    {
        try {
            $PTR = Ptr::select(DB::raw("LPAD(IFNULL(MAX(SUBSTRING_INDEX(ref_no, '-', -1)), 0) + 1, 5, 0) series"))
                ->first();

            $savePr = [];
            $propertyNos = $request->input('property_no', []);
            $ppeConditions = $request->input('ppe_condition', []);

            // Prepare data for insertion
            foreach ($propertyNos as $index => $propertyNo) {
                $savePr[] = [
                    'item_id'       => $propertyNo,
                    'ref_no'        => date('Y') . '-' . date('m') . '-' . $PTR->series,
                    'transfer_type' => $request->transfer_type,
                    'rec_by'        => $request->rec_by,
                    'trans_reason'  => $request->trans_reason,
                    'office_id'     => $request->office_id,
                    'division_id'   => $request->division_id,
                    'ppe_condition' => $ppeConditions[$index] ?? null,
                    'created_at'    => now()
                ];
            }

            // Insert the data into Ptr table
            Ptr::insert($savePr);

            // Update the `ptr` field to 1 for the selected items
            Item::whereIn('id', $propertyNos)->update(['ptr' => 1]);

            return response()->json(['success' => true, 'message' => 'PTR successfully added.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Processing Failed!', 'errors' => $e->getMessage()]);
        }
    }

    public function edit($id, Request $request)
    {
        try {

            $article = Article::find($id);

            if($request->filled('article_name')) {
                $article->article_name = $request->article_name;
            }

            if($request->filled('useful_life')) {
                $article->useful_life = $request->useful_life;
            }

            $article->push();

            return $this->successResponse('Article successfully updated.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $ptr = Ptr::find($id);

            // soft delete
            // $user->delete();

            // hard delete
            $ptr->forceDelete();

            return $this->successResponse('PTR deleted.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function print_ptr($ref)
    {
        // Fetch the single transfer record (PTR)
        $trans = Ptr::query()
            ->join('items as e', 'ptrs.item_id', '=', 'e.id')
            ->join('divisions as b', 'ptrs.division_id', '=', 'b.id') // PTR division
            ->join('offices as f', 'ptrs.office_id', '=', 'f.id') // PTR office
            ->join('deliveries as c', 'e.delivery_id', '=', 'c.id')  // Delivery details
            ->join('divisions as d', 'c.division_id', '=', 'd.id')   // Delivery division
            ->join('offices as g', 'c.office_id', '=', 'g.id')   // Delivery office
            ->join('clusters as h', 'g.cluster_id', '=', 'h.id')
            ->join('cluster_asecs as i', 'g.cluster_asec_id', '=', 'i.id')
            ->join('cluster_usecs as j', 'g.cluster_id', '=', 'j.cluster_id')
            ->where('ptrs.ref_no', $ref)
            ->first([ // Fetch the transfer record
                'b.division_name as ptr_div',
                'f.abbre as ptr_off',
                'f.id as ptr_off_id',
                'd.division_name as del_div',
                'd.abbre as del_div_ab',
                'g.abbre as del_off',
                'g.id as del_off_id',
                'c.invoice_date',
                'g.director_name',
                'e.property_no',
                'e.accountability_type',
                'ptrs.transfer_type',
                'ptrs.trans_reason',
                'ptrs.rec_by',
                'd.division_head as del_head',
                'b.division_head as ptr_head',
                'i.asec_name',
                'j.usec_name'
            ]);

        // Fetch multiple associated items in the transfer
        $items = Item::query()
            ->join('ptrs', 'items.id', '=', 'ptrs.item_id')
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->where('ptrs.ref_no', $ref)
            ->get([ // Fetch multiple items associated with this transfer
                'deliveries.invoice_date',
                'items.property_no',
                'items.description',
                'items.purchase_price',
                'ptrs.ppe_condition'
            ]);

        $isMultipleItems = $items->count() > 1;

        $employees = DB::connection('mysql_hris')
            ->table('employees')
            ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
            // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
            ->leftJoin('plantilla_owners', function($join) {
                $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                $join->on('plantilla_owners.status', '=', DB::raw("1"));
            })
            ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
            ->where('employees.id', $trans->rec_by)
            ->first([
                'employees.fullname',
                'plantillas.position'
            ]);

        $validUsecDel   = [1,2,3,4,5,22,23,24,25,26,27];
        $validUsecTrans = [6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];

        if(in_array($trans->del_off_id, $validUsecDel) && in_array($trans->del_off_id, $validUsecTrans)){
            $appSig = Str::upper($trans->usec_name);
            // $relSig = Str::upper($trans->usec_name);
        }
        else {
            $appSig = Str::upper($trans->director_name);
            $appPos = 'Regional Director';
            $relSig = Str::upper($trans->del_head);
            $relPos = 'Chief,' . $trans->del_div_ab;
        }

        // Return the view with both the transfer record, associated items, and employee
        return view('printables.print-ptr', compact('trans', 'items', 'employees', 'appSig', 'relSig', 'appPos', 'relPos', 'isMultipleItems'));
    }

    public function print_itr($ref)
    {
        // Fetch the single transfer record (PTR)
        $trans = Ptr::query()
            ->join('items as e', 'ptrs.item_id', '=', 'e.id')
            ->join('divisions as b', 'ptrs.division_id', '=', 'b.id') // PTR division
            ->join('offices as f', 'ptrs.office_id', '=', 'f.id') // PTR office
            ->join('deliveries as c', 'e.delivery_id', '=', 'c.id')  // Delivery details
            ->join('divisions as d', 'c.division_id', '=', 'd.id')   // Delivery division
            ->join('offices as g', 'c.office_id', '=', 'g.id')   // Delivery office
            ->join('clusters as h', 'g.cluster_id', '=', 'h.id')
            ->join('cluster_asecs as i', 'g.cluster_asec_id', '=', 'i.id')
            ->join('cluster_usecs as j', 'g.cluster_id', '=', 'j.cluster_id')
            ->where('ptrs.ref_no', $ref)
            ->first([ // Fetch the transfer record
                'b.division_name as ptr_div',
                'f.abbre as ptr_off',
                'f.id as ptr_off_id',
                'd.division_name as del_div',
                'd.abbre as del_div_ab',
                'g.abbre as del_off',
                'g.id as del_off_id',
                'c.invoice_date',
                'g.director_name',
                'e.property_no',
                'e.accountability_type',
                'ptrs.transfer_type',
                'ptrs.trans_reason',
                'ptrs.rec_by',
                'd.division_head as del_head',
                'b.division_head as ptr_head',
                'i.asec_name',
                'j.usec_name'
            ]);

        // Fetch multiple associated items in the transfer
        $items = Item::query()
            ->join('ptrs', 'items.id', '=', 'ptrs.item_id')
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->where('ptrs.ref_no', $ref)
            ->get([ // Fetch multiple items associated with this transfer
                'deliveries.invoice_date',
                'items.property_no',
                'items.description',
                'items.purchase_price',
                'items.accountability_no',
                'ptrs.ppe_condition'
            ]);

        $isMultipleItems = $items->count() > 1;

        $employees = DB::connection('mysql_hris')
            ->table('employees')
            ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
            // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
            ->leftJoin('plantilla_owners', function($join) {
                $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                $join->on('plantilla_owners.status', '=', DB::raw("1"));
            })
            ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
            ->where('employees.id', $trans->rec_by)
            ->first([
                'employees.fullname',
                'plantillas.position'
            ]);

        $validUsecDel   = [1,2,3,4,5,22,23,24,25,26,27];
        $validUsecTrans = [6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];

        if(in_array($trans->del_off_id, $validUsecDel) && in_array($trans->del_off_id, $validUsecTrans)){
            $appSig = Str::upper($trans->usec_name);
            // $relSig = Str::upper($trans->usec_name);
        }
        else {
            $appSig = Str::upper($trans->director_name);
            $appPos = 'Regional Director';
            $relSig = Str::upper($trans->del_head);
            $relPos = 'Chief,' . $trans->del_div_ab;
        }

        // Return the view with both the transfer record, associated items, and employee
        return view('printables.print-itr', compact('trans', 'items', 'employees', 'appSig', 'relSig', 'appPos', 'relPos', 'isMultipleItems'));
    }


}
