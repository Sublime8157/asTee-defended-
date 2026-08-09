<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Streams the two kinds of file that must never be publicly readable.
 *
 * The route takes a record id, not a path — the filename comes from the
 * database, so there is nothing for a caller to traverse. Both routes sit
 * inside the admin group.
 */
class AdminFileController extends Controller
{
    public function validId(int $userId): StreamedResponse
    {
        return $this->stream(User::findOrFail($userId)->valid_id_path);
    }

    public function paymentProof(int $paymentId): StreamedResponse
    {
        return $this->stream(Payment::findOrFail($paymentId)->proof_path);
    }

    private function stream(?string $path): StreamedResponse
    {
        abort_if(blank($path) || ! Storage::disk('private')->exists($path), 404);

        return Storage::disk('private')->response($path);
    }
}
