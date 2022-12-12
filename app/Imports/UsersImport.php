<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Storage;
use Illuminate\Support\Facades\File;
/* use App\Repositories\UserRepository; */

class UsersImport implements ToModel
{
    protected $userRepository;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[1] != 'Email') {

            if (isset($row[14]) && !empty($row[14])) {
                $filepath = public_path('/storage/directorid/original/');
                $url = $row[14];
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                File::put( $filepath.$name, $contents);

                $directorId = $name;
            }else{
                $directorId = '';
            }

            if (isset($row[15]) && !empty($row[15])) {
                $filepath = public_path('/storage/certificateOfIncorporation/original/');
                $url = $row[15];
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                File::put( $filepath.$name, $contents);

                $certificateOfIncorporation = $name;
            }else{
                $certificateOfIncorporation = '';
            }

            if (isset($row[16]) && !empty($row[16])) {
                $filepath = public_path('/storage/CR14form/original/');
                $url = $row[16];
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                File::put( $filepath.$name, $contents);

                $CR14form = $name;
            }else{
                $CR14form = '';
            }
            
            return new User([
                'name'     => $row[0],
                'email'    => $row[1],
                'phone'    => $row[2],
                'password' => \Hash::make($row[3]),
                'partnerTradingName' => $row[4],
                'accountNumber' => $row[5],
                'businessType' => $row[6],
                'partnerTradingDetails' => $row[7],
                'propertyNumber' => $row[8],
                'streetName' => $row[9],
                'suburb' => $row[10],
                'bankName' => $row[11],
                'branchName' => $row[12],
                'branchCode' => $row[13],
                'directorId' => $directorId,
                'certificateOfIncorporation' => $certificateOfIncorporation,
                'CR14form' => $CR14form,
                'role' => 'partner',
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
