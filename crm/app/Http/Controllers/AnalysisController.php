<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnalysisController extends Controller
{
    public function index()
    {
        // RFM分析
        // 1. 購買ID毎にまとめる
        $startDate = '2023-01-01';
        $endDate = '2023-12-31';
        $subQuery = Order::betweenDate($startDate, $endDate)
            ->groupBy('id')
            ->selectRaw('id, customer_id, customer_name, SUM(subtotal) as totalPerPurchase, created_at');

        // 2. 会員毎にまとめて最終購入日、回数、合計金額を取得
        $subQuery = DB::table($subQuery)
            ->groupBy('customer_id')
            ->selectRaw('customer_id, customer_name,
                max(created_at) as recentDate,
                datediff(now(), max(created_at)) as recency,
                count(customer_id) as frequency,
                sum(totalPerPurchase) as monetary');

        // 4. 会員毎のRFMランクを計算
        // $rfmPrms = [
        //     14, 28, 60, 90, 7, 5, 3, 2, 300000, 200000, 100000, 30000 ];

        // $subQuery = DB::table($subQuery)
        //     ->selectRaw('customer_id, customer_name,
        //         recentDate, recency, frequency, monetary,
        //         case
        //             when recency < ? then 5
        //             when recency < ? then 4
        //             when recency < ? then 3
        //             when recency < ? then 2
        //             else 1 end as r,
        //         case
        //             when ? <= frequency then 5
        //             when ? <= frequency then 4
        //             when ? <= frequency then 3
        //             when ? <= frequency then 2
        //             else 1 end as f,
        //         case
        //             when ? <= monetary then 5
        //             when ? <= monetary then 4
        //             when ? <= monetary then 3
        //             when ? <= monetary then 2
        //             else 1 end as m', $rfmPrms
        //     );

        // // 5.ランク毎の数を計算する
        // $total = DB::table($subQuery)->count();

        // $rCount = DB::table($subQuery, 'subquery')
        //     ->rightJoin('ranks', 'ranks.rank', '=', 'sub.rank')
        //     ->groupBy('ranks.rank')
        //     ->selectRaw('ranks.rank as r, count(*) as r_count')
        //     ->orderBy('r', 'desc')
        //     ->pluck('r_count');

        // $fCount = DB::table($subQuery, 'subquery')
        //     ->rightJoin('ranks', 'ranks.rank', '=', 'subquery.f')
        //     ->groupBy('ranks.rank')
        //     ->selectRaw('ranks.rank as f, count(*) as f_count')
        //     ->orderBy('f', 'desc')
        //     ->pluck('f_count');

        // $mCount = DB::table($subQuery, 'subquery')
        //     ->rightJoin('ranks', 'ranks.rank', '=', 'subquery.m')
        //     ->groupBy('ranks.rank')
        //     ->selectRaw('ranks.rank as m, count(*) as m_count')
        //     ->orderBy('m', 'desc')
        //     ->pluck('m_count');

        // $eachCount = []; // Vue側に渡すようの空の配列
        // $rank = 5; // 初期値5

        // for($i = 0; $i < 5; $i++)
        // {
        //     array_push($eachCount, [
        //         'rank' => $rank,
        //         'r' => $rCount[$i],
        //         'f' => $fCount[$i],
        //         'm' => $mCount[$i],
        //     ]);
        //     $rank--; // rankを1ずつ減らす
        // }

        // 6. RとFで2次元で表示してみる
        // $data = DB::table($subQuery)
        //     ->rightJoin('ranks', 'ranks.rank', '=', 'r')
        //     ->groupBy('rank')
        //     ->selectRaw('concat("r_", rank) as rRank,
        //         count(case when f = 5 then 1 end ) as f_5,
        //         count(case when f = 4 then 1 end ) as f_4,
        //         count(case when f = 3 then 1 end ) as f_3,
        //         count(case when f = 2 then 1 end ) as f_2,
        //         count(case when f = 1 then 1 end ) as f_1')
        //     ->orderBy('rRank', 'desc')
        //     ->get();

        return Inertia::render('Analysis');
    }
}
