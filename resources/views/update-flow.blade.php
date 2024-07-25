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
    <h1 class="text-center mb-4">Update Sensor Flow</h1>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form id="flowForm" action="{{ route('update-flow') }}" method="POST">
        @csrf
        <div class="form-group row mb-3 align-items-center">
            <label for="flow">Flow (%):</label>
            <div class="col-5 text-center">
                <input type="number" id="flow" name="flow" class="form-control" min="0" max="100" required>
            </div>
            <button type="submit" id="updateButton" class="btn btn-primary btn-lg">Update Flow Rate</button>
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
    document.getElementById('flowForm').onsubmit = function(event) {
        event.preventDefault(); // Prevent the default form submission

        let flowValue = document.getElementById('flow').value;
        if (flowValue < 0 || flowValue > 100) {
            alert('Please enter a value between 0 and 100.');
            return;
        }

        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                flow: flowValue
            })
        }).then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Failed to update flow.');
            }
        }).then(data => {
            window.history.back(); // Navigate back to the previous page
        }).catch(error => {
            console.error('Error details:', error);
            alert('An error occurred while updating the flow. Check console for details.');
        });
    };
</script>
@endsection
