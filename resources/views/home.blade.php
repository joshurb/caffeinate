@extends('app')

@section('title', 'Caffeinate')

@push('css')
    <link rel="stylesheet" href="/css/caffeinate.css">
@endpush

@section('content')
<div id='app'>
    <div class="jumbotron">
        <h1 class="display-4">Caffeinate! Dashboard</h1>
        <p class="lead">Track caffeine consumption... For safety!</p>
        {{--<hr class="my-4">--}}
        <p>A utility to help prevent overdosing on caffeine.</p>
        {{--<a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>--}}
    </div>

    <div class="row">

        <div class="col-lg-6 col-sm-12">
            <h5>Suggestion Section</h5>
            <div class="card"  v-if="suggestedNextDrink">
                <div class="card-body">
                    <h5 class="card-title">It looks like you have enough caffeine left for this tasty beverage:</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        @{{ suggestedNextDrink.drink_name }}
                        <small>
                            Servings: @{{ suggestedNextDrink.servings }}, Caffeine/serving: @{{ suggestedNextDrink.caffeine_amount }}
                        </small>
                    </h6>
                    <p class="card-text">@{{ suggestedNextDrink.drink_description }}</p>
                    <button  class="btn btn-success drink-now" v-on:click="drinkADrink(suggestedNextDrink.id)">Drink Now!</button>
                </div>
            </div>
            <div class="card" v-else>
                <div class="card-body">
                    <h5 class="card-title">Have you considered a caffeine-free drink?</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Maybe a nice herbal tea?
                    </h6>
                    <p class="card-text">Sorry, none of your favorite drinks have low enough amounts of caffeine to drink without putting you over your limit.</p>
                    <p class="card-text small">You could always un-drink something...</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <h5>Choose your own drink</h5>
            <div class="row">
                <div class="col-md-12">
                    Remaining Caffeine: @{{ caffeineLeft }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    Not in the mood for the suggested drink?
                    <div class="form-inline">
                        <label class="mb-2 mr-sm-2">Select your drink here:</label>
                        <select class="form-control mb-2 mr-sm-2" v-model="toDrink">
                            <option v-for="drink in drinks" v-bind:value="drink">@{{ drink.drink_name }} - @{{ drink.caffeine_amount * drink.servings }}mg</option>
                        </select>
                    </div>


                    <button class="btn btn-outline-success drink-choice" v-on:click="checkAndDrink(toDrink)">Drink Selected</button>
                </div>
            </div>
            {{--Remaining Caffeine: @{{ caffeineLeft }}--}}
            {{--Not in the mood for the suggested drink? Select your drink here: <select></select>--}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <h5>Consumed Drinks</h5>
            <table class="table table-striped">
                <thead class="thead-dark">
                <th>Drink Name</th>
                <th>Total Caffeine</th>
                <th>Un-Drink</th>
                </thead>
                <tbody>
                <tr v-for="drink in consumedDrinks">
                    <td>@{{ drink.drink.drink_name }}</td>
                    <td>@{{ drink.drink.caffeine_amount * drink.drink.servings }}mg</td>
                    <td><button class="btn btn-danger" v-on:click="deleteDrink(drink.id)">Un-Drink</button></td>
                </tr>
                </tbody>
            </table>
        </div>




    </div>

    <div id="myModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Too Much Caffeine! :(</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sorry, that drink contains enough caffeine to put you over your daily limit. Please check the drink suggestion section
                    for an option that may work</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>






@endsection

@push('scripts')
    <!-- Load our React component. -->
    {{--<script type="text/javascript" src="./js/LikeButton.js"></script>--}}
    <script type="text/javascript" src="./js/caffeinate.js"></script>


@endpush