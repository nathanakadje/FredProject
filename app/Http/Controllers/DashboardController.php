<?php

namespace App\Http\Controllers;

use App\Models\registries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function getStatusChartData()
{
    $statusData = DB::table('registries')
        ->select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('COUNT(CASE WHEN status = \'pending\' THEN 1 END) as pending_count'),
            DB::raw('COUNT(CASE WHEN status = \'valide\' THEN 1 END) as valide_count'),
            DB::raw('COUNT(CASE WHEN status = \'close\' THEN 1 END) as close_count')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->groupByRaw('EXTRACT(MONTH FROM created_at)')
        ->orderByRaw('EXTRACT(MONTH FROM created_at)')
        ->get();

    // Préparer les données pour le graphique
    $labels = [];
    $pendingData = [];
    $valideData = [];
    $closeData = [];

    // Initialiser les données pour tous les mois
    for ($i = 1; $i <= 12; $i++) {
        $labels[] = Carbon::create()->month($i)->format('M');
        $pendingData[] = 0;
        $valideData[] = 0;
        $closeData[] = 0;
    }

    // Remplacer les valeurs avec les données réelles
    foreach ($statusData as $data) {
        $index = $data->month - 1;
        $pendingData[$index] = $data->pending_count;
        $valideData[$index] = $data->valide_count;
        $closeData[$index] = $data->close_count;
    }

    return response()->json([
        'labels' => $labels,
        'pending' => $pendingData,
        'valide' => $valideData,
        'close' => $closeData,
    ]);
}

    public function getStatusCounts()
{

    
    $statusCounts = registries::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    return response()->json([
        'pending' => $statusCounts['pending'] ?? 0,
        'valide' => $statusCounts['valide'] ?? 0,
        'close' => $statusCounts['close'] ?? 0
    ]);
}

public function getStatusStatistics()
{
    $sender = registries::orderBy('created_at', 'desc')->take(5)->get(['created_at', 'name', 'country', 'status', 'date_sub']);
    // Calculer le nombre total de senders
    $totalSenders = DB::table('registries')->count();
    
    // Calculer les statistiques par statut
    $statusStats = DB::table('registries')
    ->selectRaw('status, COUNT(*) as count')
    ->groupBy('status')
    ->pluck('count', 'status')
    ->toArray();
    // Calculer les pourcentages
  
    $stats = [
        'total' => [
            'count' => $totalSenders,
            'percentage' => 100
        ],
        'pending' => [
            'count' => $statusStats['pending'] ?? 0,
            'percentage' => round(($statusStats['pending'] ?? 0) / $totalSenders * 100, 2)
        ],
        'valide' => [
            'count' => $statusStats['valide'] ?? 0,
            'percentage' => round(($statusStats['valide'] ?? 0) / $totalSenders * 100, 2)
        ],
        'close' => [
            'count' => $statusStats['close'] ?? 0,
            'percentage' => round(($statusStats['close'] ?? 0) / $totalSenders * 100, 2)
        ]
    ];

    return view('dashboard', compact('stats', 'sender'));
}
}
