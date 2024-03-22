<?php

namespace App\Http\Controllers;

use App\Models\ClassesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Classes List';
        return view("admin.classes.list", $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add New Classes';
        return view("admin.classes.add", $data);
    }

    public function insert(Request $request)
    {
        $save = new ClassesModel();
        $save->name = $request->name;
        $save->status = $request->status;
        $save->crated_by = Auth::user()->id;
        $save->save();
        return redirect('admin/classes/list')->with('success', "Classes Successfully Crated");
    }
}
