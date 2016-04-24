# ElasticsearchExtraBundle

I will not maintain this bundle anymore, prefer [elastica-extra-bundle](https://github.com/gbprod/elastica-extra-bundle).

[![Build Status](https://travis-ci.org/gbprod/elasticsearch-extra-bundle.svg?branch=master)](https://travis-ci.org/gbprod/elasticsearch-extra-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gbprod/elasticsearch-extra-bundle/?branch=master)

[![Latest Stable Version](https://poser.pugx.org/gbprod/elasticsearch-extra-bundle/v/stable)](https://packagist.org/packages/gbprod/elasticsearch-extra-bundle)
[![Total Downloads](https://poser.pugx.org/gbprod/elasticsearch-extra-bundle/downloads)](https://packagist.org/packages/gbprod/elasticsearch-extra-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gbprod/elasticsearch-extra-bundle/v/unstable)](https://packagist.org/packages/gbprod/elasticsearch-extra-bundle)
[![License](https://poser.pugx.org/gbprod/elasticsearch-extra-bundle/license)](https://packagist.org/packages/gbprod/elasticsearch-extra-bundle)

Extra tools for managing indices and types.
Built on top of [m6web/elasticsearch-bundle](https://github.com/M6Web/ElasticsearchBundle).

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

See [M6WebElasticsearchBundle](https://github.com/M6Web/ElasticsearchBundle) for configuring clients.

## Index Management Operations

### Configuration

Set indices setup

```yaml
elasticsearch_extra:
    indices:
        my_index:
            settings:
                number_of_shards: 3
                number_of_replicas: 2
            mappings:
                my_type:
                    _source:
                        enabled: true
                    properties:
                        first_name:
                            type: string
                            analyzer: standard
                        age:
                            type: integer
        my_index_2: ~
```

See [Official documentation](https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_index_management_operations.html) for options.

### Create index

With default client:

```bash
php app/console elasticsearch:index:create my_index
```

Or with specified client:

```bash
php app/console elasticsearch:index:create my_index --client=my_client
```

### Delete index

With default client:

```bash
php app/console elasticsearch:index:delete my_index --force
```

Or with specified client:

```bash
php app/console elasticsearch:index:delete my_index --force --client=my_client
```

### Put index settings

With default client:

```bash
php app/console elasticsearch:index:put_settings my_index
```

Or with specified client:

```bash
php app/console elasticsearch:index:put_settings my_index --client=my_client
```

### Put index mappings

With default client:

```bash
php app/console elasticsearch:index:put_mappings my_index my_type
```


Or with specified client:

```bash
php app/console elasticsearch:index:put_mappings my_index my_type --client=my_client
```
