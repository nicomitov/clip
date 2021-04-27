<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', 'App\Page');

        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\Page');

        $validatedAttributes = $this->validator();

        $validatedAttributes['slug'] = str_slug($validatedAttributes['title'], '-');

        $page = Page::create($validatedAttributes);

        return redirect(route('pages.show', $page))->with(['success' => 'Successfully created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $this->authorize('update', $page);

        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->authorize('update', $page);

        $validatedAttributes = $this->validator();

        $validatedAttributes['slug'] = str_slug($validatedAttributes['title'], '-');

        $page->update($validatedAttributes);

        return redirect(route('pages.show', $page))->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);

        $page->delete();

        return redirect(route('home'))->with(['success' => 'Successfully deleted!']);
    }

    protected function validator($userId = null)
    {
        $data = [
            'title' => ['required', 'min:3'],
            'body' => ''
        ];

        return request()->validate($data);
    }
}
