<?php

namespace App\GraphQL\Mutations\Document;

use App\Repositories\Interfaces\DocumentRepositoryInterface;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\User;

class CreateDocumentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateDocument'
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
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string())
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string())
            ],
            'url' => [
                'name' => 'url',
                'type' => Type::nonNull(Type::string())
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return $this->documentRepository->createDocument($args);
    }
}
