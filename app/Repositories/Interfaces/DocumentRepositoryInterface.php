<?php

namespace App\Repositories\Interfaces;

interface DocumentRepositoryInterface
{
    public function getAllDocuments();
    public function getDocumentById($documentId);
    public function getDocumentByUserId($userId);
    public function deleteDocument($documentId);
    public function createDocument(array $documentDetails);
    public function updateDocument($documentId, array $documentDetails);
}
