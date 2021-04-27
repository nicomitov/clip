<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientEmail;
use App\SubscriptionType;
use Illuminate\Http\Request;
use Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with('subscriptions')->with('emails')->get();

        // \App\Jobs\DeactivateClients::dispatch();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', 'App\Client');

        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\Client');

        $validatedAttributes = $this->validator();
        $validatedAttributes['is_active'] = isset($request['is_active']);

        $client = Client::create($validatedAttributes);

        $emails = $this->makeEmailsArray($validatedAttributes['subscription_emails']);

        // create client emails
        foreach ($emails as $email) {
            $client->emails()->create([
                'email' => $email
            ]);
        }

        $client->setActivity('created');

        return redirect(route('clients.show', $client))->with(['success' => 'Successfully created!']);
    }

    public function show(Client $client)
    {
        $client->load('emails', 'subscriptions');

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);

        $clientEmails = implode(",\r\n", $client->emails->pluck('email')->toArray());

        return view('clients.edit', compact('client', 'clientEmails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validatedAttributes = $this->validator();
        $validatedAttributes['is_active'] = isset($request['is_active']);

        $client->update($validatedAttributes);

        $emails = $this->makeEmailsArray($validatedAttributes['subscription_emails']);

        if (array_diff($emails, $client->emails()->pluck('email')->toArray())) {
            // first delete all emails
            $client->emails()->delete();

            // create client emails
            foreach ($emails as $email) {
                if (! $client->emails()->get()->contains($email)) {
                    $client->emails()->create([
                        'email' => $email
                    ]);
                }
            }
        }

        $client->setActivity('updated');

        return redirect(route('clients.show', $client))->with(['success' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->setActivity('deleted');

        foreach ($client->subscriptions as $subscription) {
            $subscription->topics()->detach();
        }

        $client->emails()->delete();
        $client->subscriptions()->delete();
        $client->delete();

        return redirect(route('clients.index'))->with(['success' => 'Successfully deleted!']);
    }

    public function clientsBySubscriptionType(SubscriptionType $subscriptionType)
    {
        $pageTitle = 'Clients - ' . $subscriptionType->display_name;

        $clients = Client::whereHas('subscriptions', function ($query) use ($subscriptionType) {
            $query->where('subscription_type_id', $subscriptionType->id);
        })->get();

        return view('clients.index', compact('pageTitle', 'clients'));
    }

    public function clientsByStatus(string $status)
    {
        $pageTitle = 'Clients: ' . $status;
        $clients = Client::getClientsByStatus($status);

        return view('clients.index', compact('clients', 'pageTitle'));
    }

    public function updateStatus(Request $request, Client $client)
    {
        $client->updateStatus($request['is_active']);

        $client->setActivity('updated');

        return back()->with(['success' => 'Successfully updated!']);
    }

    public function getEmails($id)
    {
        $models = ClientEmail::where('client_id', $id)->pluck('email', 'id')->toArray();

        $data = [];
        foreach ($models as $key => $value) {
            array_push($data, ['k' => $key, 'v' => $value]);
        }

        return Response::make($data);
    }

    public function getComment(Client $client)
    {
        return Response::make([$client->comment]);
    }

    protected function makeEmailsArray($emails)
    {
        // remove empty spaces
        $emails = str_replace(' ', '', $emails);
        // remove new lines
        $emails = str_replace("\r\n", '', $emails);
        // make array of emails
        $emails = explode(',', $emails);
        // remove empty elements
        $emails = array_filter($emails);
        // remove duplicated elements
        $emails = array_unique($emails);

        return $emails;
    }

    protected function validator()
    {
        \Validator::extend('email_array', function($attribute, $value, $parameters, $validator) {
            $array = $this->makeEmailsArray($value);

            if (! count($array)) {
                return;
            }

            foreach($array as $email) //loop over values
            {
                $email_to_validate['subscription_emails'][] = $email;
            }

            $rules = [
                'subscription_emails.*' => 'email'
            ];

            $validator = \Validator::make($email_to_validate, $rules);

            if ($validator->passes()) {
                return true;
            } else {
                return false;
            }
        });

        $data = [
            'name' => ['required'],
            'email' => ['nullable', 'email'],
            'phone' => [],
            'contact_person' => [],
            'address' => [],
            'comment' => [],
            'subscription_emails' => ['required', 'email_array'],
        ];

        $messages = [
             'subscription_emails.*' => ':attribute must have valid email addresses.'
        ];

        return request()->validate($data, $messages);
    }

}
