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
    // edit user data
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

        if (!$hero) {
            return redirect()->route('added_heroes_page_vov')->withErrors('Герой не найден!');
        }

        $name_hero = $request->input('name_hero');
        $description_hero = $request->input('description');
        $type = $hero->type; // Берем тип из существующего героя
        $city = $hero->city; // Берем город из существующего героя
    
        $hero_link = $request->input('hero_link');
        $image_hero = $request->file('image_hero');
        $image_hero_qr = $request->file('image_hero_qr');

        // Валидация
        $validator = Validator::make($request->all(), [
            'name_hero' => 'required|string|max:255',
            'hero_link' => 'nullable|string|max:255',
            'description' => 'required|string|max:500',
            'image_hero' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'image_hero_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        //==============================================================
        // if the old file has changed, then delete the old file from
        // the folder and add a new one
        //==============================================================
        $old_path_image = $hero->image_hero;
        $old_path_image_qr = $hero->image_qr;

        $folderName = $user->id;

        if ($image_hero != null) {
            // Удаляем старый файл
            if ($old_path_image && Storage::disk('public')->exists($old_path_image)) {
                Storage::disk('public')->delete($old_path_image);
            }

            // Сохраняем новый файл
            if ($type == "ВОВ") {
                $pathForSave = $image_hero->store("VOV/heroes/{$folderName}", 'public');
            } else if ($type == "СВО") {
                $pathForSave = $image_hero->store("SVO/heroes/{$folderName}", 'public');
            }
        } else {
            $pathForSave = $old_path_image;
        }

        // Обработка QR кода
        if ($image_hero_qr != null) {
            // Удаляем старый QR файл
            if ($old_path_image_qr && Storage::disk('public')->exists($old_path_image_qr)) {
                Storage::disk('public')->delete($old_path_image_qr);
            }

            // Сохраняем новый QR файл
            if ($type == "ВОВ") {
                $pathForSave_QR = $image_hero_qr->store("VOV/heroes/{$folderName}/QR", 'public');
            } else if ($type == "СВО") {
                $pathForSave_QR = $image_hero_qr->store("SVO/heroes/{$folderName}/QR", 'public');
            }
        } else {
            $pathForSave_QR = $old_path_image_qr;
        }

        // Обновляем данные героя
        $hero->update([
            'name_hero' => $name_hero,
            'description_hero' => $description_hero,
            'hero_link' => $hero_link,
            'image_hero' => $pathForSave,
            'image_qr' => $pathForSave_QR,
            'isCheck' => false
        ]);

        // Перенаправляем обратно на страницу редактирования с успешным сообщением
        return redirect()->route('edit_hero_user_page', ['id' => $id])
                ->with('success', 'Данные героя успешно изменены');

    } catch (Exception $e) {
        return redirect()->back()
                ->withInput()
                ->withErrors('Неизвестная ошибка: ' . $e->getMessage());
    }
}

    
}
