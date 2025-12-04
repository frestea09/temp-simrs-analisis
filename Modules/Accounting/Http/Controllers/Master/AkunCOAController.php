<?php

namespace Modules\Accounting\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use MercurySeries\Flashy\Flashy;
use Modules\Accounting\Entities\Master\AkunClass;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Accounting\Entities\Master\AkunSubClass;
use Modules\Accounting\Entities\Master\AkunSubType;
use Modules\Accounting\Entities\Master\AkunType;

class AkunCOAController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getAkunCOA = AkunCOA::orderBy('code')->get()->toArray();

        $data['coa'] = $getAkunCOA;

        return view('accounting::master.akun.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::master.akun.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'code' => 'required|min:9|max:9',
            'nama' => 'required',
            'status' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        // process the form
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $post = $request->except('_token');

            DB::beginTransaction();

            try {
                $code = str_split($post['code']);
                foreach ($code as $key => $value) {
                    $post['akun_code_' . ($key + 1)] = $value;
                }

                AkunCOA::create($post);
                DB::commit();
                Flashy::success('Data Akun COA Berhasil Di Tambahkan');
                return redirect(route('akun_coa.index'));
            } catch (\Exception $e) {
                DB::rollback();
                Flashy::error($e->getMessage());
                return Redirect::back();
            }
        }
    }

    public function import(Request $request)
    {
        $rules = array(
            'akun' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        // process the form
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            DB::beginTransaction();

            try {
                Excel::load(Input::file('akun'), function ($reader) {
                    $data = $reader->noHeading()->toArray();
                    unset($data[0]);
                    unset($data[1]);
                    foreach ($data as $row) {
                        if (is_null($row[0])) {
                            continue;
                        }
                        if (is_null($row[3])) {
                            $row[3] = '';
                        } else {
                            if ((int) $row[3] > 9) {
                                $row[3] = $row[3];
                            } else {
                                $row[3] = implode('', ['0', $row[3]]);
                            }
                        }
                        if (is_null($row[4])) {
                            $row[4] = '';
                        } else {
                            if ((int) $row[4] > 9) {
                                $row[4] = $row[4];
                            } else {
                                $row[4] = implode('', ['0', $row[4]]);
                            }
                        }
                        if (is_null($row[1]) && is_null($row[2]) && empty($row[3]) && empty($row[4])) {
                            AkunType::updateOrCreate(
                                [
                                    'code'      => implode('', [(string) $row[0]])
                                ],
                                [
                                    'code'      => implode('', [(string) $row[0]]),
                                    'nama'      => (is_null($row[5])) ? '-' : $row[5]
                                ]
                            );
                            continue;
                        } elseif (is_null($row[2]) && empty($row[3]) && empty($row[4])) {
                            $getAkunType = AkunType::where('code', implode('', [(string) $row[0]]))->first();
                            AkunSubType::updateOrCreate(
                                [
                                    'code'          => implode('', [(string) $row[0], (string) $row[1]])
                                ],
                                [
                                    'akun_type_id'  => $getAkunType->id,
                                    'code'          => implode('', [(string) $row[0], (string) $row[1]]),
                                    'nama'          => (is_null($row[5])) ? '-' : $row[5]
                                ]
                            );
                            continue;
                        } elseif (empty($row[3]) && empty($row[4])) {
                            $getAkunType = AkunType::where('code', implode('', [(string) $row[0]]))->first();
                            $getAkunSubType = AkunSubType::where('code', implode('', [(string) $row[0], (string) $row[1]]))->first();
                            AkunClass::updateOrCreate(
                                [
                                    'code'              => implode('', [(string) $row[0], (string) $row[1], (string) $row[2]])
                                ],
                                [
                                    'akun_type_id'      => $getAkunType->id,
                                    'akun_sub_type_id'  => $getAkunSubType->id,
                                    'code'              => implode('', [(string) $row[0], (string) $row[1], (string) $row[2]]),
                                    'nama'              => (is_null($row[5])) ? '-' : $row[5]
                                ]
                            );
                            continue;
                        } elseif (empty($row[4])) {
                            $getAkunType = AkunType::where('code', implode('', [(string) $row[0]]))->first();
                            $getAkunSubType = AkunSubType::where('code', implode('', [(string) $row[0], (string) $row[1]]))->first();
                            $getAkunClass = AkunClass::where('code', implode('', [(string) $row[0], (string) $row[1], (string) $row[2]]))->first();
                            AkunSubClass::updateOrCreate(
                                [
                                    'code'              => implode('', [(string) $row[0], (string) $row[1], (string) $row[2], (string) $row[3]])
                                ],
                                [
                                    'akun_type_id'      => $getAkunType->id,
                                    'akun_sub_type_id'  => $getAkunSubType->id,
                                    'akun_class_id'     => $getAkunClass->id,
                                    'code'              => implode('', [(string) $row[0], (string) $row[1], (string) $row[2], (string) $row[3]]),
                                    'nama'              => (is_null($row[5])) ? '-' : $row[5],
                                    'saldo_normal'      => strtolower($row[6])
                                ]
                            );
                            continue;
                        } else {
                            $getAkunType = AkunType::where('code', implode('', [(string) $row[0]]))->first();
                            $getAkunSubType = AkunSubType::where('code', implode('', [(string) $row[0], (string) $row[1]]))->first();
                            $getAkunClass = AkunClass::where('code', implode('', [(string) $row[0], (string) $row[1], (string) $row[2]]))->first();
                            $getAkunSubClass = AkunSubClass::where('code', implode('', [(string) $row[0], (string) $row[1], (string) $row[2], (string) $row[3]]))->first();
                            AkunCOA::updateOrCreate(
                                [
                                    'code'          => implode('', [(string) $row[0], (string) $row[1], (string) $row[2], (string) $row[3], (string) $row[4]])
                                ],
                                [
                                    'akun_type_id'      => $getAkunType->id,
                                    'akun_sub_type_id'  => $getAkunSubType->id,
                                    'akun_class_id'     => $getAkunClass->id,
                                    'akun_sub_class_id' => $getAkunSubClass->id,
                                    'code'              => implode('', [(string) $row[0], (string) $row[1], (string) $row[2], (string) $row[3], (string) $row[4]]),
                                    'nama'              => (is_null($row[5])) ? '-' : $row[5],
                                    'saldo_normal'      => strtolower($row[6])
                                ]
                            );
                            continue;
                        }
                    }
                });
                DB::commit();
                Flashy::success('Data Akun COA Berhasil Di Upload');
                return redirect(route('akun_coa.index'));
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                Flashy::error($e->getMessage());
                return Redirect::back();
            }
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $data['is_edit']    = 1;
        $data['data']       = AkunCOA::where('id', $id)->first();

        return view('accounting::master.akun.add-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_method', '_token', 'code');
        DB::beginTransaction();

        try {
            AkunCOA::where('id', $id)->update($post);
            DB::commit();
            Flashy::success('Data Akun COA ' . $request->code . ' Berhasil Di Update');
            return redirect(route('akun_coa.index'));
        } catch (\Exception $e) {
            DB::rollback();
            Flashy::error($e->getMessage());
            return Redirect::back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
