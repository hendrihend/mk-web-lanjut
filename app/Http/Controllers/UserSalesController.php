<?php

namespace App\Http\Controllers;

use App\Models\UserSales;
use Illuminate\Http\Request;

class UserSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $region = request('region');

        $userSales = UserSales::query();

        if ($search) {
            $userSales->search($search);
        }

        if ($region) {
            $userSales->byRegion($region);
        }

        $userSales = $userSales->paginate(10);

        $regions = UserSales::distinct()->pluck('region');

        return view('user-sales.index', compact('userSales', 'regions', 'search', 'region'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user-sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_sales,email',
            'phone' => 'nullable|string|max:20',
            'region' => 'required|string|max:100',
            'quota' => 'required|numeric|min:0',
            'achievement' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        UserSales::create($validated);

        return redirect()->route('user-sales.index')
            ->with('success', 'User Sales berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserSales $userSale)
    {
        return view('user-sales.show', compact('userSale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserSales $userSale)
    {
        return view('user-sales.edit', compact('userSale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserSales $userSale)
    {
        $validated = $request->validate([
            'sales_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_sales,email,' . $userSale->id,
            'phone' => 'nullable|string|max:20',
            'region' => 'required|string|max:100',
            'quota' => 'required|numeric|min:0',
            'achievement' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        $userSale->update($validated);

        return redirect()->route('user-sales.show', $userSale)
            ->with('success', 'User Sales berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSales $userSale)
    {
        $userSale->delete();

        return redirect()->route('user-sales.index')
            ->with('success', 'User Sales berhasil dihapus!');
    }
}
