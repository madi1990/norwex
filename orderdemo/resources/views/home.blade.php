@extends('pages.main')

@section('title', 'Upload an image for your pet')
@push('scripts')
	<script defer src="/js/pet.js"></script>
@endpush

@section('content')	
    
<div class="container">
    <form method='post' id='petForm' enctype="multipart/form-data">
        <div class="form-group">
            <label for="pet_id">Pet ID</label>
            <input type="text" class="form-control" id="pet_id" placeholder="1 - 10">
        </div>
        <div class="form-group">
            <label for="pet_name">Pet Name</label>
            <input type="text" class="form-control" id="pet_name" name="pet_name">
        </div>
        <div class="form-group">
            <label for="pet_age">Pet Age</label>
            <input type="text" class="form-control" id="pet_age" name="pet_age">
        </div>
        <div class="form-group">
            <label for="pet_avatar">Upload an image</label>
            <input type="file" class="form-control-file" id="pet_avatar" name="pet_avatar">
        </div>
        <button class="btn btn-primary" type="submit" id="btn-submit">Submit form</button>
    </form>
</div>
    
@endsection
