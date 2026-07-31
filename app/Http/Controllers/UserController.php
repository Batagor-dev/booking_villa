<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class UserController extends Controller
{
    // use UsersAuthorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = '/user';
        return view('user.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, ImageService $imageService)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $compressed = $imageService->compress($file);
            $fileName = time() . '_' . uniqid() . '.jpg';
            
            Storage::disk('public')->put('uploads/users/' . $fileName, $compressed);
            
            $data['foto'] = $fileName;
        } else {
            $data['foto'] = 'avatar-1.jpg';
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        
        $userRole = Role::whereRaw('LOWER(name) = ?', ['user'])->first();
        if ($userRole) {
            $user->assignRole($userRole);
        } else {
            $user->assignRole('User');
        }

        return redirect('/user')->with('success', 'New user has been created!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->data['user_data'] = $user;
        $this->data['action'] = "/user/".$user->uuid;
        return view('user.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user, ImageService $imageService)
    {
        // Ambil data hasil validasi
        $validatedData = $request->validated();

        // Handle foto baru
        if ($request->hasFile('foto')) {
            if ($user->foto && $user->foto !== 'avatar-1.jpg') {
                $oldFilePath = 'uploads/users/' . $user->foto;
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            }

            $file = $request->file('foto');
            $compressed = $imageService->compress($file);
            $fileName = time() . '_' . uniqid() . '.jpg';
            
            Storage::disk('public')->put('uploads/users/' . $fileName, $compressed);
            
            $validatedData['foto'] = $fileName;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect('/user')->with('success', 'User has been updated!');
    }

    public function role(User $user)
    {
        $this->data['roles'] = Role::all();
        $this->data['permissions'] = $user->getAllPermissions();
        $this->data['user'] = $user;
        //return $this->data['permissions'];
        $this->data['action'] = "/user/roleaction/" . $user->uuid;
        return view('user.role', $this->data);
    }

    public function roleaction(Request $request, User $user)
    {
        $user->syncRoles($request->roles);

        return redirect('/user')->with('success', 'Roles ' . $user->name . ' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
    // Cek permission: hanya user dengan permission 'User Banned' yang bisa ban
    abort_if(Gate::denies('User Banned'), 403, 'Anda tidak memiliki izin untuk membanned user.');

    // Cari user yang akan dibanned
    $user = User::where('uuid', $uuid)->firstOrFail();

    // Cek apakah user sudah dibanned
    if ($user->banned_at) {
        return redirect()->back()->with('info', __('messages.banned'));
    }

    // Lakukan banning
    $user->update(['banned_at' => now()]);
    return redirect()->back()->with('success', __('messages.banned'));
    }
}
