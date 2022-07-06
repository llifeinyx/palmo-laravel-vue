<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

 function update(UserRequest $request, $id)
    {
        $this->authorize('update', User::find($id));

        $model = User::find($id);
        $user = $request->except('_token', '_method');

        $model->update([
            'name' => $user['name'],
        ]);

        return response($model);
    }

    public function destroy($id)
    {
        //
    }
}
