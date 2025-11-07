<?php

namespace App\Http\Controllers\Emr;

use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\User;
use Intervention\Image\Facades\Image;
use Auth;
use PDF;
use Modules\Pegawai\Entities\Pegawai;

class EmrPenilaianController extends Controller
{




	public function status(Request $r, $unit, $registrasi_id)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'padiatric')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPenilaian();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->padiatric  = json_encode($r->padiatric);
			$emr->type  	= 'padiatric';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.penilaian.status', $data);
	}

	public function airway(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';



		return view('emr.modules.primary_airway', $data);
	}

	public function breathing(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';



		return view('emr.modules.primary_breathing', $data);
	}

	public function circulation(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';



		return view('emr.modules.primary_circulation', $data);
	}

	public function disability(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrRiwayat::where('pasien_id', $data['reg']->pasien_id)->first();
		$data['alergi'] 		   = MasterRiwayatKesehatan::where('tipe', 'A')->get();
		$data['infopasien'] 	   = 'Penerjemah Bahasa';



		return view('emr.modules.primary_disability', $data);
	}
	public function diagnosis(Request $r, $unit, $registrasi_id)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'diagnosis')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPenilaian();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->diagnosis  = json_encode($r->diagnosis);
			$emr->type  	= 'diagnosis';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.penilaian.diagnosis', $data);
	}
	public function nyeri(Request $r, $unit, $registrasi_id)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'nyeri')->orderBy('id', 'DESC')->get();

		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPenilaian();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->nyeri  = json_encode($r->nyeri);
			$emr->type  	= 'nyeri';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.penilaian.nyeri', $data);
	}
	public function fisik(Request $r, $unit, $registrasi_id, $cppt_id = null)
	{
		// public function fisik(Request $r,$unit,$registrasi_id){		

		// dd($data['riwayat']);

		if ($r->method() == 'POST') {
			$emr = new EmrInapPenilaian();
			$emr->pasien_id = 1234;
			$emr->registrasi_id = 112;
			$emr->user_id = Auth::user()->id;
			$emr->type = 'fisik';

			// Save image to public folder

			if ($r->hasFile('drawing')) {
				$image = $r->file('drawing');
				if ($image->isValid()) {
					$filename = time() . '.' . $image->getClientOriginalExtension();
					$path = public_path('images/' . $filename);
					Image::make($image->getRealPath())->save($path);
					$emr->image = "P";
				} else {
					// handle file upload error
					return redirect()->back()->withErrors(['error' => 'File upload failed']);
				}
			}



			// Save pemeriksaan to database
			$emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.fisik', $data);
	}

	public function fisikPost(Request $r)
	{

		$unit = $r->unit;
		if ($r->cppt_id) {
			$dataEmr = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'fisik')->first();
		} else {
			if($unit == 'inap'){
				$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'fisik-inap-dewasa')->first();
			}else{
				$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'fisik')->first();
			}
		}

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			// $emr->type = 'fisik';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect()->back();
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			if($unit == 'inap'){
				$emr->type = 'fisik-inap-dewasa';
			}else{
				$emr->type = 'fisik';
			}
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.penilaian.fisik', $data);
	}

	public function prostodonti(Request $r, $unit, $registrasi_id, $cppt_id = null)
	{

		if ($r->method() == 'POST') {
			$emr = new EmrInapPenilaian();
			$emr->pasien_id = 1234;
			$emr->registrasi_id = 112;
			$emr->user_id = Auth::user()->id;
			$emr->type = 'prostodonti';

			// Save image to public folder

			if ($r->hasFile('drawing')) {
				$image = $r->file('drawing');
				if ($image->isValid()) {
					$filename = time() . '.' . $image->getClientOriginalExtension();
					$path = public_path('images/' . $filename);
					Image::make($image->getRealPath())->save($path);
					$emr->image = "P";
				} else {
					// handle file upload error
					return redirect()->back()->withErrors(['error' => 'File upload failed']);
				}
			}



			// Save pemeriksaan to database
			$emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'prostodonti')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'prostodonti')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();
		$data['gambar'] 		   = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
		$data['ketGambar'] 		   = $data['gambar'] ? json_decode($data['gambar']->fisik, true) : null;

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.prostodonti', $data);
	}

	public function prostodontiPost(Request $r)
	{

		$unit = $r->unit;
		if ($r->cppt_id) {
			$dataEmr = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'prostodonti')->first();
		} else {
			if($unit == 'inap'){
				$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'prostodonti')->first();
			}else{
				$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'prostodonti')->first();
			}
		}

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect()->back();
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			if($unit == 'inap'){
				$emr->type = 'prostodonti';
			}else{
				$emr->type = 'prostodonti';
			}
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.penilaian.prostodonti', $data);
	}

	public function cetakProstodonti($registrasi_id)
	{
		$data['registrasi'] = Registrasi::find($registrasi_id);
		$data['penilaian'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->where('type', 'prostodonti')->first();
		if ($data['penilaian']) {
			$data['cetak']      = json_decode(@$data['penilaian']->fisik);
			$data['pasien']     = Pasien::find($data['penilaian']->pasien_id);
			$data['dokter']     = Pegawai::find($data['registrasi']->dokter_id);
			$data['gambar'] 	= EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
				if ($data['gambar'] && $data['gambar']->fisik != null) {
				$data['ketGambar'] = json_decode($data['gambar']->fisik, true);
				}
			$pdf = PDF::loadView('emr.modules.penilaian._cetak_prostodonti', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} else {
			Flashy::error('Tidak informed consent!');
			return redirect()->back();
		}
	}

	public function gigi(Request $r, $unit, $registrasi_id, $cppt_id = null)
	{
		// public function gigi(Request $r,$unit,$registrasi_id){		

		// dd($cppt_id);

		if ($r->method() == 'POST') {
			$emr = new EmrInapPenilaian();
			$emr->fisik = $r->fisik;
			$emr->pasien_id = 1234;
			$emr->registrasi_id = 112;
			$emr->user_id = Auth::user()->id;
			$emr->type = 'gigi';

			// Save image to public folder

			if ($r->hasFile('drawing')) {
				$image = $r->file('drawing');
				if ($image->isValid()) {
					$filename = time() . '.' . $image->getClientOriginalExtension();
					$path = public_path('images/' . $filename);
					Image::make($image->getRealPath())->save($path);
					$emr->image = "P";
				} else {
					// handle file upload error
					return redirect()->back()->withErrors(['error' => 'File upload failed']);
				}
			}



			// Save pemeriksaan to database
			$emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'gigi')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'gigi')->orderBy('id', 'DESC')
			->selectRaw('image as image, fisik as fisik')
			->get();

		// dd($data);

		return view('emr.modules.penilaian.gigi', $data);
	}

	public function gigiPost(Request $r)
	{

		if ($r->cppt_id) {
			$dataEmrGigi = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'gigi')->first();
		} else {
			$dataEmrGigi = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'gigi')->first();
		}

		if ($dataEmrGigi != null) {

			// dd($r);


			$emr = $dataEmrGigi;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'gigi';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect()->back();
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'gigi';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}







		return view('emr.modules.penilaian.gigi');
	}


	public function obgyn(Request $r, $unit, $registrasi_id, $cppt_id = null)
	{
		// public function obgyn(Request $r,$unit,$registrasi_id){		

		// dd($cppt_id);

		if ($r->method() == 'POST') {
			$emr = new EmrInapPenilaian();
			$emr->pasien_id = 1234;
			$emr->registrasi_id = 112;
			$emr->user_id = Auth::user()->id;
			$emr->type = 'obgyn';

			// Save image to public folder

			if ($r->hasFile('drawing')) {
				$image = $r->file('drawing');
				if ($image->isValid()) {
					$filename = time() . '.' . $image->getClientOriginalExtension();
					$path = public_path('images/' . $filename);
					Image::make($image->getRealPath())->save($path);
					$emr->image = "P";
				} else {
					// handle file upload error
					return redirect()->back()->withErrors(['error' => 'File upload failed']);
				}
			}



			// Save pemeriksaan to database
			$emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		$data['cppt_id']		   = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'obgyn')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'obgyn')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.obgyn', $data);
	}

	public function obgynPost(Request $r)
	{
		if ($r->cppt_id) {
			$emrObgyn = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'obgyn')->first();
		} else {
			$emrObgyn = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'obgyn')->first();
		}

		if ($emrObgyn != null) {

			// dd($r);


			$emr = $emrObgyn;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'obgyn';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect()->back();
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'obgyn';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.penilaian.obgyn');
	}

	public function hemodialisis($unit, $registrasi_id, $cppt_id = null)
	{
		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		  		 = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'hemodialisis')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'hemodialisis')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.hemodialisis', $data);
	}

	public function hemodialisisPost(Request $r)
	{
		if ($r->cppt_id) {
			$dataEmr = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'hemodialisis')->first();
		} else {
			$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'hemodialisis')->first();
		}

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'hemodialisis';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect('emr-soap/pemeriksaan/hemodialisis/' . $r->unit . '/' . $r->registrasi_id);
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'hemodialisis';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect('emr-soap/pemeriksaan/hemodialisis/' . $r->unit . '/' . $r->registrasi_id);
		}
	}

	public function mata1($unit, $registrasi_id, $cppt_id = null)
	{
		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		  		 = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mata1')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mata1')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.mata1', $data);
	}

	public function mata1Post(Request $r)
	{
		if ($r->cppt_id) {
			$dataEmr = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'mata1')->first();
		} else {
			$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'mata1')->first();
		}

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'mata1';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect('emr-soap/pemeriksaan/mata/' . $r->unit . '/' . $r->registrasi_id);
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'mata1';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect('emr-soap/pemeriksaan/mata/' . $r->unit . '/' . $r->registrasi_id);
		}
	}

	public function mata2($unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		  		 = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mata2')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mata2')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.mata2', $data);
	}

	public function mata2Post(Request $r)
	{
		$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->where('type', 'mata2')->first();

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'mata2';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect('emr-soap/pemeriksaan/mata/' . $r->unit . '/' . $r->registrasi_id);
		}


		if ($r->method() == 'POST' || $r->registrasi_id == null) {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'mata2';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect('emr-soap/pemeriksaan/mata/' . $r->unit . '/' . $r->registrasi_id);
		}
	}

	public function mata3($unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		  		 = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mata3')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mata3')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.mata3', $data);
	}

	public function mata3Post(Request $r)
	{
		$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->where('type', 'mata3')->first();

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'mata3';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect('emr-soap/pemeriksaan/mata/' . $r->unit . '/' . $r->registrasi_id);
		}


		if ($r->method() == 'POST' || $r->registrasi_id == null) {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'mata3';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect('emr-soap/pemeriksaan/mata/' . $r->unit . '/' . $r->registrasi_id);
		}
	}

	public function paru($unit, $registrasi_id, $cppt_id = null)
	{
		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		  		 = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'paru')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'paru')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.paru', $data);
	}

	public function paruPost(Request $r)
	{
		if ($r->cppt_id) {
			$dataEmr = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'paru')->first();
		} else {
			$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'paru')->first();
		}

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'paru';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect('emr-soap/pemeriksaan/paru/' . $r->unit . '/' . $r->registrasi_id);
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'paru';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect('emr-soap/pemeriksaan/paru/' . $r->unit . '/' . $r->registrasi_id);
		}
	}

	public function kulit($unit, $registrasi_id, $cppt_id = null)
	{
		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		  		 = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'kulit')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'kulit')->orderBy('id', 'DESC')
			->selectRaw('image as image')
			->get();

		// dd($data['dataImage'][0]["image"]);

		return view('emr.modules.penilaian.kulit', $data);
	}

	public function kulitPost(Request $r)
	{
		if ($r->cppt_id) {
			$dataEmr = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'kulit')->first();
		} else {
			$dataEmr = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'kulit')->first();
		}

		if ($dataEmr != null) {

			// dd($r);


			$emr = $dataEmr;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'kulit';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return response()->json(['sukses' => true]);
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'kulit';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			// Save pemeriksaan to database
			// $emr->fisik = json_encode($r->pemeriksaan);
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return response()->json(['sukses' => true]);
		}
	}

	public function bedahMulut(Request $r, $unit, $registrasi_id, $cppt_id = null)
	{

		$data['cppt_id']           = $cppt_id;
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'bedahMulut')->orderBy('id', 'DESC')->get();
		$data['dataImage']         = EmrInapPenilaian::where('pasien_id', $data['reg']->pasien_id)->where('type', 'bedahMulut')->orderBy('id', 'DESC')
			->selectRaw('image as image, fisik as fisik')
			->get();

		// dd($data);

		return view('emr.modules.penilaian.bedahMulut', $data);
	}

	public function bedahMulutPost(Request $r)
	{

		if ($r->cppt_id) {
			$dataEmrBedahMulut = EmrInapPenilaian::where('cppt_id', $r->cppt_id)->where('type', 'bedah-mulut')->first();
		} else {
			$dataEmrBedahMulut = EmrInapPenilaian::where('registrasi_id', $r->registrasi_id)->whereNull('cppt_id')->where('type', 'bedah-mulut')->first();
		}

		if ($dataEmrBedahMulut != null) {

			// dd($r);


			$emr = $dataEmrBedahMulut;
			// dd($emr);
			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			// $emr->cppt_id = $r->cppt_id;
			$emr->type = 'bedah-mulut';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}
			// $emr->update();

			$emr->update();

			Flashy::success('Record berhasil di update');
			return redirect()->back();
		} else {
			// dd($r->all());
			$emr = new EmrInapPenilaian();

			$emr->pasien_id = $r->pasien_id;
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id = Auth::user()->id;
			$emr->cppt_id = @$r->cppt_id;
			$emr->type = 'bedah-mulut';
			$emr->fisik = $r->fisikKeterangan;

			// Save image to public folder

			if ($r->drawing) {
				$imageData = $r->input('drawing');
				$filename = time() . '.png';
				$path = public_path('images/' . $filename);
				$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
				file_put_contents($path, $image);
				$emr->image = $filename;
			}

			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.penilaian.bedahMulut');
	}
}
