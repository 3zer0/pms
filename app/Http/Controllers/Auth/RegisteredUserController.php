<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserPrivilege;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Models\UserJurisdiction;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    use ResponseTrait;

    private $canView;
    private $canEdit;
    private $canDelete;

    public function __construct()
    {
        $this->canView   = Gate::allows('user', 'view');
        $this->canEdit   = Gate::allows('user', 'edit');
        $this->canDelete = Gate::allows('user', 'delete');
    }

    public function index()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.users');
    }

    public function dt_users(Request $request)
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

        $user = User::query()
                ->join('user_privileges', 'users.id', '=', 'user_privileges.user_id')
                ->join('user_jurisdictions', 'users.id', '=', 'user_jurisdictions.user_id')
                ->join('divisions', 'user_jurisdictions.division_id', '=', 'divisions.id')
                ->where($filter);

        $filteredCount = $user->count();
        $filteredData  = $user->skip($start)
                            ->take($perPage)
                            ->orderBy('users.lastname', 'asc')
                            ->get([
                                'users.*',
                                'user_privileges.user_view',
                                'user_privileges.user_add',
                                'user_privileges.user_edit',
                                'user_privileges.user_delete',
                                'user_privileges.supplier_view',
                                'user_privileges.supplier_add',
                                'user_privileges.supplier_edit',
                                'user_privileges.supplier_delete',
                                'user_jurisdictions.division_id',
                                'divisions.division_name'
                            ]);

        if($filteredCount > 0) {

            foreach ($filteredData as $key => $dt) {

                $action  = '';
                $buttons = '';

                if($this->canEdit || $this->canDelete) {

                    if($this->canEdit) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3" data-action="edit-user" data-row="'. $key .'">
                                        Edit
                                    </a>
                                </div>';
                    }

                    if($this->canDelete) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3 text-danger" data-action="delete-user" data-row="'. $key .'">
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

    public function validate_username(Request $request)
    {
        if(!$request->filled('username')) return [ 'valid' => true ];

        $emp = User::where('username', $request->get('username'))->count();

        return [ 'valid' => $emp > 0 ? false : true ];
    }

    public function validate_email(Request $request)
    {
        if(!$request->filled('email')) return [ 'valid' => true ];

        $emp = User::where('email', $request->get('email'));

        if($request->has('self')) {
            $emp->where('id', '!=', $request->get('self'));
        }

        $count = $emp->count();

        return [ 'valid' => $count > 0 ? false : true ];
    }

    public function validate_mobile_no(Request $request)
    {
        if(!$request->filled('mobile_no')) return [ 'valid' => true ];

        $emp = User::where('mobile_no', $request->get('mobile_no'));

        if($request->has('self')) {
            $emp->where('id', '!=', $request->get('self'));
        }

        $count = $emp->count();

        return [ 'valid' => $count > 0 ? false : true ];
    }

    public function store(StoreUserRequest $request): Response
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

            $user = User::create([
                'uniq_id'   => Str::random(32),
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'designate' => $request->designate,
                'email'     => $request->email,
                'mobile_no' => $request->mobile_no,
                'username'  => $request->username,
                'password'  => Hash::make($request->string('password')),
            ]);

            UserPrivilege::create([
                'user_id'         => $user->id,
                'user_view'       => (int) $request->user_view ?? 0,
                'user_add'        => (int) $request->user_add ?? 0,
                'user_edit'       => (int) $request->user_edit ?? 0,
                'user_delete'     => (int) $request->user_delete ?? 0,
                'supplier_view'   => (int) $request->supplier_view ?? 0,
                'supplier_add'    => (int) $request->supplier_add ?? 0,
                'supplier_edit'   => (int) $request->supplier_edit ?? 0,
                'supplier_delete' => (int) $request->supplier_delete ?? 0,
            ]);

            UserJurisdiction::create([
                'user_id'     => $user->id,
                'cluster_id'  => 5, // General Administration Cluster
                'office_id'   => 25, // Administrative Service Office
                'division_id' => $request->division_id
            ]);

            return $this->successResponse('User account was successfully created.');
        }
        catch(Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function edit($id, Request $request)
    {
        try {

            $user = User::find($id);

            if($request->filled('firstname')) {
                $user->firstname = $request->firstname;
            }

            if($request->filled('lastname')) {
                $user->lastname = $request->lastname;
            }

            if($request->filled('designate')) {
                $user->designate = $request->designate;
            }

            if($request->filled('email')) {
                $user->email = $request->email;
            }

            if($request->filled('mobile_no')) {
                $user->mobile_no = $request->mobile_no;
            }

            if($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Update privilege table
            if($request->filled('user_view')) {
                $user->privilege->user_view       = (int) $request->user_view;
                $user->privilege->user_add        = (int) $request->user_add;
                $user->privilege->user_edit       = (int) $request->user_edit;
                $user->privilege->user_delete     = (int) $request->user_delete;
                $user->privilege->supplier_view   = (int) $request->supplier_view;
                $user->privilege->supplier_add    = (int) $request->supplier_add;
                $user->privilege->supplier_edit   = (int) $request->supplier_edit;
                $user->privilege->supplier_delete = (int) $request->supplier_delete;
            }

            // Update jurisdiction table
            if($request->filled('division_id')) {
                $user->jurisdiction->division_id = $request->division_id;
            }

            $user->push();

            return $this->successResponse('User account was successfully updated.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $user = User::find($id);

            // soft delete
            // $user->delete();

            // hard delete
            $user->forceDelete();

            return $this->successResponse('User account was successfully deleted.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }
}
