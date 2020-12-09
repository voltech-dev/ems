<?php
namespace App\Http\Controllers;


use App\Models\User;
use App\Models\UserDetails;
use App\Models\EmpDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Dtssp;
use Response;
class SiteController extends Controller
{
    //use UploadTrait;
    //use RoleTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function holidayList(Request $request){

    }

   /* public function userList(Request $request)
    {
        if ($this->RolePermision(auth()->user()->id, 'usercreate')) {
            $model = User::all();
            return view('site.userList', ['model' => $model]);
        } else {
            return redirect('site/NotAuthendicate')->with('status', 'Access Denied!, You\'r Not Authorized to view');
        }
    }

    public function entrydashboard(Request $request)
    {
        if ($this->RolePermision(auth()->user()->id, 'dataentry')) {
            return view('dashboard.entrydashboard');
        } else {
            return redirect('site/NotAuthendicate')->with('status', 'Access Denied!, You\'r Not Authorized to view');
        }
    }

    public function customerfile(Request $request)
    {

        return view('customerdata.customerdata');
    }

  

    public function usercreate(Request $request)
    {
        if ($this->RolePermision(auth()->user()->id, 'usercreate')) {
            return view('site.usercreate');
        } else {
            return redirect('NotAuthendicate')->with('status', 'Access Denied!, You\'r Not Authorized to view');
        }
    }
    public function userupdate($id)
    {
        $user = User::findOrFail($id);
        return view('site.userupdate', [
            'model' => $user,
        ]);
    } */

    public function user(Request $request)
    {
        $user = User::all();
        return view('site.user',[
            'model' => $user,
        ]);
    }

    public function passresetdata(Request $reques,$id)
    {
        $user = User::findOrFail($id);
        return response()->json([      
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function passwordreset(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->password = Hash::make($request->user_password);
        $user->save();
     
    }

    public function storeuser(Request $request)
    {
      
       /* $user_details =UserDetails::all();
        foreach($user_details as $user){
           $empdet = ProjectDetails::where(['id'=>$user->emp_code])->first();
            $create_user = new User();
            $create_user->name = $user->emp_name;
            $create_user->email = $user->email;
            $create_user->password = Hash::make($user->emp_name);
           
            $create_user->role ="ProjectAdmin";
            $create_user->project_id = $empdet->id;

        $create_user->save();
        }
        /*$user_details =UserDetails::all();
        foreach($user_details as $user){
           $empdet = EmpDEtails::where(['emp_code'=>$user->emp_code])->first();
            $create_user = new User();
            $create_user->name = $user->emp_name;
            $create_user->email = $user->email;
            $create_user->password = Hash::make($user->emp_code);
           
            $create_user->role ="Employee";
            $create_user->emp_id = $empdet->id;

        $create_user->save();
        }*/

        $create_user = new User();
        $create_user->name ="Administrator";
        $create_user->email = "administrator@voltechgroup.in";
        $create_user->password = Hash::make("Administrator");
       
        $create_user->role ="Administrator";
        $create_user->save();

    }

   /* public function updateuser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        $user = User::findOrFail($request->userid);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != '') {
            $user->forceFill([
                'password' => Hash::make($request->password),
            ]);
        }
        if ($user->save()) {
            Role::Where('user_id', $request->userid)->delete();
            foreach ($request->role as $roles => $role) {
                $model = new Role();
                $model->user_id = $user->id;
                $model->role = $role;
                $model->save();
            }
        }
        return redirect()->back()->with(['status' => 'User Updated successfully.']);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;

        if ($request->has('profile_image')) {

            if ($user->profile_image != null) {
                unlink(public_path('storage' . $user->profile_image));
            }
            $image = $request->file('profile_image');
            $name = Str::slug($request->input('name')) . '_' . time();
            $folder = '/images/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $this->uploadImg($image, $folder, 'public', $name);
            $user->profile_image = $filePath;
        }
        if ($request->password != '') {
            $user->forceFill([
                'password' => Hash::make($request->password),
            ]);
        }
        // Persist user record to database
        $user->save();

        // Return user back and show a flash message
        return redirect()->back()->with(['status' => 'Profile updated successfully.']);

    }*/
  

}