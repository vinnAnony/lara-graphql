<?php

namespace App\GraphQL\Types;

use App\Models\Document;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DocumentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Document',
        'description' => 'A type',
        'model' => Document::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The document id'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the document'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the document'
            ],
            'url' => [
                'type' => Type::string(),
                'description' => 'The url of the document'
            ],
            // Relation field to model User
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The user whom the document belongs to'
            ]
        ];
    }
}
