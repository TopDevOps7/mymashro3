<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use App\Imports\InvoicesExport;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\Projects;
use Maatwebsite\Excel\Facades\Excel;

class ProjectsController extends Controller
{
    public function index()
    {

        return view('dashboard/projects.index');
    }

    public function export(Request $request)
    {
        $body = Order::select("id", "client_name", "phone", "total", "status", "created_at", "updated_at");

        if ($request->from && $request->to) {

            $from_d = parent::date_get($request->from, 2) . '-' . parent::date_get($request->from, 0) . '-' . parent::date_get($request->from, 1);
            $to_d = parent::date_get($request->to, 2) . '-' . parent::date_get($request->to, 0) . '-' . parent::date_get($request->to, 1);

            $from = date($from_d);
            $to = date($to_d);

            $body = $body->whereBetween('created_at', [$from, $to]);
        }
        $city_ids = City::where("active", 1)->pluck('id');
        $restaurants = Restaurant::whereIn('restaurant_city', $city_ids)->pluck('id');
        $body = $body->whereIn('restaurant_id', $restaurants)->get();
        $headers_collc = [
            'order_id',
            'Name',
            'Phone',
            'Total',
            'Status',
            'Created Date',
            'Updated Date',
        ];
        $export = new InvoicesExport([
            $headers_collc,
            $body
        ]);
        return Excel::download($export, 'export' . time() . '.xlsx');
    }


    public function add_edit()
    {
        return view('dashboard/projects.add_edit');
    }

    public function view_project($id = null)
    {
        $item = Order::where('id', '=', $id)->first();
        if ($item == null) {
            return redirect()->route('dashboard_projects.index');
        }
        return view('dashboard/projects.view_project', compact('item'));
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
        $orThose = ['topproject'=> '1'];

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
            ->orWhere($orThose)
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
    function topget_data(Request $request)
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
        $orThose = ['topproject'=> '0'];

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
            ->orWhere($orThose)
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
                $nestedData['options'] = "<button class='btn_select_current btn btn-success btn-sm' id='btn_select_current' data-id='{$post->id}' title='حذف' ><span id='btn_select_current'>Select</span></button>";
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
    // function get_data(Request $request)
    // {
    //     $columns = array(
    //         0 => 'id',
    //         1 => 'name',
    //         2 => 'avatar',
    //         3 => 'featured',
    //         4 => 'type',
    //         5 => 'id',
    //     );
    //     $city_ids = City::where("active", 1)->pluck('id');
    //     $restaurants = Restaurant::whereIn('restaurant_city', $city_ids)->pluck('id');

    //     // $totalData = Order::whereIn('restaurant_id', $restaurants)->count();
    //     // $totalFiltered = $totalData;

    //     $cat = $request->cat;
    //     $status = $request->status;
    //     $city = $request->city;

    //     $limit = $request->input('length');
    //     $start = $request->input('start');
    //     $order = $columns[$request->input('order.0.column')];
    //     $dir = $request->input('order.0.dir');

    //     $search = $request->input('search.value');

    //     $posts = Order::whereIn('restaurant_id', $restaurants)->Where('client_name', 'LIKE', "%{$search}%")->where(function ($q) use ($cat, $status, $city) {
    //         if ($cat) {
    //             //Products
    //             $q->whereHas("Items", function ($q2) use ($cat) {
    //                 $q2->whereHas("Products", function ($q2) use ($cat) {
    //                     $q2->Where('restaurant_id', $cat);
    //                 });
    //             });
    //         }
    //         if ($status) {
    //             $q->Where('status', $status);
    //         }
    //         if ($city) {
    //             $q->Where('city_id', $city);
    //         }
    //     });
    //     if ($limit) $posts = $posts->offset($start)->limit($limit);
    //     $posts = $posts->orderBy('id', 'desc')->orderBy($order, $dir)->get();

    //     // if ($search != null) {
    //     $totalData = Order::whereIn('restaurant_id', $restaurants)->Where('client_name', 'LIKE', "%{$search}%")
    //         ->where(function ($q) use ($cat, $status, $city) {
    //             if ($cat) {
    //                 //Products
    //                 $q->whereHas("Items", function ($q2) use ($cat) {
    //                     $q2->whereHas("Products", function ($q2) use ($cat) {
    //                         $q2->Where('restaurant_id', $cat);
    //                     });
    //                 });
    //             }
    //             if ($status) {
    //                 $q->Where('status', $status);
    //             }
    //             if ($city) {
    //                 $q->Where('city_id', $city);
    //             }
    //         })
    //         ->count();
    //     // }


    //     $data = array();
    //     if (!empty($posts)) {
    //         foreach ($posts as $post) {

    //             $items_pr = $post->Items;
    //             $Restaurant_r = array();
    //             $Products_r = "";
    //             $logo_a = "";
    //             $cat2 = "";
    //             if ($items_pr->count() != 0) {
    //                 foreach ($items_pr as $r) {
    //                     $Products = $r->Products;
    //                     $Productsname = $r->Products->name;

    //                     $Restaurant = $Products->Restaurant->User->name;
    //                     if (!in_array($Restaurant, $Restaurant_r)) {
    //                         array_push($Restaurant_r, $Restaurant);
    //                     }
    //                     //$Restaurant_r = $Restaurant_r . " $Restaurant";
    //                     $Products_r = $Products_r . " <span class='btn-sm btn btn-dark'>$Productsname</span>";
    //                     $logo_a = path() . $Products->Restaurant->user->avatar;
    //                     $cat = $Products->ProductsCategory;
    //                     foreach ($cat as $c) {
    //                         $e = $c->SubCategory->name;
    //                         $cat2 =  $e;
    //                     }
    //                 }
    //             }

    //             $logo = "<img src='$logo_a' style='width: 50px;height: 50px;'>";

    //             $edit = route('dashboard_projects.add_edit', ['id' => $post->id]);
    //             $view_project = route('dashboard_projects.view_project', ['id' => $post->id]);

    //             $nestedData['id'] = $post->id;
    //             $nestedData['logo'] = $logo;
    //             $nestedData['cat'] = $cat2;
    //             $nestedData['city'] = $post->City->name;
    //             $nestedData['phone'] = $post->phone;
    //             $nestedData['total'] = $post->total;
    //             $nestedData['date'] = $post->date();
    //             $nestedData['status'] = $post->status();
    //             $nestedData['name'] = $post->client_name;
    //             $nestedData['restaurant_r'] = implode(", ", $Restaurant_r);
    //             $nestedData['products_r'] = $Products_r;
    //             $nestedData['view_project'] = "<a class='btn btn-sm btn-secondary' href='{$view_project}' title='View' ><i class='fa fa-info-circle'></i> Edit Project</a>";
    //             $nestedData['options'] = "<a class='btn btn-sm btn-primary' href='{$edit}' title='Edit' ><i class='fa fa-edit'></i> Edit</a>
    //                                       <a class='btn_delete_current btn btn-sm btn-danger' href='#' data-id='{$post->id}' title='Delete' ><i class='fa fa-trash'></i> Delete</a>";
    //             $data[] = $nestedData;
    //         }
    //     }
    //     $totalFiltered = $totalData;
    //     $json_data = array(
    //         "draw" => intval($request->input('draw')),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data
    //     );
    //     echo json_encode($json_data);
    // }
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
    function get_data_by_id(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post = Projects::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        return response()->json(['success' => $Post]);
    }

    function selectdata(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post = Projects::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        return response()->json(['data' => $Post]);
    }
    function deleted(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post = Projects::where('id', '=', $id)->first();
        if ($Post == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $Post->delete();
        return response()->json(['error' => __('language.msg.d')]);
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

    public function post_data(Request $request)
    {
        $projectid = $request->id;
        $toprpoject = "1";
        $topproject = Projects::where('id', '=', $projectid)->first();   
        $topproject->topproject = $toprpoject;
        $topproject->update();
        return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_otherprojects.index')]);
    }

    private function rules()
    {
        $x = [
            'projectname' => 'required|min:1|max:191',
        ];
        return $x;
    }
}