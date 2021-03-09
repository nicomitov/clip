<?php

namespace App\Schedule;

use App\Subscription;
use App\Mail\CLIP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendClip
{
    protected $sendDir = 'public/clip/send/';

    protected $archiveDir = 'public/clip/archive/';

    public function __invoke()
    {
        // if no files return
        if (! count($this->getFiles())) {
            return;
        }

        // send emails & set activity on email
        $this->sendEmails('pics');
        $this->sendEmails('text');

        // move to archive & set activity
        $this->moveToArchive($this->getFiles());

        return true;
    }

    public function getFiles(string $type = null)
    {
        $files = Storage::files($this->sendDir);

        // set extensions array
        if ($type == 'pics') {
            $extensions = ['jpg', 'jpeg', 'png'];
        } elseif ($type == 'text') {
            $extensions = ['doc', 'docx'];
        } else { // null
            return $files;
        }

        // build array
        $filesArr = [];

        foreach ($files as $file) {

            $info = pathinfo($file);

            $info['path'] = storage_path()."/app/".$file;
            $topic = explode("_", $info['filename']);
            $info['topic'] = $topic[0];

            if (in_array($info['extension'], $extensions)) {
                $filesArr[$type][$info['topic']][] = $info['path'];
            }
        }

        return $filesArr;
    }

    public function getEmails(int $topicNumber)
    {
        $subscriptions =
            Subscription::getActiveSubscriptions()
                        ->where('subscription_type_id', 2)
                        ->whereHas('topics', function ($query) use ($topicNumber) {
                            $query->where('number', $topicNumber);
                        })->get();

        $emails = [];
        foreach ($subscriptions as $subscription) {
            foreach ($subscription->emails as $email) {
                array_push($emails, $email->email);
            }
        }

        return $emails;
    }

    public function sendEmails(string $emailType)
    {
        foreach($this->getFiles($emailType) as $type => $pics) {
            foreach ($pics as $topic => $data) {
                foreach ($this->getEmails($topic) as $email) {
                    // send mails
                    Mail::to($email)->send(new CLIP($data, $type, $topic));

                    // set activity
                    $this->setActivity('SENT-CLIP', $data, $email);
                }
            }
        }

        return true;
    }

    public function moveToArchive($files)
    {
        // make dir
        if (! Storage::disk('local')->exists($this->archiveDir . date('Y/m/d'))) {
            Storage::disk('local')->makeDirectory($this->archiveDir . date('Y/m/d'));
        };

        $arr = []; // for activity
        foreach ($files as $file) {
            $file = pathinfo($file);

            array_push($arr, $file['basename']);

            // check if the file exists and overwrite it
            if (Storage::disk('local')->exists($this->archiveDir . date('Y/m/d') . '/' . $file['basename'])) {
                Storage::delete($this->archiveDir . date('Y/m/d') . '/' . $file['basename']);
            }

            // move file
            Storage::disk('local')->move($file['dirname'] . '/' . $file['basename'], $this->archiveDir . date('Y/m/d') . '/' . $file['basename']);
        }

        // set activity
        $this->setActivity('ARCHIVED', $arr);

        return true;
    }

    public function setActivity(string $logName, array $data, string $email = null)
    {
        $arr = [];
        foreach ($data as $file) {
            $file = pathinfo($file);
            array_push($arr, $file['basename']);
        }
        $files = implode(', ', $arr);

        $properties = ['attributes' => [
            'Files' => $files,
        ]];

        if (! is_null($email)) {
            $properties['attributes']['Email'] = $email;
        }

        return activity($logName)
            ->withProperties($properties)
            ->log('');

        return true;
    }
}
