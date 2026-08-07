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

        // Kalkulasi Stat Cards Dinamis
        $totalOutput = $operasionals->count();
        $targetOutput = $kpi ? $kpi->target_konten : 50; // Fallback jika KPI belum diset
        $outputPercentage = $targetOutput > 0 ? round(($totalOutput / $targetOutput) * 100) : 0;
        
        $onTimeCount = $operasionals->whereIn('status_deadline', ['On-Time', 'On Track', 'Completed', 'Selesai'])->count();
        $onTimePercentage = $totalOutput > 0 ? round(($onTimeCount / $totalOutput) * 100) : 0;
        
        $avgEr = $operasionals->filter(fn($op) => $op->metric != null)->avg(fn($op) => $op->metric->engagement_rate) ?? 0;
        $avgEr = round($avgEr, 2);

        $avgRevisi = $operasionals->avg('jumlah_revisi') ?? 0;
        $avgRevisi = round($avgRevisi, 1);

        $stats = [
            'totalOutput' => $totalOutput,
            'targetOutput' => $targetOutput,
            'outputPercentage' => min(100, $outputPercentage),
            'onTimeCount' => $onTimeCount,
            'onTimePercentage' => $onTimePercentage,
            'avgEr' => $avgEr,
            'avgRevisi' => $avgRevisi,
        ];

        return view('operational.content-creator.dashboard', compact(
            'kpi', 'operasionals', 'chartLabels', 'chartErData', 'chartTopVisualNames', 'chartTopVisualEr', 'stats'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content_id' => 'required|unique:content_operasionals,content_id',
            'tanggal_brief' => 'required|date',
            'target_deadline' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status_deadline' => 'required|in:On Track,Late,Completed',
            'platform' => 'required',
            'format_konten' => 'required',
            'judul_konten' => 'required',
            'jumlah_revisi' => 'required|integer|min:0',
            'link_aset' => 'nullable|url'
        ]);

        \App\Models\ContentOperasional::create($request->all());

        return redirect()->back()->with('success', 'Data Konten Operasional berhasil ditambahkan.');
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
