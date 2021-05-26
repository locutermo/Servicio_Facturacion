<?php

namespace App\Imports;

use App\Author;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

use Maatwebsite\Excel\Row;

class AuthorsImport implements ToModel, WithHeadingRow,WithValidation
{

    use Importable;

    /**
     * @param array $row
     *
     * @return Author|null
     */
    public function model(array $row)
    {   
      
        if (isset($row['name']) && isset($row['categories'])) {     
          
            return Author::updateOrCreate(
                ['name'=>$row['name']],//Si esto coincide
                ['name'=> $row['name'],'categories'=> $row['categories'],] //actualiza por esto , sino lo crea
        );
        }
    }


    public function rules(): array
    {
        return [
            //  'name' => function($attribute, $value, $onFailure) {
            //       if (Author::all()->where('name',$value)->isNotEmpty()) {
            //            $onFailure($value.' ya está registrado.');
            //       }
            //   }
        ];
    }


}