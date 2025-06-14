<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class studentController extends Controller
{
       public function profile()
    {
       
        return view('student.profile');  // 
    }
     public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Validate photo upload
        ]);
        $data = $request->only(['name', 'email', 'phone','photo']);

        

         // If a new photo is uploaded, store it and add the path to the data array
         if ($request->hasFile('photo')) {

          
            
            $photoPath = $request->file('photo')->store('profile_photos', 'public'); // Store in the 'profile_photos' directory
            $data['photo'] = $photoPath;
        }

    
        // Update the user's profile in the database
        $user->update($data);

        // Redirect back with a success message
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully');
    }


      public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required', // Validate current password
            'new_password' => 'required|min:8|confirmed', // Validate new password with confirmation
        ]);

        // Check if the current password matches the user's stored password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            // If passwords don't match, return with an error
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password if the current password is correct and the new passwords match
        Auth::user()->update([
            'password' => Hash::make($request->new_password), // Hash the new password before saving it
        ]);

 
        return redirect()->back()->with('success', 'Password updated successfully.');
    
    }

  public function dashboard()
    {
        
        return view('student.dashboard');  
    }
}
