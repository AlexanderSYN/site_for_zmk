<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //------------------------------------------
    // Method for checking a serialized string
    //------------------------------------------
    public function isSerialized($data) {
        //---------------------------------------------------------------------
        // If the string starts with s: and contains a serialization structure
        //---------------------------------------------------------------------
        return is_string($data) &&
            preg_match('/^s:\d+:\".*\";$/', $data);
    }

    public function show()
    {        
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        try {
            //-----------------------------------------------------------
            // First we deserialize the string, then we try to decrypt
            // Checking whether the string is serialized
            //-----------------------------------------------------------

            $decryptedEmail = Crypt::decryptString($user->email);

            if ($this->isSerialized($decryptedEmail)) {
                // Now we are trying to decipher
                $decryptedEmail = unserialize($decryptedEmail);
            }

        } catch (DecryptException $DectExc) {
            $decryptedEmail = "Не Удалось Вывести Email";
        } catch (Exception $e) {
            $decryptedEmail = "Не Удалось Вывести Email";
        }
    
        return view('profile.profile', ['user' => $user, 'email' => $decryptedEmail]);
    }

    public function change_data(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }  

        User::where('id', $user->id)
            ->update(array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'patronymic' => $request->patronymic,
                'login' => $request->login,
                'email' => Crypt::encrypt($request->email)
            ));
            

        return redirect()->route('profile')
            ->with('success', 'Данные профиля успешно обновлены!');
    }
}

?>