@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 30px;">
    <h2 style="color: #333; margin-top: 0;">Feedback Results for {{ $event->name }}</h2>

    <!-- Summary Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 217, 163, 0.3);">
            <p style="margin: 0; font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">Average Rating</p>
            <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700;">{{ number_format($averageRating, 1) }}</h3>
            <p style="margin: 5px 0 0 0; font-size: 18px;">
                @for($i = 0; $i < floor($averageRating); $i++)
                    ★
                @endfor
                @if($averageRating - floor($averageRating) > 0)
                    <span style="opacity: 0.5;">★</span>
                @endif
            </p>
        </div>

        <div style="background: #3b82f6; color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
            <p style="margin: 0; font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">Total Responses</p>
            <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700;">{{ $totalResponses }}</h3>
            <p style="margin: 5px 0 0 0; font-size: 14px;">out of {{ $registeredCount }} registered</p>
        </div>

        <div style="background: #f59e0b; color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
            <p style="margin: 0; font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">Response Rate</p>
            <h3 style="margin: 10px 0 0 0; font-size: 36px; font-weight: 700;">{{ $responseRate }}%</h3>
            <div style="margin-top: 10px; background: rgba(255, 255, 255, 0.2); border-radius: 20px; height: 6px;">
                <div style="background: white; height: 100%; border-radius: 20px; width: {{ $responseRate }}%;"></div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 40px;">
        <h3 style="margin-top: 0; color: #333;">Rating Distribution</h3>
        @for($rating = 5; $rating >= 1; $rating--)
            @php
                $count = $ratingDistribution[$rating] ?? 0;
                $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100) : 0;
            @endphp
            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-weight: 600; min-width: 80px;">
                        @for($i = 0; $i < $rating; $i++)
                            ★
                        @endfor
                        ({{ $rating }})
                    </span>
                    <div style="flex: 1; background: #e5e7eb; border-radius: 20px; height: 20px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); height: 100%; width: {{ $percentage }}%; transition: width 0.3s ease;"></div>
                    </div>
                    <span style="min-width: 60px; text-align: right; color: #666;">{{ $count }} ({{ $percentage }}%)</span>
                </div>
            </div>
        @endfor
    </div>

    <!-- Individual Feedbacks -->
    <div>
        <h3 style="color: #333; margin-top: 0;">Recent Feedback</h3>
        @forelse($feedbacks as $feedback)
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                    <div>
                        <strong style="color: #333; font-size: 16px;">{{ $feedback->user->name }}</strong>
                        <p style="margin: 8px 0 0 0; color: #666; font-size: 14px;">
                            @for($i = 0; $i < $feedback->rating; $i++)
                                ★
                            @endfor
                            <span style="color: #999; margin-left: 10px;">({{ $feedback->rating }}/5)</span>
                        </p>
                    </div>
                    <small style="color: #999;">{{ $feedback->created_at->format('M d, Y') }}</small>
                </div>

                @if($feedback->comment)
                    <p style="margin: 0; color: #555; line-height: 1.6; font-size: 14px;">{{ $feedback->comment }}</p>
                @else
                    <p style="margin: 0; color: #999; font-style: italic; font-size: 14px;">No comment provided</p>
                @endif
            </div>
        @empty
            <div style="background: #f9fafb; padding: 40px; border-radius: 10px; text-align: center;">
                <i class="fas fa-comment-dots" style="font-size: 48px; color: #d1d5db; margin-bottom: 15px; display: block;"></i>
                <p style="color: #999; font-size: 16px;">No feedback yet</p>
            </div>
        @endforelse
    </div>

    {{ $feedbacks->links() }}
</div>
@endsection
