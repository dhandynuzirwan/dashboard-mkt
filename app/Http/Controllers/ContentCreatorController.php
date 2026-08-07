<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentCreatorController extends Controller
{
    public function index()
    {
        // Ambil KPI
        $kpi = \App\Models\ContentKpi::latest()->first();
        
        // Ambil data Operasional beserta Metrik & Evaluasinya
        $operasionals = \App\Models\ContentOperasional::with(['metric', 'evaluation'])
                            ->orderBy('target_deadline', 'desc')->get();
        
        // Siapkan Data Chart
        $chartLabels = [];
        $chartErData = [];
        $chartTopVisualNames = [];
        $chartTopVisualEr = [];

        // Kalkulasi untuk Line Chart & Bar Chart
        // Misal kita ambil 5 data terakhir untuk trend ER
        $recentOps = $operasionals->take(5)->reverse();
        foreach($recentOps as $op) {
            $chartLabels[] = $op->judul_konten ?? 'Konten';
            $chartErData[] = $op->metric ? $op->metric->engagement_rate : 0;
        }

        // Cari 5 Top Visual berdasarkan ER (jika ada metric)
        $topOps = $operasionals->filter(function($op) {
            return $op->metric != null;
        })->sortByDesc(function($op) {
            return $op->metric->engagement_rate;
        })->take(5);

        foreach($topOps as $op) {
            $chartTopVisualNames[] = $op->judul_konten ?? 'Konten';
            $chartTopVisualEr[] = $op->metric->engagement_rate;
        }

        return view('operational.content-creator.dashboard', compact(
            'kpi', 'operasionals', 'chartLabels', 'chartErData', 'chartTopVisualNames', 'chartTopVisualEr'
        ));
    }

    public function storeMetric(Request $request, $id)
    {
        $op = \App\Models\ContentOperasional::findOrFail($id);
        
        // Hitung manual ER jika diperlukan, misal: (Likes + Comments + Shares + Saves) / Impressions * 100
        $impressions = $request->impressions ?? 0;
        $reach = $request->reach ?? 0;
        $likes = $request->likes ?? 0;
        $comments = $request->comments ?? 0;
        $shares = $request->shares ?? 0;
        $saves = $request->saves ?? 0;

        $totalEngagements = $likes + $comments + $shares + $saves;
        $er = $impressions > 0 ? ($totalEngagements / $impressions) * 100 : 0;

        \App\Models\ContentMetric::updateOrCreate(
            ['content_id' => $op->content_id],
            [
                'impressions' => $impressions,
                'reach' => $reach,
                'likes' => $likes,
                'comments' => $comments,
                'shares' => $shares,
                'saves' => $saves,
                'engagement_rate' => round($er, 2),
                'link_insight' => $request->link_insight,
            ]
        );

        return redirect()->back()->with('success', 'Metrik performa berhasil disimpan.');
    }

    public function storeEvaluation(Request $request, $id)
    {
        $op = \App\Models\ContentOperasional::findOrFail($id);

        \App\Models\ContentEvaluation::updateOrCreate(
            ['content_id' => $op->content_id],
            [
                'kesesuaian_brand' => $request->kesesuaian_brand,
                'jumlah_template_baru' => $request->jumlah_template_baru ?? 0,
                'status_laporan_riset' => $request->status_laporan_riset,
            ]
        );

        return redirect()->back()->with('success', 'Evaluasi internal berhasil disimpan.');
    }
}
