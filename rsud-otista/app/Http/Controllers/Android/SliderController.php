<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Android\slider;
use MercurySeries\Flashy\Flashy;
use Image;

class SliderController extends Controller
{
    public function index()
    {
        $data['slider'] = slider::all();
        return view('android.slider.index', compact('data'));
    }

    public function store( Request $request)
    {
        $validate = [
            'gambar' => 'required',
        ];
        $request->validate($validate);

        $image = time().$request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('images/slider/', $image);
        $img = Image::make(public_path().'/images/slider/'.$image);
        $img->save();
        $content_path = '/images/slider/';

        $data = [
            "slider_path" => $content_path,
            "slider_img" => $image
        ];

        slider::create($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('android/slider');
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'gambar' => 'required',
        ];
        $request->validate($validate);

        $find = slider::find($id);
        
        $image = time().$request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('images/slider/', $image);
        $img = Image::make(public_path().'/images/slider/'.$image);
        $img->save();
        $content_path = '/images/slider/';

        $data = [
            "slider_path" => $content_path,
            "slider_img" => $image
        ];

        $find->update($data);

        Flashy::success('Data Berhasil Diperbarui !');
        return redirect('android/slider');
    }

    public function destroy($id)
    {
        $find = slider::find($id);
        $find->delete();

        Flashy::success('Data Berhasil Dihapus !');
        return redirect('/android/slider');
    }
}
