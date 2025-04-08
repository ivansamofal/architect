<?php

namespace App\Factories;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClientFactory
{
    public static function create(): Client
    {
        return ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])// todo env
            ->build();
    }
}
