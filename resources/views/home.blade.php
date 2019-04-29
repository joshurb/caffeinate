@extends('app')

@section('title', 'Caffeinate')

@section('content')

    <!-- ... existing HTML ... -->

    <div id="like_button_container"></div>




@endsection

@push('scripts')
    <!-- Load our React component. -->
    <script type="text/javascript" src="./js/LikeButton.js"></script>

@endpush