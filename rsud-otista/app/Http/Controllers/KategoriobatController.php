<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Kategoriobat;
use Flashy;

class KategoriobatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kategoriobat'] = Kategoriobat::all();
        return view('kategoriobat.index',$data)->with('no', 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoriobat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = request()->validate(['nama'=>'required|unique:kategoriobats,nama']);
      Kategoriobat::create($data);
      Flashy::success('Kategori Obat Telah Ditambahkan');
      return redirect('kategoriobat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kategoriobat'] = Kategoriobat::find($id);
        return view('kategoriobat.edit',$data);
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
      $data = request()->validate(['nama'=>'required|unique:kategoriobats,nama,'.$id]);
      Kategoriobat::find($id)->update($data);
      Flashy::info('Data Kategori Obat berhasil di update');
      return redirect('kategoriobat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
