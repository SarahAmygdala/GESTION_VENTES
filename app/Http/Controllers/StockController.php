<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Affiche l'historique des mouvements de stock (l'archive).
     */
    public function index(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date_start')) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        $movements = $query->latest()->paginate(20)->withQueryString();

        return view('stock.index', compact('movements'));
    }

    /**
     * Formulaire pour ajouter du stock.
     */
    public function create(Request $request)
    {
        $products = Product::where('active', true)->orderBy('name')->get();
        $selected_product_id = $request->product_id;

        return view('stock.create', compact('products', 'selected_product_id'));
    }

    /**
     * Enregistre un mouvement de stock et met à jour le produit.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'type'       => 'required|in:in,out,adjustment',
            'reason'     => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);

            // Créer le mouvement (l'archive)
            StockMovement::create([
                'product_id' => $request->product_id,
                'user_id'    => \Illuminate\Support\Facades\Auth::id(),
                'previous_stock' => $product->stock,
                'quantity'   => $request->quantity,
                'type'       => $request->type,
                'reason'     => $request->reason,
            ]);

            // Mettre à jour le stock du produit
            if ($request->type === 'in') {
                $product->increment('stock', $request->quantity);
            } elseif ($request->type === 'out') {
                $product->decrement('stock', $request->quantity);
            } else {
                // Adjustment: on remplace ou on ajuste ? Généralement on ajuste.
                // Ici on va considérer que c'est un ajout/retrait signé
                $product->increment('stock', $request->quantity);
            }

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "Stock mis à jour avec succès pour {$product->name}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Erreur lors de la mise à jour du stock : " . $e->getMessage());
        }
    }
}
