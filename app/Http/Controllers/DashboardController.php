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
    $statusData = DB::table('mt_messages')
        ->select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('COUNT(CASE WHEN status = \'ESME_ROK\' THEN 1 END) as pending_count'),
            DB::raw('COUNT(CASE WHEN status = \'DELIVRD\' THEN 1 END) as valide_count'),
            DB::raw('COUNT(CASE WHEN status = \'UNDELIV\' THEN 1 END) as close_count')
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

    
    $statusCounts = DB::table('mt_messages')
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();

    return response()->json([
        'pending' => $statusCounts['ESME_ROK'] ?? 0,
        'valide' => $statusCounts['DELIVRD'] ?? 0,
        'close' => $statusCounts['UNDELIV'] ?? 0
    ]);
}

public function getStatusStatistics()
{
    // $sender = registries::orderBy('created_at', 'desc')->take(5)->get(['created_at', 'name', 'country', 'status', 'date_sub']);
    $sender = DB::table('mt_messages')
    ->join('networks', 'mt_messages.network', '=', 'networks.network_id') // Jointure entre mt_messages et networks
    ->select([
        'mt_messages.created_at',
        'mt_messages.source_addr',
        'mt_messages.sent_at',

        'mt_messages.status',
        'networks.network_name' // Colonne provenant de la table networks
    ])
    ->orderBy('mt_messages.created_at', 'desc') // Tri par date de création décroissante
    ->take(5) // Limiter à 5 résultats
    ->get();
    // Calculer le nombre total de senders
    $totalSenders = DB::table('mt_messages')->count();
    
    // Calculer les statistiques par statut
    $statusStats = DB::table('mt_messages')
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
            'count' => $statusStats['ESME_ROK'] ?? 0,
            'percentage' => round(($statusStats['ESME_ROK'] ?? 0) / $totalSenders * 100, 2)
        ],
        'valide' => [
            'count' => $statusStats['DELIVRD'] ?? 0,
            'percentage' => round(($statusStats['DELIVRD'] ?? 0) / $totalSenders * 100, 2)
        ],
        'close' => [
            'count' => $statusStats['UNDELIV'] ?? 0,
            'percentage' => round(($statusStats['UNDELIV'] ?? 0) / $totalSenders * 100, 2)
        ]
    ];

    return view('dashboard', compact('stats', 'sender'));
}
}
