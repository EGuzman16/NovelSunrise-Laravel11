<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Theme;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class BlogsController extends Controller
{
    //public function index()
   // {
       // $blogs = Blog::all();
        // dd($blogs);
       // return view('blogs.index', [
       //     'blogs' => $blogs,
       // ]);

    //$blogs=Blog::with('theme')->get();
   // return view('blogs.index', [
     //   'blogs' => $blogs,
    //]);
    //}
    public function index(Request $request)
    {
        $queryBlogs = Blog::with('theme');
        $searchParams = collect([
            'title' => $request->query('sTitle'),
            'theme' => $request->query('sTheme'),
        ]);

        if($searchParams['title'] != null) {
            $queryBlogs->where('title', 'LIKE', '%' . $searchParams['title'] . '%');
        }

        if($searchParams['theme'] != null) {
            $queryBlogs->where('theme_fk', '=', $searchParams['theme']);
        }

        $blogs = $queryBlogs
            ->paginate(3)
            ->withQueryString();

        return view('blogs.index', [
            'blogs' => $blogs,
            'themes' => Theme::all(),
            'searchParams' => $searchParams,
        ]);       
    }


    public function panel(Request $request)
    {
        $queryBlogs = Blog::with('theme');
        $searchParams = collect([
            'title' => $request->query('sTitle'),
            'theme' => $request->query('sTheme'),
        ]);

        if ($searchParams['title'] != null) {
            $queryBlogs->where('title', 'LIKE', '%' . $searchParams['title'] . '%');
        }

        if ($searchParams['theme'] != null) {
            $queryBlogs->where('theme_fk', '=', $searchParams['theme']);
        }

        $blogs = $queryBlogs
            ->paginate(3)
            ->withQueryString();

        return view('blogs.panel', [
            'blogs' => $blogs,
            'themes' => Theme::all(),
            'searchParams' => $searchParams,
        ]);
    }

    public function view(int $id)
    {
        $blog = Blog::findOrFail($id);
         // dd($blog);
        return view('blogs.view', [
            'blog' => $blog,
        ]);
    }

    public function createForm()
    {
        return view('blogs/create-form', [
            'themes' => Theme::all(),           
        ]);
    }

    public function createProcess(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'content' => 'required',
            'theme_fk' => 'required',
        ], [
            'theme_fk.required' => 'Selecciona una temática.',
        ]
    );
        $input = $request->only(['title', 'content', 'theme_fk', 'pic_description']);

        if($request->hasFile('pic')) {
            $input['pic'] = $request->file('pic')->store('imgs');
        }

        Blog::create($input);

        return redirect()
            ->route('blogs.index')
            ->with('feedback.message', 'La publicación <b>' . e($input['title']) . '</b> se subió con éxito.');
    }

    public function editForm(int $id)
    {
        return view('blogs.edit-form', [
            'blog' => Blog::findOrFail($id),
            'themes' => Theme::all(),
        ]);
    }

    public function editProcess(int $id, Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'theme_fk' => 'required', 
            'content' => 'required',
        ], [
            'theme_fk.required' => 'Selecciona una temática.',
        ]
    );

        $blog = Blog::findOrFail($id);

        $input = $request->only(['title', 'theme_fk', 'content', 'pic_description']);
        $oldPic = $blog->pic;
        if($request->hasFile('pic')) {
            $input['pic'] = $request->file('pic')->store('imgs');
            Image::read(\Storage::path($input['pic']))
                ->coverDown(520, 320)
                ->save();
        }


    
        $blog->update($input);

        if($request->hasFile('pic') && $oldPic !== null && \Storage::exists($oldPic)) {
            \Storage::delete($oldPic);
        }

        return redirect()
            ->route('blogs.index')
            ->with('feedback.message', 'La publicación <b>' . e($input['title']) . '</b> se editó con éxito.');
    }

    public function deleteForm(int $id)
    {
        return view('blogs.delete-form', [
            'blog' => Blog::findOrFail($id),
        ]);
    }

    public function deleteProcess(int $id)
    {
        $blog = Blog::findOrFail($id);

        $blog->delete();

        if($blog->pic !== null && \Storage::exists($blog->pic)) {
            \Storage::delete($blog->pic);
        }

        return redirect()
            ->route('blogs.index')
            ->with('feedback.message', 'La publicación <b>' . e($blog->title) . '</b> se eliminó con éxito.');
    }
}
