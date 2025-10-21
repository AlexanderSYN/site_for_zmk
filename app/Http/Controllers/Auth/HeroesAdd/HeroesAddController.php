<?php

namespace App\Http\Controllers\Auth\HeroesAdd;

use App\Http\Controllers\Controller;
use App\Models\heroes_added_by_user;

use Illuminate\Http\Request;
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

        $type = $request->input('type');
        $city = $request->input('city');

        $image_hero = $request->input('image_hero');
        $image_hero_qr = $request->input('image_hero_qr');
        $name_hero = $request->input('name_hero');
        $hero_link = $request->input('hero_link');
        $description = $request->input('description');

        try {
            $validator = Validator::make($request->all(), [
                'name_hero' => 'required|string|max:255',
                'hero_link' => 'required|string|max:255',
                'description_hero' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'image_hero' => 'required|string|max:255',
                'image_qr' => 'required|string|max:255'
            ]);

            $existingHero = heroes_added_by_user::where('name_hero', $name_hero)->first();

            if ($existingHero) {
                return redirect()->back()
                        ->withErrors('Такой герой уже есть на сайте!')
                        ->withInput();
            }

            $data = heroes_added_by_user::create([
                'name_hero' => $name_hero,
                'description_hero' => $description,
                'hero_link' => $hero_link,
                'city' => $city,
                'type' => $type,
                'image_hero' => $image_hero,
                'image_qr' => $image_hero_qr,
                'added_user_id' => $user->id,
                'isCheck' => false
            ]);

            return redirect()->back()->withInput();

        } catch (Exception $e) {
            echo "ERROR " . $e; 
        }


    }
}
