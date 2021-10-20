<?php

namespace App\Http\Controllers\Dashboard;
use App\Category;
use App\Projects;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Discounts;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DiscountController extends Controller
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
        // $project = Projects::where("active", 1)->get();
        return view('dashboard/discounts.index');
    }

     public function add_edit()
    { 
        $project = DB::table('projects')->get();
        return view('dashboard/discounts.add_edit',compact('project'));
    }
    
    public function post_data(Request $request){
         $editid = $request->id;
         $projectid = $request->discountname;
         $project = Projects::where('id', '=', $projectid)->first();
         $discountname = $project->name;
         $picture = $project->picture;
         $originalprice = $request->originalprice;
         $discountprice = $request->discountprice;
         $progressval = $request->progressval;
         $validation = Validator::make($request->all(), $this->rules_test($editid));
         if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
         }else{
               if ($editid != null) {
                  if($request->file == null){

                   $discount = Discounts::where('id', $request->id)->first();
                   $discount->name=$discountname;
                   $discount->projectid=$projectid;
                   $discount->picture=$picture;
                   $discount->originalprice=$originalprice;
                   $discount->discountprice=$discountprice;
                   $discount->progressval=$progressval;
                 
                   $discount->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_discount.index')]);
                  }else{
                   $discount = Discounts::where('id', $request->id)->first();
                   $discount->name=$discountname;
                   $discount->projectid=$projectid;
                   $discount->picture=$picture;
                   $discount->originalprice=$originalprice;
                   $discount->discountprice=$discountprice;
                   $discount->progressval=$progressval;
                   $discount->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_discount.index')]);
                  }
                  
             }
           else{
                   $discount = new Discounts();
                   $discount->name=$discountname;
                   $discount->projectid=$projectid;
                   $discount->picture=$picture;
                   $discount->originalprice=$originalprice;
                   $discount->discountprice=$discountprice;
                   $discount->progressval=$progressval;
                
                   $discount->save();
                   return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_discount.index')]);
                }
         }
        
    }
      private function rules_test($editid = null)
    {

        if ($editid != null) {
            $x['id'] = 'required|integer|min:1';
        } else {
            $x = [
                'discountname' => 'required',
                'originalprice' => 'required|min:1|max:191',
                'discountprice' => 'required|min:1|max:191',
                'progressval' => 'required',
            ];
       }
         return $x;
    }
 

    function get_data(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'originalprice',
            3 => 'discountprice',
            4 => 'progressval',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $totalData = Discounts::
        where(function ($q) use ($search) {
            if ($search) {
                $q->Where('name', 'LIKE', "%{$search}%");
            }
        })->count();
        $totalFiltered = $totalData;

        $posts = Discounts::
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
            foreach ($posts as $post) {

                $edit = route('dashboard_discount.add_edit', ['id' => $post->id]);
             
                $add = "<label>
                        <input type=\"checkbox\" data-id='$post->id' class=\"btn_select_btn_deleted\">
                    </label>";
                $ava = url(parent::PublicPa() . $post->picture);
                $progressbar = "<div class='progress'><div class='progress-bar progress-bar-striped bg-warning' role='progressbar' style='width: {$post->progressval}%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div></div> <span id='pregressval1'>$post->progressval%</span>";
                $originprice = bcdiv($post->originalprice, 1, 2);
                $discountprice = bcdiv($post->discountprice, 1, 2);
                $nestedData['id'] = $add;
                $nestedData['name'] = $post->name;
                $nestedData['originalprice'] =$originprice;
                $nestedData['discountprice'] = $discountprice;
                $nestedData['progressval'] = $progressbar;
                $nestedData['options'] = "&emsp;<a class='btn btn-success btn-sm' href='{$edit}' title='تعديل' ><span class='color_wi fa fa-edit'></span></a>
                                         <a class='btn_delete_current btn btn-danger btn-sm' data-id='{$post->id}' title='حذف' ><span class='color_wi fa fa-trash'></span></a>";
                $data[] = $nestedData;

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
        $project = Discounts::where('id', '=', $id)->first();
        if ($project == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        return response()->json(['success' => $project]);
    }
    
   function deleted(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $rider = Discounts::where('id', $id)->first();
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
            $Post = Discounts::where('id', '=', $value)->first();
            if ($Post == null) {
                return response()->json(['error' => 'Error Happen']);
            }
            $Post->delete();
        }
        return response()->json(['success' => 'Delete Done']);
    }
}