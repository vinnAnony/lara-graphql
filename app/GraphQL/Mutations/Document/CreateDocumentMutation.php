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
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'string', 'max:100'],
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['string', 'max:50'],
            ],
            'document_file' => [
                'name' => 'document_file',
                'type' => GraphQL::type('Upload'),
                'rules' => ['required', 'mimes:png,jpg,pdf', 'max:1024'],
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int())
            ],
            'upload_local' => [
                'name' => 'upload_local',
                'type' => Type::boolean()
            ],
            'upload_aws' => [
                'name' => 'upload_aws',
                'type' => Type::boolean()
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return $this->documentRepository->createDocument($args);
    }
}
