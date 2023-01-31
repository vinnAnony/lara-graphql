<?php

namespace App\GraphQL\Mutations\Document;

use App\Repositories\Interfaces\DocumentRepositoryInterface;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\User;

class DeleteDocumentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteDocument'
    ];

    protected DocumentRepositoryInterface $documentRepository;

    public function __construct(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function type(): Type
    {
        return GraphQL::type('Document');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $this->documentRepository->deleteDocument($args);
        return true;
    }
}
