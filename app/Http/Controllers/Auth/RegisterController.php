<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    // 登録後に飛ばす先
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // バリデーションのルール
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['required', 'string', 'max:255'],  // ←ここ！user_name追加！！
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // ユーザーをDBに登録する処理
    protected function create(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],   // ←ここも！user_name保存！
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
