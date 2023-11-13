<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->has('role_id'), function ( $query) {
                $query->where('role_id',\request('role_id'));
            })
            ->where('status',1)->get();
        return response()->json(UserResource::collection($users));
    }
    public function profile()
    {
        return response()->json(new UserResource(Auth::user()));
    }
    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user()->update($request->validated());

        return response()->json(new UserResource($user));
    }


}
