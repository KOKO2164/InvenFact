<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use CommonTrait;

    protected $model = User::class;
    protected $searchField = 'name';
    protected function validationRules($id = null)
    {
        $rules = [
            'dni' => 'required|numeric|digits:8|unique:users,dni,' . $id,
            'name' => 'required|string|regex:/^(?=.*[\p{L}].*[\p{L}])[\p{L}0-9&\-\'\., ]+$/u',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:users,email,' . $id
        ];

        if (is_null($id)) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }
    protected function otherModels()
    {
        return null;
    }
}
