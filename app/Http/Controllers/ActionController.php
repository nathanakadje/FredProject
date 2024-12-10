<?php

namespace App\Http\Controllers;

use App\Models\registries;
use App\Exports\ActionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ActionController extends Controller
{
    // Récupérer les détails d'un enregistrement
public function getRegistryDetails($id)
{
    $registry = registries::findOrFail($id);
    return response()->json($registry);
}

// Mettre à jour l'enregistrement
public function updateRegistry(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:registries,id',
        'name' => 'required|string',
        'operator' => 'required|string',
        'country' => 'required|string',
        'status' => 'required|in:pending,valide,close'
    ]);

    try {
        $registry = registries::findOrFail($validated['id']);
        $registry->update($validated);
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

// Supprimer l'enregistrement
public function deleteRegistry($id)
{
    try {
        $registry = registries::findOrFail($id);
        $registry->delete();
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
    
    // public function dashboard()
    // {
    //     $user = registries::orderBy('created_at', 'desc')->get();
       
    //     return view('actions', compact('user'));
    // }
    // public function show($id)
    // {
    //     $user = registries::findOrFail($id);
        
    //     return response()->json($user);
    // }

    // public function update(Request $request, $id)
    // {
        
    //     $user = registries::findOrFail($id);
    //     $user->name = $request->name;
    //     $user->country = $request->country;
    //     $user->status = $request->status;
    //     $user->operator = $request->operator;
    //     $user->save();

    //     return response()->json(['success' => true]);
    // }
    // public function destroy($id)
    // {
    //     $user = registries::findOrFail($id);
    //     $user->delete();

    //     return response()->json(['success' => true]);
    // }
    public function index()
    {

        // Passer les utilisateurs paginés à la vue
        return view('actions', [
            'user' => registries::orderBy('created_at', 'desc')->paginate(15)
        ]);
    }
    
    public function search(Request $request)
{
   
    $query = registries::query();

    // Traitement uniquement des champs renseignés
    $filters = $request->only(['name', 'operator', 'country', 'status', 'created_at','date_to']);
    
    foreach ($filters as $field => $value) {
        if (!empty($value)) {
            switch ($field) {
                case 'name':
                    $query->where('name', 'like', '%' . $value . '%');
                    break;
                    case 'operator':
                        $query->where('operator', 'like', '%' . $value . '%');
                        break;
                    
                case 'country':
                    $query->where('country', 'like', '%' . $value . '%');
                    break;

                    case 'status':
                        $query->where('status', $value);
                        break;
                    
                case 'created_at':
                    $query->whereDate('created_at', '>=', $value);
                    break;

                    case 'date_to':
                        $query->whereDate('created_at', '<=', $value);
                        break;
            }
        }
    }

    $user = $query->latest()->paginate(15);
    return view('actions', compact('user'))->render();
}


    // private function getFilteredQuery()
    // {
    //     $query = registries::query();

    //     if (request()->filled('name')) {
    //         $query->where('name', 'LIKE', '%' . request('name') . '%');
    //     }

    //     if (request()->filled('operator')) {
    //         $query->where('operator', 'LIKE', '%' . request('operator') . '%');
    //     }

    //     if (request()->filled('country')) {
    //         $query->where('country', request('country'));
    //     }

    //     if (request()->filled('status')) {
    //         $query->where('status', request('status'));
    //     }
    //     if (request()->filled('start_date')) {
    //         $query->whereDate('start_date', request('start_date'));
    //     }
    //     if (request()->filled('end_date')) {
    //         $query->whereDate('end_date', request('end_date'));
    //     }
        
    //     if (request()->filled('updated_at')) {
    //         $query->whereDate('updated_at', request('updated_at'));
    //     }    

      
    //     return $query;
    // }

    // public  function exported(string $type)
    // {
      
    //     $senders = $this->getFilteredQuery()->get();

    //     $filename = 'sender_export_' . date('Y-m-d_H-i-s');

    //     return match($type) {
    //                 'excel' => Excel::download(new ActionExport($senders), $filename . '.xlsx'),
    //                 'csv' => Excel::download(new ActionExport($senders), $filename . '.csv'),
    //                 default => redirect()->back()->with('error', 'Format d\'export non supporté'),
    //             };
    // }

}
