
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
