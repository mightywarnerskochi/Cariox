<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormDataController extends Controller
{
    public function index(Request $request)
    {
        $query = FormData::query();

        // Filters
        if ($request->filled('source')) {
            $query->where('page_source', $request->source);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $datas = $query->latest()->get();
        $sources = FormData::distinct()->pluck('page_source')->filter()->values();

        return view('admin.form_data.index', compact('datas', 'sources'));
    }

    public function show($id)
    {
        $data = FormData::findOrFail($id);
        return view('admin.form_data.view', compact('data'));
    }

    public function destroy($id)
    {
        FormData::findOrFail($id)->delete();
        return back()->with('success', 'Form data deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids && is_array($request->ids)) {
            FormData::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true, 'message' => 'Items deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No items selected.'], 400);
    }

    public function export(Request $request)
    {
        $query = FormData::query();

        if ($request->filled('source')) {
            $query->where('page_source', $request->source);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $records = $query->latest()->get();
        $type = $request->get('type', 'csv');
        $filename = "form_datas_" . date('Y-m-d_H-i-s');

        if ($type === 'excel') {
            // XLS compatible HTML output
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');

            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Product/Service</th><th>Message</th><th>Source</th><th>URL</th><th>Created At</th></tr>';
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row->id . '</td>';
                echo '<td>' . e($row->name) . '</td>';
                echo '<td>' . e($row->email) . '</td>';
                echo '<td>' . e($row->phone) . '</td>';
                echo '<td>' . e($row->company) . '</td>';
                echo '<td>' . e($row->product_name) . '</td>';
                echo '<td>' . e($row->message) . '</td>';
                echo '<td>' . e($row->page_source) . '</td>';
                echo '<td>' . e($row->page_url) . '</td>';
                echo '<td>' . $row->created_at->format('Y-m-d H:i:s') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            exit();
        }
        else {
            // CSV output
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
            $handle = fopen('php://output', 'w');
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Company', 'Product/Service', 'Message', 'Source', 'URL', 'Created At']);

            foreach ($records as $row) {
                fputcsv($handle, [
                    $row->id, $row->name, $row->email, $row->phone, $row->company,
                    $row->product_name, $row->message, $row->page_source, $row->page_url,
                    $row->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
            exit();
        }
    }
}
