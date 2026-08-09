<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use App\Traits\SortsQueries;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * The catalog screen — what the admin panel called the "On Hand" tab.
 *
 * It was one of three near-identical controllers (894 lines across
 * adminOnHandsController, adminOnProcessController and
 * adminCancelReturnController) that each re-implemented moveProduct,
 * moveMultiple, removeMultiple, sortProduct and filterDate. Splitting them by
 * responsibility rather than by destination table is what removes the
 * duplication: this one owns products, AdminOrderItemController owns order
 * lines, and neither copies rows into the other.
 */
class AdminProductController extends Controller
{
    use SortsQueries;

    private const SORTABLE = ['id', 'description', 'price', 'stock', 'created_at'];

    public function index()
    {
        return view('admin.products.onHand', [
            'products' => Product::latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules() + [
            // svg dropped: it is a scriptable document, and these are served
            // back to browsers.
            'image_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // store() hashes the filename. storeAs($clientOriginalName) let an
        // upload silently overwrite an existing file of the same name.
        $validated['image_path'] = $request->file('image_path')->store('images', 'public');

        Product::create($validated);

        return redirect()->to('/products/onHand')->with('success', 'Product added');
    }

    public function update(Request $request, int $id)
    {
        Product::findOrFail($id)->update($request->validate($this->rules()));

        return redirect()->back()->with('updatingSuccess', 'Updating successful');
    }

    public function destroy(int $id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->back()->with('removedSucess', 'Product successfully removed');
    }

    public function destroyMany(Request $request)
    {
        $ids = $this->idList($request->input('toRemove'));

        if ($ids === []) {
            return redirect()->back()->with(['fail' => 'No selected item']);
        }

        Product::whereIn('id', $ids)->delete();

        return redirect()->back()->with(['success' => 'Deleted successfully']);
    }

    /**
     * Sell an on-hand product to a named customer.
     *
     * This is what moveProduct did by copying the row into product_on_process
     * and deleting it from product_on_hand — which lost the stock count for
     * every other customer, since the whole product left the catalog however
     * many were bought.
     */
    public function sell(Request $request, int $id, OrderService $orders)
    {
        $validated = $request->validate([
            'userId' => ['required', 'exists:customers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $customer = User::findOrFail($validated['userId']);

        $orders->placeFor($customer, [$id => (int) $validated['quantity']], [
            'address' => $customer->address,
            'contact' => (string) $customer->contact,
            'payment_method' => 'cash_on_delivery',
        ]);

        return redirect()->back()->with('moveSuccess', 'Order created for the customer');
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'id' => ['nullable', 'integer'],
            'variation' => ['nullable', Rule::enum(Variation::class)],
            'gender' => ['nullable', Rule::enum(Gender::class)],
            'size' => ['nullable', Rule::enum(ShirtSize::class)],
            'price' => ['nullable', 'numeric'],
        ]);

        $products = Product::query()
            ->when($validated['id'] ?? null, fn ($q, $v) => $q->whereKey($v))
            ->when($validated['variation'] ?? null, fn ($q, $v) => $q->where('variation', $v))
            ->when($validated['gender'] ?? null, fn ($q, $v) => $q->where('gender', $v))
            ->when($validated['size'] ?? null, fn ($q, $v) => $q->where('size', $v))
            ->when($validated['price'] ?? null, fn ($q, $v) => $q->where('price', $v))
            ->get();

        return view('admin.products.onHandPartial', compact('products'));
    }

    public function sort(Request $request)
    {
        $products = $this->applySort(Product::query(), $request, self::SORTABLE, 'sortProductBy', 'orderProductBy')->get();

        return view('admin.products.onHandPartial', compact('products'));
    }

    private function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255'],
            'variation' => ['required', Rule::enum(Variation::class)],
            'gender' => ['required', Rule::enum(Gender::class)],
            'size' => ['required', Rule::enum(ShirtSize::class)],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    private function idList(?string $csv): array
    {
        if (blank($csv)) {
            return [];
        }

        return array_values(array_filter(array_map('intval', explode(',', $csv))));
    }
}
