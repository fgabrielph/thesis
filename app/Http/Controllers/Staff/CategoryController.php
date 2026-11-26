<?php

namespace App\Http\Controllers\Staff;

use App\Category;
use App\Http\Controllers\Controller;
use App\Logs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('staff.categories.index')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, ['name' => 'required|unique:categories|max:160']);
        // Create Category
        $category = new Category;
        $category->name = $request->input('name');
        // $post->user_id = auth()->user()->id; //This Gets the Currently User Logged in
        $category->save();
        // Added Log
        $log = new Logs;
        $log->action = 'Added a category';
        $log->staff_id = Auth::user()->id;
        $log->save();

        return back()->with('success', 'Category Added');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Validation
        $this->validate($request, ['name' => 'required|max:160']);
        // Update Category
        $category = Category::find($id);
        $category->name = $request->input('name');
        // $post->user_id = auth()->user()->id; //This Gets the Currently User Logged in
        $category->save();
        // Updated Log
        $log = new Logs;
        $log->action = 'Updated an Category';
        $log->staff_id = Auth::user()->id;
        $log->save();

        return back()->with('success', 'Category Updated');
    }
}
