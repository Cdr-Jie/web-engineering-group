<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    @vite('resources/css/style.css')
</head>
<body>

@include('includes.loginTopNav')

<section class="dashboard-section-content">
    <h2>Edit Event</h2>

    @if($errors->any())
        <div class="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="event-form">
        @csrf
        @method('PUT')

        <fieldset>
            <legend>Event Information</legend>

            <fieldset>
            <legend>Event Posters</legend>

            @if($event->posters && count($event->posters) > 0)
                <div style="margin-bottom: 20px;">
                    <p><strong>Current Posters:</strong></p>
                    <div class="events-images-container">
                        @foreach($event->posters as $index => $poster)
                            <div class="event-image-item" style="position: relative;">
                                <img src="{{ asset('storage/' . $poster) }}" alt="Event Poster" class="event-poster">
                                <button type="button" class="poster-delete-btn" onclick="removePoster(this, {{ $index }})" style="position: absolute; top: 5px; right: 5px; background: rgba(255, 0, 0, 0.8); color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 14px;">Delete</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <label>
                Event Name <span style="color:red;">*</span>
                <input type="text" name="name" value="{{ old('name', $event->name) }}" required>
            </label>

            <label>
                Description <span style="color:red;">*</span>
                <textarea name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
            </label>

            <label>
                Organizer <span style="color:red;">*</span>
                <input type="text" name="organizer" value="{{ old('organizer', $event->organizer) }}" required>
            </label>

            <label>
                Contact Person
                <input type="text" name="contact_person" value="{{ old('contact_person', $event->contact_person) }}">
            </label>

            <label>
                Contact Number
                <input type="text" name="contact_no" value="{{ old('contact_no', $event->contact_no) }}">
            </label>

            <label>
                Event Type <span style="color:red;">*</span>
                <select name="type" required>
                    <option value="">-- Select Type --</option>
                    <option value="Workshop" {{ old('type', $event->type) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Seminar" {{ old('type', $event->type) == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="Competition" {{ old('type', $event->type) == 'Competition' ? 'selected' : '' }}>Competition</option>
                    <option value="Festival" {{ old('type', $event->type) == 'Festival' ? 'selected' : '' }}>Festival</option>
                    <option value="Sport" {{ old('type', $event->type) == 'Sport' ? 'selected' : '' }}>Sport</option>
                    <option value="Course" {{ old('type', $event->type) == 'Course' ? 'selected' : '' }}>Course</option>
                </select>
            </label>
        </fieldset>

        <fieldset>
            <legend>Event Details</legend>

            <label>
                Venue <span style="color:red;">*</span>
                <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" required>
            </label>

            <label>
                Event Date <span style="color:red;">*</span>
                <input type="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
            </label>

            <label>
                Event Time <span style="color:red;">*</span>
                <input type="time" name="time" value="{{ old('time', $event->time) }}" required>
            </label>

            <label>
                Mode <span style="color:red;">*</span>
                <select name="mode" required>
                    <option value="">-- Select Mode --</option>
                    <option value="Physical" {{ old('mode', $event->mode) == 'Physical' ? 'selected' : '' }}>Physical</option>
                    <option value="Online" {{ old('mode', $event->mode) == 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Hybrid" {{ old('mode', $event->mode) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </label>

            <label>
                Registration Close Date <span style="color:red;">*</span>
                <input type="date" name="registration_close" value="{{ old('registration_close', $event->registration_close->format('Y-m-d')) }}" required>
            </label>

            <label>
                Maximum Participants
                <input type="number" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="1">
                <small>Leave empty for unlimited</small>
            </label>

            <label>
                Fee <span style="color:red;">*</span>
                <input type="text" name="fee" value="{{ old('fee', $event->fee) }}" placeholder="e.g., Free or RM 50" required>
            </label>

            <label>
                Remarks
                <textarea name="remarks" rows="3">{{ old('remarks', $event->remarks) }}</textarea>
            </label>
        </fieldset>

        

            <label>
                Upload New Posters (Optional)
                <input type="file" name="posters[]" multiple accept="image/*">
                <small>Upload 1-4 images. If you upload new posters, they will replace the existing ones.</small>
            </label>
        </fieldset>

        <div style="margin-top: 20px;">
            <button type="submit">Update Event</button>
            <a href="{{ route('events.my') }}" class="btn" style="display: inline-block; text-decoration: none;">Cancel</a>
        </div>

        <!-- Hidden input to track deleted poster indices -->
        <input type="hidden" id="deleted_poster_indices" name="deleted_poster_indices" value="">
    </form>
</section>

<script>
    function removePoster(button, index) {
        if (confirm('Are you sure you want to delete this poster?')) {
            const container = button.parentElement;
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
            button.textContent = 'Removing...';
            
            // Track deleted poster index
            const deletedInput = document.getElementById('deleted_poster_indices');
            const deletedIndices = deletedInput.value ? deletedInput.value.split(',') : [];
            if (!deletedIndices.includes(index.toString())) {
                deletedIndices.push(index);
            }
            deletedInput.value = deletedIndices.join(',');
        }
    }
</script>

</body>
</html>
