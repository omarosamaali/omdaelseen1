<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function create()
    {
        return view('mobile.order.product.create');
    }

    public function store(Request $request)
    {
        \Log::info('Store Input:', $request->all());
        $validatedData = $request->validate([
            'reference_number' => 'required|string|unique:products,reference_number',
            'number_of_products' => 'required|integer|min:1|max:5',
            'price_unexpected' => 'required|string',
            'item_unavailable' => 'required|string',
            'no_returns' => 'required|string',
            'no_problem' => 'required|string',
            'same_company' => 'required|string',
            'batteries' => 'required|string',
            'see_product' => 'required|string',
            'user_id' => 'required',
        ]);

        \Log::info('Validated Data:', $validatedData);
        $request->session()->put('product_order_data', $validatedData);
        \Log::info('Session Data Stored:', $request->session()->all());

        return redirect()->route('mobile.order.product.createProducts');
    }

    public function createProducts(Request $request)
    {
        $orderData = $request->session()->get('product_order_data');
        \Log::info('Session Data:', $orderData ?? ['no_data' => true]);
        if (!$orderData) {
            return redirect()->route('mobile.order.product.create')->with('error', 'يرجى إكمال النموذج الأول');
        }
        return view('mobile.order.product.createProducts', [
            'referenceNumber'    => $orderData['reference_number'],
            'numberOfProducts'   => $orderData['number_of_products'],
            'priceUnexpected'    => $orderData['price_unexpected'],
            'itemUnavailable'    => $orderData['item_unavailable'],
            'noReturns'          => $orderData['no_returns'],
            'no_problem'         => $orderData['no_problem'],
            'same_company'       => $orderData['same_company'],
            'batteries'          => $orderData['batteries'],
            'see_product'        => $orderData['see_product'],
            'userId'             => $orderData['user_id']
        ]);
    }

    public function storeProducts(Request $request)
    {
        \Log::info('StoreProducts Input:', $request->all());
        $orderData = $request->session()->get('product_order_data');

        if (!$orderData) {
            \Log::error('No session data found');
            return redirect()->route('mobile.order.product.create')
                ->with('error', 'انتهت جلستك، يرجى البدء من جديد');
        }

        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.name' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.link' => 'nullable|url',
            'products.*.price' => 'nullable|numeric|min:0',
            'products.*.size' => 'nullable|string|max:255',
            'products.*.color' => 'nullable|string|max:255',
            'products.*.notes' => 'nullable|string',
            'products.*.images' => 'nullable|array|max:5',
            'products.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors', $validator->errors()->toArray());
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'يرجى التأكد من صحة جميع البيانات المدخلة');
        }

        DB::beginTransaction();
        try {
            $productOrder = Product::create([
                'user_id' => $orderData['user_id'],
                'reference_number' => $orderData['reference_number'],
                'number_of_products' => $orderData['number_of_products'],
                'price_unexpected' => $orderData['price_unexpected'],
                'item_unavailable' => $orderData['item_unavailable'],
                'no_returns' => $orderData['no_returns'],
                'no_problem' => $orderData['no_problem'], // Add this
                'same_company' => $orderData['same_company'], // Add this
                'batteries' => $orderData['batteries'], // Add this
                'see_product' => $orderData['see_product'], // Add this
            ]);
            \Log::info('Product Created', $productOrder->toArray());

            $productsData = $request->input('products');
            $productFiles = $request->file('products');

            foreach ($productsData as $key => $productData) {
                $imagesPaths = [];
                if (isset($productFiles[$key]['images'])) {
                    foreach ($productFiles[$key]['images'] as $image) {
                        $filename = time() . '_' . $key . '_' . $image->getClientOriginalName();
                        $path = $image->storeAs('product-images', $filename, 'public');
                        $imagesPaths[] = $path;
                    }
                }

                $productOrder->orderProducts()->create([
                    'name' => $productData['name'],
                    'link' => $productData['link'] ?? null,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'] ?? null,
                    'size' => $productData['size'] ?? null,
                    'color' => $productData['color'] ?? null,
                    'notes' => $productData['notes'] ?? null,
                    'images' => json_encode($imagesPaths),
                ]);
            }

            DB::commit();
            $request->session()->forget('product_order_data');

            return redirect()->route('mobile.order.product.success', ['product' => $productOrder->id])
                ->with('success', 'تم إرسال طلب المنتجات بنجاح!');
        } catch (\Exception $e) {
            \Log::error('StoreProducts Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            DB::rollBack();
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }


    private function handleProductImages($request, $product)
    {
        foreach ($request->file('products') as $productIndex => $productFiles) {
            if (isset($productFiles['images']) && is_array($productFiles['images'])) {
                foreach ($productFiles['images'] as $image) {
                    $filename = time() . '_' . $productIndex . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('product-images', $filename, 'public');
                }
            }
        }
    }

    public function success($productId)
    {
        $product = Product::findOrFail($productId);
        return view('mobile.order.product.success', compact('product'));
    }
}
