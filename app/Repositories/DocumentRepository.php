<?php

namespace App\Repositories;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentRepositoryInterface;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function getAllDocuments()
    {
        return Document::all();
    }
    public function getDocumentById($documentId)
    {
        return Document::findOrfail($documentId);
    }
    public function getDocumentByUserId($userId)
    {
        return Document::where('user_id', $userId)->get();
    }
    public function deleteDocument($documentId)
    {
        return Document::destroy($documentId);
    }
    public function createDocument(array $documentDetails)
    {
        return Document::create($documentDetails);
    }
    public function updateDocument($documentId, array $newDetails)
    {
        Document::whereId($documentId)->update($newDetails);
    }
}
