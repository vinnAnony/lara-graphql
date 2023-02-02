<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class DocumentController extends Controller
{

    private DocumentRepositoryInterface $documentRepository;

    public function __construct(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => $this->documentRepository->getAllDocuments()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Document\StoreDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request)
    {
        $documentDetails = $request->all();

        return response()->json([
            'data' => $this->documentRepository->createDocument($documentDetails)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $documentId)
    {

        return response()->json([
            'data' => $this->documentRepository->getDocumentById($documentId)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function showByUserId(Request $request, $userId)
    {

        return response()->json([
            'data' => $this->documentRepository->getDocumentByUserId($userId)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Document\UpdateDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentRequest $request)
    {
        $documentDetails = $request->only([
            'title',
            'description',
            'url',
            'user_id',
        ]);
        $documentId = $request->route('id');

        return response()->json([
            'data' => $this->documentRepository->updateDocument($documentId, $documentDetails)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Support\Facades\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $documentId)
    {
        return response()->json([
            'data' => $this->documentRepository->deleteDocument($documentId)
        ]);
    }
}
