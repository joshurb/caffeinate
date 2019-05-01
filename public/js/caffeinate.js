
$('document').ready(function(){



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
