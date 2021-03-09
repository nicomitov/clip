<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'contact_person', 'address', 'is_active', 'comment'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['subscriptions'];

    public function emails()
    {
        return $this->hasMany(ClientEmail::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function updateStatus(int $status)
    {
        return $this->update([
            'is_active' => $status
        ]);
    }

    public static function getClientsByStatus($status)
    {
        if ($status =='active') {
            $clients = self::getActiveClients();
        } elseif ($status == 'inactive') {
            $clients = self::getInactiveClients();
        }

        return $clients;
    }

    public static function getActiveClients()
    {
        return Client::where('is_active', 1)->get();
    }

    public static function getinactiveClients()
    {
        return Client::where('is_active', 0)->get();
    }

    public function emailList($num = 2)
    {
        $all = $this->emails;

        if ($all->count() > $num) {
            if ($num == 1) {
                $firstEmail = $all->shift();
                $more = count($all);

                foreach ($all as $value) {
                    $moreEmails[] = $value->email;
                }

                $result = $firstEmail->email . ', <span class="small text-primary" style="cursor:pointer" data-toggle="popover" data-html="true" title="" data-content="'.implode(',<br> ', $moreEmails).'">' . $more . ' more...</span>';
            } else {
                $chunks = $all->chunk($num)->toArray();

                foreach ($chunks[0] as $chunk) {
                    $firstEmails[] = $chunk['email'];
                }

                foreach ($chunks[1] as $chunk1) {
                    $moreEmails[] = $chunk1['email'];
                }

                $more = count($moreEmails);

                $result = implode(',<br>', $firstEmails) . ', <span class="href small text-primary" style="cursor:pointer" data-toggle="popover" data-html="true" title="" data-content="'.implode(',<br> ', $moreEmails).'">' . $more . ' more...</span>';
            }
        } else {
            $result = implode(',<br>', $all->pluck('email')->toArray());
        }

        return $result;
    }

    public function setActivity(string $event)
    {
        return activity('clients')
            ->causedBy(auth()->user())
            ->performedOn($this)
            ->withProperties([
                'attributes' => [
                    'Name' => $this->name,
                    'E-Mail' => $this->email,
                    'Phone' => $this->phone,
                    'Contact Person' => $this->contact_person,
                    'Address' => $this->address,
                    'Status' => $this->is_active == 1 ? 'Active' : 'Inactive',
                    'Comment' => $this->comment,
                    'Subscription E-Mails' => implode(',<br>', $this->emails->pluck('email')->toArray()),
                ]
            ])
            ->log($event);
    }
}
