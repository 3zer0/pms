<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSupplierRequest;

class SupplierController extends Controller
{
    use ResponseTrait;

    private $canView;
    private $canEdit;
    private $canDelete;

    public function __construct()
    {
        $this->canView   = Gate::allows('supplier', 'view');
        $this->canEdit   = Gate::allows('supplier', 'edit');
        $this->canDelete = Gate::allows('supplier', 'delete');
    }

    public function index()
    {
        // if(!$this->canView) {
        //     abort(401);
        // }

        return view('pages.suppliers');
    }

    public function dt_suppliers(Request $request)
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
                        $query->orWhere($col, 'LIKE', $searchVal . "%");
                    }
                } ];
            }
        }

        $supplier = Supplier::query()
                // ->join('suppliers', 'users.id', '=', 'suppliers.added_by')
                ->where($filter);

        $filteredCount = $supplier->count();
        $filteredData  = $supplier->skip($start)
                            ->take($perPage)
                            ->orderBy('suppliers.created_at', 'desc')
                            ->get([
                                // 'suppliers.supplier_name',
                                // 'suppliers.supplier_address',
                                // 'suppliers.supplier_mobile_no',
                                // 'suppliers.supplier_email',
                                // 'suppliers.supplier_tin'
                                'suppliers.*'
                            ]);

        if($filteredCount > 0) {

            foreach ($filteredData as $key => $dt) {

                $action  = '';
                $buttons = '';

                if($this->canEdit || $this->canDelete) {

                    if($this->canEdit) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3" data-action="edit-supplier" data-row="'. $key .'">
                                        Edit
                                    </a>
                                </div>';
                    }

                    if($this->canDelete) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3 text-danger" data-action="delete-supplier" data-row="'. $key .'">
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

    public function validate_suppliername(Request $request)
    {
        if(!$request->filled('supplier_name')) return [ 'valid' => true ];

        $supName = Supplier::where('supplier_name', $request->get('supplier_name'))->count();

        return [ 'valid' => $supName > 0 ? false : true ];
    }

    // public function validate_email(Request $request)
    // {
    //     if(!$request->filled('email')) return [ 'valid' => true ];

    //     $emp = Supplier::where('email', $request->get('email'));

    //     if($request->has('self')) {
    //         $emp->where('id', '!=', $request->get('self'));
    //     }

    //     $count = $emp->count();

    //     return [ 'valid' => $count > 0 ? false : true ];
    // }

    // public function validate_mobile_no(Request $request)
    // {
    //     if(!$request->filled('mobile_no')) return [ 'valid' => true ];

    //     $emp = Supplier::where('mobile_no', $request->get('mobile_no'));

    //     if($request->has('self')) {
    //         $emp->where('id', '!=', $request->get('self'));
    //     }

    //     $count = $emp->count();

    //     return [ 'valid' => $count > 0 ? false : true ];
    // }

    public function store(StoreSupplierRequest $request)
    {
        try {

            // Another option for field validation
            // $validator = Validator::make($request->only('username', 'password'), [
            //     'username' => ['required', 'string', 'min:5', 'max:15'],
            //     'password' => ['required', 'string', 'min:6'],
            // ], [], [
            //     'username' => 'Username',
            //     'password' => 'Password',
            // ]);

            // if($validator->fails()) {
            //     $this->validationError($validator);
            // }

            $supplier = Supplier::create([
                'supplier_name'      => $request->supplier_name,
                'supplier_address'   => $request->supplier_address,
                'supplier_mobile_no' => $request->supplier_mobile_no,
                'supplier_email'     => $request->supplier_email,
                'supplier_tin'       => $request->supplier_tin
            ]);

            return $this->successResponse('Supplier successfully added.');
        }
        catch(Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function edit($id, Request $request)
    {
        try {

            $supplier = Supplier::find($id);

            if($request->filled('supplier_name')) {
                $supplier->supplier_name = $request->supplier_name;
            }

            if($request->filled('supplier_address')) {
                $supplier->supplier_address = $request->supplier_address;
            }

            if($request->filled('supplier_mobile_no')) {
                $supplier->supplier_mobile_no = $request->supplier_mobile_no;
            }

            if($request->filled('supplier_email')) {
                $supplier->supplier_email = $request->supplier_email;
            }

            if($request->filled('supplier_tin')) {
                $supplier->supplier_tin = $request->supplier_tin;
            }

            $supplier->push();

            return $this->successResponse('Supplier details successfully updated.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $supplier = Supplier::find($id);

            // soft delete
            // $user->delete();

            // hard delete
            $supplier->forceDelete();

            return $this->successResponse('Supplier information successfully deleted.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }
}
