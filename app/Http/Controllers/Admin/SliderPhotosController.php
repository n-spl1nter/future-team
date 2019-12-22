<?php

namespace App\Http\Controllers\Admin;

use App\Entities\SliderPhoto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderPhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = SliderPhoto::orderByDesc('order')->get();

        return view('admin.slider-photos.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create()
    {
        return view('admin.slider-photos.form');
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
            'photo' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=1280,min_height=800',
            'order' => 'required|integer',
        ]);

        $sliderPhoto = new SliderPhoto($request->all());
        $sliderPhoto->save();
        $sliderPhoto->setPhoto($request->file('photo'));

        return redirect()->route('admin.sliderPhotos.index')->with('success', 'Image has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SliderPhoto $sliderPhoto
     * @return void
     */
    public function edit(SliderPhoto $sliderPhoto)
    {
        return view('admin.slider-photos.form', ['model' => $sliderPhoto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param SliderPhoto $sliderPhoto
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, SliderPhoto $sliderPhoto)
    {
        $this->validate($request, [
            'photo' => 'nullable|image|mimes:jpeg,bmp,png|dimensions:min_width=1280,min_height=800',
            'order' => 'required|integer',
        ]);
        $sliderPhoto->update($request->all());
        $sliderPhoto->setPhoto($request->get('photo'));
        return redirect()->route('admin.sliderPhotos.index')->with('success', 'Image has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sliderPhoto = SliderPhoto::findOrFail($id);
        $sliderPhoto->remove();

        return redirect()->route('admin.sliderPhotos.index')->with('success', 'Image has been removed');
    }
}
