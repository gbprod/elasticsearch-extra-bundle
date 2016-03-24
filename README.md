# ElasticsearchExtraBundle

[![Build Status](https://travis-ci.org/gbprod/elasticsearch-extra-bundle.svg?branch=master)](https://travis-ci.org/gbprod/elasticsearch-extra-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/?branch=master)

Extra tools for [m6web/elasticsearch-bundle](https://github.com/M6Web/ElasticsearchBundle).

## Installation

With composer :

```bash
composer require gbprod/elasticsearch-extra-bundle
```

Update your `app/AppKernel.php` file:

```php
public function registerBundles()
{
    $bundles = array(
        new M6Web\Bundle\ElasticsearchBundle\M6WebElasticsearchBundle(),
        new GBProd\ElasticsearchExtraBundle\ElasticsearchExtraBundle(),
    );
}
```

See [M6WebElasticsearchBundle](https://github.com/M6Web/ElasticsearchBundle] for configuring clients.

## Index Management Operations

### Configuration

Set indices setup

```yaml
elasticsearch_extra:
    my_client:
        indices:
            my_index_1:
                settings:
                    number_of_shards: 3
                    number_of_replicas: 2
                mappings:
                    my_type:
                        _source:
                            enabled: true
                        properties:
                            first_name
                                type: string
                                analyzer: standard
                            age:
                                type: integer
            my_index_2: ~
    my_client_2:
        indices:
            my_index_3:
            # ....
```

See [Official documentation](https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_index_management_operations.html) for options.

### Create index

```bash
php app/console elasticsearch:create_index my_client my_index_1
```
