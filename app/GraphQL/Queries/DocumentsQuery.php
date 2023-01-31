<?php

namespace App\GraphQL\Queries;

use App\Models\Document;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class DocumentsQuery extends Query
{

    protected $attributes = [
        'name' => 'documents',
        'description' => 'A query of documents'
    ];

    public function type(): Type
    {
        // Result with Laravel pagination
        return Type::listOf(GraphQL::type('Document'));
    }

    public function resolve($root, $args)
    {
        return Document::all();
    }
}
