<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\registries;
use App\Exports\SenderExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{  
    public function searchs(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'nullable|string',
            'operator' => 'nullable|string', 
            'country' => 'nullable|string',
            'status' => 'nullable|in:pending,valide,close',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        
        $query = DB::table('registries')->select(
            'id',
            'created_at', 
            'name', 
            'operator', 
            'status', 
            'country', 
            'commentaire',
            'date_sub',
            'date_valid',
            'updated_at'
        );

        if (!empty($validated['name'])) {
            $query->where('name', 'LIKE', '%' . $validated['name'] . '%');
        }

        if (!empty($validated['operator'])) {
            $query->where('operator', $validated['operator']);
        }

        if (!empty($validated['country'])) {
            $query->where('country', $validated['country']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }
        if (!empty($validated['date_sub'])) {
            $query->whereDate('date_sub', $validated['date_sub']);
        }
        if (!empty($validated['date_valid'])) {
            $query->whereDate('date_valid', $validated['date_valid']);
        }
        if (!empty($validated['updated_at'])) {
            $query->whereDate('updated_at', $validated['updated_at']);
        }
        
        
        
        $results = $query->get();
        session(['results' => $results]);
        $showForm = true;
       
      
        return view('search', compact('results', 'showForm'));
    }
    
    public function export(string $type)
    {
        $results = session('results');
    
        // Convertir les résultats en tableau
        $exportData = $results->map(function($item) {
            return [
                'Created At' => $item->created_at,
                'Name' => $item->name,
                'Operator' => $item->operator,
                'Status' => $item->status,
                'Country' => $item->country,
                'Commentaire' => $item->commentaire
            ];
        })->toArray();

        $filename = 'sender_export_' . date('Y-m-d_H-i-s');

        // Export Excel
        if ($type === 'excel') {
            return Excel::download(new SenderExport($exportData), $filename . '.xlsx');
        }

        // Export CSV
        if ($type === 'csv') {
            return Excel::download(new SenderExport($exportData), $filename . '.csv');
        }
        
    }
    public function index()
    {
        $results = collect([]);
        return view('search', compact('results'));
    }
    // public function show($id)
    // {
    //     $record = DB::table('registries')->where('id', $id)->first();

    //     if (request()->ajax()) {
    //         return response()->json($record);
    //     }

    //     return view('search', compact('record'));
    // }
    public function getRegistryDetails($id)
{
    $registry = DB::table('registries')->find($id);
    
    return response()->json($registry);
}





    // public function sender()
    // {
    //     return view('searchsender');
    // }
    
    //     public function dashboard()
    // {
    //     $sender = registries::orderBy('created_at', 'desc')->paginate(10);
       
    //     return view('searchsender', compact('sender'));
    // }
    
    // public function show($id)
    // {
    //     $record = registries::findOrFail($id);
    //     return view('show', compact('record'));
    // }
// ****************************************** search Bouton**************************
    // public function search(Request $request)
    // {
    //     $query = registries::query();

    //     // Traitement uniquement des champs renseignés
    //     $filters = $request->only(['name', 'operator', 'country', 'status', 'created_at','date_to']);
        
    //     foreach ($filters as $field => $value) {
    //         if (!empty($value)) {
    //             switch ($field) {
    //                 case 'name':
    //                     $query->where('name', 'like', '%' . $value . '%');
    //                     break;
    //                     case 'operator':
    //                         $query->where('operator', 'like', '%' . $value . '%');
    //                         break;
                        
    //                 case 'country':
    //                     $query->where('country', 'like', '%' . $value . '%');
    //                     break;

    //                     case 'status':
    //                         $query->where('status', $value);
    //                         break;
                        
    //                 case 'created_at':
    //                     $query->whereDate('created_at', '>=', $value);
    //                     break;

    //                     case 'date_to':
    //                         $query->whereDate('created_at', '<=', $value);
    //                         break;
    //             }
    //         }
    //     }

    //     $sender = $query->latest()->paginate(10);
    //     return view('searchsender', compact('sender'))->render();
    // }
}
