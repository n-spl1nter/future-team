<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Country;
use App\Entities\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Review::all();
        return view('admin.reviews.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('title_en', 'country_id');
        return view('admin.reviews.form', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_ru' => 'required|string',
            'name_en' => 'required|string',
            'text_ru' => 'required|string',
            'text_en' => 'required|string',
            'country_id' => 'required|integer',
            'photo' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=480,min_height=360',
        ]);

        $review = new Review($request->all());
        $review->save();
        $review->setAvatar($request->file('photo'));

        return redirect()->route('admin.reviews.index')->with('success', 'Review has been stored.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Review $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $model)
    {
        $countries = Country::pluck('title_en', 'country_id');
        return view('admin.reviews.form', compact('countries', 'model'));
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
        //
    }
}
