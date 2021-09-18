<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Indo_Province;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getProvinsi(Request $request){
        $province = Indo_Province::select('province')->distinct()->get();
        $output='<option selected disabled>Select a province</option>';
        foreach ($province as $item) {
            $output .= '<option value="'.$item->province.'">'.$item->province.'</option>';
        }
        return $output;
    }

    public function getKota(Request $request){
        $city = Indo_Province::select('city')->where('province',$request->get('selected'))->distinct()->get();
        $output='<option selected disabled>Select a city</option>';
        foreach ($city as $item) {
            $output .= '<option value="'.$item->city.'">'.$item->city.'</option>';
        }
        return $output;
    }

    public function getKecamatan(Request $request){
        $district = Indo_Province::select('district')->where('city',$request->get('selected'))->distinct()->get();
        $output='<option selected disabled>Select a district</option>';
        foreach ($district as $item) {
            $output .= '<option value="'.$item->district.'">'.$item->district.'</option>';
        }
        return $output;
    }

    public function getKelurahan(Request $request){
        $sub_district = Indo_Province::where('district',$request->get('selected'))->distinct()->get();
        $output='<option selected disabled>Select a sub district</option>';
        foreach ($sub_district as $item) {
            $output .= '<option value="'.$item->province_id.'">'.$item->sub_district.'</option>';
        }
        return $output;
    }

    public function getKodePos(Request $request){
        $zip_code = Indo_Province::where('province_id',$request->get('selected'))->distinct()->get();
        $output='';
        foreach ($zip_code as $item) {
            $output .= '<option value="'.$item->province_id.'">'.$item->zip_code.'</option>';
        }
        return $output;
    }

    public function populateLocation(){
        $user = Auth::user();
        $selectedLocation = Indo_Province::where('province_id',$user->province_id)->first();
        
        $province = Indo_Province::select('province')->distinct()->get();
        $outputProvince='<option disabled>Select a province</option>';
        foreach ($province as $item) {
            if($item->province == $selectedLocation->province){
                $outputProvince .= '<option value="'.$item->province.'" selected>'.$item->province.'</option>';
            }else{
                $outputProvince .= '<option value="'.$item->province.'">'.$item->province.'</option>';
            }
        }
        
        $city = Indo_Province::select('city')->where('province',$selectedLocation->province)->distinct()->get();
        $outputCity='<option disabled>Select a city</option>';
        foreach ($city as $item) {
            if($item->city == $selectedLocation->city){
                $outputCity .= '<option value="'.$item->city.'" selected>'.$item->city.'</option>';
            }else{
                $outputCity .= '<option value="'.$item->city.'">'.$item->city.'</option>';
            }
        }
        
        $district = Indo_Province::select('district')->where('city',$selectedLocation->city)->distinct()->get();
        $outputDistrict='<option disabled>Select a district</option>';
        foreach ($district as $item) {
            if($item->district == $selectedLocation->district){
                $outputDistrict .= '<option value="'.$item->district.'" selected>'.$item->district.'</option>';
            }else{
                $outputDistrict .= '<option value="'.$item->district.'">'.$item->district.'</option>';
            }
        }
        
        $sub_district = Indo_Province::select('sub_district')->where('district',$selectedLocation->district)->distinct()->get();
        $outputSub_district='<option disabled>Select a sub district</option>';
        foreach ($sub_district as $item) {
            if($item->sub_district == $selectedLocation->sub_district){
                $outputSub_district .= '<option value="'.$item->sub_district.'" selected>'.$item->sub_district.'</option>';
            }else{
                $outputSub_district .= '<option value="'.$item->sub_district.'">'.$item->sub_district.'</option>';
            }
        }
        
        $outputZip_code = '<option value="'.$selectedLocation->province_id.'" selected>'.$selectedLocation->zip_code.'</option>';

        $response = [
            'province'=>$outputProvince,
            'city'=>$outputCity,
            'district'=>$outputDistrict,
            'sub_district'=>$outputSub_district,
            'zip_code'=>$outputZip_code
        ];
        return $response;
    }

    public function appIndex(Request $request){
        return view('front.welcome');
    }

    public function aboutIndex(){
        return view('front.about');
    }
}
