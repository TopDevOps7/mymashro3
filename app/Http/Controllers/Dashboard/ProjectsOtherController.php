<?php

namespace App\Http\Controllers\Dashboard;
use App\Category;
use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Projects;

use Illuminate\Http\Request;

class ProjectsOtherController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

     public function index()
    {
        return view('dashboard/projectsother.index');
    }

     public function add_edit()
    {
        return view('dashboard/projectsother.add_edit');
    }
    
    public function post_data(Request $request){
         $editid = $request->id;
         $projectname = $request->projectname;
         $numberofticket = $request->numberofticket;
         $priceofticker = $request->priceofticker;
        //  $progressval = $request->progressval;
        //  $available = $request->available;
        //  $sold = $request->sold;
        //  $status = $request->status;
         $validation = Validator::make($request->all(), $this->rules_test($editid));
         if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
         }else{
               if ($editid != null) {
                  if($request->file == null){
                   $project = Projects::where('id', $request->id)->first();
                   $project->name=$projectname;
                   $project->numberofticket=$numberofticket;
                   $project->priceofticker=$priceofticker;
                   $sold = $project->sold;
                   $project->available=$numberofticket - $sold;
                   $available = $project->available;
                   $progressval =($available/$numberofticket)*100;;
                   $project->progressval=$progressval;
                  
                   $project->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_otherprojects.index')]);
                  }else{
                   $imageName = time().'.'.$request->file->getClientOriginalExtension();
                   $fileName = time().'_'.$request->file->getClientOriginalName();
                   $filePath = $request->file->storeAs('upload/projects', $fileName, 'public');
                   $request->file->move(public_path('upload/projects'), $fileName);
                   $project = Projects::where('id', $request->id)->first();
                   $project->name=$projectname;
                   $project->numberofticket=$numberofticket;
                   $sold = $project->sold;
                   $project->available=$numberofticket - $sold;
                   $available = $project->available;
                   $project->priceofticker=$priceofticker;
                   $progressval =($available/$numberofticket)*100;;
                   $project->progressval=$progressval;
                   $project->picture=$filePath;
                   $project->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_otherprojects.index')]);
                  }
                  
             }
           else{
                   $imageName = time().'.'.$request->file->getClientOriginalExtension();
                   $fileName = time().'_'.$request->file->getClientOriginalName();
                   $filePath = $request->file->storeAs('upload/projects', $fileName, 'public');
                     $request->file->move(public_path('upload/projects'), $fileName);
                   $status = 0;
                   $topproject ="0";
                   $available = $numberofticket;
                   $sold = 0;
                   if($numberofticket == 0){
                       $progressval =0;
                   }  else{
                       $progressval =($available/$numberofticket)*100;
                   }
                   $project = new Projects();
                   $project->name=$projectname;
                   $project->numberofticket=$numberofticket;
                   $project->priceofticker=$priceofticker;
                   $project->progressval=$progressval;
                   $project->available=$available;
                   $project->sold=$sold;
                   $project->status=$status;
                   $project->picture=$filePath;
                   $project->topproject=$topproject;
                   $project->save();
                   return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_otherprojects.index')]);
                }
         }
        
    }
      private function rules_test($editid = null)
    {

        if ($editid != null) {
            $x['id'] = 'required|integer|min:1';
        } else {
            $x = [
                'projectname' => 'required|min:3|max:191',
                'numberofticket' => 'required|min:1|max:191',
                'priceofticker' => 'required|min:1|max:191',
                'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            ];
       }
         return $x;
    }
    
   
    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'picture',
            2 => 'name',
            3 => 'priceofticker',
            4 => 'numberofticket',
            5 => 'available',
            6 => 'sold',
            7 => 'status',
            8 => 'progressval',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $totalData = Projects::
        where(function ($q) use ($search) {
            if ($search) {
                $q->Where('name', 'LIKE', "%{$search}%");
            }
        })->count();
        $totalFiltered = $totalData;

        $posts = Projects::
        where(function ($q) use ($search) {
            if ($search) {
                $q->Where('name', 'LIKE', "%{$search}%");
            }
        })
            ->offset($start)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($posts)) {
            $active_count = 1;
            foreach ($posts as $post) {
                $check1 = 1;
                $active_or_no1 = 'Disable';
                if ($post->status == 1) {
                    $check1 = 'checked';
                    $active_or_no1 = 'Enable';
                }
                $add1= '<div class="material-switch pull-left">
                            <input data-id="'. $post->id .'" id="active_'.$active_count.'" class="btn_confirm_email_current" type="checkbox" '.$check1.'/>
                            <label for="active_'.$active_count.'" class="label-success"></label>
                        </div>';
                $edit = route('dashboard_otherprojects.add_edit', ['id' => $post->id]);
             
                $add = "<label>
                        <input type=\"checkbox\" data-id='$post->id' class=\"btn_select_btn_deleted\">
                    </label>";
                $ava = url(parent::PublicPa() . $post->picture);
                $stastusdiv ="";
                $imagess = "<img style='width: 50px;height: 50px;' src='{$ava}' class='img-circle img_data_tables'>";
                
                // if($post->status == "on")  $stastusdiv = "<div class='card-body' style='margin-top:-35px'><div class='row'><div class='col-md-4 x-check-active'><div class='material-switch pull-left' style='transform: translateY(16px);'><input value='true' type='checkbox' checked/><label for='someSwitchOptionSuccess3' class='label-success'></label></div></div></div></div>";   
                // if($post->status == "off") $stastusdiv = "<div class='card-body' style='margin-top:-35px'><div class='row'><div class='col-md-4 x-check-active'><div class='material-switch pull-left' style='transform: translateY(16px);'><input value='true' type='checkbox' /><label for='someSwitchOptionSuccess3' class='label-success'></label></div></div></div></div>";
                $progressbar = "<div class='progress'><div class='progress-bar progress-bar-striped bg-warning' role='progressbar' style='width: {$post->progressval}%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>
                </div></div> <span id='pregressval1'>$post->progressval%</span>";
                $price = bcdiv($post->priceofticker, 1, 2);
                $nestedData['id'] = $add;
                $nestedData['picture'] = $imagess;
                $nestedData['name'] = $post->name;
                $nestedData['priceofticker'] = $price;
                $nestedData['numberofticket'] = $post->numberofticket;
                $nestedData['available'] = $post->available;
                $nestedData['sold'] = $post->sold;
                $nestedData['status'] = $add1;
                $nestedData['progressval'] = $progressbar;
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='تعديل' ><span class='color_wi fa fa-edit'></span></a>
                                         <a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='حذف' ><span class='color_wi fa fa-trash'></span></a>";
                $data[] = $nestedData;
                $active_count += 1;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    function get_data_by_id(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $project = Projects::where('id', '=', $id)->first();
        if ($project == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        return response()->json(['success' => $project]);
    }
    function get_data_by_iddata(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $project = Projects::where('id', '=', $id)->first();
        if ($project == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        return response()->json(['success' => $project]);
    }


   function confirm_email(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $project = Projects::where('id', '=', $id)->first();
        if ($project == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($project->id == parent::CurrentID()) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($project->status == 1) {
            $project->status = 0;
            $project->update();
            
            return response()->json(['error' => __('Disactive is success')]);
        } else {
            $project->status = 1;
            $project->update();
            
            return response()->json(['success' => __('Active is success')]);
        }
    }

   function deleted(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $rider = Projects::where('id', $id)->first();
        if ($rider == null) {
            return response()->json(['error' => 'Error Happen']);
        }

        $rider->delete();
        return response()->json(['error' => 'Delete Done']);
    }

      function deleted_all(Request $request)
    {
        $array = $request->array;
        if ($array == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        if (count($array) == 0) {
            return response()->json(['error' => 'Error Happen']);
        }
        foreach ($array as $key => $value){
            $Post = Projects::where('id', '=', $value)->first();
            if ($Post == null) {
                return response()->json(['error' => 'Error Happen']);
            }
            $Post->delete();
        }
        return response()->json(['success' => 'Delete Done']);
    }
}