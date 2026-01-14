<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Feedback;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show feedback form for event
     */
    public function create(Event $event)
    {
        // Check if user is registered for the event
        $isRegistered = $event->registrations()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isRegistered) {
            return redirect()->back()->with('error', 'You must be registered for this event to give feedback');
        }

        // Check if user already submitted feedback
        $existingFeedback = Feedback::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingFeedback) {
            return redirect()->back()->with('info', 'You have already submitted feedback for this event');
        }

        return view('feedback.form', compact('event'));
    }

    /**
     * Store feedback submission
     */
    public function store(Request $request, Event $event)
    {
        // Check if user is registered
        $isRegistered = $event->registrations()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isRegistered) {
            return redirect()->back()->with('error', 'You must be registered for this event');
        }

        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if feedback already exists
        $existingFeedback = Feedback::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingFeedback) {
            return redirect()->back()->with('error', 'You have already submitted feedback for this event');
        }

        // Create feedback record
        Feedback::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('events.show', $event)->with('success', 'Thank you for your feedback!');
    }

    /**
     * Show feedback results (for organizer/admin)
     */
    public function results(Event $event)
    {
        // Check authorization
        if ($event->user_id !== Auth::id() && Auth::user()->category !== 'admin') {
            abort(403);
        }

        $feedbacks = $event->feedbacks()->latest()->paginate(10);
        $averageRating = $event->feedbacks()->avg('rating');
        $totalResponses = $event->feedbacks()->count();
        $registeredCount = $event->registrations()->count();
        $responseRate = $registeredCount > 0 ? round(($totalResponses / $registeredCount) * 100) : 0;

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = $event->feedbacks()->where('rating', $i)->count();
        }

        return view('feedback.results', compact('event', 'feedbacks', 'averageRating', 'totalResponses', 'responseRate', 'registeredCount', 'ratingDistribution'));
    }
}
