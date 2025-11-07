<?php

namespace App\Http\Controllers;

use App\SnomedCT;  
use App\SnomedCTChildren;

class SnomedCTController extends Controller
{
    public function detail($conceptID, $version){
        $completeurl = "https://browser.ihtsdotools.org/snowstorm/snomed-ct/browser/MAIN/$version/concepts/$conceptID";

        $session = curl_init($completeurl);
        curl_setopt($session, CURLOPT_HTTPGET, 1);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        // Menambahkan User-Agent
        curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');


        $response = curl_exec($session);
        $sml = json_decode($response, true);
        return $sml;
    }
    
    public function children($conceptID, $version){
        $completeurl = "https://browser.ihtsdotools.org/snowstorm/snomed-ct/browser/MAIN/$version/concepts/$conceptID/children?form=stated";
        $session = curl_init($completeurl);
        curl_setopt($session, CURLOPT_HTTPGET, 1);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        // Menambahkan User-Agent
        curl_setopt($session, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
    
        $response = curl_exec($session);
        $sml = json_decode($response, true);
        return $sml;
    }

    public function insert($conceptID, $version){
        // Get Detail
        $snomed = $this->detail($conceptID, $version);
        // Get Children
        $children = $this->children($conceptID, $version);

        $cek = SnomedCT::where('concept_id', $snomed['conceptId'])->first();

        if ($cek) {
            $data = $cek;
            SnomedCTChildren::where('snomed_ct_id', $cek->id)->delete();
        } else {
            $data = new SnomedCT();
        }
        $data->concept_id = $snomed['conceptId'];
        $data->fsn_term = $snomed['fsn']['term'];
        $data->fsn_lang = $snomed['fsn']['lang'];
        $data->pt_term = $snomed['pt']['term'];
        $data->pt_lang = $snomed['pt']['lang'];
        $data->active = $snomed['active'];
        $data->moduleId = $snomed['moduleId'];
        $data->version = $version;
        $data->save();
        
        if (count($children) > 0) {
            foreach ($children as $child) {
                $chld = new SnomedCTChildren();
                $chld->concept_id = $child['conceptId'];
                $chld->fsn_term = $child['fsn']['term'];
                $chld->fsn_lang = $child['fsn']['lang'];
                $chld->pt_term = $child['pt']['term'];
                $chld->pt_lang = $child['pt']['lang'];
                $chld->active = $child['active'];
                $chld->moduleId = $child['moduleId'];
                $chld->definitionStatus = $child['definitionStatus'];
                $chld->snomed_ct_id = $data->id;
                $chld->version = $version;
                $chld->save();
            }
        }
        dd("done");
    }
}
