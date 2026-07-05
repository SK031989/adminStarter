<?php

namespace Modules\Product\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Product\App\Models\Product;
use Modules\Product\App\Http\Requests\StoreProductRequest;
use Modules\Product\App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        $this->authorize('viewAny', Product::class);

        $products = Product::query()
            ->forTenant(auth()->user()->tenant_id)
            ->when($request->search, fn ($q) => $q->search($request->search))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(config('modulebuilder.pagination.per_page', 15))
            ->withQueryString();

        return view('products::index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        $this->authorize('create', Product::class);

        return view('products::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $data              = $request->validated();
        $data['tenant_id'] = auth()->user()->tenant_id;

        Product::create($data);

        $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
        $route = $isAdminCase ? 'admin.products.index' : 'products.index';
        return redirect()
            ->route($route)
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        $this->authorize('view', $product);

        return view('products::show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (auth()->check()) {
            $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if ($isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        $this->authorize('update', $product);

        return view('products::edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        $isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
        $route = $isAdminCase ? 'admin.products.index' : 'products.index';
        return redirect()
            ->route($route)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        $route = auth()->user()->is_admin ? 'admin.products.index' : 'products.index';
        return redirect()
            ->route($route)
            ->with('success', 'Product deleted successfully.');
    }
}