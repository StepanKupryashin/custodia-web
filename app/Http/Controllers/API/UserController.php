<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->get('login'),
            'email' => $request->get('email'),
            'secret_word' => $request->get('secret_word', ''),
            'password' => Hash::make($request->get('password')),
        ]);
        $data = [
            'user' => User::find($user->id),
            'token' => $user->createToken('User Token')->accessToken
        ];

        return $this->susscesResponse($data);
    }

    public function login(Request $request)
    {
        if (
            Auth::attempt(
                [
                    'name' => $request->get('login'),
                    'password' => $request->get('password'),
                    'secret_word' => $request->get('secret_word')
                ]
            )
        ) {

            $user = Auth::user();
            $data = [
                'user' => User::find($user->id),
                'token' => $user->createToken('User Token')->accessToken
            ];

            return $this->susscesResponse($data);
        } else {
            return $this->failResponse('Login failed or user not found');
        }

    }

    public function setAdmin(Request $request) {
        $user = User::find(auth()->user()->id);
        $user->is_admin = true;
        $user->save();
        return $this->susscesResponse($user);

    }

    public function users() {
        $data = User::all();
        foreach ($data as &$user) {
            $user->positions;
            $user->position = $user->positions[0]->title ?? "Не указано";
         }
        return $this->susscesResponse($data);
    }

    public function updateUsers(Request $request) {
        $data = $request->all();

        foreach ($data as &$d) {
            if(isset($d['position'])) {
                $position = $d['position'];
                unset($d['position']);
                unset($d['positions']);
            }
            if($d['password'] == User::find($d['id'])->password) {
                $d['password'] = User::find($d['id'])->password;
            }
            else {
                $d['password'] = Hash::make($d['password']);
            }
            $user = User::updateOrCreate(
                ['id' => $d['id'],],
                $d
            );
            if($position) {
                $p = Position::firstOrCreate([
                    'title' => $position,
                ], [
                    'title' => $position
                ]);
                DB::table('positions_users')->insert([
                    'user_id' => $user->id,
                    'position_id' => $p->id
                ]);
            }
        }
        return $this->susscesResponse($data);
    }
}
