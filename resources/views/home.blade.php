@extends('app')

@section('title', 'Caffeinate')

@push('css')
    <link rel="stylesheet" href="/css/caffeinate.css">
@endpush

@section('content')

    <div class="jumbotron">
        <h1 class="display-4">Caffeinate! Dashboard</h1>
        <p class="lead">Track caffeine consumption... For safety!</p>
        {{--<hr class="my-4">--}}
        <p>A utility to help prevent overdosing on caffeine.</p>
        {{--<a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>--}}
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-12">
            
        </div>
        <div class="col-lg-6 col-sm-12">

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <th>Drink Name</th>
                    <th>Total Caffeine</th>
                    <th>Delete Drink</th>
                </thead>
                <tbody>
                    <tr>
                        <td>coffee</td>
                        <td>75mg</td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-lg-6 col-sm-12">
            Graphs
        </div>

    </div>





@endsection

@push('scripts')
    <!-- Load our React component. -->
    {{--<script type="text/javascript" src="./js/LikeButton.js"></script>--}}

@endpush