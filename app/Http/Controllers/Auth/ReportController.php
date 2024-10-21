<?php

namespace App\Http\Controllers\Auth;

use pa;
use Exception;
use Carbon\Carbon;
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

class ReportController extends Controller
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

    public function ipa()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.rep_ipa');
    }

    public function pa()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.rep_pa');
    }

    public function pc()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.rep_pc');
    }

    public function ppe()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.rep_ppe');
    }

    public function sep()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.rep_sep');
    }

    public function dt_reports(Request $request)
    {
        $draw    = $request->get('draw');
        $start   = $request->get('start');
        $perPage = $request->get('length');
        $typePpe = $request->get('type');
        $typeSep = 'ICS';

        // Additional conditions
        $filter = [];

        // Search
        if ($request->has('searchCols')) {
            $searchCols = $request->get('searchCols');
            $searchVal  = $request->get('search');

            if (!empty($searchVal)) {
                $filter[] = [ function($query) use ($searchCols, $searchVal) {
                    foreach ($searchCols as $key => $col) {
                        $query->orWhere($col, 'LIKE', "%" . $searchVal . "%");
                    }
                } ];
            }
        }

        $type = $request->get('type');

        $items = Item::with('employee:id,fullname')
        ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
        ->join('articles', 'items.article_id', '=', 'articles.id')
        ->join('categories', 'items.category_id', '=', 'categories.id')
        ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
        // ->leftJoin(DB::connection('mysql_hris')->getDatabaseName() . '.employees', 'items.mr_to', '=', 'employees.id')
        ->select([
            'items.*',
            'deliveries.*',
            'articles.*',
            'categories.*',
            'divisions.abbre as divab',
            'items.mr_to' // Include mr_to to fetch related employees later
        ]);

        if (!empty($type)) {
            $items->where('categories.type', $type);  // Assuming the type field exists in the categories table
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $items->where('items.category_id', $request->category);
        }

        // Filter by type
        // if ($request->has('category') && !empty($request->category)) {
        //     $items->where('items.type', 'PAR');
        // }

        // Filter by naame
        if ($request->has('mr_to') && !empty($request->mr_to)) {
            $items->where('items.mr_to', $request->mr_to);
        }

        // Filter by date range
        if ($request->has('date_range') && !empty($request->date_range)) {
            // Parse the date range
            $dates = explode(' - ', $request->date_range);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();

            // Apply the date range filter
            $items->whereBetween('items.created_at', [$startDate, $endDate]);
        }

        // Apply additional filters
        $items->where($filter);

        // Get the count of filtered records
        $filteredCount = $items->count();

        // Get the paginated filtered data
        $filteredData = $items->skip($start)
                            ->take($perPage)
                            ->orderBy('deliveries.ref_no', 'DESC')
                            ->orderBy('items.created_at', 'DESC')
                            ->get([
                                'items.*',
                                'items.id as item_id',
                                'articles.*',
                                'categories.*',
                                'deliveries.*',
                                'employees.fullname'
                            ]);

        foreach ($filteredData as $item) {
            $employee = DB::connection('mysql_hris')
                ->table('employees')
                // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
                ->leftJoin('plantilla_owners', function($join) {
                    $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                    $join->on('plantilla_owners.status', '=', DB::raw("1"));
                })
                ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
                ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
                ->join('divisions', 'employee_jurisdictions.division_id', '=', 'divisions.id')


                ->where('employees.id', $item->mr_to) // Fetch employee based on mr_to
                ->first([
                    'employees.id',
                    'employees.fullname',
                    'plantillas.position',
                    'divisions.abbre',
                    'divisions.division_head'
                ]);

            // Attach the employee data to the item
            $item->employee = $employee;
        }

        return [
            'draw'                 => $draw,
            'iTotalRecords'        => $filteredCount,
            'iTotalDisplayRecords' => $filteredCount,
            'data'                 => $filteredData,
            'typePpe'              => $typePpe,
            'typeSep'              => $typeSep
        ];
    }

    public function print_report_ipa(Request $request)
    {
        // Get the query parameters
        $cat = $request->get('category_id');
        $dateRange = $request->get('date_range');

        // Parse date range if available
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Build the base query for items
        $baseQuery = Item::query()
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->join('articles', 'items.article_id', '=', 'articles.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('users', 'items.created_by', '=', 'users.id')
            ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
            ->select([
                'items.*',
                'users.lastname',
                'users.firstname',
                'users.designate',
                'deliveries.invoice_date',
                'articles.*',
                'categories.*',
                'divisions.abbre as divab',
                'divisions.division_head'
            ]);

        // Filter by mr_to if provided
        if ($cat) {
            $baseQuery->where('items.category_id', $cat);
        }

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $baseQuery->whereBetween('items.created_at', [$startDate, $endDate]);
        }

        // Determine if we should fetch a single item or multiple items
        $items = $baseQuery->get(); // Get all matching records

        // Determine if we expect a single item or multiple items
        $isMultipleItems = $items->count() > 1;

        // If expecting a single item, get the first item from the collection
        $item = $isMultipleItems ? null : $items->first();

        // Sum the item quantities
        $totalQuantity = $baseQuery->sum('item_quantity'); // Sum of filtered item quantities

        // Sum the item amount
        $totalAmount = $baseQuery->sum('purchase_price'); // Sum of filtered item quantities

        // Fetch employee details based on mr_to if applicable
        $employees = null; // Initialize as null
        if ('items.mr_to') {
            $employees = DB::connection('mysql_hris')
                ->table('employees')
                ->leftJoin('plantilla_owners', function($join) {
                    $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                    $join->on('plantilla_owners.status', '=', DB::raw("1"));
                })
                ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
                ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
                ->join('divisions', 'employee_jurisdictions.division_id', '=', 'divisions.id')
                ->where('employees.id', 'items.mr_to') // Fetch employee based on the provided mr_to
                ->first(['employees.id', 'employees.fullname', 'plantillas.position', 'divisions.abbre', 'division_head']);
        }

        // Pass data to the view
        return view('printables.print-rep-ipa', compact('item', 'items', 'employees', 'isMultipleItems','totalQuantity', 'totalAmount', 'endDate'));
    }

    public function checkItemsIpa(Request $request)
    {
        $cat = $request->get('category_id');
        $dateRange = $request->get('date_range');

        // Parse the date range
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Query to check for matching items
        $items = Item::query()
            ->where('category_id', $cat)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count(); // Count the matching items

        // Return a JSON response indicating whether items are available
        return response()->json([
            'hasItems' => $items > 0
        ]);
    }

    public function print_report_pa(Request $request)
    {
        // Get the query parameters
        $mrTo = $request->get('mr_to');
        $dateRange = $request->get('date_range');

        // Parse date range if available
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Build the base query for items
        $baseQuery = Item::query()
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->join('articles', 'items.article_id', '=', 'articles.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('users', 'items.created_by', '=', 'users.id')
            ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
            ->select([
                'items.*',
                'users.lastname',
                'users.firstname',
                'users.designate',
                'deliveries.invoice_date',
                'articles.*',
                'categories.*',
                'divisions.abbre as divab',
                'divisions.division_head'
            ]);

        // Filter by mr_to if provided
        if ($mrTo) {
            $baseQuery->where('items.mr_to', $mrTo);
        }

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $baseQuery->whereBetween('items.created_at', [$startDate, $endDate]);
        }

        // Determine if we should fetch a single item or multiple items
        $items = $baseQuery->get(); // Get all matching records

        // Determine if we expect a single item or multiple items
        $isMultipleItems = $items->count() > 1;

        // If expecting a single item, get the first item from the collection
        $item = $isMultipleItems ? null : $items->first();

        // Sum the item quantities
        $totalQuantity = $baseQuery->sum('item_quantity'); // Sum of filtered item quantities

        // Fetch employee details based on mr_to if applicable
        $employees = null; // Initialize as null
        if ($mrTo) {
            $employees = DB::connection('mysql_hris')
                ->table('employees')
                // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
                ->leftJoin('plantilla_owners', function($join) {
                    $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                    $join->on('plantilla_owners.status', '=', DB::raw("1"));
                })
                ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
                ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
                ->join('divisions', 'employee_jurisdictions.division_id', '=', 'divisions.id')
                ->where('employees.id', $mrTo) // Fetch employee based on the provided mr_to
                ->first(['employees.id', 'employees.fullname', 'plantillas.position', 'divisions.abbre', 'division_head']);
        }

        // Pass data to the view
        return view('printables.print-rep-pa', compact('item', 'items', 'employees', 'isMultipleItems','totalQuantity', 'endDate'));
    }

    public function checkItemsPa(Request $request)
    {
        $mrTo = $request->get('mr_to');
        $dateRange = $request->get('date_range');

        // Parse the date range
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Query to check for matching items
        $items = Item::query()
            ->where('mr_to', $mrTo)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count(); // Count the matching items

        // Return a JSON response indicating whether items are available
        return response()->json([
            'hasItems' => $items > 0
        ]);
    }

    public function print_report_pc(Request $request)
    {
        // Get the query parameters
        $cat = $request->get('category_id');
        $dateRange = $request->get('date_range');

        // Parse date range if available
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Build the base query for items
        $baseQuery = Item::query()
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->join('articles', 'items.article_id', '=', 'articles.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('users', 'items.created_by', '=', 'users.id')
            ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
            ->select([
                'items.*',
                'users.lastname',
                'users.firstname',
                'users.designate',
                'deliveries.invoice_date',
                'articles.*',
                'categories.*',
                'divisions.abbre as divab',
                'divisions.division_head'
            ]);

        // Filter by mr_to if provided
        if ($cat) {
            $baseQuery->where('items.category_id', $cat);
        }

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $baseQuery->whereBetween('items.created_at', [$startDate, $endDate]);
        }

        // Determine if we should fetch a single item or multiple items
        $items = $baseQuery->get(); // Get all matching records

        // Determine if we expect a single item or multiple items
        $isMultipleItems = $items->count() > 1;

        // If expecting a single item, get the first item from the collection
        $item = $isMultipleItems ? null : $items->first();

        // Sum the item quantities
        $totalQuantity = $baseQuery->sum('item_quantity'); // Sum of filtered item quantities

        // Sum the item amount
        $totalAmount = $baseQuery->sum('purchase_price'); // Sum of filtered item quantities

        // Fetch employee details based on mr_to if applicable
        $employees = null; // Initialize as null
        if ('items.mr_to') {
            $employees = DB::connection('mysql_hris')
                ->table('employees')
                ->leftJoin('plantilla_owners', function($join) {
                    $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                    $join->on('plantilla_owners.status', '=', DB::raw("1"));
                })
                ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
                ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
                ->join('divisions', 'employee_jurisdictions.division_id', '=', 'divisions.id')
                ->where('employees.id', 'items.mr_to') // Fetch employee based on the provided mr_to
                ->first(['employees.id', 'employees.fullname', 'plantillas.position', 'divisions.abbre', 'division_head']);
        }

        // Pass data to the view
        return view('printables.print-rep-pc', compact('item', 'items', 'employees', 'isMultipleItems','totalQuantity', 'totalAmount', 'endDate'));
    }

    public function checkItemsPc(Request $request)
    {
        $cat = $request->get('category_id');
        $dateRange = $request->get('date_range');

        // Parse the date range
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Query to check for matching items
        $items = Item::query()
            ->where('category_id', $cat)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count(); // Count the matching items

        // Return a JSON response indicating whether items are available
        return response()->json([
            'hasItems' => $items > 0
        ]);
    }

    public function print_report_ppe(Request $request)
    {
        // Get the query parameters
        $mrTo = $request->get('mr_to');
        $dateRange = $request->get('date_range');
        $categoryId = $request->get('category_id');  // Add category filter

        $userId = Auth::user();
        $userId->jurisdiction->division;
        $userId->jurisdiction->office;

        // Parse date range if available
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Build the base query for items
        $baseQuery = Item::query()
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->join('articles', 'items.article_id', '=', 'articles.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('users', 'items.created_by', '=', 'users.id')
            ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
            ->leftJoin(DB::connection('mysql_hris')->getDatabaseName() . '.employees', 'items.mr_to', '=', 'employees.id')
            ->select([
                'items.*',
                'users.lastname',
                'users.firstname',
                'users.designate',
                'deliveries.invoice_date',
                'articles.*',
                'categories.*',
                'divisions.abbre as divab',
                'divisions.division_head',
                'employees.fullname'
            ]);

        // Filter by mr_to if provided
        if ($mrTo) {
            $baseQuery->where('items.mr_to', $mrTo);
        }

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $baseQuery->whereBetween('items.created_at', [$startDate, $endDate]);
        }

        // Filter by category_id if provided
        if ($categoryId) {
            $baseQuery->where('items.category_id', $categoryId);
        }

        // Fetch the items
        $items = $baseQuery->get(); // Get all matching records

        // Determine if we expect a single item or multiple items
        $isMultipleItems = $items->count() > 1;

        // If expecting a single item, get the first item from the collection
        $item = $isMultipleItems ? null : $items->first();

        // Sum the item quantities
        $totalQuantity = $baseQuery->sum('item_quantity'); // Sum of filtered item quantities

        // Sum the item amount
        $totalAmount = $baseQuery->sum('purchase_price'); // Sum of filtered item quantities

        // Fetch employee details based on mr_to if applicable
        $employees = DB::connection('mysql_hris')
            ->table('employees')
            // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
            ->leftJoin('plantilla_owners', function($join) {
                $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                $join->on('plantilla_owners.status', '=', DB::raw("1"));
            })
            ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
            ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
            ->join('divisions', 'employee_jurisdictions.division_id', '=', 'divisions.id')
            ->where('employees.id', auth()->id()) // Fetch employee based on the provided mr_to
            ->first(['employees.id', 'employees.fullname', 'plantillas.position', 'divisions.division_name', 'divisions.abbre', 'division_head']);

        // Pass data to the view
        return view('printables.print-rep-ppe', compact('item', 'items', 'employees', 'isMultipleItems','totalQuantity', 'totalAmount', 'endDate', 'userId'));
    }

    public function checkItemsPpe(Request $request)
    {
        $cat = $request->get('category_id');
        $dateRange = $request->get('date_range');

        // Parse the date range
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Query to check for matching items
        $items = Item::query()
            ->where('category_id', $cat)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count(); // Count the matching items

        // Return a JSON response indicating whether items are available
        return response()->json([
            'hasItems' => $items > 0
        ]);
    }

    public function print_report_sep(Request $request)
    {
        // Get the query parameters
        $mrTo = $request->get('mr_to');
        $dateRange = $request->get('date_range');
        $categoryId = $request->get('category_id');

        $userId = Auth::user();
        // $divId = $userId->jurisdiction->office->id;
        $userId->jurisdiction->division;
        $userId->jurisdiction->office;
        // return $userId;

        // Parse date range if available
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Build the base query for items
        $baseQuery = Item::with('employee:id,fullname')
            ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
            ->join('articles', 'items.article_id', '=', 'articles.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('users', 'items.created_by', '=', 'users.id')
            ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
            // ->join(DB::connection('mysql_hris')->getDatabaseName() . '.employees', 'items.mr_to', '=', 'employees.id')
            ->select([
                'items.*',
                'users.lastname',
                'users.firstname',
                'users.designate',
                'deliveries.invoice_date',
                'articles.*',
                'categories.*',
                'divisions.abbre as divab',
                'divisions.division_head',
                // 'employees.fullname'
            ]);

        // Filter by mr_to if provided
        if ($mrTo) {
            $baseQuery->where('items.mr_to', $mrTo);
        }

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $baseQuery->whereBetween('items.created_at', [$startDate, $endDate]);
        }

        // Filter by category_id if provided
        if ($categoryId) {
            $baseQuery->where('items.category_id', $categoryId);
        }

        // Determine if we should fetch a single item or multiple items
        $items = $baseQuery->get(); // Get all matching records

        // Determine if we expect a single item or multiple items
        $isMultipleItems = $items->count() > 1;

        // If expecting a single item, get the first item from the collection
        $item = $isMultipleItems ? null : $items->first();

        // Sum the item quantities
        $totalQuantity = $baseQuery->sum('item_quantity'); // Sum of filtered item quantities

        // Sum the item amount
        $totalAmount = $baseQuery->sum('purchase_price'); // Sum of filtered item quantities

        // Fetch employee details based on mr_to if applicable
        $employees = null; // Initialize as null
        $employees = DB::connection('mysql_hris')
            ->table('employees')
            // ->join('plantilla_owners', 'employees.id', '=', 'plantilla_owners.employee_id')
            ->leftJoin('plantilla_owners', function($join) {
                $join->on('employees.id', '=', 'plantilla_owners.employee_id');
                $join->on('plantilla_owners.status', '=', DB::raw("1"));
            })
            ->join('plantillas', 'plantilla_owners.plantilla_id', '=', 'plantillas.id')
            ->join('employee_jurisdictions', 'employees.id', '=', 'employee_jurisdictions.employee_id')
            ->join('divisions', 'employee_jurisdictions.division_id', '=', 'divisions.id')
            ->where('employees.id', auth()->id()) // Fetch employee based on the provided mr_to
            ->first(['employees.id', 'employees.fullname', 'plantillas.position', 'divisions.division_name', 'divisions.abbre', 'division_head']);

        // Pass data to the view
        return view('printables.print-rep-sep', compact('item', 'items', 'employees', 'isMultipleItems','totalQuantity', 'totalAmount', 'endDate', 'userId'));
    }

    public function checkItemsSep(Request $request)
    {
        $cat = $request->get('category_id');
        $dateRange = $request->get('date_range');

        // Parse the date range
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $startDate = null;
            $endDate = null;
        }

        // Query to check for matching items
        $items = Item::query()
            ->where('category_id', $cat)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count(); // Count the matching items

        // Return a JSON response indicating whether items are available
        return response()->json([
            'hasItems' => $items > 0
        ]);
    }


}
