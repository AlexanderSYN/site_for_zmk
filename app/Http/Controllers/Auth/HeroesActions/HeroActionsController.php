<?php

namespace App\Http\Controllers\Auth\HeroesActions;

// my helper
use App\Http\Controllers\Auth\HeroesActions\helper\Helper_hero;

// laravel and etc
use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Exception;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class HeroActionsController extends Controller
{
    //============================
    // redirect to the added page 
    //============================
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
        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

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
                return redirect()->route('profile', ['user' => $user, 
                            'city' => $city, 'type' => $type]);
            }

            // Create hero record
            $data = heroes_added_by_user::create([
                'name_hero' => $name_hero,
                'description_hero' => $description,
                'hero_link' => $hero_link,
                'city' => $city,
                'type' => $type,
                'image_hero' => $pathForSave,  // Store the actual file path
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
                                ->withErrors('Неизвестная ошибка!');
                    break;
                case "СВО":
                    return redirect()->route('add_heroes_page_svo', ['user' => $user, 
                                'city' => $city, 'type' => $type])
                                ->withInput()
                                ->withErrors('Неизвестная ошибка!');
                    break;
            }
        }

    }

    //=======================
    // edit hero data
    //=======================
    public function edit_hero_user(Request $request)
    {

        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $id = $request->input('id_hero');
            $hero = heroes_added_by_user::where('id', $id)->with('user')->first();
            
            $hero_image = $request->file('image_hero');
            $hero_image_qr = $request->file('image_hero_qr');

            $old_path_hero_image = $hero->image_hero;
            $old_path_hero_image_qr = $hero->image_qr;

            //==============================================================
            // if the old file has changed, then delete the old file from
            // the folder and add a new one
            //==============================================================
            // check image hero
            if ($hero_image == null) {
                $full_path_to_image_hero = public_path('storage/', $old_path_hero_image);
                if (file_exists($full_path_to_image_hero)) {
                    unlink($full_path_to_image_hero);
                }
            }
            
            dd($hero_image, $hero_image_qr);
        } catch (Exception $e) {
            return redirect()->route('edit_hero_user_page')
                ->withErrors('ERROR' . $e->getMessage());
        }

    }

    //=======================
    // delete hero
    //=======================
    public function delete_hero(Request $request) {
        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $id = $request->input('id_hero');
            $hero = heroes_added_by_user::where('id', $id)->with('user')->first();

            $type = $hero->type;
            $city = $hero->city;

            $path_image_hero = $hero->image_hero;
            $path_image_hero_qr = $hero->image_qr;
            
            $heroes = heroes_added_by_user::where('city', $city)
                ->where('type', $type)
                ->where('city', $city)
                ->where('added_user_id', $user->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $data = heroes_added_by_user::find($id);


            Storage::disk('public')->delete($path_image_hero);
            Storage::disk('public')->delete($path_image_hero_qr);


            $hero->delete();

            if ($type == "СВО") {
                return redirect()->route('added_heroes_page_svo', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city]);
            }
            else if ($type == "ВОВ") {
                return redirect()->route('added_heroes_page_vov', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city]);
            }
            else {
                return redirect()->route('profile');
            }


        } catch (Exception $e) {
            if ($type == "СВО") {
                return redirect()->route('added_heroes_page_svo', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city])
                    ->withErrors('Неизвестная ошибка!'.$e);;
            }
            else if ($type == "ВОВ") {
                return redirect()->route('added_heroes_page_vov', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city])
                    ->withErrors('Неизвестная ошибка!'.$e);
            }
            return redirect()->route('profile');
                
        }
    }
 
}