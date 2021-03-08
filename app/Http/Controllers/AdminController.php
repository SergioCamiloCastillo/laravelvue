<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Category;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        //Primero hay que revisar si el usuario esta y es administrador
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        //Revisar si el usuario esta logueado y es administrador
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }
        return view('welcome');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
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
    public function deleteUser(Request $request)
    {
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return User::where('id', $request->id)->delete();
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
            'role_id' => 'required'
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id
        ]);
        return $user;
    }
    public function getUser()
    {
        return User::get();
    }
    public function editUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail:required|email|unique:users,email, $request->id",
            'password' => 'min:6',
            'role_id' => 'required'
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'role_id' => $request->role_id
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
            $user = Auth::user();
            if ($user->role->isAdmin == '0') {
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login details'
                ]);
            }
            return response()->json([
                'msg' => 'Tu estas logueado'
            ]);
        } else {
            return response()->json([
                'msg' => 'Datos incorrectos'
            ], 401);
        }
    }
    public function addRole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required'
        ]);
        return Role::create([
            'roleName' => $request->roleName
        ]);
    }
    public function getRoles()
    {
        return Role::all();
    }
    public function editRole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required'
        ]);
        return Role::where('id', $request->id)->update([
            'roleName' => $request->roleName
        ]);
    }
}
