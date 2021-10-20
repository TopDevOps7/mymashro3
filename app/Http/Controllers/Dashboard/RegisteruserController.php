<?php

namespace App\Http\Controllers\Dashboard;
use App\Category;
use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Registerusers;
use App\User;

use Illuminate\Http\Request;

class RegisteruserController extends Controller
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
        return view('dashboard/registeruser.index');
    }

     public function add_edit()
    {
        return view('dashboard/registeruser.add_edit');
    }
    
    public function post_data(Request $request){
         $editid = $request->id;
         $registername = $request->registername;
         $email = $request->email;
         $mobile = $request->mobile;
         $password = $request->password;
         $datepicker = $request->datepicker;
         $status = $request->status;
         $validation = Validator::make($request->all(), $this->rules_test($editid));
         if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
         }else{
               if ($editid != null) {
                  if($request->file == null){
                    if($status == null)
                    {
                        $status = "off";
                    }else{
                            $status = "on"; 
                    } 
                   $registeruser = Registerusers::where('id', $request->id)->first();
                   $registeruser->name=$registername;
                   $registeruser->email=$email;
                   $registeruser->password=$password;
                   $registeruser->mobile=$mobile;
                   $registeruser->datepicker=$datepicker;
                   $registeruser->status=$status;
                 
                   $registeruser->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_registereduser.index')]);
                  }else{
                   $imageName = time().'.'.$request->file->getClientOriginalExtension();
                   $fileName = time().'_'.$request->file->getClientOriginalName();
                   $filePath = $request->file->storeAs('upload/registerusers', $fileName, 'public');
                    $request->file->move(public_path('upload/registerusers'), $fileName);
                   if($status == null)
                   {
                       $status = "off";
                     }
                     else{
                         $status = "on"; 
                   } 
                   $registeruser = Registerusers::where('id', $request->id)->first();
                   $registeruser->name=$registername;
                   $registeruser->email=$email;
                   $registeruser->password=$password;
                   $registeruser->mobile=$mobile;
                   $registeruser->status=$status;
                   $registeruser->datepicker=$datepicker;
                   $registeruser->picture=$filePath;
                   $registeruser->update();
                   return response()->json(['success' => __('language.msg.m'), 'dashboard' => '1', 'redirect' => route('dashboard_registereduser.index')]);
                  }
                  
             }
           else{
                   $imageName = time().'.'.$request->file->getClientOriginalExtension();
                   $fileName = time().'_'.$request->file->getClientOriginalName();
                   $filePath = $request->file->storeAs('upload/registerusers', $fileName, 'public');
                     $request->file->move(public_path('upload/registerusers'), $fileName);
                     if($status == null)
                   {
                       $status = "off";
                     }
                     else{
                         $status = "on"; 
                   } 
                   $registeruser = new Registerusers();
                   $registeruser->name=$registername;
                   $registeruser->email=$email;
                   $registeruser->mobile=$mobile;
                   $registeruser->datepicker = $datepicker;
                   $registeruser->status=$status;
                   $registeruser->password=$password;
                   $registeruser->picture=$filePath;
                   $registeruser->save();
                   return response()->json(['success' => __('language.msg.s'), 'dashboard' => '1', 'redirect' => route('dashboard_registereduser.index')]);
                }
         }
        
    }
      private function rules_test($editid = null)
    {

        if ($editid != null) {
            $x['id'] = 'required|integer|min:1';
        } else {
            $x = [
                'registername' => 'required|min:3|max:191',
                'email' => 'required|email',
                'mobile' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',
                'datepicker' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:10',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
                'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            ];
       }
         return $x;
    }
 

    function get_data(Request $request)
    {
         $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'avatar',
            4 => 'avatar',
            5 => 'confirm_email',
            6 => 'id',
        );

        $type = $request->type;
        $totalData = User::where(function ($q) use ($type) {
            if ($type) {
                $q->where("role", $type);
            } else {
                $q->where("role", '5');
            }
        })->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        $posts = User::
        where(function ($q) use ($type) {
            if ($type) {
                $q->where("role", $type);
            } else {
                $q->where("role", '5');
            }
        })->
        where(function ($q) use ($search) {
            if ($search) {
                $q->Where('name', 'LIKE', "%{$search}%");
                $q->orWhere('email', 'LIKE', "%{$search}%");
            }
        })
            ->offset($start)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->orderBy($order, $dir)
            ->get();

        if ($search != null) {
            $totalFiltered = User::where(function ($q) use ($type) {
                if ($type) {
                    $q->where("role", $type);
                } else {
                    $q->where("role", '5');
                }
            })->
            where(function ($q) use ($search) {
                if ($search) {
                    $q->Where('name', 'LIKE', "%{$search}%");
                    $q->orWhere('email', 'LIKE', "%{$search}%");
                }
            })->count();
        }


        $data = array();
        if (!empty($posts)) {
            $active_count = 1;
            foreach ($posts as $post) {
                $ava = url(parent::PublicPa() . $post->avatar);
                if ($post->type_login != null) {
                    $ava = $post->avatar;
                }

                $edit = route('dashboard_users.add_edit', ['id' => $post->id, 'type' => $request->type]);

                $role = $post->NameRole();

                $check1 = '';
                $active_or_no1 = 'Disable';
                if ($post->active == 1) {
                    $check1 = 'checked';
                    $active_or_no1 = 'Enable';
                }

                $add1= '<div class="material-switch pull-left">
                            <input data-id="'. $post->id .'" id="active_'.$active_count.'" class="btn_confirm_email_current" type="checkbox" '.$check1.'/>
                            <label for="active_'.$active_count.'" class="label-success"></label>
                        </div>';


                $add = "<label>
                            <input type=\"checkbox\" data-id='$post->id' class=\"btn_select_btn_deleted\">
                        </label>";

                $nestedData['id'] = $add;
                $nestedData['name'] = $post->name;
                $nestedData['phone'] = $post->phone;
                $nestedData['confirm_email'] = $add1;
                $nestedData['email'] = $post->email;
                $nestedData['role'] = '<div class="badge badge-primary">' . $role . '</div>' . '<br>';
                $nestedData['avatar'] = "<img style='width: 50px;height: 50px;' src='{$ava}' class='img-circle img_data_tables'>";

                $nestedData['options'] = "<a class='btn_delete_current btn btn-sm btn-danger' href='#' data-id='{$post->id}' title='Delete' ><i class='fa fa-trash'></i> Delete</a>";
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

   
      function confirm_email(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        $user = User::where('id', '=', $id)->first();
        if ($user == null) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($user->id == parent::CurrentID()) {
            return response()->json(['error' => __('language.msg.e')]);
        }
        if ($user->active == 1) {
            $user->active = 0;
            $user->update();
            
            $to = $user['email'];
            $subject = "Sandwich Map";
            $message = 'Your Account has been freezed 
            
To reactivate your account please contact your relationship manager   

www.sandwichmap.net

Thank you for using SandwichMap for more support Please call 0501212770';

            $headers = "From:   noreply@icheck-antibody.jp" . "\r\n" .
                        "CC: somebodyelse@example.com";

            $message1 = 'Your Account has been Freezed 
            
To reactivate your account please contact your relationship manager.

www.sandwichmap.net
Thank you for using SandwichMap for more support Please call 0501212770
Please do not reply to this email.
We would also be happy to receive your feedback - suggestions and complaints on

Management Email :
    sandwichmap@yahoo.com

Owner Email :
    '. $to . '
fs.aljabri@yahoo.com
Sincerely,

Sandwich Map LLC
Restaurants Partners Support Team
UAE';
            Common::SendTextSMS($user['phone'], $message);
            Common::SendEmail($to,$subject,$message1,$headers);
            
            return response()->json(['error' => __('table.a_n_ver')]);
        } else {
            $user->active = 1;
            $user->update();
            
            $to = $user['email'];
            $subject = "Sandwich Map";
            $message = 'Your Account has been successfully activated

www.sandwichmap.net

Thank you for using SandwichMap for more support Please call 0501212770';

            $headers = "From:   noreply@icheck-antibody.jp" . "\r\n" .
                        "CC: somebodyelse@example.com";

            $message1 = 'Your Account has been successfully activated.

www.sandwichmap.com
Thank you for using SandwichMap for more support Please call 0501212770
Please do not reply to this email.
We would also be happy to receive your feedback - suggestions and complaints on

Management Email :
    sandwichmap@yahoo.com

Owner Email :
    '. $to . '
fs.aljabri@yahoo.com
Sincerely,

Sandwich Map LLC
Restaurants Partners Support Team
UAE';
            Common::SendTextSMS($user['phone'], $message);
            Common::SendEmail($to,$subject,$message1,$headers);
            
            return response()->json(['success' => __('table.a_ver')]);
        }
    }
    function get_data_by_id(Request $request)
    {
        $id = $request->id;
        if ($id == null) {
            return response()->json(['error' => 'Error Happen']);
        }
        $project = User::where('id', '=', $id)->first();
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
        $rider = User::where('id', $id)->first();
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
            $Post = User::where('id', '=', $value)->first();
            if ($Post == null) {
                return response()->json(['error' => 'Error Happen']);
            }
            $Post->delete();
        }
        return response()->json(['success' => 'Delete Done']);
    }
}