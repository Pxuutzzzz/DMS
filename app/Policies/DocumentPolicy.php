<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Document $document): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->canUploadDocuments();
    }

    public function upload(User $user): bool
    {
        return $user->canUploadDocuments();
    }

    public function update(User $user, Document $document): bool
    {
        if ($user->isAdmin()) return true;
        if ($document->status === Document::STATUS_DRAFT || $document->status === Document::STATUS_REVISION) {
            return $user->id === $document->created_by;
        }
        return false;
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->canDeleteDocuments();
    }
}
