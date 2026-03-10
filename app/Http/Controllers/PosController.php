<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Client;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('active', true)->get();
        $categories = Category::all();
        $clients = Client::where('active', true)->get();

        return view('pos.index', compact('products', 'categories', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'      => 'nullable|exists:clients,id',
            'items'          => 'required|array|min:1',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'amount_paid'    => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuffisant pour {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $product->price,
                    'subtotal'     => $subtotal,
                ];

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            $discount_amount = ($total * ($request->discount ?? 0)) / 100;
            $final_total = $total - $discount_amount;
            $change = $request->amount_paid - $final_total;

            $sale = Sale::create([
                'sale_number'     => Sale::generateNumber(),
                'user_id'         => auth()->id(),
                'client_id'       => $request->client_id,
                'subtotal'        => $total,
                'discount'        => $request->discount ?? 0,
                'discount_amount' => $discount_amount,
                'total'           => $final_total,
                'amount_paid'     => $request->amount_paid,
                'change_amount'   => max(0, $change),
                'payment_method'  => $request->payment_method,
            ]);

            foreach ($items as $item) {
                $item['sale_id'] = $sale->id;
                SaleItem::create($item);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vente enregistrée avec succès',
                'sale_id' => $sale->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
