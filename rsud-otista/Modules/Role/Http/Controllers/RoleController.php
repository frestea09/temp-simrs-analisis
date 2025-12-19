<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Role;
use Flashy;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $role = Role::all();
        return view('role::index', compact('role'))->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('role::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate([
        'name' => 'required|unique:roles,name',
        'display_name' => 'required|unique:roles,display_name',
        'description' => 'sometimes'
      ]);
      Role::create($data);
      Flashy::success('Role baru berhasil di tambahkan');
      return redirect()->route('role');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('role::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('role::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function hapus($id)
    {
        $cek_role = Role::where('id', $id)->count();
        if($cek_role == 0){
            return redirect('role');
        } else {
            Role::where('id', $id)->delete();
            Flashy::error('Role berhasil dihapus');
            return redirect('role');
        }
    }
}

