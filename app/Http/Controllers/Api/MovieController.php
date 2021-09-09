<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Movie;
use App\Models\Category;

use Image;
use Storage;
use Illuminate\Support\Str;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $movies = Movie::orderBy('updated_at', 'desc');
      if($request->category_id) {
        $movies = $movies->whereHas('categories', function($query) use ($request) {
          $query->where('category_id', $request->category_id);
        });
      }
      $movies = $movies->get();
      return response()->json($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'duration' => 'required',
        'cover' => 'required|file',
        'launch' => 'required|date'
      ]);
      $movie = new Movie;
      $movie->name = $request->name;
      $movie->description = $request->description;
      $movie->duration = $request->duration;
      $movie->trailer = $request->trailer;
      $movie->launch = $request->launch;

      //load images
      if($request->hasFile('cover')) {
        $img = Image::make($request->file('cover'))->fit(260,340)->encode('png');
        $movie->cover = Str::random(40).'-cover.png';
        $store = Storage::disk('public')->put($movie->cover, $img);
      }
      $movie->save();

      $movie->categories()->attach(explode(',', $request->storeCategories));
      return response()->json($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $movie = Movie::with('categories')->findOrFail($id);
      return response()->json($movie);
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
