@extends('layouts.admin')

@section('styles')
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Include custom CSS for further styling -->
    <style>
        body {
            padding-top: 50px;
        }
        .container {
            max-width: 600px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 0;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Update Sensor Interval</h1>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form id="intervalForm" action="{{ route('update-interval') }}" method="POST">
        @csrf
        <div class="form-group row mb-3 align-items-center">
            <label for="interval">Interval (ms):</label>
            <div class="col-5 text-center">
                <input type="number" id="interval" name="interval" class="form-control" min="1000" required>
            </div>
            <button type="submit" id="updateButton" class="btn btn-primary btn-lg">Update Interval</button>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript to handle form submission and navigate back -->
<script>
    document.getElementById('intervalForm').onsubmit = function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Perform the form submission using fetch
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                interval: document.getElementById('interval').value
            })
        }).then(response => {
            if (response.ok) {
                window.history.back(); // Navigate back to the previous page
            } else {
                // Handle errors if necessary
                alert('Failed to update interval.');
            }
        }).catch(error => {
            // Handle network errors if necessary
            console.error('Error:', error);
            alert('An error occurred while updating the interval.');
        });
    };
</script>
@endsection