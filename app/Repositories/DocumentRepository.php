<?php

namespace App\Repositories;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $doc = Document::whereId($documentId)->first();
        if (Document::destroy($documentId)) {
            return $doc;
        }
    }
    public function createDocument(array $documentDetails)
    {
        try {
            if ($documentDetails['upload_local']) {
                // Upload to local storage
                $file_name = time() . '.' . $documentDetails['document_file']->getClientOriginalExtension();
                $file_path = $documentDetails['document_file']->storeAs('documents', $file_name, 'public');
                $documentDetails['url'] = '/storage/' . $file_path;
            }
            if ($documentDetails['upload_aws']) {
                // Upload to AWS S3 Bucket
                $storagePath = Storage::disk('s3')->put('documents', $documentDetails['document_file'], 'public');
                if (Storage::disk('s3')->exists($storagePath)) {
                    $documentDetails['aws_url'] = Storage::disk('s3')->url($storagePath);
                    $documentDetails['url'] = $documentDetails['aws_url'];
                }
            }

            if ($documentDetails['upload_aws'] && $documentDetails['upload_aws']) {
                $documentDetails['url'] = $documentDetails['aws_url'];
            }

            return Document::create($documentDetails);
        } catch (\Exception $e) {
            Log::error('Doc upload error: ' . $e->getMessage());
        }
    }
    public function updateDocument($documentId, array $newDetails)
    {
        return Document::whereId($documentId)->update($newDetails);
    }
}
