<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Requests\UpdateAcountRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class AcountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('acount.index', compact('user'));
    }

    public function store(UpdateAcountRequest $request, ImageService $imageService)
    {
        $user = Auth::user();
        $validatedData = $request->validated();

        // Update data selain foto & identity_image
        $user->fill(Arr::except($validatedData, ['foto', 'identity_image']));

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $compressed = $imageService->compress($file);
            $filename = time() . '.jpg';

            Storage::disk('public')->put('uploads/users/' . $filename, $compressed);

            // Hapus foto lama jika bukan default avatar
            if ($user->foto && !str_starts_with($user->foto, 'avatar-') && Storage::disk('public')->exists('uploads/users/' . $user->foto)) {
                Storage::disk('public')->delete('uploads/users/' . $user->foto);
            }

            $user->foto = $filename;
        }

        if ($request->hasFile('identity_image')) {
            $file = $request->file('identity_image');
            $compressed = $imageService->compress($file);
            $filename = 'identity_' . time() . '_' . uniqid() . '.jpg';

            Storage::disk('public')->put('uploads/identities/' . $filename, $compressed);

            if ($user->identity_image && Storage::disk('public')->exists('uploads/identities/' . $user->identity_image)) {
                Storage::disk('public')->delete('uploads/identities/' . $user->identity_image);
            }

            $user->identity_image = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', __('messages.profile_updated'));
    }

    public function security()
    {
        $user = Auth::user();
        return view('acount.security', compact('user'));
    }

    public function updatePassword(\App\Http\Requests\UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->newPassword);
        $user->save();

        return redirect()->route('acount.security')->with('success', __('messages.password_updated'));
    }
}