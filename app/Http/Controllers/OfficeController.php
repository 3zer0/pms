<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Cluster;
use App\Models\ClusterAsecs;
use App\Models\ClusterUsec;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Gate;

class OfficeController extends Controller
{
    use ResponseTrait;

    private $canUpdate;

    public function __construct()
    {
        $this->canUpdate = Gate::allows('others', 'edit');
    }

    public function cluster()
    {
        $cluster = Cluster::with([ 'cluster_usec', 'cluster_usec.cluster_asec' ])->get();

        if(!is_null($cluster)) {
            foreach ($cluster as $key => $dt) {
                $editBtn = '';
                $addBtn  = '';

                if($this->canUpdate) {
                    $editBtn = '<button type="button" class="btn btn-light btn-icon h-20px w-20px ms-2" data-action="edit-usec" data-row="'. $key .'" title="Change Usec">
                                    <i class="ki-duotone ki-arrows-circle fs-7 fw-bold text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </button>';

                    $addBtn = '<button type="button" class="btn btn-light btn-icon h-25px w-25px" data-action="add-asec" data-row="'. $key .'" title="Add Asec">
                                    <i class="ki-duotone ki-plus fs-4 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </button>';

                    if(!is_null($dt->cluster_usec->cluster_asec)) {
                        foreach ($dt->cluster_usec->cluster_asec as $i => $asec) {
                            $dt->cluster_usec->cluster_asec[$i]['btn'] = '<button type="button" class="btn btn-light btn-icon h-20px w-20px ms-2" data-action="remove-asec" data-id="'. $asec->id .'" title="Remove Asec">
                            <i class="ki-duotone ki-cross fs-5 text-danger"><span class="path1"></span><span class="path2"></span></i>
                        </button>';
                        }
                    }
                }


                $cluster[$key]['edit'] = $editBtn;
                $cluster[$key]['add']  = $addBtn;
            }
        }

        return [ 'data' => $cluster ];
    }

    public function office_search(Request $request)
    {
        $clusterId = $request->get('n');

        return Office::where('cluster_id', $clusterId)->get([ 'id', 'office_name', 'abbre']);
    }

    public function division_search(Request $request)
    {
        $officeId = $request->get('n');

        return Division::where('office_id', $officeId)->get([ 'id', 'division_name', 'abbre']);
    }

    // public function edit_usec($id, Request $request)
    // {
    //     try {
    //         if(!$this->canUpdate) {
    //             throw new Exception('You are not authorized to edit cluster data.');
    //         }

    //         $office = ClusterUsec::find($id);
    //         $office->employee_id   = $request->employee_id;
    //         $office->usec_name = $request->name;
    //         $office->save();

    //         return $this->successResponse('Cluster undersecretary was successfully saved.');
    //     }
    //     catch(\Exception $e) {
    //         return $this->errorResponse('Processing Failed!', $e->getMessage());
    //     }
    // }

    // public function add_asec($id, Request $request)
    // {
    //     try {
    //         if(!$this->canUpdate) {
    //             throw new Exception('You are not authorized to edit cluster data.');
    //         }

    //         ClusterAsecs::create([
    //             'cluster_usec_id' => $id,
    //             'employee_id'     => $request->employee_id,
    //             'asec_name'       => $request->name
    //         ]);

    //         return $this->successResponse('Cluster assistant undersecretary was successfully saved.');
    //     }
    //     catch(\Exception $e) {
    //         return $this->errorResponse('Processing Failed!', $e->getMessage());
    //     }
    // }

    // public function remove_asec($id, Request $request)
    // {
    //     try {
    //         if(!$this->canUpdate) {
    //             throw new Exception('You are not authorized to edit cluster data.');
    //         }

    //         $asec = ClusterAsecs::find($request->asec_id);
    //         $asec->delete();

    //         return $this->successResponse('Cluster assistant undersecretary was successfully removed.');
    //     }
    //     catch(\Exception $e) {
    //         return $this->errorResponse('Processing Failed!', $e->getMessage());
    //     }
    // }

    // public function edit_office($id, Request $request)
    // {
    //     try {
    //         if(!$this->canUpdate) {
    //             throw new Exception('You are not authorized to edit office data.');
    //         }

    //         $office = Office::find($id);
    //         $office->employee_id   = $request->employee_id;
    //         $office->director_name = $request->name;
    //         $office->save();

    //         return $this->successResponse('Office was successfully saved.');
    //     }
    //     catch(\Exception $e) {
    //         return $this->errorResponse('Processing Failed!', $e->getMessage());
    //     }
    // }

    // public function edit_division($id, Request $request)
    // {
    //     try {
    //         if(!$this->canUpdate) {
    //             throw new Exception('You are not authorized to edit division data.');
    //         }

    //         $div = Division::find($id);
    //         $div->employee_id   = $request->employee_id;
    //         $div->division_head = $request->name;
    //         $div->save();

    //         return $this->successResponse('Division was successfully saved.');
    //     }
    //     catch(\Exception $e) {
    //         return $this->errorResponse('Processing Failed!', $e->getMessage());
    //     }
    // }
}
