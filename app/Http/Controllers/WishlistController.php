<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()
            ->orderBy('is_bought')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();

        $totalEstimated = $wishlists->where('is_bought', false)->sum('estimated_price');

        return view('wishlists.index', compact('wishlists', 'totalEstimated'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'icon'            => 'nullable|string|max:10',
            'estimated_price' => 'nullable|numeric|min:0',
            'link'            => 'nullable|url|max:255',
            'priority'        => 'required|in:low,medium,high',
        ]);

        auth()->user()->wishlists()->create($request->all());
        return redirect()->route('wishlists.index')->with('success', 'Item wishlist berhasil ditambahkan!');
    }

    public function toggleBought(Wishlist $wishlist)
    {
        $wishlist->update(['is_bought' => !$wishlist->is_bought]);
        return redirect()->route('wishlists.index')->with('success',
            $wishlist->is_bought ? 'Item ditandai belum dibeli!' : 'Selamat! Item ditandai sudah dibeli! 🎉'
        );
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return redirect()->route('wishlists.index')->with('success', 'Item berhasil dihapus!');
    }
}