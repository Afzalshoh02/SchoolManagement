<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\String\u;

class AdminController extends Controller
{
    //admin list get
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Admin List';
        return view('admin.admin.list', $data);
    }

    //add new admin get
    public function add()
    {
        $data['header_title'] = 'Add New Admin';
        return view('admin.admin.add', $data);
    }

    //create new admin post
    public function insert(Request $request)
    {
        $request->validate([
           'email' => ['required', 'email', 'unique:users']
        ]);
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();
        return redirect('admin/admin/list')->with('success', "Admin successfully created");
    }

    //edit admin in id
    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Admin';
            return view('admin.admin.edit', $data);
        } else {
            abort(404);
        }
    }

    //update admin in id
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email,'.$id]
        ]);
        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect('admin/admin/list')->with('success', "Admin successfully updated");
    }

    //delete admin in id
    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect('admin/admin/list')->with('success', "Admin successfully deleted");
    }
}
