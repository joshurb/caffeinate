<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drink;
use App\ConsumedDrink;

class ConsumedDrinkController extends Controller
{

    const DAILY_MAX = 500;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $test = ConsumedDrink::with('drink')->get();
//        dd($test);

        return ConsumedDrink::with('drink')->get();
    }

    /**
     * Display a total consumed caffeine.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalCaffeine()
    {
        $totalCaffeine = $this->getTotalCaffeine();


        return ['totalCaffeine'=>$totalCaffeine];
    }

    /**
     * Display a total remaining caffeine.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalCaffeineRemaining()
    {
        $totalCaffeine = $this->getTotalCaffeine();


        return ['totalCaffeineRemaining'=>ConsumedDrinkController::DAILY_MAX-$totalCaffeine];
    }

    function getTotalCaffeine(){
        $allDrank = ConsumedDrink::with('drink')->get();
        $totalCaffeine = 0;
        foreach($allDrank as $drink){
            $totalCaffeine += ($drink->drink->servings*$drink->drink->caffeine_amount);
        }

        return $totalCaffeine;
    }

    /**
     * Suggest a drink that wont put you over the daily caffeine limit.
     *
     * @return \Illuminate\Http\Response
     */
    public function suggestMaximumDrink()
    {
        $totalCaffeine = $this->getTotalCaffeine();

        $drinkAvailable = Drink::all();
        $suggestedDrinks = null;


        foreach($drinkAvailable as $drink){
            $currentCaffCount = $drink->servings*$drink->caffeine_amount;
            if($currentCaffCount + $totalCaffeine <= ConsumedDrinkController::DAILY_MAX){
                if($suggestedDrinks){
                    if($suggestedDrinks->servings * $suggestedDrinks->caffeine_ammount < $currentCaffCount){
                        $suggestedDrinks = $drink;
                    }
                }
                else{
                    $suggestedDrinks = $drink;
                }

            }
        }


        return $suggestedDrinks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $consumed = new ConsumedDrink($data);
        $consumed->save();

        return ConsumedDrink::with('drink')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consumedDrink = ConsumedDrink::where('id', $id);
        $consumedDrink->delete();

        return ConsumedDrink::with('drink')->get();
    }
}
