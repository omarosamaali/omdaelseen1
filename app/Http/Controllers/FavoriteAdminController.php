<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoriteAdminController extends Controller
{
    public function index(){
        $favorites = Favorites::withCount('place')->get();
        return view('admin.omdaHome.favorites.index', compact('favorites'));
    }

    public function show($id){
        $favorites = Favorites::with(['place', 'user'])->where('user_id', $id)->get();
        return view('admin.omdaHome.favorites.show', compact('favorites'));
    }
}
