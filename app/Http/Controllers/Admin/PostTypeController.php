<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostType;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostTypeController extends Controller
{
   
    public function index()
    {
        $post_types = PostType::orderByDesc('id')->paginate(5);
        return view('admin.post_type.list', compact('post_types'));
    }

 
    public function create()
    {
        return view('admin.post_type.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:post_types,name|string'
        ]);
        DB::beginTransaction();
        try {
            PostType::create($data);
            DB::commit();
            return redirect()->route('post_type.index');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function edit(PostType $post_type)
    {
        return view('admin.post_type.edit', compact('post_type'));
    }

    public function update(Request $request, PostType $post_type)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $post_type->update($data);
            DB::commit();
            return redirect()->route('post_type.index');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy(PostType $post_type)
    {
        $post_type->delete();
        return redirect()->back()->with('success', 'Delete successfully!');
    }
}
