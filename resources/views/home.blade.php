@extends('app')

@section('title', 'Caffeinate')

@push('css')
    <link rel="stylesheet" href="/css/caffeinate.css">
@endpush

@section('content')
<div id='app'>
    <page-header>
        <template v-slot:page-title>Caffeinate! Dashboard</template>
        <template v-slot:slogan>Track caffeine consumption... For safety!</template>
        <template v-slot:description>A utility to help prevent overdosing on caffeine.</template>
    </page-header>

    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <h5>Suggestion Section</h5>
            <div class="card"  v-if="suggestedNextDrink">
                <div class="card-body">
                    <h5 class="card-title">It looks like you have enough caffeine left for this tasty beverage:</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        @{{ suggestedNextDrink.drink_name }}
                        <small>
                            Servings: @{{ suggestedNextDrink.servings }}, Caffeine/serving: @{{ suggestedNextDrink.caffeine_amount }}mg
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
{{--                    <drink-a-drink-module v-bind:drinks="drinks"></drink-a-drink-module>--}}
                    <button class="btn btn-outline-success drink-choice" v-on:click="checkAndDrink(toDrink)">Drink Selected</button>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <drinks-consumed-table v-bind:consumed_drinks="consumedDrinks" @undrink="deleteDrink">Consumed Drinks</drinks-consumed-table>
        </div>
    </div>

    <warning-modal>
        <template v-slot:header>Too Much Caffeine! :-(</template>
        <template v-slot:message>Sorry, that drink contains enough caffeine to put you over your daily limit. Please check the drink suggestion section
            for an option that may work</template>
    </warning-modal>

</div>
@endsection

@push('scripts')

    <script type="text/javascript" src="./js/caffeinate.js"></script>

@endpush
