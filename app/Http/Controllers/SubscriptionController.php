<?php

namespace App\Http\Controllers;

use App\User;
use App\Topic;
use App\Client;
use App\Subscription;
use App\SubscriptionType;
use Illuminate\Http\Request;
use App\Notifications\SubscriptionNotification;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::all();

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', 'App\Subscription');

        $clients = Client::all()->sortBy('name')->pluck('name', 'id');
        $topics = Topic::getTopicsForSelect();
        $topics = json_encode($topics);
        $types = SubscriptionType::pluck('display_name', 'id');

        return view('subscriptions.create', compact('clients', 'topics', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\Subscription');

        $validatedAttributes = $this->validator();

        $client = Client::find($validatedAttributes['client_id']);

        // disallow creating multiple DN-subscription (only multiple CLIP-subscription is allowed)
        if ($validatedAttributes['subscription_type_id'] == '1' && $client->subscriptions->where('subscription_type_id', '1')->count() != 0) {
            return back()->with(['warning' => 'This subscription allready exist!']);
        }

        $subscription = Subscription::create($validatedAttributes);

        $subscription->emails()->attach($validatedAttributes['toEmails']);

        if (isset($validatedAttributes['toTopics'])) {
            $subscription->topics()->attach($validatedAttributes['toTopics']);
        }

        $client->comment = $request['comment'];
        $client->save();

        // Notifications
        $user = auth()->user();
        $notifyUsers = User::where('id', '!=', $user->id)->get();
        \Notification::send($notifyUsers, new SubscriptionNotification($user, $subscription));

        $subscription->setActivity('created');

        return redirect(route('subscriptions.show', $subscription))->with(['success' => 'Successfully created!']);
    }

    public function show(Subscription $subscription)
    {
        $subscription->load('emails', 'client', 'topics', 'type');

        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        $clients = Client::all()->sortBy('name')->pluck('name', 'id');
        $types = SubscriptionType::pluck('display_name', 'id');

        $topics = Topic::getTopicsForSelect($subscription);
        $topics = json_encode($topics);

        return view('subscriptions.edit', compact('subscription', 'clients', 'topics', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        $validatedAttributes = $this->validator();

        $client = Client::find($validatedAttributes['client_id']);

        // disallow creating multiple DN-subscription (only multiple CLIP-subscription is allowed)
        if ($validatedAttributes['subscription_type_id'] != $subscription['subscription_type_id']) {
            if ($validatedAttributes['subscription_type_id'] == 1 && $client->subscriptions->where('subscription_type_id', 1)->count() != 0) {
                return back()->with(['warning' => 'This subscription allready exist!']);
            }
        }

        $subscription->update($validatedAttributes);

        $subscription->emails()->sync($validatedAttributes['toEmails']);

        if (isset($validatedAttributes['toTopics'])) {
            $subscription->topics()->sync($validatedAttributes['toTopics']);
        }

        $client->comment = $request['comment'];
        $client->save();

        // Notifications
        $user = auth()->user();
        $notifyUsers = User::where('id', '!=', $user->id)->get();
        \Notification::send($notifyUsers, new SubscriptionNotification($user, $subscription));

        $subscription->setActivity('updated');

        return redirect(route('subscriptions.show', $subscription))->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $this->authorize('delete', $subscription);

        $subscription->setActivity('deleted');

        $subscription->emails()->detach();
        $subscription->topics()->detach();
        $subscription->delete();

        return redirect(route('subscriptions.index'))->with(['success' => 'Successfully deleted!']);
    }

    public function subscriptionsByType(SubscriptionType $subscriptionType)
    {
        $pageTitle = 'Subscriptions - ' . $subscriptionType->display_name;

        // $subscriptions = Subscription::where('subscription_type_id', $subscriptionType->id)->get();
        $subscriptions = Subscription::getActiveSubscriptions()
                                     ->where('subscription_type_id', $subscriptionType->id)
                                     ->get();

        return view('subscriptions.index', compact('pageTitle', 'subscriptions'));
    }

    public function subscriptionsByStatus(string $status)
    {
        $pageTitle = 'Subscriptions: ' . $status;
        $subscriptions = Subscription::getSubscriptionsByStatus($status);

        return view('subscriptions.index', compact('subscriptions', 'pageTitle'));
    }

    protected function validator()
    {
        $data = [
            'client_id' => ['required', 'integer'],
            'toEmails' => ['required', 'array'],
            'toEmails.*' => ['integer', 'exists:client_emails,id'],
            'subscription_type_id' => ['required'],
            'start_date' => ['required', 'date', 'before:end_date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ];

        if (request()->subscription_type_id == 2) { // Pressclipping
            $data['toTopics'] = ['required', 'array'];
            $data['toTopics.*'] = ['integer', 'exists:topics,id'];
        }

        return request()->validate($data);
    }
}
