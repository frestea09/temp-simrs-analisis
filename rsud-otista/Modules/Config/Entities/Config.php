<?php

namespace Modules\Config\Entities;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['nama', 'alamat', 'website', 'email', 'logo', 'logo_paripurna', 'bayardepan', 'kasirtindakan', 'antrianfooter',
  'tahuntarif', 'panjangkodepasien', 'ipsep', 'usersep', 'ipinacbg', 'pt', 'kota', 'dinas', 'npwp', 'tlp','kode_pos','visi_misi','pegawai_id','create_org','province_id','regency_id', 'district_id', 'village_id','status_satusehat', 'id_organization','longitude', 'latitude', 'altitude', 'rt', 'rw','status_finger_kiosk','status_validasi_sep'];
}
