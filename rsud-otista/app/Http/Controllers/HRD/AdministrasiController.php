<?php

namespace App\Http\Controllers\HRD;

use App\HRD\HrdAdministrasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HRD\HrdBiodata;
use Auth;
use Validator;
use Yajra\DataTables\DataTables;
use File;
use Image;
use Flashy;
use Laracasts\Flash\Flash;
use Modules\Pegawai\Entities\Pegawai;
use DB;

class AdministrasiController extends Controller
{

    // SURAT MASUK
    public function suratMasuk()
    {
        $data['data'] = HrdAdministrasi::where('type','surat_masuk')->get();
        return view( 'hrd.administrasi.surat-masuk.index',$data);
    }

    public function suratMasukByTanggal(Request $request)
    {
        $data['data'] = HrdAdministrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->where('type','surat_masuk')->get();
        return view( 'hrd.administrasi.surat-masuk.index',$data);
    }

    public function createSuratMasuk($id = null)
    {
        $data['data'] = HrdAdministrasi::find($id);
        return view( 'hrd.administrasi.surat-masuk.form',$data);
    }
    public function deleteSuratMasuk($id = null)
    {
        HrdAdministrasi::find($id)->delete();
        Flashy::success('Data Telah Dihapus');
        return redirect()->back();
    }
    public function saveSuratMasuk(Request $request)
    {
        if($request->id){
            $hrdAdministrasi = HrdAdministrasi::where('id',$request->id)->first();;
        }else{
            $hrdAdministrasi = new HrdAdministrasi();

        }
        if(!empty($request->file('file'))){
            
			// menyimpan data file yang diupload ke variabel $file
            $file = $request->file('file');
        
            $filename = date('His').$file->getClientOriginalName(); // nama file
            $extension = $file->getClientOriginalExtension(); // ekstensi file
            $path = $file->getRealPath(); // real path
            $size = $file->getSize();// ukuran file
            $mime = $file->getMimeType(); // tipe mime
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'dokumen';
            $file->move($tujuan_upload,$filename);
            
            $hrdAdministrasi->format = $mime;
            $hrdAdministrasi->path  = $path;
            $hrdAdministrasi->size  = $size;
            $hrdAdministrasi->extension  = $extension;
            $hrdAdministrasi->filename  = $filename;
		}
        
        $hrdAdministrasi->nomor = $request->nomor;
        $hrdAdministrasi->nama  = $request->nama;
        
        $hrdAdministrasi->tanggal  = date('Y-m-d');
        $hrdAdministrasi->type  = $request->type;
        $hrdAdministrasi->user_id  = Auth::user()->id;
        $hrdAdministrasi->save();
        Flashy::success('Data Telah Disimpan');
        return redirect('hrd/administrasi/surat-masuk/');
        // return view( 'hrd.administrasi.surat-masuk.form');
    }

    public function previewSuratMasuk($id)
    {
       $data['data'] = HrdAdministrasi::find($id);
       return view( 'hrd.administrasi.surat-masuk.view',$data);
    }
    //  PRODUK HUKUM
    public function produkHukum()
    {
        $data['data'] = HrdAdministrasi::where('type','produk_hukum')->get();
        return view( 'hrd.administrasi.produk-hukum.index',$data);
    }

    public function produkHukumByTanggal(Request $request)
    {
        $data['data'] = HrdAdministrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->where('type','produk_hukum')->get();
        return view( 'hrd.administrasi.produk-hukum.index',$data);
    }

    public function createProdukHukum($id = null)
    {
        $data['data'] = HrdAdministrasi::find($id);
        return view( 'hrd.administrasi.produk-hukum.form',$data);
    }
    public function deleteProdukHukum($id = null)
    {
        HrdAdministrasi::find($id)->delete();
        Flashy::success('Data Telah Dihapus');
        return redirect()->back();
    }
    public function saveProdukHukum(Request $request)
    {
        if($request->id){
            $hrdAdministrasi = HrdAdministrasi::where('id',$request->id)->first();;
        }else{
            $hrdAdministrasi = new HrdAdministrasi();

        }
        if(!empty($request->file('file'))){
            
			// menyimpan data file yang diupload ke variabel $file
            $file = $request->file('file');
        
            $filename = date('His').$file->getClientOriginalName(); // nama file
            $extension = $file->getClientOriginalExtension(); // ekstensi file
            $path = $file->getRealPath(); // real path
            $size = $file->getSize();// ukuran file
            $mime = $file->getMimeType(); // tipe mime
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'dokumen';
            $file->move($tujuan_upload,$filename);
            
            $hrdAdministrasi->format = $mime;
            $hrdAdministrasi->path  = $path;
            $hrdAdministrasi->size  = $size;
            $hrdAdministrasi->extension  = $extension;
            $hrdAdministrasi->filename  = $filename;
		}
        
        $hrdAdministrasi->nomor = $request->nomor;
        $hrdAdministrasi->nama  = $request->nama;
        
        $hrdAdministrasi->tanggal  = date('Y-m-d');
        $hrdAdministrasi->type  = $request->type;
        $hrdAdministrasi->user_id  = Auth::user()->id;
        $hrdAdministrasi->save();
        Flashy::success('Data Telah Disimpan');
        return redirect('hrd/administrasi/produk-hukum/');
        // return view( 'hrd.administrasi.surat-masuk.form');
    }

    public function previewProdukHukum($id)
    {
       $data['data'] = HrdAdministrasi::find($id);
       return view( 'hrd.administrasi.produk-hukum.view',$data);
    }

    //  LAINNYA
    public function lain()
    {
        $data['data'] = HrdAdministrasi::where('type','lain_lain')->get();
        return view( 'hrd.administrasi.lain-lain.index',$data);
    }

    public function lainByTanggal(Request $request)
    {
        $data['data'] = HrdAdministrasi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->where('type','lain_lain')->get();
        return view( 'hrd.administrasi.lain-lain.index',$data);
    }

    public function createLain($id = null)
    {
        $data['data'] = HrdAdministrasi::find($id);
        return view( 'hrd.administrasi.lain-lain.form',$data);
    }
    public function deleteLain($id = null)
    {
        HrdAdministrasi::find($id)->delete();
        Flashy::success('Data Telah Dihapus');
        return redirect()->back();
    }
    public function saveLain(Request $request)
    {
        if($request->id){
            $hrdAdministrasi = HrdAdministrasi::where('id',$request->id)->first();;
        }else{
            $hrdAdministrasi = new HrdAdministrasi();

        }
        if(!empty($request->file('file'))){
            
			// menyimpan data file yang diupload ke variabel $file
            $file = $request->file('file');
        
            $filename = date('His').$file->getClientOriginalName(); // nama file
            $extension = $file->getClientOriginalExtension(); // ekstensi file
            $path = $file->getRealPath(); // real path
            $size = $file->getSize();// ukuran file
            $mime = $file->getMimeType(); // tipe mime
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'dokumen';
            $file->move($tujuan_upload,$filename);
            
            $hrdAdministrasi->format = $mime;
            $hrdAdministrasi->path  = $path;
            $hrdAdministrasi->size  = $size;
            $hrdAdministrasi->extension  = $extension;
            $hrdAdministrasi->filename  = $filename;
		}
        
        $hrdAdministrasi->nomor = $request->nomor;
        $hrdAdministrasi->nama  = $request->nama;
        
        $hrdAdministrasi->tanggal  = date('Y-m-d');
        $hrdAdministrasi->type  = $request->type;
        $hrdAdministrasi->user_id  = Auth::user()->id;
        $hrdAdministrasi->save();
        Flashy::success('Data Telah Disimpan');
        return redirect('hrd/administrasi/lain/');
        // return view( 'hrd.administrasi.surat-masuk.form');
    }

    public function previewLain($id)
    {
       $data['data'] = HrdAdministrasi::find($id);
       return view( 'hrd.administrasi.lain-lain.view',$data);
    }
    
}
