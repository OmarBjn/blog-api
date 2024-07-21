<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile)
    {
        $canUpdate = Auth::user()->can('update', $profile);

        return response()->json([
            // 'profile' => $profile,
            'profile' => new ProfileResource($profile),
            'can_update' => $canUpdate,
        ]);
    }

    public function update(Request $request, Profile $profile){

        Gate::authorize('update', $profile);
        
        $profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'info' => $request->info,
            'profile_picture' => $request->profile_picture
        ]);

        return response()->json([
            'message' => 'Updated Successfully',
            'profile' => new ProfileResource($profile)
        ]);
    }
}
