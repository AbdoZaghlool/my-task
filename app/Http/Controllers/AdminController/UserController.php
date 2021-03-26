<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'phone_number'          => 'required|unique:users',
            'name'                  => 'required|max:255',
            'email'                 => 'nullable|email|unique:users',
            'image'                 => 'nullable|mimes:jpeg,bmp,png,jpg|max:3000',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ];
        $this->validate($request, $rules);
        $user = User::create([
            'phone_number'      => $request->phone_number,
            'email'             => $request->email,
            'name'              => $request->name,
            'password'          => Hash::make($request->password),
            'image'             => $request->image == null ? 'default.png' : UploadImage($request->file('image'), 'user', '/uploads/users'),
        ]);

        toastr()->success('تم اضافة المستخدم بنجاح');
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'phone_number'      => 'required|unique:users,phone_number,' . $id,
            'email'             => 'nullable|email|unique:users,email,' . $id,
            'name'              => 'required|max:255',
            'image'             => 'nullable|mimes:jpeg,bmp,png,jpg|max:3000',
            'password'          => 'nullable|string|min:6',
            'password_confirmation' => 'required_with:password|same:password',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $user->update([
            'name'              => $request->name,
            'phone_number'      => $request->phone_number,
            'email'             => $request->email,
            'password'          => $request->password == null ? $user->password : Hash::make($request->password),
            'image'             => $request->file('image') == null ? $user->image : UploadImageEdit($request->file('image'), 'image', '/uploads/users', $user->image),
        ]);

        toastr()->success('تم تعديل بيانات المستخدم');
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $image = $user->image;
        $user->delete();
        if (file_exists(public_path('uploads/users/') . $image) && $image != 'default.png') {
            unlink(public_path('uploads/users/') . $image);
        }
        
        toastr()->success('تم الحذف بنجاح');
        return back();
    }
}