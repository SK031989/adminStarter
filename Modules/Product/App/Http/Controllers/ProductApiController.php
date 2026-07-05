<?php

namespace Modules\Product\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Product\App\Models\Product;
use Modules\Product\App\Http\Requests\StoreProductRequest;
use Modules\Product\App\Http\Requests\UpdateProductRequest;

class ProductApiController extends Controller
{
    /**
     * GET /api/v1/products
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Product::class);

        $items = Product::query()
            ->forTenant(auth()->user()->tenant_id)
            ->when($request->search, fn($q) => $q->search($request->search))
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json($items);
    }

    /**
     * POST /api/v1/products
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $data              = $request->validated();
        $data['tenant_id'] = auth()->user()->tenant_id;

        $item = Product::create($data);

        return response()->json(['data' => $item, 'message' => 'Product created.'], 201);
    }

    /**
     * GET /api/v1/products/{id}
     */
    public function show(Product $product): JsonResponse
    {
        $this->authorize('view', $product);

        return response()->json(['data' => $product]);
    }

    /**
     * PUT /api/v1/products/{id}
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return response()->json(['data' => $product->fresh(), 'message' => 'Product updated.']);
    }

    /**
     * DELETE /api/v1/products/{id}
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json(['message' => 'Product deleted.']);
    }
}