<?php
// app/Http/Controllers/Admin/ReviewController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with([
            'user',
            // withTrashed() so reviews for soft-deleted products don't crash
            'product' => fn($q) => $q->withTrashed(),
        ])
        ->latest()
        ->paginate(15);

        $avgRating    = round(Review::avg('rating'), 1);
        $totalReviews = Review::count();

        return view('admin.reviews.index', compact('reviews', 'avgRating', 'totalReviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}