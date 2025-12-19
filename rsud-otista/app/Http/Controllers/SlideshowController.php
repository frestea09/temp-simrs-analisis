<?php

namespace App\Http\Controllers;

use App\Operasi;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Slideshow;
use Carbon\Carbon;
use Image;
use File;
use Auth;
use Modules\Kelas\Entities\Kelas;
use Modules\Bed\Entities\Bed;
use Modules\Kamar\Entities\Kamar;

class SlideshowController extends Controller
{
    public function index()
    {
        $slideshow = Slideshow::paginate(5);
        $no = $slideshow->firstItem();
        return view('slideshow.index', compact('slideshow', 'no'));
    }

    public function store(Request $request)
    {
        $validator = request()->validate(['foto' => 'required']);

        if(!empty($request->file('foto')))
        {
          $gambar = $request->file('foto');
          foreach ($gambar as $key => $d)
          {
            $image = time().$d->getClientOriginalName();
            $d->move('images/slideshow/', $image);
            Image::make(public_path().'/images/slideshow/'.$image)->resize(800,350)->save();
            $data = $request->all();
            $data['image'] = $image;
            $data['user_id'] = Auth::user()->id;
            Slideshow::create($data);
          }
        }
        Flashy::success('Slideshow berhasil di tambahkan');
        return redirect('slideshow');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $slide = Slideshow::find($id);
        if($slide->publish == 'Y')  {
          $slide->publish = 'N';
          Flashy::info('Slideshow berhasil di non aktifkan');
        } else {
          $slide->publish = 'Y';
          Flashy::success('Slideshow berhasil aktifkan');
        }
        $slide->update();
        return redirect('slideshow');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function display()
    {
        $data = Slideshow::where('publish', 'Y')->get();
        return view('displaytempattidur.display', compact('data'));
    }

    public function display_jumlah(){
      $data['kelas'] = Kelas::get();
      $data['bed'] = Bed::count();
      return view('displaytempattidur.display_jumlah', compact('data'));
    }

    public function display_operasi(){
      // $date = date('Y-m-d', strtotime('-5 days'));
      $today = Carbon::today()->toDateString();
      $data['jadwal_operasi'] = Operasi::whereDate('rencana_operasi', $today)->where('terlaksana','0')->orderBy('rencana_operasi','DESC')->orderBy('id','DESC')->get();
      // dd($data['jadwal_operasi']);
      return view('displaytempattidur.display_operasi', compact('data'));
    }

    public function displayRuangan(){
        $data['beds']   = Bed::where('hidden', 'N')->get();
        $data['rooms']  = Kamar::with('bed')->where('hidden', 'N')->get();
        return view('displaytempattidur.display_ruangan', $data);

    }
}
