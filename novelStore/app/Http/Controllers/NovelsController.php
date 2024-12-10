<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class NovelsController extends Controller
{
   // public function index()
   // {
        //$novels =  Novel::with(['category', 'tags'])->get();
        // dd($novels);
        //return view('novels/index', [
        //    'novels' => $novels,
        //]);
    //}

    public function index(Request $request)
    {
 $queryNovels = Novel::with(['category', 'tags']);
 $searchParams = collect([
            'title' => $request->query('sTitle'),
            'category' => $request->query('sCategory'),
            'tag' => $request->query('sTag')
        ]);

        if($searchParams['title'] != null) {
            $queryNovels->where('title', 'LIKE', '%' . $searchParams['title'] . '%');
        }

        if($searchParams['category'] != null) {
            $queryNovels->where('category_fk', '=', $searchParams['category']);
        }

        if ($searchParams['tag'] != null) {
            $queryNovels->whereHas('tags', function ($query) use ($searchParams) {
                $query->where('tag_id', '=', $searchParams['tag']);
            });
        }

        $novels = $queryNovels
                            ->paginate(3)
                            ->withQueryString();
                            //->appends(request()->query());

        return view('novels/index', [
            'novels' => $novels,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'searchParams' => $searchParams,
        ]);
    }


    public function panel(Request $request)
    {
        $queryNovels = Novel::with(['category', 'tags']);
        $searchParams = collect([
            'title' => $request->query('sTitle'),
            'category' => $request->query('sCategory'),
            'tag' => $request->query('sTag')
        ]);

        if ($searchParams['title'] != null) {
            $queryNovels->where('title', 'LIKE', '%' . $searchParams['title'] . '%');
        }

        if ($searchParams['category'] != null) {
            $queryNovels->where('category_fk', '=', $searchParams['category']);
        }

        if ($searchParams['tag'] != null) {
            $queryNovels->whereHas('tags', function ($query) use ($searchParams) {
                $query->where('tag_id', '=', $searchParams['tag']);
            });
        }

        $novels = $queryNovels
            ->paginate(3)
            ->withQueryString();

        return view('novels.panel', [
            'novels' => $novels,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'searchParams' => $searchParams,
        ]);
    }

    public function view(int $id)
    {
        $novel = Novel::findOrFail($id);
         // dd($novel);
        return view('novels/view', [
            'novel' => $novel,
        ]);
    }

    public function createForm()
    {
        return view('novels/create-form', [
            'categories' => Category::all(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function createProcess(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'price' => 'required|numeric',
            'release_date' => 'required',
            'category_fk' => 'required',
        ], [
            'category_fk.required' => 'Selecciona una categoría.',
        ]);
        $input = $request->only(['title', 'price', 'release_date', 'synopsis', 'category_fk', 'cover_description']);
        
        if($request->hasFile('cover')) {
            $input['cover'] = $request->file('cover')->store('imgs');
        }

        $novel= Novel::create($input);

        $novel->tags()->attach($request->input('tag_fk', []));
        
        return redirect()
            ->route('novels.index')
            ->with('feedback.message', 'La novela <b>' . e($input['title']) . '</b> se subió con éxito.');
    }

    public function editForm(int $id)
    {
        return view('novels.edit-form', [
            'novel' => Novel::findOrFail($id),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function editProcess(int $id, Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'price' => 'required|numeric',
            'release_date' => 'required',
            'category_fk' => 'required',
            'tag_fk' => 'sometimes|array',
        ],[
            'category_fk.required' => 'Selecciona una categoría.',
        ]);

        $novel = Novel::findOrFail($id);

        $input = $request->only(['title', 'price', 'release_date', 'synopsis', 'category_fk', 'cover_description']);
        $oldCover = $novel->cover;
        if($request->hasFile('cover')) {
            $input['cover'] = $request->file('cover')->store('imgs');
            Image::read(\Storage::path($input['cover']))
                ->coverDown(570, 800)
                ->save();
        }

        $novel->update($input);

        if($request->hasFile('cover') && $oldCover !== null && \Storage::exists($oldCover)) {
            \Storage::delete($oldCover);
        }

        $novel->tags()->sync($request->input('tag_fk', []));

        return redirect()
            ->route('novels.index')
            ->with('feedback.message', 'La novela <b>' . e($input['title']) . '</b> se editó con éxito.');
    }

    public function deleteForm(int $id)
    {
        return view('novels.delete-form', [
            'novel' => Novel::findOrFail($id),
        ]);
    }

    public function deleteProcess(int $id)
    {
        $novel = Novel::findOrFail($id);

        $novel->tags()->detach();

        $novel->delete();


        

        return redirect()
            ->route('novels.index')
            ->with('feedback.message', 'La novela <b>' . e($novel->title) . '</b> se eliminó con éxito.');
    }
}
