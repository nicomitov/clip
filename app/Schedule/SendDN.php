<?php

namespace App\Schedule;

use App\Subscription;
use App\Mail\DN;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendDN
{
    protected $sendDir = 'public/dn/send/';

    protected $archiveDir = 'public/dn/archive/';

    public function __invoke()
    {
        // build attachments array
        $attachments = [];
        foreach($this->getFiles() as $file) {
            array_push($attachments, $file['path']);
        }

        // if no files
        if (! count($attachments)) {
            return false;
        }

        // send mails
        $emailsArr = [];
        foreach ($this->getEmails() as $email) {
            if (is_null(Mail::to($email)->send(new DN($attachments)))) {
                array_push($emailsArr, $email);
            }
        }
        // activity
        if (count($emailsArr)) {
            $this->setActivity('', 'SENT-DAILY-NEWS', $attachments, $emailsArr);
        }

        // move to archive
        if ($this->moveToArchive($this->getFiles())) {
            // activity
            $this->setActivity('', 'ARCHIVED', $attachments);
        }

        return true;
    }

    public function getEmails()
    {
        $subscriptions =
            Subscription::getActiveSubscriptions()
                        ->where('subscription_type_id', 1)
                        ->get();

        $emails = [];
        foreach ($subscriptions as $subscription) {
            foreach ($subscription->emails as $email) {
                array_push($emails, $email->email);
            }
        }

        return $emails;
    }

    public function getFiles()
    {
        $files = Storage::files($this->sendDir);

        // build array
        $filesArr = [];
        foreach ($files as $file) {

            $info= pathinfo($file);

            $info['path']= storage_path()."/app/".$file;

            if ($info['extension'] == 'pdf') {
                $filesArr[] = $info;
            }
        }

        return $filesArr;
    }

    public function moveToArchive($files)
    {
        // make dir
        if (! Storage::disk('local')->exists($this->archiveDir . date('Y/m/d'))) {
            Storage::disk('local')->makeDirectory($this->archiveDir . date('Y/m/d'));
        };

        foreach ($files as $file) {
            // check if the file exists and overwrite it
            if (Storage::disk('local')->exists($this->archiveDir . date('Y/m/d') . '/' . $file['basename'])) {
                Storage::delete($this->archiveDir . date('Y/m/d') . '/' . $file['basename']);
            }

            // move file
            Storage::disk('local')->move($file['dirname'] . '/' . $file['basename'], $this->archiveDir . date('Y/m/d') . '/' . $file['basename']);
        }

        return true;
    }

    public function setActivity(string $event, $logName, $files, $emails = null)
    {
        if (is_array($files)) {
            $arr = [];
            foreach ($files as $file) {
                $exploded = explode('/', $file);
                array_push($arr, end($exploded));
            }
            $files = implode('<br> ', $arr);
        }

        $properties = ['attributes' => ['Files' => $files,]];

        if ($emails) {
            $arr = [];
            foreach ($emails as $email) {
                array_push($arr, $email);
            }
            $emails = implode('<br> ', $arr);
            $properties['attributes']['Emails'] = $emails;
        }

        return activity($logName)
            ->withProperties($properties)
            ->log($event);
    }
}
