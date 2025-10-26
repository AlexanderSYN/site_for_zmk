<?php

namespace App\Http\Controllers\Auth\HeroesAdd;

use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Exception;

class HeroesAddController extends Controller
{
    //=======================
    // redirect to the added page 
    //=======================
    public function show(Request $request)
    {
        $user = Auth::user();

        $type = $request->input('type');
        $city = $request->input('city');

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        return view('profile.add_hero_and_city.add_hero', ['user' => $user, 
                                            'city' => $city, 'type' => $type]);
    }

    //=======================
    // save user data
    //=======================
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        try {
            $validator = Validator::make($request->all(), [
                'name_hero' => 'string|max:255',
                'hero_link' => 'string|max:255',
                'description_hero' => 'string|max:255',
                'type' => 'string|max:255',
                'image_hero' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image_qr' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048'
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $type = $request->input('type');
            $city = $request->input('city');
            $name_hero = $request->input('name_hero');
            $hero_link = $request->input('hero_link');
            $description = $request->input('description');

            // Check if hero already exists
            $existingHero = heroes_added_by_user::where('name_hero', $name_hero)->exists();
            
            if ($existingHero) {
                switch ($type) {
                        case "ВОВ":
                            return redirect()->route('add_heroes_page_vov', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Такой герой уже есть на сайте!');
                            break;
                        case "СВО":
                            return redirect()->route('add_heroes_page_svo', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Такой герой уже есть на сайте!');
                            break;
                }
            }

            // Generate unique folder name for this hero
            $folderName = $user->id;
            
            // Store files based on type
            if ($type == "ВОВ") {
                $pathForSave = $request->file('image_hero')->store("VOV/heroes/{$folderName}", 'public');
                $pathForSave_QR = $request->file('image_hero_qr')->store("VOV/heroes/{$folderName}/QR", 'public');
            } 
            else if ($type == "СВО") {
                $pathForSave = $request->file('image_hero')->store("SVO/heroes/{$folderName}", 'public');
                $pathForSave_QR = $request->file('image_hero_qr')->store("SVO/heroes/{$folderName}/QR", 'public');
            }
            else {
                switch ($type) {
                    case "ВОВ":
                        return redirect()->route('add_heroes_page_vov', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Неверный тип героя!');
                        break;
                    case "СВО":
                        return redirect()->route('add_heroes_page_svo', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Неверный тип героя!');
                        break;
                }
            }

            // Create hero record
            $data = heroes_added_by_user::create([
                'name_hero' => $name_hero,
                'description_hero' => $description,
                'hero_link' => $hero_link,
                'city' => $city,
                'type' => $type,
                'image_hero' => $pathForSave, // Store the actual file path
                'image_qr' => $pathForSave_QR, // Store the actual file path
                'added_user_id' => $user->id,
                'isCheck' => false
            ]);

            switch ($type) {
                case "ВОВ":
                    return redirect()->route('add_heroes_page_vov', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                            ->withInput()
                            ->with('success', 'Герой успешно добавлен!');
                    break;
                case "СВО":
                    return redirect()->route('add_heroes_page_svo', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->with('success', 'Герой успешно добавлен!');
                    break;
            }


        } catch (Exception $e) {
            switch ($type) {
                case "ВОВ":
                    return redirect()->route('add_heroes_page_vov', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withErrors('Неизвестная ошибка!' . $e);
                    break;
                case "СВО":
                    return redirect()->route('add_heroes_page_svo', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Неизвестная ошибка!' . $e);
                    break;
            }
        }

    }

    //=======================
    // edit user data
    //=======================
    public function edit_hero_user(Request $request)
    {
        $user = Auth::user();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        try {
            $id = $request->input('id_hero');
            $hero = heroes_added_by_user::where('id', $id)->with('user')->first();

            $name_hero = $request->input('name_hero');
            $description_hero = $request->input('description');
            $type = $request->input('type');
            $city = $request->input('city');
        
            $hero_link = $request->input('hero_link');
            $image_hero = $request->file('image_hero');
            $image_hero_qr = $request->file('image_hero_qr');

            $old_image_hero = $request->input('old_image_hero');

            // Check if hero is not exists
            $existingHero = heroes_added_by_user::where('id', $id)->exists();
            
            if (!$existingHero) {
                switch ($type) {
                        case "ВОВ":
                            return redirect()->route('added_heroes_page_vov', ['user' => $user, 
                                'hero' => $hero]);
                            break;
                        case "СВО":
                            return redirect()->route('added_heroes_page_vov', ['user' => $user, 
                                'hero' => $hero]);
                            break;
                }
            }

            //==============================================================
            // if the old file has changed, then delete the old file from
            // the folder and add a new one
            //==============================================================
            $old_path_image = DB::table('heroes')->where('id', $id)->value('image_hero');
            $folderName = $user->id;

            if ($image_hero != null) {

                if ($type == "ВОВ") {
Log::info("Attempting to delete file:", [
        'path' => $old_path_image,
        'disk' => 'public',
        'full_path' => Storage::disk('public')->path($old_path_image)
    ]);
                    //Storage::delete($old_path_image);
                    // Store files based on type
                    //$pathForSave = $request->file('image_hero')->store("VOV/heroes/{$folderName}", 'public');
                    //$pathForSave_QR = $request->file('image_hero_qr')->store("VOV/heroes/{$folderName}/QR", 'public');
                } 
                else if ($type == "СВО")  {
                    Storage::delete($old_path_image);
                    // Store files based on type
                    $pathForSave = $request->file('image_hero')->store("SVO/heroes/{$folderName}", 'public');
                    $pathForSave_QR = $request->file('image_hero_qr')->store("SVO/heroes/{$folderName}/QR", 'public');
                }

                heroes_added_by_user::where('id', $id)
                    ->update(array(
                        'name_hero' => $name_hero,
                        'description_hero' => $description_hero,
                        'hero_link' => $hero_link,
                        'image_hero' => $pathForSave,
                        'image_qr' => $pathForSave_QR,
                        'isCheck' => false
                ));

                // return view('profile.added_heroes_city_by_user.edit_heroes', 
                //         ['user' => $user, 'hero' => $hero ]);

            }

            
            
           
            // else {
            //     switch ($type) {
            //         case "ВОВ":
            //             return redirect()->route('add_heroes_page_vov', ['user' => $user, 
            //                     'city' => $city, 'type' => $type])
            //                     ->withInput()
            //                     ->withErrors('Неверный тип героя!');
            //             break;
            //         case "СВО":
            //             return redirect()->route('add_heroes_page_svo', ['user' => $user, 
            //                     'city' => $city, 'type' => $type])
            //                     ->withInput()
            //                     ->withErrors('Неверный тип героя!');
            //             break;
            //     }
            // }

            // // Create hero record
            // $data = heroes_added_by_user::create([
            //     'name_hero' => $name_hero,
            //     'description_hero' => $description,
            //     'hero_link' => $hero_link,
            //     'city' => $city,
            //     'type' => $type,
            //     'image_hero' => $pathForSave, // Store the actual file path
            //     'image_qr' => $pathForSave_QR, // Store the actual file path
            //     'added_user_id' => $user->id,
            //     'isCheck' => false
            // ]);

            // switch ($type) {
            //     case "ВОВ":
            //         return redirect()->route('add_heroes_page_vov', ['user' => $user, 
            //                     'city' => $city, 'type' => $type])
            //                 ->withInput()
            //                 ->with('success', 'Герой успешно добавлен!');
            //         break;
            //     case "СВО":
            //         return redirect()->route('add_heroes_page_svo', ['user' => $user, 
            //                     'city' => $city, 'type' => $type])
            //                     ->withInput()
            //                     ->with('success', 'Герой успешно добавлен!');
            //         break;
            // }


        } catch (Exception $e) {
            switch ($type) {
                case "ВОВ":
                    return redirect()->route('add_heroes_page_vov', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withErrors('Неизвестная ошибка!' . $e);
                    break;
                case "СВО":
                    return redirect()->route('add_heroes_page_svo', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Неизвестная ошибка!' . $e);
                    break;
            }
        }
        
    }


}
