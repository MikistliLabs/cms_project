<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\UserRequest;
use App\Models\RolesModel;
use App\Models\User;

class UserController extends Controller
{

    // Mostrar formulario de creación
    public function create(){
        $roles = RolesModel::all();
        return view('users.create', compact('roles'));
    }

    // Guardar usuaeio
    public function store(UserRequest $request){
        try {
            $article = User::createUsuario($request->validated());
            return redirect()->route('admin.dashboard')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    // Mostrar formulario de edición
    public function edit($articleId){
        try {
            $usr = User::findOrFail($articleId);
            $roles = RolesModel::all();
            return view('users.edit', compact('usr','roles'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Artículo no encontrado.');
        }
    }

    // Actualizar artículo
    // public function update(UserRequest $request, User $article){
        public function update(Request $request, User $user){
            // dd($request, $user);
            $rules = [
                'name'  => 'required|string|max:255',
                'email' => [
                'required', 'email',
                \Illuminate\Validation\Rule::unique('pgsql_read.users')->ignore($user->id),
            ],
                // 'password' => 'nullable|min:8|confirmed',
            ];

            $data = $request->validate($rules);

            if (!$request->filled('password')) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            $updated = $user->updateUser($data, $user->id);

            if ($updated) {
                return redirect()->route('admin.dashboard')->with('success', 'Artículo actualizado exitosamente.');
            } else {
                return redirect()->back()->with('error', 'No se realizaron cambios en el artículo.');
            }
        }


    // Eliminar artículo
    public function destroy(User $user)
    {
        try {
            $user->deleteUser($user->id);
            return redirect()->route('admin.dashboard')->with('success', 'Artículo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }
}
