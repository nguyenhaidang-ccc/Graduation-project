<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Throwable;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $brands = Brand::orderByDesc('id')->paginate(5);
        return view('admin.brand.list', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            Brand::create($data);
            DB::commit();
            return redirect()->route('brand.index');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $brand->update($data);
            DB::commit();
            return redirect()->route('brand.index');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->back()->with('success', 'Delete successfully!');
    }
}
