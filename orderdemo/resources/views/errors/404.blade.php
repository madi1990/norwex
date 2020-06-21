@extends('pages.main')

@section('title', 'Page Not Found')
@section('content')	
    
    <div class="container">
    	<div class="error-content">
    		<div class='col-md-12 text-center'>
    			<div class="errorMessageBlock">
                @if(isset($data) && is_array($data) && isset($data['errorMessage']))
					<br /><label class='error-text' id="errorMessage">{{{$data['errorMessage']}}}</label>
                @endif
				</div>
    		</div>
    	</div>
    </div>
    

@endsection
