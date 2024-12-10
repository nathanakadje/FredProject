<?php

namespace App\Http\Controllers;


use App\Models\registries;
use App\Models\registry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
//  ********************************************************************************************  
   
    
        public function store(Request $request){
        
            $this->validate($request, [
                'name' => 'required|max:11',
                'operator' => 'required|max:20',
                'country' => 'required|max:20',
                'status' => 'required|in:close,pending,valide',
                'date_sub' => 'required|date|before_or_equal:today',
                'date_valid' => 'required_if:status,valide,close',
                'commentaire' => 'required_if:status,close',
                
            ]);
    
            if ($request->status === 'close') {
                $rules['date_valid'] = 'required|date|nullable|after_or_equal:date_sub';
                $rules['commentaire'] = 'required|string';
            } else {
                $rules['date_valid'] = 'nullable|date';
                $rules['commentaire'] = 'nullable|string';
            }
            
            
            $messages = [
                'name.required' => 'Le nom est obligatoire',
                'name.max' => 'Le nom saisie depasse les caractère max(11) ',
                'operator.required' => 'L\'opérateur est obligatoire',
                'operator.max' => 'Le nom saisie depasse les caractère',
                'country.required' => 'Le pays est obligatoire',
                'country.max' => 'Le nom du pays saisie depasse les caractère',
                'status.required' => 'Le statut est obligatoire',
                'status.in' => 'Le statut doit être close, pending ou valide',
                'date_sub.required' => 'La date de soumission est obligatoire',
                'date_sub.date' => 'La date de soumission doit être une date valide',
                'date_valid.required' => 'La date de validation est obligatoire pour le statut valide ou close',
                'date_valid.date' => 'La date de validation doit être une date valide',
                'commentaire.required' => 'Le commentaire est obligatoire pour le statut close',
                
            ];
    
            try {
    // Validation
                $validator = Validator::make($request->all(), $rules, $messages);
    
                $sender = new registry();
                $sender->name = $request->name;
                $sender->operator = $request->operator;
                $sender->country = $request->country;
                $sender->status = $request->status;
                $sender->date_sub = $request->date_sub;
                $sender->date_valid = $request->date_valid;
                $sender->commentaire = $request->commentaire;
                $sender->save();
    
                
                    return redirect()->route('form')
                    ->with('success', 'Enregistrement réussi!');
    
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Une erreur est survenue lors de la création',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    

}
