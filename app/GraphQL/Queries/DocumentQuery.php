<?php

namespace App\GraphQL\Queries;

use App\Models\Document;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class DocumentQuery extends Query
{

    protected $attributes = [
        'name' => 'document',
        'description' => 'A query of a document'
    ];

    public function type(): Type
    {
        return GraphQL::type('Document');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Document::findOrFail($args['id']);
    }
}
