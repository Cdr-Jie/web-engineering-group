@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="margin-top: 0; color: #333;">Feedback for {{ $event->name }}</h2>
    <p style="color: #666; margin-bottom: 30px;">Thank you for attending! Please share your experience below.</p>

    @if($errors->any())
        <div style="background-color: #fee; border: 1px solid #fcc; color: #c33; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('feedback.store', $event) }}" method="POST">
        @csrf

        <!-- Star Rating -->
        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 15px; font-weight: 600; color: #333; font-size: 16px;">How would you rate this event? *</label>
            <div style="display: flex; gap: 15px; align-items: center;">
                @for($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required style="display: none;">
                    <label for="star{{ $i }}" style="font-size: 40px; cursor: pointer; color: #ddd; transition: all 0.2s; display: inline-block;" 
                        onmouseover="highlightStars({{ $i }})" 
                        onmouseout="resetStars()"
                        onclick="selectStar({{ $i }})">
                        ★
                    </label>
                @endfor
                <span id="ratingText" style="margin-left: 20px; font-weight: 600; color: #666; font-size: 16px;">Please select</span>
            </div>
        </div>

        <!-- Comment -->
        <div style="margin-bottom: 30px;">
            <label for="comment" style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 16px;">Your Feedback (Optional)</label>
            <textarea name="comment" id="comment" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-family: sans-serif; font-size: 14px; resize: vertical;" rows="5" placeholder="Tell us what you liked, what could be improved..."></textarea>
            <small style="color: #999;">Maximum 1000 characters</small>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn" style="flex: 1; background: linear-gradient(135deg, #00d9a3 0%, #1aa573 100%); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 217, 163, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 217, 163, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 217, 163, 0.3)'">
                Submit Feedback
            </button>
            <a href="{{ route('events.show', $event) }}" class="btn" style="flex: 1; background: #e5e7eb; color: #333; padding: 12px 24px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d1d5db'" onmouseout="this.style.backgroundColor='#e5e7eb'">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    const ratingText = {
        1: '😞 Poor',
        2: '😐 Fair',
        3: '😊 Good',
        4: '😄 Very Good',
        5: '🤩 Excellent'
    };

    function selectStar(rating) {
        document.getElementById(`star${rating}`).checked = true;
        updateRatingDisplay(rating);
    }

    function highlightStars(rating) {
        for (let i = 1; i <= 5; i++) {
            const label = document.querySelector(`label[for="star${i}"]`);
            label.style.color = i <= rating ? '#ffc107' : '#ddd';
        }
        document.getElementById('ratingText').textContent = ratingText[rating];
        document.getElementById('ratingText').style.color = '#ffc107';
    }

    function resetStars() {
        const selectedRating = document.querySelector('input[name="rating"]:checked');
        if (selectedRating) {
            highlightStars(selectedRating.value);
        } else {
            for (let i = 1; i <= 5; i++) {
                document.querySelector(`label[for="star${i}"]`).style.color = '#ddd';
            }
            document.getElementById('ratingText').textContent = 'Please select';
            document.getElementById('ratingText').style.color = '#666';
        }
    }

    function updateRatingDisplay(rating) {
        for (let i = 1; i <= 5; i++) {
            const label = document.querySelector(`label[for="star${i}"]`);
            label.style.color = i <= rating ? '#ffc107' : '#ddd';
        }
        document.getElementById('ratingText').textContent = ratingText[rating];
        document.getElementById('ratingText').style.color = '#ffc107';
    }

    // Initialize display on page load
    document.addEventListener('DOMContentLoaded', function() {
        resetStars();
    });
</script>
@endsection
