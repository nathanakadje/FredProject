<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function form_login()
    {
        return  view('login');
    }
    public function form_register()
    {
        return  view('register');
    }
    // ***********************Traitement des donnees de la page register*****************************
    public function form_traitement(Request $request)
    {
         $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'email|required|unique:admins',
            'password' => 'required|min:8'
         ]);
         $messages = [
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'L\'email saisie exite déjà',
            'password.required' => 'le password est  obligatoire',
            'password.min' => 'Saisie au moins huit caractère',

         ];
         try {
            $validator = Validator::make($request->all(), $messages);
            $user = new Admin();
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            
            return redirect('/dashboard');
         } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
// ***********************Traitement des donnees de la page login*****************************
    public function login_form(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:8'
        ]);
        $user = Admin::where('email', $request->input('email'))->first();
        // *********************compare le password entrer à celui de la bd*****************
        if($user)
        {
            if($user && Hash::check($request->input('password'), $user->password)){

                $request->session()->put('admins', $user);
                return redirect('/dashboard');

            }else{
                return back()->with('status', 'Identifiant ou mot de passe incorrect');
            }

        }else{
            return back()->with('status', 'désole vous n\'avez pas de compte client.');
        }
    }

    // *******************************************************

}
