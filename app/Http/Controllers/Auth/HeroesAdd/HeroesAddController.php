<?php

namespace App\Http\Controllers\Auth\HeroesAdd;

use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Exception;

class HeroesAddController extends Controller
{
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
                return redirect()->back()
                    ->withErrors('Такой герой уже есть на сайте!')
                    ->withInput();
            }

            // Generate unique folder name for this hero
            $folderName = $user->id . "_" . $user->first_name;
            
            // Store files based on type
            if ($type == "ВОВ") {
                $pathForSave = $request->file('image_hero')->store("VOV/heroes/{$folderName}", 'public');
                $pathForSave_QR = $request->file('image_qr')->store("VOV/heroes/{$folderName}/QR", 'public');
            } 
            else if ($type == "СВО") {
                $pathForSave = $request->file('image_hero')->store("SVO/heroes/{$folderName}", 'public');
                $pathForSave_QR = $request->file('image_hero_qr')->store("SVO/heroes/{$folderName}/QR", 'public');
            }
            else {
                return redirect()->back()
                    ->withErrors('Неверный тип героя!')
                    ->withInput();
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

            return redirect()->back()->with('success', 'Герой успешно добавлен!');

        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors('Ошибка при добавлении героя: ' . $e->getMessage())
                ->withInput();
        }


    }
}
