<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Public storefront browsing. */
class productsController extends Controller
{
    public function displayOnHandsProducts()
    {
        $products = Product::inStock()->latest()->get();

        return view('user.Product', ['products' => $products]);
    }

    public function filterProducts(Request $request)
    {
        $validated = $request->validate([
            'variation' => ['nullable', Rule::enum(Variation::class)],
            'gender' => ['nullable', Rule::enum(Gender::class)],
            'size' => ['nullable', Rule::enum(ShirtSize::class)],
            'priceFrom' => ['nullable', 'numeric', 'min:0'],
            'priceTo' => ['nullable', 'numeric', 'min:0'],
        ]);

        $products = Product::inStock()
            ->when($validated['variation'] ?? null, fn ($q, $v) => $q->where('variation', $v))
            ->when($validated['gender'] ?? null, fn ($q, $v) => $q->where('gender', $v))
            ->when($validated['size'] ?? null, fn ($q, $v) => $q->where('size', $v))
            ->when($validated['priceFrom'] ?? null, fn ($q, $v) => $q->where('price', '>=', $v))
            ->when($validated['priceTo'] ?? null, fn ($q, $v) => $q->where('price', '<=', $v))
            ->get();

        return view('user.productResult', ['products' => $products]);
    }

    public function details(int $id)
    {
        return view('user.productDetails', ['product' => Product::findOrFail($id)]);
    }
}
