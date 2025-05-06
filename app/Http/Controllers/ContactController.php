<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService)
    {
    }

    public function index(): JsonResponse
    {
        $contacts = $this->contactService->list();

        return response()->json(['data' => $contacts]);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $this->contactService->create($request->validated());

        return response()->json($contact, 201);
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $updated = $this->contactService->update($contact, $request->validated());

        return response()->json($updated);
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $this->contactService->delete($contact);

        return response()->json(['message' => 'Contact deleted.']);
    }
}
