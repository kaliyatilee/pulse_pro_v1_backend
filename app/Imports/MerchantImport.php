<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\File;

class MerchantImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[1] != 'Email') {
            if (isset($row[8]) && !empty($row[8])) {
                $filepath = public_path('/storage/directorid/original/');
                $url = $row[8];
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                File::put( $filepath.$name, $contents);

                $directorId = $name;
            }else{
                $directorId = '';
            }

            if (isset($row[9]) && !empty($row[9])) {
                $filepath = public_path('/storage/mousigned/original/');
                $url = $row[9];
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                File::put( $filepath.$name, $contents);

                $mousigned = $name;
            }else{
                $mousigned = '';
            }

            return new User([
                'name' => ucwords(strtolower($row[0])),
                'registrationNumber' => $row[4],
                'email' => strtolower($row[1]),
                'password' => $row[3],
                'phone' => $row[2],
                'directorName' => $row[5],
                'directorId' => $directorId,
                'mouSigned' => $mousigned,
                'registrationfee' => $row[6],
                'paymentAcceptance' => $row[7],
                'role' => 'merchant',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
