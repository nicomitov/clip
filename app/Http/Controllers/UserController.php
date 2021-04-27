<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Notifications\UserWelcome;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->latest('id')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', 'App\User');

        $roles = Role::pluck('display_name', 'id');

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\User');

        $plainPassword = $request['password'];

        $validatedAttributes = $this->validator();

        $validatedAttributes['password'] = Hash::make($validatedAttributes['password']);
        $validatedAttributes['is_active'] = isset($request['is_active']);
        $validatedAttributes['notify'] = isset($request['notify']);

        $user = User::create($validatedAttributes);

        $user->roles()->attach($validatedAttributes['toRoles']);

        \Notification::send($user, new UserWelcome($user, $plainPassword));

        $user->setActivity('created');

        return redirect(route('users.index'))
                ->with(['success' => 'Successfully created!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::pluck('display_name', 'id');
        $userRoles = $user->roles()->pluck('id');

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedAttributes = $this->validator($user->id);
        $validatedAttributes['is_active'] = isset($request['is_active']);
        $validatedAttributes['notify'] = isset($request['notify']);

        // unset empty pasword
        if (is_null($validatedAttributes['password'])) {
            unset($validatedAttributes['password']);
        } else {
            $validatedAttributes['password'] = Hash::make($validatedAttributes['password']);
        }

        // update
        $user->update($validatedAttributes);

        // sync roles
        if (isset($validatedAttributes['toRoles'])) {
            $user->roles()->sync($validatedAttributes['toRoles']);
        }

        $user->setActivity('updated');

        return back()->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->setActivity('deleted');

        $user->roles()->detach();
        $user->delete();

        return back()->with(['success' => 'Successfully deleted!']);
    }

    public function updateStatus(Request $request, User $user)
    {
        $user->updateStatus($request['is_active']);

        $user->setActivity('updated');

        return back()->with(['success' => 'Successfully updated!']);
    }

    protected function validator($userId = null)
    {
        //create
        $data = [
            'email' => ['required', 'unique:users,email', 'email'],
            'name' => ['required', 'min:3'],
            'password' => ['required', 'min:4'],
            'department' => '',
            'toRoles' => ['required', 'exists:roles,id'],
        ];

        // update
        if (Route::currentRouteName() == 'users.update') {
            if (auth()->user()->hasRole('admin')) { // admin

                $data['password'] = ['nullable', 'min:4'];
                $data['email'] = ['required', 'email', 'unique:users,email,'.$userId];

            } else { // user own profile update

                unset($data['email'], $data['toRoles']);
                $data['password'] = ['nullable', 'min:4', 'confirmed'];

            }
        }

        return request()->validate($data);
    }
}
