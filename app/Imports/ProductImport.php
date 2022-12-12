<?php

namespace App\Imports;

use App\Models\Reward;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] != 'Product Name') {
            if (isset($row[5]) && !empty($row[5])) {
                $filepath = storage_path('/trynos/pulsehealth/images/');
                $url = $row[5];
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                File::put( $filepath.$name, $contents);

                $productImage = env('APP_URL').'/storage/trynos/pulsehealth/images/'.$name;
            }else{
                $productImage = '';
            }

            return new Reward([
                'reward_name' => ucwords(strtolower($row[0])),
                'description' => $row[1],
                'amount' => $row[2],
                'pulse_points' => $row[3],
                'totalQty' => $row[4],
                'userId' => Auth::user()->id,
                'productimage' => $productImage,
                'imageurl' => $productImage,
                'status' => 'pending',
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
