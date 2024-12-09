<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\App;
use App\Models\Supplier;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function setLocalization() {
        $locale = session()->get('locale');
        App::setLocale($locale);
    }


    function supplierUniqueCode(){
        $lastSupplier = Supplier::orderByRaw('CAST(code AS Integer) desc')->first();
        if(!empty($lastSupplier)){
            $get_code          = (int) $lastSupplier->code + 1;
            $code        = str_pad($get_code, 4, '0', STR_PAD_LEFT);
        }
        else{
            $code = '1001';
        }
        return $code;
    }

    function returnUniqueSaleBillNo(){
        $lastSale = Sale::orderBy('id', 'desc')->first();


        if(!empty($lastSale)){
            if($lastSale->bill_no){
                $get_bill_no = intval($lastSale->bill_no) + 1 ;
            }
            else{
                $get_bill_no = '100001';
            }
        }
        else{
            $get_bill_no = '100001';
        }
        return $get_bill_no;
    }



    function setMessage($message, $type) {
        session()->flash('message', $message);
        session()->flash('type', $type);
    }

    function sweetAlertMessage($type, $message, $title = '') {
        session()->flash('alert-title', $title);
        session()->flash('alert-message', $message);
        session()->flash('alert-type', $type);
    }

    function uploadFile($file, $upload_path, $height = '', $width = '') {
        $file_name = time() . str_random(10) . rand(1, 10000) . '.' . $file->getClientOriginalExtension();
        $image     = Image::make($file);

        if ($height != '' && $width != '') {
            $image->resize($width, $height);
        }

        $image->save(env('PROJECT_LOCATION', 'public/uploads/') . $upload_path . '/' . $file_name);
        return $file_name;
    }

    function removeFile($file, $upload_path) {

        if (!empty($file)) {
            $old_file_path = str_replace('\\', '/', public_path()) . '/uploads/' . $upload_path . '/' . $file;

            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }

        }

    }

}
