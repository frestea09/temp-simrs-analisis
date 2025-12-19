<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Android\android_content;
use App\Android\android_content_type;
use MercurySeries\Flashy\Flashy;
use Auth;
use Image;

class PagesController extends Controller
{
    public function index()
    {
        $data = android_content_type::all();
        return view('android.index', compact('data'));
    }

    public function create($id)
    {
        return view('android.pages.form', compact('id'));
    }

    public function show($type)
    {   
        $type = android_content_type::where('type_slug', $type)->first();

        if( $type == null ) {
            Flashy::error('Type Halaman Tidak Ditemukan !'); 
            return redirect('android/pages');
        }

        $query = android_content::where('type_id',$type->id);

        if( $type->type_slug == "berita" or $type->type_slug == "pelayanan" ) $data['content'] = $query->paginate(6);
        else $data['content'] = $query->first();

        $data['type_nama'] = $type->type_nama;
        $data['type_slug'] = $type->type_slug;
        $data['type_id'] = $type->id;

        return view('android.pages.index', compact('data'));
    }

    public function store( Request $request)
    {   
        $validate = [
            'content_title' => 'required|max:255',
            'content_description' => 'required',
        ];
        // 3: berita, 6:pelayanan
        if( $request->type_id == 3 || $request->type_id == 6 ) {
            $validate['content_thumbnail'] = 'required';
        }
        $request->validate($validate);

        $data = [
            "content_title" => $request->content_title,
            "content_description" => $request->content_description,
            "type_id" => $request->type_id,
            "content_author" => isset(auth()->user()->id) ? auth()->user()->id : null,
        ];
        if(!empty($request->file('content_thumbnail'))){
            $image = time().$request->file('content_thumbnail')->getClientOriginalName();
            $request->file('content_thumbnail')->move('images/content/', $image);
            $img = Image::make(public_path().'/images/content/'.$image);
            $img->save();
            $content_path = '/images/content/';
        }else{
          $image = '';
          $content_path = '';
        }
        $data['content_thumbnail'] = $image;
        $data['content_path'] = $content_path;

        android_content::create($data);

        Flashy::success('Data Berhasil Ditambahkan !');
        return redirect('android/pages');
    }

    public function edit($id)
    {
        $data = android_content::findOrFail($id);
        return view('android.pages.form',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'content_title' => 'required|max:255',
            'content_description' => 'required',
        ];
        // 3: berita, 6:pelayanan
        if( $request->type_id == 3 || $request->type_id == 6 ) {
            $validate['content_thumbnail'] = 'required';
        }
        $request->validate($validate);

        $find = android_content::find($id);
        $data = [
            "content_title" => $request->content_title,
            "content_description" => $request->content_description,
            "content_author" => isset(auth()->user()->id) ? auth()->user()->id : null
        ];
        if(!empty($request->file('content_thumbnail'))){
            $image = time().$request->file('content_thumbnail')->getClientOriginalName();
            $request->file('content_thumbnail')->move('images/content/', $image);
            $img = Image::make(public_path().'/images/content/'.$image);
            $img->save();
            $content_path = '/images/content/';
        }else{
          $image = $find->content_thumbnail;
          $content_path = $find->content_path;
        }

        $data['content_thumbnail'] = $image;
        $data['content_path'] = $content_path;
        $find->update($data);

        Flashy::success('Data '.$find->content_title.' Berhasil Diperbarui !');
        return redirect('android/pages');
    }

    public function destroy($id)
    {
        $find = android_content::findOrFail($id);
        $find->delete();
        Flashy::success('Data Berhasil Dihapus !');
        return redirect('android/pages');
    }
}
