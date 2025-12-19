<?php

namespace Modules\Instalasi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Instalasi\Http\Requests\SaveinstalasiRequest;
use Modules\Instalasi\Http\Requests\UpdateinstalasiRequest;
use Modules\Instalasi\Entities\Instalasi;

class InstalasiController extends Controller
{
    public function index()
    {
        $instalasi = Instalasi::all();
        return view('instalasi::index', compact('instalasi'))->with('no', 1);
    }

    public function create()
    {
        return view('instalasi::create');
    }

    public function store(SaveinstalasiRequest $request)
    {
      Instalasi::create($request->all());
      return redirect()->route('instalasi');
    }

    public function show()
    {
        return view('instalasi::show');
    }

    public function edit($id)
    {
        $instalasi = Instalasi::find($id);
        return view('instalasi::edit', compact('instalasi'));
    }

    public function update(UpdateinstalasiRequest $request, $id)
    {
      Instalasi::find($id)->update($request->all());
      return redirect()->route('instalasi');
    }

    public function destroy()
    {
    }
}
