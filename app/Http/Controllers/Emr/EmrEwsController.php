<?php

namespace App\Http\Controllers\Emr;

use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use App\EmrEws;
use Auth;

class EmrEwsController extends Controller
{
	// EWS DEWASA
	public function dewasa(Request $r,$unit,$registrasi_id, $id_emr = NULL, $method = NULL)
	{	
		// dd($method);
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		$data['all_resume']     = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-dewasa')->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrEws::find($id_emr);
		$data['ewss'] = [];
		
		if($id_emr){
			if($data['emr']){
				$data['ewss'] = json_decode($data['emr']->diagnosis,true);
			}

			if($method == 'delete'){
				$emr = EmrEws::where('id',$id_emr)->delete();
				Flashy::success('Record berhasil dihapus');
			 	return redirect()->back();
			}
		}
		
		// dd($data['ewss']);

		if ($r->method() == 'POST')
		{
			if($r->emr_id){
				$emr = EmrEws::where('id',$r->emr_id)->first();
			}else{
				$emr = new EmrEws();
	
			}
			 $emr->pasien_id  = $r->pasien_id;
			 $emr->tanggal  = $r->tanggal;
			 $emr->waktu  = $r->waktu;
			 $emr->registrasi_id  = $r->registrasi_id;
			 $emr->user_id  = Auth::user()->id;
			 $emr->type  	= 'ews-dewasa';
			 $emr->diagnosis  	= json_encode($r->formulir);
			 $emr->save();
			 
			 Flashy::success('Record berhasil disimpan');
			 return redirect()->back();
		}

		return view('emr.modules.ews.dewasa', $data);
	}

	// EWS MATERNAL
	public function maternal(Request $r,$unit,$registrasi_id, $id_emr = NULL, $method = NULL)
	{	
		// dd($method);
		// dd(pernapasan_ews_maternal());
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		$data['all_resume']     = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-maternal')->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrEws::find($id_emr);
		$data['ewss'] = [];
		
		if($id_emr){
			if($data['emr']){
				$data['ewss'] = json_decode($data['emr']->diagnosis,true);
			}

			if($method == 'delete'){
				$emr = EmrEws::where('id',$id_emr)->delete();
				Flashy::success('Record berhasil dihapus');
			 	return redirect()->back();
			}
		}
		
		// dd($data['ewss']);

		if ($r->method() == 'POST')
		{
			if($r->emr_id){
				$emr = EmrEws::where('id',$r->emr_id)->first();
			}else{
				$emr = new EmrEws();
	
			}
			 $emr->pasien_id  = $r->pasien_id;
			 $emr->tanggal  = $r->tanggal;
			 $emr->waktu  = $r->waktu;
			 $emr->registrasi_id  = $r->registrasi_id;
			 $emr->user_id  = Auth::user()->id;
			 $emr->type  	= 'ews-maternal';
			 $emr->diagnosis  	= json_encode($r->formulir);
			 $emr->save();
			 
			 Flashy::success('Record berhasil disimpan');
			 return redirect()->back();
		}

		return view('emr.modules.ews.maternal', $data);
	}

	// EWS Anak
	public function anak(Request $r,$unit,$registrasi_id, $id_emr = NULL, $method = NULL)
	{	
		// dd($method);
		// dd(pernapasan_ews_maternal());
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		$data['all_resume']     = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-anak')->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrEws::find($id_emr);
		$data['ewss'] = [];
		
		if($id_emr){
			if($data['emr']){
				$data['ewss'] = json_decode($data['emr']->diagnosis,true);
			}

			if($method == 'delete'){
				$emr = EmrEws::where('id',$id_emr)->delete();
				Flashy::success('Record berhasil dihapus');
			 	return redirect()->back();
			}
		}
		
		// dd($data['ewss']);

		if ($r->method() == 'POST')
		{
			if($r->emr_id){
				$emr = EmrEws::where('id',$r->emr_id)->first();
			}else{
				$emr = new EmrEws();
	
			}
			 $emr->pasien_id  = $r->pasien_id;
			 $emr->tanggal  = $r->tanggal;
			 $emr->waktu  = $r->waktu;
			 $emr->registrasi_id  = $r->registrasi_id;
			 $emr->user_id  = Auth::user()->id;
			 $emr->type  	= 'ews-anak';
			 $emr->diagnosis  	= json_encode($r->formulir);
			 $emr->save();
			 
			 Flashy::success('Record berhasil disimpan');
			 return redirect()->back();
		}

		return view('emr.modules.ews.anak', $data);
	}

	// EWS Neonatus
	public function neonatus(Request $r,$unit,$registrasi_id, $id_emr = NULL, $method = NULL)
	{	
		$data['registrasi_id']  = $registrasi_id;
		$data['unit']           = $unit;
		$data['reg']            = Registrasi::find($registrasi_id);
		$data['all_resume']     = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-neonatus')->orderBy('id', 'DESC')->get();
		$data['emr']			= EmrEws::find($id_emr);
		$data['ewss'] = [];
		
		if($id_emr){
			if($data['emr']){
				$data['ewss'] = json_decode($data['emr']->diagnosis,true);
			}

			if($method == 'delete'){
				$emr = EmrEws::where('id',$id_emr)->delete();
				Flashy::success('Record berhasil dihapus');
			 	return redirect()->back();
			}
		}
		
		// dd($data['ewss']);

		if ($r->method() == 'POST')
		{
			if($r->emr_id){
				$emr = EmrEws::where('id',$r->emr_id)->first();
			}else{
				$emr = new EmrEws();
	
			}
			 $emr->pasien_id  = $r->pasien_id;
			 $emr->tanggal  = $r->tanggal;
			 $emr->waktu  = $r->waktu;
			 $emr->registrasi_id  = $r->registrasi_id;
			 $emr->user_id  = Auth::user()->id;
			 $emr->type  	= 'ews-neonatus';
			 $emr->diagnosis  	= json_encode($r->formulir);
			 $emr->save();
			 
			 Flashy::success('Record berhasil disimpan');
			 return redirect()->back();
		}

		return view('emr.modules.ews.neonatus', $data);
	}

	public function getEws($registrasi_id)
	{
		$data['ews'] = EmrEws::where('registrasi_id', $registrasi_id)->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		return view('emr.modules.ews.dataEws', $data);
	}

	
}
