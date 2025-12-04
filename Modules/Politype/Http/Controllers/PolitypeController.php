<?php

namespace Modules\Politype\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Politype\Entities\Politype;
use MercurySeries\Flashy\Flashy;

class PolitypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $politype = Politype::all();
        return view('politype::index', compact('politype'))->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('politype::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['kode'=>'required|max:1','nama'=>'required']);
      Politype::create($data);
      Flashy::success('Politype berhasil di tambahkan');
      return redirect()->route('politype');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('politype::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $politype = Politype::find($id);
        return view('politype::edit', compact('politype'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
      $data = request()->validate(['kode'=>'required|max:1','nama'=>'required']);
      Politype::find($id)->update($data);
      Flashy::info('Politype berhasil di update');
      return redirect()->route('politype');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
