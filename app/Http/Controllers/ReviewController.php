<?php
// app/Http/Controllers/ReviewController.php  (Customer reviews)
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Only customers who completed a purchase of that product can post a review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'     => ['required', 'exists:products,id'],
            'transaction_id' => ['required', 'exists:transactions,id'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'comment'        => ['required', 'string', 'max:1000'],
        ]);

        $user = auth()->user();

        // Verify the transaction belongs to this customer (by ID or email)
        $transaction = Transaction::where('id', $validated['transaction_id'])
            ->where(function ($q) use ($user) {
                $q->where('customer_user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->where('status', 'completed')
            ->whereHas('orderItems', fn($q) => $q->where('product_id', $validated['product_id']))
            ->first();

        if (!$transaction) {
            return back()->withErrors(['error' => 'You can only review products from your completed orders.']);
        }

        // Prevent duplicate reviews
        $exists = Review::where([
            'user_id'        => $user->id,
            'product_id'     => $validated['product_id'],
            'transaction_id' => $validated['transaction_id'],
        ])->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'You have already reviewed this product for this order.']);
        }

        Review::create([
            'user_id'        => $user->id,
            'product_id'     => $validated['product_id'],
            'transaction_id' => $validated['transaction_id'],
            'rating'         => $validated['rating'],
            'comment'        => $validated['comment'],
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $review->update($validated);
        return back()->with('success', 'Review updated!');
    }
}