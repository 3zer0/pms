<?php

namespace App\Http\Controllers\Auth;

use Exception;
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
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreDeliveryRequest;

class ArticleController extends Controller
{
    use ResponseTrait;

    private $canView;
    private $canEdit;
    private $canDelete;

    public function __construct()
    {
        $this->canView   = Gate::allows('article', 'view');
        $this->canEdit   = Gate::allows('article', 'edit');
        $this->canDelete = Gate::allows('article', 'delete');
    }

    public function index()
    {
        if(!$this->canView) {
            abort(401);
        }

        return view('pages.articles');
    }

    public function dt_articles(Request $request)
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

        $article = Article::query()
                // ->join('divisions', 'deliveries.division_id', '=', 'divisions.id')
                ->where($filter);

        $filteredCount = $article->count();
        $filteredData  = $article->skip($start)
                            ->take($perPage)
                            ->orderBy('articles.article_name', 'asc')
                            ->get([
                                'articles.*'
                            ]);

        if($filteredCount > 0) {

            foreach ($filteredData as $key => $dt) {

                $action  = '';
                $buttons = '';

                if($this->canEdit || $this->canDelete) {

                    if($this->canEdit) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3" data-action="edit-article" data-row="'. $key .'">
                                        Edit Article
                                    </a>
                                </div>';
                    }

                    if($this->canDelete) {
                        $buttons .= '<div class="menu-item px-3">
                                    <a href="javascript:void(0);" class="menu-link px-3 text-danger" data-action="delete-article" data-row="'. $key .'">
                                        Delete Article
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

    public function store(StoreArticleRequest $request): Response
    {
        try {
            Article::create([
                'article_name' => $request->article_name,
                'useful_life'  => $request->useful_life
            ]);

            return $this->successResponse('Article details successfully added.');
        }
        catch(Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
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
            $article = Article::find($id);

            // soft delete
            // $user->delete();

            // hard delete
            $article->forceDelete();

            return $this->successResponse('Article deleted.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }
}
