<?php

namespace App\Http\Controllers\Auth\HeroesMPActions;

// my helper
use App\Http\Controllers\Auth\HeroesMPActions\helper\Helper_hero;

// laravel and etc
use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;
use App\Models\city_heroes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Exception;


class HeroActionsController extends Controller
{
    //================================
    // redirect to the add hero page 
    // (перекидывание на страницу 
    // добавления героя)
    //================================
    public function show(Request $request)
    {
        $user = Auth::user();

        $type = $request->input('type');
        $city = city_heroes::where('city', $request->input('city'))
                            ->where('type', $type)
                            ->first();

        if ($user->isBan) {
            return redirect()->route('profile_banned');
        }

        return view('profile.add_hero_mp_and_city.add_hero', ['user' => $user, 
                                            'city' => $city->id, 'type' => $type]);
    }

    //=================================
    //
    // add_hero_in_bd
    //
    // save data about the hero in the 
    // database
    // (сохранить данные о герое в бд)
    //=================================
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
            // (проверка на ошибки валидации)
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $type = $request->input('type');

            $city = $request->input('city');
            $city_for_bd = city_heroes::where('city', $request->input('city'))
                    ->where('type', $type)
                    ->first();
                    
            $name_hero = $request->input('name_hero');
            $hero_link = $request->input('hero_link');
            $description = $request->input('description');

            // Check if hero already exists
            // (проверка - существует ли герой с таким именем или нет)
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

            // the folder name is taken from the user id
            // (название папки берётся из id пользователя)
            $folderName = $user->id;
            
            // save the image to the VOV or SVO folder (depends on which page you went to)
            // (сохраняем изображение в папку VOV или SVO (зависит с какой страницы
            // ты перешёл))
            if ($type == "ВОВ") {
                $pathForSave = $request->file('image_hero')->store("VOV/heroes/{$city}/{$folderName}", 'public');
                $pathForSave_QR = $request->file('image_hero_qr')->store("VOV/heroes/{$city}/{$folderName}/QR", 'public');
            } 
            else if ($type == "СВО") {
                $pathForSave = $request->file('image_hero')->store("SVO/heroes/{$city}{$folderName}", 'public');
                $pathForSave_QR = $request->file('image_hero_qr')->store("SVO/heroes/{$city}{$folderName}/QR", 'public');
            }
            else {
                return redirect()->route('profile', ['user' => $user, 
                            'city' => $city->id, 'type' => $type]);
            }

            // add a hero to the database
            // добавить героя в бд
            $data = heroes_added_by_user::create([
                'name_hero' => $name_hero,
                'description_hero' => $description,
                'hero_link' => $hero_link,
                'city' => $city_for_bd->id,
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
                                ->withErrors('Неизвестная ошибка!' . $e);
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

    //================
    // выложить героя
    // upload hero
    //================
    public function upload_hero(Request $request)
    {
        try {
            $user = Auth::user();

            $id = $request->input('id_hero');
            $type = $request->input('type');

            $hero = heroes_added_by_user::where('id', $id)->first();
            $hero->update([
                'updated_at' => now(),
                'isCheck' => true
            ]);

            switch ($type) {
                case "ВОВ":
                    return redirect()->route('added_heroes_page_vov'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->with('success', 'Герой: "' . $hero->name_hero . '" успешно выложен!');
                    break;
                case "СВО":
                    return redirect()->route('added_heroes_page_svo'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->with('success', 'Герой: "' . $hero->name_hero . '" успешно выложен!');
                    break;
            }
        } catch (Exception $e) {
             switch ($hero->type) {
                case "ВОВ":
                    return redirect()->route('added_heroes_page_vov'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->withErrors('Неизвестная ошибка!');
                    break;
                case "СВО":
                    return redirect()->route('added_heroes_page_svo'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                     ->withErrors('Неизвестная ошибка!');
                    break;
            }
        }
    }

    //=======================================================
    //
    // to return to the hero check (for_verifacations)
    // для возврата на проверку героя
    //
    //=======================================================
    public function for_verification(Request $request)
    {
        try {
            $user = Auth::user();

            $id = $request->input('id_hero');
            $type = $request->input('type');

            $hero = heroes_added_by_user::where('id', $id)->first();
            $hero->update([
                'updated_at' => now(),
                'isCheck' => false
            ]);

            switch ($type) {
                case "ВОВ":
                    return redirect()->route('added_heroes_page_vov'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->with('success', 'Герой: "' . $hero->name_hero . '" успешно перемещен на проверке!');
                    break;
                case "СВО":
                    return redirect()->route('added_heroes_page_svo'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->with('success', 'Герой: "' . $hero->name_hero . '" успешно перемещен на проверке!');
                    break;
            }
        } catch (Exception $e) {
             switch ($hero->type) {
                case "ВОВ":
                    return redirect()->route('added_heroes_page_vov'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->withErrors('Неизвестная ошибка!');
                    break;
                case "СВО":
                    return redirect()->route('added_heroes_page_svo'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                     ->withErrors('Неизвестная ошибка!');
                    break;
            }
        }
    }

    //===========================
    // edit hero data
    // (изменить данные о герое)
    //===========================
    public function edit_hero_user(Request $request)
    {

        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $id = $request->input('id_hero');
            $name_hero = $request->input('name_hero');
            $description = $request->input('description');
            $hero_link = $request->input('hero_link');

            $hero = heroes_added_by_user::where('id', $id)->with('user')->first();
            
            $hero_image = $request->file('image_hero');
            $hero_image_qr = $request->file('image_hero_qr');

            $old_path_hero_image = $hero->image_hero;
            $old_path_hero_image_qr = $hero->image_qr;

            // paths to the image to be sent to the database
            // (пути к изображению для отправки в бд)
            $path_image_hero = "none"; 
            $path_image_hero_qr = "none";
            $folder_name = $user->id;

            //==============================================================
            // if the old file has changed, then delete the old file from
            // the folder and add a new one
            // (если изменили фотку, тогда удаляем старую из папки и 
            // добавляем измененную фотку)
            //==============================================================
            switch ($hero->type) {
                case "ВОВ":
                    if ($hero_image != null) {
                        Storage::disk('public')->delete($old_path_hero_image);
                        $path_image_hero = $request->file('image_hero')->store("VOV/heroes/{$hero->city}/{$folder_name}", 'public');
                    } else $path_image_hero = $old_path_hero_image;

                    if ($hero_image_qr != null) {
                        Storage::disk('public')->delete($old_path_hero_image_qr);
                        $path_image_hero_qr = $request->file('image_hero_qr')->store("SVO/heroes/{$hero->city}/{$folder_name}", 'public');;
                    } else $path_image_hero_qr = $old_path_hero_image_qr;
                    break;

                case "СВО":
                    if ($hero_image != null) {
                        Storage::disk('public')->delete($old_path_hero_image);
                        $path_image_hero = $request->file('image_hero')->store("VOV/heroes/{$hero->city}/{$folder_name}", 'public');
                    } else $path_image_hero = $old_path_hero_image;

                    if ($hero_image_qr != null) {
                        Storage::disk('public')->delete($old_path_hero_image_qr);
                        $path_image_hero_qr = $request->file('image_hero_qr')->store("SVO/heroes/{$hero->city}/{$folder_name}", 'public');;
                    } else $path_image_hero_qr = $old_path_hero_image_qr;
                    break;

                default:
                    $path_image_hero = $old_path_hero_image;
                    $path_image_hero_qr = $old_path_hero_image_qr;
                    break;
            }

            // update data about hero
            // обновить данные о героя
            $hero->update([
                'updated-at' => now(),
                'name_hero' => $name_hero,
                'description_hero' => $description,
                'hero_link' => $hero_link,
                'city' => $hero->city,
                'type' => $hero->type,
                'image_hero' => $path_image_hero,  // update to the current image path 
                'image_qr' => $path_image_hero_qr, // (обновить на актуальный путь к изображению)
                'added_user_id' => $user->id,
                'isCheck' => false
            ]);
            
            switch ($hero->type) {
                case "ВОВ":
                    return redirect()->route('added_heroes_page_vov'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->with('success', 'Данные героя: "' . $name_hero . '" успешно изменены!');
                    break;
                case "СВО":
                    return redirect()->route('added_heroes_page_svo'
                    , ['user' => $user, 'heroes' => $hero,'type' => $hero->type, 'city' => $hero->city])
                    ->with('success', 'Данные героя: "' . $name_hero . '" успешно изменены!');
                    break;
            }

        } catch (Exception $e) {
            return redirect()->route('edit_hero_user_page')
                ->withErrors('Неизвестная ошибка!');
        }

    }

    //=======================
    // delete hero
    // (удалить героя)
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
            
            // deleting file
            // удаление файлов
            if ($path_image_hero != null) {
                Storage::disk('public')->delete($path_image_hero);
            }
            if ($path_image_hero_qr != null) {
                Storage::disk('public')->delete($path_image_hero_qr);
            }


            $hero->delete();

            if ($type == "СВО") {
                return redirect()->route('added_heroes_page_svo', 
                    ['user' => $user, 'heroes' => $hero,'type' => $type, 'city' => $city])
                    ->with('success', 'Герой: "' . $hero->name_hero . '" успешно удален!');
            }
            else if ($type == "ВОВ") {
                return redirect()->route('added_heroes_page_vov', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city])
                    ->with('success',  'Герой: "' . $hero->name_hero . '" успешно удален!');
            }
            else {
                return redirect()->route('profile');
            }


        } catch (Exception $e) {
            if ($type == "СВО") {
                return redirect()->route('added_heroes_page_svo', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city])
                    ->withErrors('Неизвестная ошибка!');;
            }
            else if ($type == "ВОВ") {
                return redirect()->route('added_heroes_page_vov', 
                    ['user' => $user, 'heroes' => $heroes,'type' => $type, 'city' => $city])
                    ->withErrors('Неизвестная ошибка!');
            }
            return redirect()->route('profile');
                
        }
    }
 
}