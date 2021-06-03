<?php
namespace App\Http\Controllers;

use App\Business;
use App\Models\EditorModel as Editor;
use Auth;
use Cloudder;
use App\Forms;
use App\Store;
use App\StoreItems;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $editors = Editor::where('user_id', $user->id)->get();
        $business = Business::where('user_id', $user->id)->first();
        $trash = Editor::onlyTrashed()->get();
        return view('edit.createe')->with(['editors' => $editors, 'business' => $business, 'trash' => $trash]);
    }

    public function single($id)
    {
        $editor = Editor::find($id);
        return view('edit.editorr')->with('editor', $editor);
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

    public function view($slug)
    {
        $editor = Editor::where('slug', $slug)->first();
        return view('edit.indexx')->with('editor', $editor);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'content' => 'required'

        ]);

        $editor = Editor::find($id);

        $editor->content = $request->content;

        $editor->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $editor = Editor::find($id);

        $editor->delete();

        return redirect()->back();
    }

    public function kill($id)
    {
        $editor = Editor::withTrashed()->where('id', $id)->first();

        $editor->forceDelete();

        return redirect()->back();
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $business = Business::where('user_id', $user->id)->first();
        $this->validate($request, [
            'page_name' => 'required',
            'url' => 'required'
        ]);

        $editor = Editor::firstOrCreate(['user_id' => $user->id, 'slug' => str_slug($business->business_name), 'url' => 'https://'.trim(strtolower(str_replace(" ", "",$business->business_name))).'.orderbank.com'.$request->url, 'page_name' => $request->page_name]);
        $editor->content = \htmlspecialchars($request->content);
        $editor->user_id = $user->id;
        $editor->page_name = $request->page_name;
        $editor->url = 'https://'.trim(strtolower(str_replace(" ", "",$business->business_name))).'.orderbank.com'.$request->url;
        $editor->save();

        return redirect()->back();

        return response()->json($editor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function trashed() {
        $editors = Editor::onlyTrashed()->get();

        return view('user.posts.trash')->with('posts', $posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'sometimes|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        $image = $request->file;
        Cloudder::upload($image, null);
        $uploaded = Cloudder::getResult();
        $res = ($uploaded['url']);
        return response()->json($res);

    }
}
