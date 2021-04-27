<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::orderBy('number')->get();

        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', 'App\Topic');

        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\Topic');

        $validatedAttributes = $this->validator();

        $topic = Topic::create($validatedAttributes);

        $topic->setActivity('created');

        return back()->with(['success' => 'Successfully created!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);

        return view('topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $validatedAttributes = $this->validator($topic->id);

        $topic->update($validatedAttributes);

        $topic->setActivity('updated');

        return back()->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('delete', $topic);

        $topic->setActivity('deleted');

        foreach ($topic->subscriptions as $subscription) {
            if ($subscription->topics->count() == 1) {

                $subscription->setActivity('deleted');

                $subscription->emails()->detach();
                $subscription->delete();
            }
        }

        $topic->delete();

        return redirect(route('topics.index'))->with(['success' => 'Successfully deleted!']);
    }

    public function topicsByStatus(string $status)
    {
        $pageTitle = 'Topics Pressclipping: ' . $status;
        $topics = Topic::getTopicsByStatus($status);

        return view('topics.index', compact('topics', 'pageTitle'));
    }

    protected function validator($topicId = null)
    {
        //create
        $data = [
            'number' => ['required', 'unique:topics,number', 'integer'],
            'name' => ['required', 'min:3'],
        ];

        // update
        if (Route::currentRouteName() == 'topics.update') {
            $data['number'] = ['required', 'unique:topics,number,'.$topicId, 'integer'];
        }

        return request()->validate($data);
    }
}
