<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = Post::latest()->paginate(5);

        //render view with posts
        return view('posts.index', compact('posts'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //  dd($request ->all());
        // dd("jk");
        //validate form
        $this->validate($request, [
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'          => 'required|min:1',
            'nis'           => 'required|min:2',
            'tempatlahir'   => 'required|min:5',
            'tanggallahir'  => 'required|min:5',
            'alamat'        => 'required|min:5',
            'jeniskelamin'  => 'required|min:5',
            'agama'         => 'required|min:5',
            'email'         => 'required|min:5',
            'hobi'          => 'required|min:5',
            'warna'         => 'required|min:5'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        Post::create([
            'image'         => $image->hashName(),
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'tempatlahir'   => $request->tempatlahir,
            'tanggallahir'  => $request->tanggallahir,
            'alamat'        => $request->alamat,
            'jeniskelamin'  => $request->jeniskelamin,
            'agama'         => $request->agama,
            'email'         => $request->email,
            'hobi'          => $request ->hobi,
            'warna'         => $request ->warna

        ]);

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, Post $post)
    {
        // dd($request ->all());
       //validate form
        $this->validate($request, [
            // 'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'          => 'required|min:1',
            'nis'           => 'required|min:2',
            'tempatlahir'   => 'required|min:5',
            'tanggallahir'  => 'required|min:5',
            'alamat'        => 'required|min:5',
            'jeniskelamin'  => 'required|min:5',
            'agama'         => 'required|min:5',
            'email'         => 'required|min:5',
            'hobi'          => 'required|min:5',
            'warna'         => 'required|min:5'

           
        ]);
        
         //check if image is uploaded
         if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$post->image);

            //update post with new image
            $post->update([
            'image'         => $image->hashName(),
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'tempatlahir'   => $request->tempatlahir,
            'tanggallahir'  => $request->tanggallahir,
            'alamat'        => $request->alamat,
            'jeniskelamin'  => $request->jeniskelamin,
            'agama'         => $request->agama,
            'email'         => $request->email,
            'hobi'          => $request ->hobi,
            'warna'         => $request ->warna

            ]);

        } else {

            //update post without image
            $post->update([
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'tempatlahir'   => $request->tempatlahir,
            'tanggallahir'  => $request->tanggallahir,
            'alamat'        => $request->alamat,
            'jeniskelamin'  => $request->jeniskelamin,
            'agama'         => $request->agama,
            'email'         => $request->email,
            'hobi'          => $request ->hobi,
            'warna'         => $request ->warna
            ]);
        }

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);

    }
    
    public function destroy(Post $post)
    {
        //delete image
        Storage::delete('public/posts/'. $post->image);

        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}