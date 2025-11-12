<?php

namespace App\Http\Controllers\Auth\HeroesMPActions;

use App\Http\Controllers\Controller;
use App\Models\city_heroes;
use App\Models\mp_added_by_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Exception;

//========================
// -------hint------------
// mp => memorable places
//========================

class MPActionsController extends Controller
{
    //===============================
    // redirect to the add mp page 
    // (перекидывание на страницу 
    // добавления памятного места)
    //===============================
    public function show(Request $request)
    {
        try {
            $user = Auth::user();

            $city = city_heroes::where('id', $request->input('city_id'))->first();
   
            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            return view('profile.add_hero_mp_and_city.add_mp', ['user' => $user, 
                                                'city_id' => $city->id, 'city' => $city->city]);
        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    }

    //=======================
    // save the data about 
    // the memorable place in 
    // the database
    // (сохранить данные о 
    // памятном места в бд)
    //=======================
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'mp_link' => 'string|max:255',
                'description' => 'string|max:255',
                'image_mp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image_qr' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048'
            ]);

            // Check if validation fails
            // (проверка на ошибки валидации)
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $city = $request->input('city');
            $name_mp = $request->input('name_mp');
            $mp_link = $request->input('mp_link');
            $description = $request->input('description');
            $city_id = city_heroes::where('id', $city)->first();


            // Check if hero already exists
            // (проверка - существует ли герой с таким именем или нет)
            $existingMP = mp_added_by_user::where('name', $name_mp)->exists();
            
            if ($existingMP) {
                return redirect()->route('add_mp_page', ['user' => $user, 
                            'city' => $city, 'city_id' => $city_id])
                            ->withInput()
                            ->withErrors('Такое Памятное Место уже есть на сайте!');
            }

            // the folder name is taken from the user id
            // (название папки берётся из id пользователя)
            $folderName = $user->id;
            
            // save the image to the MP folder (depends on which page you went to)
            // (сохраняем изображение в папку MP)
            if ($request->file('image_mp') == null) {
                return redirect()->route('add_mp_page', ['user' => $user, 
                        'city' => $city, 'city_id' => $city_id])
                        ->withInput()
                        ->withErrors('Вы не выбрали картинку для Памятного Места!');
            }

            if ($request->file('image_mp_qr') == null) {
                return redirect()->route('add_mp_page', ['user' => $user, 
                        'city' => $city, 'city_id' => $city_id])
                        ->withInput()
                        ->withErrors('Вы не выбрали картинку для Памятного Места!');
            }

            $pathForSave = $request->file('image_mp')->store("MP/{$city}/{$folderName}", 'public');
            $pathForSave_QR = $request->file('image_mp_qr')->store("MP/{$city}/{$folderName}/QR", 'public');

            // add a mp to the database
            // добавить Памятное Место в бд
            mp_added_by_user::create([
                'name' => $name_mp,
                'description' => $description,
                'mp_link' => $mp_link,
                'city' => $city,
                'image_mp' => $pathForSave,  // Store the actual file path
                'image_qr' => $pathForSave_QR, // Store the actual file path
                'added_user_id' => $user->id,
                'isCheck' => false
            ]);


            return redirect()->route('add_mp_page', ['user' => $user, 
                        'city' => $city, 'city_id' => $city_id])
                        ->withInput()
                        ->with('success', 'Памятное Место успешно добавлено!');


        } catch (Exception $e) {
            return redirect()->route('add_mp_page', ['user' => $user, 
                        'city' => $city, 'city_id' => $city_id])
                        ->withInput()
                        ->withErrors('Неизвестная ошибка!');
        }

    }

    //==============================
    // edit memorable place data
    // (изменить данные о Памятном
    // Месте)
    //==============================
    public function edit_mp_user(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $id = $request->input('id_mp');
            $name_mp = $request->input('name_mp');
            $description = $request->input('description');
            $mp_link = $request->input('mp_link');

            $mp = mp_added_by_user::where('id', $id)->with('user')->first();
            
            $mp_image = $request->file('image_mp');
            $mp_image_qr = $request->file('image_mp_qr');

            $old_path_mp_image = $mp->image_mp;
            $old_path_mp_image_qr = $mp->image_qr;

             // paths to the image to be sent to the database
            // (пути к изображению для отправки в бд)
            $path_image_mp = "none"; 
            $path_image_mp_qr = "none";
            $folder_name = $user->id;

            //==============================================================
            // if the old file has changed, then delete the old file from
            // the folder and add a new one
            // (если изменили фотку, тогда удаляем старую из папки и 
            // добавляем измененную фотку)
            //==============================================================
            if ($mp_image != null) {
                Storage::disk('public')->delete($old_path_mp_image);
                $path_image_mp = $request->file('image_mp')->store("MP/{$mp->city}/{$folder_name}", 'public');
            } else $path_image_mp = $old_path_mp_image;

            if ($mp_image_qr != null) {
                Storage::disk('public')->delete($old_path_mp_image_qr);
                $path_image_mp_qr = $request->file('image_mp_qr')->store("MP/{$mp->city}/{$folder_name}/QR", 'public');;
            } else $path_image_mp_qr = $old_path_mp_image_qr;

            // update data about MP
            // обновить данные о ПМ
            $mp->update([
                'updated-at' => now(),
                'name' => $name_mp,
                'description' => $description,
                'mp_link' => $mp_link,
                'city' => $mp->city,
                'image_mp' => $path_image_mp,  // update to the current image path 
                'image_qr' => $path_image_mp_qr, // (обновить на актуальный путь к изображению)
                'added_user_id' => $user->id,
                'isCheck' => false
            ]);
            
           return redirect()->route('added_mp_page'
                    , ['user' => $user, 'memorable_places' => $mp,'city' => $mp->city])
                    ->with('success', 'Данные героя: "' . $name_mp . '" успешно изменены!');


        } catch (Exception $e) {
            return redirect()->route('edit_mp_user_page', ['user' => $user, 'mp' => $mp])
                ->withErrors('Неизвестная ошибка!');
        }

    }

    /**
    * upload memorable place
    * (выложить памятное место)
    *
    */
    public function upload_mp(Request $request)
    {
        try {
            $user = Auth::user();
            $mp_id = $request->input('id_mp');
            $mp = mp_added_by_user::where('id', $mp_id)->first();

            $mp->update([
                'updated_at' => now(),
                'isCheck' => true
            ]);

            return redirect()->route('added_mp_page',
            ['user' => $user, 'memorable_places' => $mp,'city' => $mp->city])
            ->with('success', 'Памятное место: "'. $mp->name . '" выложено успешно!');

        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    }

    /**
     * return the memorable place for verification
     * (верните для проверки памятное место)
     */
    public function return_for_verification_mp(Request $request)
    {
        try {
            $user = Auth::user();
            $mp_id = $request->input('id_mp');
            $mp = mp_added_by_user::where('id', $mp_id)->first();

            $mp->update([
                'updated_at' => now(),
                'isCheck' => false
            ]);

            return redirect()->route('added_mp_page',
                ['user' => $user, 'memorable_places' => $mp,'city' => $mp->city])
                ->with('success', 'Памятное место: "'. $mp->name . '" на проверке!');

        } catch (Exception $e) {
            return redirect()->route('profile');
        }
    }

    //==========================
    // delete memorable place
    // (удалить памятное место)
    //==========================
    public function delete_mp(Request $request) {
        try {
            $user = Auth::user();

            if ($user->isBan) {
                return redirect()->route('profile_banned');
            }

            $id = $request->input('id_mp');
            $mp = mp_added_by_user::where('id', $id)->with('user')->first();

            $city = $mp->city;

            $path_image_mp = $mp->image_mp;
            $path_image_mp_qr = $mp->image_qr;
            
            $memorable_places = mp_added_by_user::where('city', $city)
                ->where('added_user_id', $user->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $data = mp_added_by_user::find($id);
            
            // deleting file
            // удаление файлов
            if ($path_image_mp != null) {
                Storage::disk('public')->delete($path_image_mp);
            }
            if ($path_image_mp_qr != null) {
                Storage::disk('public')->delete($path_image_mp_qr);
            }

            $mp->delete();

            return redirect()->route('added_mp_page', 
                    ['user' => $user, 'memorable_places' => $mp, 'city' => $city])
                    ->with('success', 'Памятное Место: "' . $mp->name . '" успешно удалено!');


        } catch (Exception $e) {
            return redirect()->route('added_mp_page', 
                    ['user' => $user, 'memorable_places' => $mp, 'city' => $city])
                    ->withErros("Неизвестная ошибка!");
                
        }
    }

}
