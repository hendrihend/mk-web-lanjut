<?php

namespace App\Http\Controllers;

use App\Models\MarketingUser;
use Illuminate\Http\Request;

class MarketingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MarketingUser::query();

        // Filter berdasarkan search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter berdasarkan department
        if ($request->filled('department')) {
            $query->where('department', $request->get('department'));
        }

        // Filter berdasarkan territory
        if ($request->filled('territory')) {
            $query->where('territory', $request->get('territory'));
        }

        $marketingUsers = $query->paginate(15);

        return view('marketing-users.index', compact('marketingUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marketing-users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:marketing_users,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'territory' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        MarketingUser::create($validated);

        return redirect()->route('marketing-users.index')
            ->with('success', 'Marketing user berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketingUser $marketingUser)
    {
        return view('marketing-users.show', compact('marketingUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketingUser $marketingUser)
    {
        return view('marketing-users.edit', compact('marketingUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarketingUser $marketingUser)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:marketing_users,email,' . $marketingUser->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'territory' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        $marketingUser->update($validated);

        return redirect()->route('marketing-users.show', $marketingUser)
            ->with('success', 'Marketing user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketingUser $marketingUser)
    {
        $marketingUser->delete();

        return redirect()->route('marketing-users.index')
            ->with('success', 'Marketing user berhasil dihapus!');
    }

    /**
     * Display the admin dashboard summary.
     */
    public function dashboard()
    {
        $totalUsers = MarketingUser::count();
        $activeUsers = MarketingUser::where('status', 'active')->count();
        $inactiveUsers = MarketingUser::where('status', 'inactive')->count();
        $departments = MarketingUser::distinct('department')->whereNotNull('department')->count('department');

        return view('dashboard', compact('totalUsers', 'activeUsers', 'inactiveUsers', 'departments'));
    }
}
