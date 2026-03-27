<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = Newsletter::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $datas = $query->latest()->get();

        return view('admin.newsletter.index', compact('datas'));
    }

    public function destroy($id)
    {
        Newsletter::findOrFail($id)->delete();
        return back()->with('success', 'Newsletter subscription removed.');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids && is_array($request->ids)) {
            Newsletter::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true, 'message' => 'Subscriptions deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No items selected.'], 400);
    }

    public function export(Request $request)
    {
        $query = Newsletter::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $records = $query->latest()->get();
        $type = $request->get('type', 'csv');
        $filename = "newsletter_subscriptions_" . date('Y-m-d_H-i-s');

        if ($type === 'excel') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Email</th><th>Subscribed At</th></tr>';
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row->id . '</td>';
                echo '<td>' . e($row->email) . '</td>';
                echo '<td>' . $row->created_at->format('Y-m-d H:i:s') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            exit();
        }
        else {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
            $handle = fopen('php://output', 'w');
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, ['ID', 'Email', 'Subscribed At']);

            foreach ($records as $row) {
                fputcsv($handle, [$row->id, $row->email, $row->created_at->format('Y-m-d H:i:s')]);
            }
            fclose($handle);
            exit();
        }
    }
}
