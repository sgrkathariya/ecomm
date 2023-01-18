<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialMediaRequest;
use App\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:super-admin|admin');
    }

    public function index(SocialMedia $socialMedia = null)
    {
        if (!$socialMedia) {
            $socialMedia = new SocialMedia();
        }

        $socialMedias = SocialMedia::orderBy('name')->get();

        return view('social-media.index', compact('socialMedia', 'socialMedias'));
    }

    public function store(SocialMediaRequest $request)
    {
        $socialMedia = SocialMedia::create($request->validated());

        return redirect()->back()->with('success', 'Brand has been added');
    }


    public function edit(SocialMedia $socialMedia)
    {
        return $this->index($socialMedia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $category
     * @return \Illuminate\Http\Response
     */
    public function update(SocialMediaRequest $request, SocialMedia $socialMedia)
    {
        $data = $request->validated();
        $socialMedia = $socialMedia->update($data);
        return redirect()->route('social-medias.index')->with('success', 'Social Media has been updated');
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $socialMedia->delete();
        return redirect()->back()->with('success', 'Social Media has been deleted');
    }
}
