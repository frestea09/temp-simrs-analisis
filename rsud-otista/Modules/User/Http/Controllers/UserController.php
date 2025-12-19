<?php

namespace Modules\User\Http\Controllers;

use App\Role;
use App\User;
use Auth;
use DB;
use Image;
use Flashy;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pegawai\Entities\Pegawai;

class UserController extends Controller {
	public function index() {
		$user = User::all();
		return view('user::index', compact('user'))->with('no', 1);
	}

	public function create() {
		$role = Role::pluck('display_name', 'name');
		$pegawai = Pegawai::pluck('nama', 'nama');
		$poli = \Modules\Poli\Entities\Poli::all();
		$gudang = \App\LogistikGudang::all();
		return view('user::create', compact('role', 'pegawai', 'poli','gudang'));
	}

	public function store(Request $request) {
		request()->validate([
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
			'role' => 'required',
		]);

		// $gudang = !empty($request['gudang_id']) ? implode(',', $request['gudang_id']) : '';
		
		$user = User::create([
			'name' => $request['name'],
			'email' => $request['email'],
			'kelompokkelas_id' => 	$request['kelompokkelas_id'],
			'poli_id' => $request['poli_id'],
			'gudang_id'	=> $request['gudang_id'],
			'password' => bcrypt($request['password']),
		]);
		$pegawai = Pegawai::where('nama',$request['name'])->first();
		if($pegawai){
			$pegawai->user_id = $user->id;
			$pegawai->save();
		}
		
		$role = Role::where('name', $request['role'])->first();
		foreach ($request['role'] as $d) {
			$role = \App\Role::where('name', $d)->first();
			$user->attachRole($role);
		}
		Flashy::success('Data user berhasil ditambahkan');
		return redirect()->route('user');
	}

	public function show($id) {
		if(Auth::user()->id != $id){
			Flashy::warning('Anda Tidak berhak akses data ini');
			return redirect('/');
		}
		
		$user    = User::find($id);
		$cek     = Pegawai::where('user_id', $user->id)->first();
		
		if(!$cek){
			Flashy::warning('Data Tidak Singkron, Hubungi Team Simrs');
			return redirect()->back();
		}else{
			$pegawai = Pegawai::where('user_id',$id)->first();
		}
	
		return view('user::show', compact('user','pegawai'));
	}

	public function updateUser(Request $request) {

        $getid           = DB::table('pegawais')->where('user_id', Auth::user()->id)->first();
		$pegawai         = Pegawai::find($getid->id);
	    // dd($request->sip);
		if (!$request['password']) {
			DB::table('users')->where('id', Auth::user()->id)->update(['name' => $request['name']]);
			Flashy::success('Data berhasil diubah pengguna' . Auth::user()->name);
		} else {
			DB::table('users')->where('id', Auth::user()->id)->update(['name' => $request['name'], 'password' => bcrypt($request['password'])]);
			Flashy::success('Nama lengkap berhasil di ubah jadi ' . Auth::user()->name . ' password jadi ' . $request['password']);
		}

		if(!empty($request->file('foto'))){
			$image = time().$request->file('foto')->getClientOriginalName();
			$request->file('foto')->move('images/', $image);
			$img   = Image::make(public_path().'/images/'.$image)->resize(300,300);
			$img->save();
		}else{
		    $image = $pegawai->foto_profile;
		}

		if(!empty($request->file('ttd'))){
			$imagettd = time().$request->file('ttd')->getClientOriginalName();
			$request->file('ttd')->move('images/', $imagettd);
			$img   = Image::make(public_path().'/images/'.$imagettd)->resize(300,300);
			$img->save();
		}else{
		    $imagettd = $pegawai->tanda_tangan;
		}

		$tgllahir = empty($request->tgllahir) ? null : Carbon::parse($request->tgllahir)->format('Y-m-d');
        // $data                 = $request->all();
		$lahir                = $tgllahir;
		$pegawai->sip          = $request->sip;
		$pegawai->nik          = $request->nik;
		$pegawai->tgllahir     = $lahir;
		$pegawai->tmplahir     = $request->tmplahir;
		$pegawai->kelamin      = $request->kelamin;
		$pegawai->agama        = $request->agama;
		$pegawai->alamat       = $request->alamat;
		$pegawai->sip_awal     = $request->sip_awal;
		$pegawai->sip_akhir    = $request->sip_akhir;
		$pegawai->str          = $request->str;
		// $data['foto_profile'] = $image;
		$pegawai->foto_profile = $image;
		$pegawai->tanda_tangan = $imagettd;
		$pegawai->status_tte   = $request->status_tte;
		$pegawai->save();
		// $pegawai->update($data);

		return redirect('user/' . Auth::user()->id . '/show');
	}

	public function edit($id) {
		// if(Auth::user()->id !== 1){
			// if(Auth::user()->id !== $id){
			// 	Flashy::warning('Anda Tidak berhak akses data ini');
			// 	return redirect('/');
			// }
		// }
		$user = User::find($id);
		$role = Role::select('display_name', 'id')->get();
		$poli = \Modules\Poli\Entities\Poli::all();
		$gudang = \App\LogistikGudang::all();
		return view('user::edit', compact('user', 'role', 'poli','gudang'));
	}


	public function hapus($id) {
		$user = User::find($id);
		$user->delete();

		$pegawai = Pegawai::where('user_id', '=', $id)->first();
		$pegawai->delete();
		Flashy::success('Data user berhasil di hapus');
		return response($user);
	}



	public function update(Request $request, $id) {
		// dd($request->all());
		request()->validate([
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users,email,' . $id,
			'password' => 'nullable|min:6|confirmed',
			'role' => 'required',
		]);

		$user = User::find($id);
		$password = !empty($request['password']) ? bcrypt($request['password']) : $user->password;
		// $poliupdate = !empty($request['poli_id']) ? implode($request['poli_id'], ',') : $user->poli_id;
		$poliupdate = !empty($request['poli_id']) ? implode(',',$request['poli_id']) : $user->poli_id;
		$kelas = !empty($request['kelompokkelas_id']) ? implode(',',$request['kelompokkelas_id']) : $user->coder_nik;
		$user->update([
			'name' => $request['name'],
			'email' => $request['email'],
			'kelompokkelas_id' => @$request['kelompokkelas_id'][0],
			'poli_id' => $poliupdate,
			'coder_nik' => $kelas,
			'gudang_id'	=> $request['gudang_id'],
			'password' => $password,
			'is_edit' => json_encode($request['roleaksi']),
		]);
		foreach ($user->roles as $d) {
			$user->detachRole($d);
		}
		foreach ($request['role'] as $d) {
			$role = \App\Role::where('name', $d)->first();
			$user->attachRole($role);
		}

		Flashy::success('Data user berhasil diupdate');
		return redirect()->route('user');
	}

	public function getUser($id) {
		$user = User::findOrFail($id);
		$user['role'] = $user->role;
		return $user;
	}

	public function destroy() {
	}
}
