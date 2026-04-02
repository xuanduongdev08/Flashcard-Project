<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar_file' => 'nullable|image|max:2048', // max 2MB
            'province' => 'nullable|string',
            'district' => 'nullable|string',
            'ward' => 'nullable|string',
            'address_detail' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'province', 'district', 'ward', 'address_detail']);

        try {
            if ($request->hasFile('avatar_file')) {
                $file = $request->file('avatar_file');
                
                // Delete old avatar if it's stored locally
                if ($user->avatar && str_contains($user->avatar, '/storage/')) {
                    $oldPath = str_replace(asset('storage/'), '', $user->avatar);
                    Storage::disk('public')->delete($oldPath);
                }

                // Custom path name to avoid collision
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('avatars', $filename, 'public');
                
                // Use a relative path for Render stability
                $data['avatar'] = '/storage/' . $path;
                
                // Log for debugging
                Log::info('Avatar uploaded successfully:', ['path' => $path]);
            }

            $user->update($data);
            return redirect()->route('profile.edit')->with('success', 'Thông tin tài khoản đã được cập nhật thành công!');

        } catch (\Exception $e) {
            Log::error('Profile update failed:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Đã có lỗi xảy ra khi lưu thông tin: ' . $e->getMessage()]);
        }
    }
}
