<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * get all admins
     *
     * @return void
     */
    public function index()
    {
        $data = Admin::latest()->get();
        return view('admin.admins.admins.index', compact('data'));
    }

    /**
     * get admin create form
     *
     * @return void
     */
    public function create()
    {
        return view('admin.admins.admins.create');
    }

    /**
     * store new admin to storage
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            ]);

        $request['password'] = Hash::make($request->password);
        $admin = Admin::create($request->all());
        toastr()->success('تم اضافة المشرف بنجاح');
        return redirect(url('/admin/admins'));
    }

    /**
     * get admin edit view
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $data = Admin::find($id);
        return view('admin.admins.admins.edit', compact('data'));
    }

    /**
     * update admin info to storage
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
        ]);

        $admin = Admin::findOrFail($id);
        $admin->update($request->only('name', 'email', ));

        toastr()->success('تم التعديل بنجاح');
        return redirect(url('/admin/admins'));
    }

    /**
     * get admin profile page
     *
     * @return void
     */
    public function my_profile()
    {
        $data = Admin::find(Auth::id());
        return view('admin.admins.profile.profile', compact('data'));
    }

    /**
     * update admin profile info in storage
     *
     * @param Request $request
     * @return void
     */
    public function my_profile_edit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:admins,email,' . Auth::id(),
            'phone' => 'required',
        ]);
        $data = Admin::where('id', Auth::id())->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        toastr()->success('تم التعديل بنجاح');
        return redirect(url('/admin/profile'));
    }

    /**
     * get admin password view
     *
     * @return void
     */
    public function change_pass()
    {
        return view('admin.admins.profile.change_pass');
    }

    /**
     * update admin password
     *
     * @param Request $request
     * @return void
     */
    public function change_pass_update(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
        ]);
        $updated = Admin::where('id', Auth::id())->update([
            'password' => Hash::make($request->password),
        ]);
        toastr()->success('تم التعديل بنجاح');
        return redirect(url('/admin/profileChangePass'));
    }

    /**
     * delete admin from storage
     *
     * @param int $id
     * @return void
     */
    public function admin_delete($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        toastr()->success('تم الحذف بنجاح');
        return back();
    }
}