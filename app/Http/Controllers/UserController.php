<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\CmotCategory;
use App\Models\User;

class UserController extends Controller
{

    public function __counstruct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        // if (Auth::user()->hasRole('SUPERADMIN')) {
        //     $users = User::paginate(10);
        // } else if (Auth::user()->hasRole('ADMIN')) {
        //     $users      =   User::whereDoesntHave('roles', function ($query) {
        //         $query->whereIn('name', ['superadmin']);
        //     })->paginate(10);
        // } else if (Auth::user()->hasRole('CMOT-ADMIN')) {
        //     $users = User::whereHas('roles', function ($query) {
        //         $query->whereIn('name', ['JURY', 'GRANDJURY', 'CMOT-ADMIN']);
        //     })->paginate(10);
        // } else {
        //     $users = User::whereHas('roles', function ($query) {
        //         $query->where('name', Auth::user()->getRoleNames());
        //     })->paginate(10);
        // }

        // if (Auth::user()->hasRole('SUPERADMIN')) {
        //     $roles = Role::all();
        // } else if (Auth::user()->hasRole('ADMIN')) {
        //     $roles = Role::where('name', '!=', 'SUPERADMIN')->get();
        // } else if (Auth::user()->hasRole('CMOT-ADMIN')) {
        //     $roles = Role::whereIn('name', ['JURY', 'GRANDJURY', 'RECRUITER', Auth::user()->getRoleNames()])->get();
        // } else {
        //     $roles = Role::where('name', Auth::user()->getRoleNames())->get();
        // }
        $userRole = Auth::user()->getRoleNames()->first();
        switch ($userRole) {

            case 'SUPERADMIN':
                $users = User::paginate(10);
                $roles = Role::all();
                break;

            case 'ADMIN':
                $users = User::whereDoesntHave('roles', function ($query) {
                    $query->whereIn('name', ['superadmin']);
                })->paginate(10);
                $roles = Role::where('name', '!=', 'SUPERADMIN')->get();
                break;

            // case 'CMOT-ADMIN':
            //     $users = User::whereHas('roles', function ($query) {
            //         $query->whereIn('name', ['JURY', 'GRANDJURY', 'CMOT-ADMIN']);
            //     })->paginate(10);
            //     $roles = Role::whereIn('name', ['JURY', 'GRANDJURY', 'RECRUITER', $userRole])->get();
            //     break;

            default:
                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', Auth::user()->getRoleNames());
                })->paginate(10);
                Role::where('name', Auth::user()->getRoleNames())->get();
                break;
        }
        return view('users.index', compact(['users', 'roles']));
    }

    public function create()
    {
        if (Auth::user()->hasRole('CMOT-ADMIN')) {
            $roles = Role::whereNotIn('name', ['superadmin', 'admin', 'cmot-admin'])->get();
        } else {
            $roles = Role::all();
        }
        // $categories = CmotCategory::get();
        return view('users.create', [
            'roles'             =>  $roles,
            // 'categories'        =>  $categories,
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();
        $roleId     =   $request->input('role_id');
        $roleById       =   Role::find($roleId);
        $roleNameByid   =   $roleById ? $roleById->name : 'the selected role';

        $messages = [
            'name.required'                     =>  'The name field is required.',
            'email.required'                    =>  'The email field is required.',
            'email.unique'                      =>  'The email has already been taken.',
            'mobile.required'                   =>  'The mobile field is required.',
            'mobile.digits'                     =>  'The mobile number must be exactly 10 digits.',
            'role_id.required'                  =>  'The role id field is required.',
            'cmot_category_id.required_if'      =>  "The category field is required when role is " . $roleNameByid . ".",
            'production_house.required_if'      =>  "The production house field is required when role is " . $roleNameByid . ".",
            'password.required'                 =>  'The password field is required.',
            'password.string'                   =>  'The password must be a string.',
            'password.min'                      =>  'The password must be at least 8 characters.',
            'password.confirmed'                =>  'The password confirmation does not match.',
        ];

        $request->validate([
            'name'              =>  'required',
            'email'             =>  ['required', 'unique:users,email'],
            'mobile'            =>  ['required', 'unique:users,mobile', 'digits:10'],
            'role_id'           =>  'required',
            'cmot_category_id'  =>  'required_if:role_id,3,4',
            'production_house'  =>  'required_if:role_id,13',
            'password'          =>  'required|string|min:8|confirmed',

        ], $messages);

        if (isset($payload['role_id']) && !empty($payload['role_id'])) {
            $roleName = Role::select('name')->where('id', $payload['role_id'])->first();
        }

        $username = NULL;
        if ($roleName['name'] === 'OTHERS') {
            $getUsername = User::select('username')->where('role_id', $payload['role_id'])->orderBy('id', "desc")->first();
            if (empty($getUsername)) {
                $username   =   "OTR0001";
            } else {
                $number     =   explode('OTR000', $getUsername->username);
                $username   =   $number[1] + 1;
                $username   =   'OTR000' . $username;
            }
        }

        $data = [
            'name'                  =>  $payload['name'],
            'username'              =>  $username,
            'email'                 =>  $payload['email'],
            'mobile'                =>  $payload['mobile'],
            'password'              =>  Hash::make($payload['password']),
            'role_id'               =>  $payload['role_id'],
            'cmot_category_id'      =>  isset($payload['cmot_category_id']) ? $payload['cmot_category_id'] : NULL,
            'production_house'   =>  isset($payload['production_house']) ? $payload['production_house'] : NULL,
        ];

        $user = User::create($data);
        if ($user) {
            $user->roles()->detach();
            if (!is_null($roleName)) {
                $user->assignRole($roleName['name']);
            }
            return redirect()->route('users.index')->with('success', $roleName['name'] . ' created successfully.!!');
        } else {
            return redirect()->route('users.index')->with('error', 'User not created .!!');
        }
    }

    public function show(User $user)
    {
        return view('users.show', compact(['user']));
    }

    public function edit(string $id)
    {
        $roles      =   Role::all();
        $user       =   User::find($id);
        // $categories =   CmotCategory::get();
        return view('users.edit', [
            'user' => $user,
            'roles' =>  $roles,
            // 'categories' => $categories
        ]);
    }

    public function update(Request $request, string $id)
    {
        $payload = $request->all();
        $request->validate([
            'name'              =>  ['required'],
            'email'             =>  ['required'],
            'mobile'            =>  ['required'],
            'role_id'           =>  ['required'],
            // 'password'          =>  ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($id);
        $user->name             =   isset($payload['name']) && !empty($payload['name']) ? $payload['name'] :  $user->name;
        $user->email            =   isset($payload['email']) && !empty($payload['email']) ? $payload['email'] :  $user->email;
        $user->mobile           =   isset($payload['mobile']) && !empty($payload['mobile']) ? $payload['mobile'] :  $user->email;
        $user->role_id          =   isset($payload['role_id']) && !empty($payload['role_id']) ? $payload['role_id'] :  $user->role_id;
        // $user->password         =   isset($payload['password']) && !empty($payload['password']) ? $payload['password'] :  $user->password;

        $roleName = Role::select('name')->where('id', $payload['role_id'])->first();
        if ($roleName['name'] === 'ADMIN' || $roleName['name'] === 'SUPERADMIN') {
            $user->cmot_category_id =   NULL;
        } else {
            $user->cmot_category_id =   isset($payload['cmot_category_id']) && !empty($payload['cmot_category_id']) ? $payload['cmot_category_id'] :  $user->cmot_category_id;
        }
        // $user->password         =   Hash::make($payload['password']);
        $user->password         =   isset($payload['password']) && !empty($payload['password']) ? Hash::make($payload['password'])  :  $user->password;

        if ($user->update()) {
            $user->roles()->detach();
            if (!is_null($roleName)) {
                $user->syncRoles($roleName['name']);
            }
            return redirect()->route('users.index')->with('success', 'User updated successfully.!!');
        } else {
            return redirect()->route('users.index')->with('error', 'User not created .!!');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id == 1) {
            abort(403, 'SUPERADMIN CAN NOT BE DELETED. !!');
        }
        if (Auth::user()->id == $user->id) {
            abort(403, 'CAN NOT DELETE SELF RECORD. !!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.!!');
    }

    public function assign($id)
    {
        $user   =   User::find($id);
        $role   =   Role::select('name')->where('id', $user->role_id)->first();
        if (!empty($user)) {
            $findRole   =   Role::where('name', $role['name'])->first();
            if (!is_null($findRole)) {
                $user->assignRole($findRole['name']);
                return redirect()->route('users.index')->with('success', 'Role assigned successfully. !!');
            } else {
                return redirect()->route('users.index')->with('warning', 'ROLE NAME--:' . $role . ' :--IS NOT FOUND. !!');
            }
        } else {
            return redirect()->route('users.index')->with('danger', 'User not found.!!');
        }
    }

    public function search(Request $request)
    {
        $payload = $request->all();
        $users = User::query()
            ->when($payload, function (Builder $builder) use ($payload) {
                if (!empty($payload['role_id'])) {
                    $builder->where('role_id', $payload['role_id']);
                }
                // if (!empty($payload['email'])) {
                //     // $builder->where('email', $payload['email']);
                //     $builder->where('email', 'like', '%' . $payload['email'] . '%');
                // }
            })
            ->paginate(10);

        $userRole = Auth::user()->getRoleNames()->first();
        switch ($userRole) {
            case 'SUPERADMIN':
                $roles = Role::all();
                break;
            case 'ADMIN':
                $roles = Role::where('name', '!=', 'SUPERADMIN')->get();
                break;
            case 'CMOT-ADMIN':
                $roles = Role::whereIn('name', ['JURY', 'GRANDJURY', 'RECRUITER', Auth::user()->getRoleNames()])->get();
                break;
            default:
                $roles = Role::where('name', Auth::user()->getRoleNames())->get();
                break;
        }
        return view('users.index', [
            'users'     =>  $users,
            'roles'     =>  $roles,
            'payload'   =>  $payload
        ]);
    }
}
