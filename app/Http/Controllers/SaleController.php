<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Exports\SalesExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'client']);

        if ($request->filled('search')) {
            $query->where('sale_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('date_start')) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        $sales = $query->latest()->paginate(15)->withQueryString();
        $clients = Client::all();

        return view('sales.index', compact('sales', 'clients'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'client', 'items.product']);
        return view('sales.show', compact('sale'));
    }

    public function downloadPdf(Sale $sale)
    {
        $sale->load(['user', 'client', 'items.product']);

        $pdf = Pdf::loadView('sales.invoice', compact('sale'));

        return $pdf->download('Facture-' . $sale->sale_number . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'Ventes_Mi_Varotra_' . date('d-m-Y') . '.xlsx');
    }
}
