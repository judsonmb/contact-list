<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactCreated;

class ContactService
{
    public function create(array $data): Contact
    {
        $contact = Contact::create($data);

        Notification::route('mail', env('NOTIFICATION_EMAIL'))
            ->notify(new ContactCreated($contact));

        return $contact;
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);

        return $contact;
    }

    public function delete(Contact $contact): void
    {
        $contact->delete();
    }

    public function list(): Collection
    {
        return Contact::orderBy('name')->get();
    }
}
