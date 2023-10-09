<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoryImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Category([
           'name'     => $row[0],
        ]);
    }
}