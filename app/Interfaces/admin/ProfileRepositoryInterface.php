<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface ProfileRepositoryInterface
{
  

    public function updateProfile(Request $request, $id);
    public function getSingleProfile($id);
}
