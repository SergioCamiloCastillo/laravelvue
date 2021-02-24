<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function addTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }
    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    public function editTag(Request $request)
    {
        // validate request
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName,
        ]);
    }
    public function deleteTag(Request $request)
    {
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->delete();
    }
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }
    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }
    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $fileName = public_path() . '/uploads/' . $fileName;
            if (file_exists($fileName)) {
                @unlink($fileName);
            }
        }
        $filePath = public_path() . "/uploads/" . $fileName;
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }
    public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }
    public function editCategory(Request $request)
    {
        // validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }
    public function deleteCategory(Request $request)
    {
        //Primero eliminamos el file original del server
        $this->deleteFileFromServer($request->iconImage);
        //Validar lo que venga de la
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id', $request->id)->delete();
    }
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail:required|email|unique:users',
            'password' => 'required|min:6',
            'userType' => 'required'
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'userType' => $request->userType
        ]);
        return $user;
    }
    public function getUser()
    {
        return User::where('userType', '!=', 'User')->orderBy('id', 'desc')->get();
    }
    public function editUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail:required|email|unique:users,email, $request->id",
            'password' => 'min:6',
            'userType' => 'required'
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'userType' => $request->userType
        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $user = User::where('id', $request->id)->update($data);
        return $user;
    }
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'msg' => 'Tu estas logueado/a'
            ]);
        } else {
            return response()->json([
                'msg' => 'Datos incorrectos'
            ], 401);
        }
    }
}
