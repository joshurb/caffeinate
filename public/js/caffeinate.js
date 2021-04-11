
$('document').ready(function(){

    Vue.component('drinks-consumed-table', {
        props: ['consumed_drinks'],
        template: `
            <div>
                <h5><slot></slot></h5>
                <table class="table table-striped">
                    <thead class="thead-dark">
                    <th>Drink Name</th>
                    <th>Total Caffeine</th>
                    <th>Un-Drink</th>
                    </thead>
                    <tbody>
                    <tr is="drinks-table-row" v-for="drink in consumed_drinks" v-bind:key="drink.id" v-bind:consumed_drink="drink" v-on="$listeners"></tr>
                    </tbody>
                </table>
            </div>
        `
    });

    Vue.component('drinks-table-row', {
        props: ['consumed_drink'],
        template: `
            <tr>
                <td>{{ consumed_drink.drink.drink_name }}</td>
                <td>{{ consumed_drink.drink.caffeine_amount * consumed_drink.drink.servings }}mg</td>
                <td>
                    <button class="btn btn-danger" v-on:click="$emit('undrink', consumed_drink.id)">Un-Drink</button>
                </td>
            </tr>
        `
    });

    Vue.component('warning-modal',{
        template: `
            <div id="myModal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><slot name="header"></slot></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><slot name="message"></slot></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `
    });

    Vue.component('page-header', {
        template: `
            <div class="jumbotron">
                <h1 class="display-4"><slot name="page-title"></slot></h1>
                <p class="lead"><slot name="slogan"></slot></p>
                <p><slot name="description"></slot></p>
            </div>
        `
    });

    Vue.component('drink-a-drink-module', {
        props: ['drinks'],
        data: function() {
            return {
                selectedDrink: null
            }
        },
        template: `
            <div class="form-inline">
                <label class="mb-2 mr-sm-2"><slot name="labelText"></slot>Select your drink here:</label>
                <select class="form-control mb-2 mr-sm-2" v-model="selectedDrink">
                    <option v-for="drink in drinks" v-bind:value="drink">@{{ drink.drink_name }} - @{{ drink.caffeine_amount * drink.servings }}mg</option>
                </select>
            </div>
        `
    });

    var app = new Vue({
    el: '#app',
    data: {
    drinks: null,
    consumedDrinks: null,
    suggestedNextDrink: null,
    toDrink: null,
    totalCaffeine: 0,
    caffeineLeft: ''
        },
        mounted () {
            this.caffeineRemaining();
            this.consumed();
            this.suggestDrink();
            this.drinksAvailable();

        },
        methods: {
            suggestDrink: function(){
                axios
                    .get('http://caffeinate.test/api/suggest-drink')
                    .then(response => (this.suggestedNextDrink = response.data));
            },
            caffeineRemaining: function(){
                axios
                    .get('http://caffeinate.test/api/total-caffeine-remaining')
                    .then(response => (this.caffeineLeft = response.data.totalCaffeineRemaining));
            },
            consumed: function(){
                axios
                    .get('http://caffeinate.test/api/drinks-consumed')
                    .then(response => (this.consumedDrinks = response.data));
            },
            drinksAvailable: function(){
                axios
                .get('http://caffeinate.test/api/drinks')
                .then(response => (this.drinks = response.data));
            },
            checkAndDrink: function(toDrink){
                if(this.caffeineLeft - toDrink.caffeine_amount * toDrink.servings > 0)
                    this.drinkADrink(toDrink.id);
                else{
                    $('.modal').modal('toggle');
                    console.log('too much caffeine');
                }

            },
            drinkADrink: function(id){
                let drink = { drink_id: id };
                axios
                    .post('http://caffeinate.test/api/drank', drink)
                    // .then(response => (app.consumedDrinks = response.data));
                    .then(function(response){
                        // this.consumedDrinks = response.data;
                        app.consumed();
                        app.caffeineRemaining();
                        app.suggestDrink();
                    })
            },
            deleteDrink: function(id){
                axios
                    .delete('http://caffeinate.test/api/delete-consumed-drink/'+id)
                    // .then(response => (app.consumedDrinks = response.data));
                    .then(function(response){
                        app.consumed();
                        app.caffeineRemaining();
                        app.suggestDrink();
                    })
            }
        }
    });
});
