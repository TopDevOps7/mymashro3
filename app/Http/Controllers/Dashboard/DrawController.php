<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Draws;

use Illuminate\Http\Request;

class DrawController extends Controller
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
        return view('dashboard/drawview.index');
    }

     public function add_edit()
    {
        return view('dashboard/drawview.add_edit');
    }
   
    public function post_data(Request $request){
         $editid = $request->id;
         $drawsname = $request->drawsname;
         $validation = Validator::make($request->all(), $this->rules_test($editid));
         if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
         }else{
               if ($editid != null) {
                  if($request->file == null){
                   $advertisement = Draws::where('id', $request->id)->first();
                   $advertisement->name=$drawsname;
                  
                   $advertisement->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_draws.index')]);
                  }else{
                   $imageName = time().'.'.$request->file->getClientOriginalExtension();
                   $fileName = time().'_'.$request->file->getClientOriginalName();
                   $filePath = $request->file->storeAs('upload/draws', $fileName, 'public');
                    $request->file->move(public_path('upload/draws'), $fileName);
                   $advertisement = Draws::where('id', $request->id)->first();
                   $advertisement->name=$drawsname;
                   $advertisement->file=$filePath;
                   $advertisement->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_draws.index')]);
                  }
                  
             }
           else{
                   $imageName = time().'.'.$request->file->getClientOriginalExtension();
                   $fileName = time().'_'.$request->file->getClientOriginalName();
                   $filePath = $request->file->storeAs('upload/draws', $fileName, 'public');
                     $request->file->move(public_path('upload/draws'), $fileName);
                   $priority = "1";
                   $status = 0;
                   $darw = new Draws();
                   $darw->name=$drawsname;
                   $darw->priority=$priority;
                   $darw->status=$status;
                   $darw->file=$filePath;
                   $darw->save();
                   return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_draws.index')]);
                }
         }
        
    }
      private function rules_test($editid = null)
    {

        if ($editid != null) {
            $x['id'] = 'required|integer|min:1';
        } else {
            $x = [
                'drawsname' => 'required|min:3|max:191',
                'file' => 'required|file|mimetypes:video/mp4'

            ];
       }
         return $x;
    }


    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'file',
            2 => 'name',
            3 => 'status',
            4 => 'priority',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $totalData = Draws::
        where(function ($q) use ($search) {
            if ($search) {
                $q->Where('name', 'LIKE', "%{$search}%");
            }
        })->count();
        $totalFiltered = $totalData;

        $posts = Draws::
        where(function ($q) use ($search) {
            if ($search) {
                $q->Where('name', 'LIKE', "%{$search}%");
            }
        })
            ->offset($start)
            ->limit($limit)
            ->orderBy('priority', 'ASC')
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
                $edit = route('dashboard_draws.add_edit', ['id' => $post->id]);
             
                $add = "<label>
                        <input type=\"checkbox\" data-id='$post->id' class=\"btn_select_btn_deleted\">
                    </label>";
                $ava = url(parent::PublicPa() . $post->file);
                $imagess = "<video width='100' height='100' controls loop> <source src='$ava' type='video/mp4'><source src='movie.ogg' type='video/ogg'></video>";
                $priority = "<div><input type='Number' data-id='$post->id' class='cls form-control' name='priority' id='priority' placeholder='priority Price' value='$post->priority'></div>";
                $nestedData['id'] = $add;
                $nestedData['file'] = $imagess;
                $nestedData['name'] = $post->name;
                $nestedData['discreption'] =  $post->discreption;
                $nestedData['status'] = $add1;
                $nestedData['priority'] =$priority;
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
        $project = Draws::where('id', '=', $id)->first();
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
        $project = Draws::where('id', '=', $id)->first();
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
    function get_data_by_iddata(Request $request)
     {
        $id = $request->id;
        $priority = $request->value;
        if( $priority > 10) $priority = 10;
        if( $priority < 1) $priority = 1;
        if( $priority == 0) $priority = 1;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $alldata =  Draws::all();
        foreach ($alldata as &$value) {
           if($value->priority == $priority ){
                $advertisement = Draws::where('id', '=', $value->id)->first();
                $advertisement1 = Draws::where('id', '=', $id)->first();
                $previouspriority = $advertisement->priority;
                $previouspriority1 = $advertisement1->priority;
                if($priority < 10 )  $advertisement->priority= $previouspriority1;
                $advertisement->update();
                if($priority < 10 ) $advertisement1->priority=$previouspriority;
                $advertisement1->update();
                if ($advertisement == null &&  $advertisement1 == null) {
                    return response()->json(['error' => 'Error Happen']);
                }
                return response()->json(['success' => $advertisement]);

           }
        }   
                $advertisement3 = Draws::where('id', '=',$id)->first();
                $advertisement3->priority=$priority;
                $advertisement3->update();
                if ($advertisement3 == null) {
                    return response()->json(['error' => 'Error Happen']);
                }
                return response()->json(['success' => $advertisement3]);

      
    }
   function deleted(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $rider = Draws::where('id', $id)->first();
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
            $Post = Draws::where('id', '=', $value)->first();
            if ($Post == null) {
                return response()->json(['error' => 'Error Happen']);
            }
            $Post->delete();
        }
        return response()->json(['success' => 'Delete Done']);
    }
}