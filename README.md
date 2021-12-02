### DEPRECATED | CHECK NEW VERSION > https://github.com/pagarme/magento2

# Mundipagg agora é Pagar.me

Buscando trazer a melhor experiência para os nossos clientes, a Mundipagg agora é parte do Pagar.me.

Somamos nossas funcionalidades e agora você tem acesso a uma plataforma financeira completa, que oferece o melhor das duas soluções em uma experiência unificada.

Você pode customizar nossos produtos e serviços da forma que for melhor para o seu e-commerce. Ficou curioso para saber o que muda? Preparamos um FAQ completo explicando tudo.

[Saiba mais](https://mundipagg.zendesk.com/hc/pt-br/categories/4404432249876-Incorpora%C3%A7%C3%A3o-Mundipagg-pelo-Pagar-me)


# Magento2/Mundipagg Integration module
This is the official Magento2 module for Mundipagg integration

## Documentation
Refer to [module documentation](https://github.com/mundipagg/magento2/wiki)

## Plugin in Magento Marketplace
Coming soon :construction:

## Installation

This module is now available through *Packagist*! You don't need to specify the repository anymore.

[https://packagist.org/packages/mundipagg/mundipagg-magento2-module](https://packagist.org/packages/mundipagg/mundipagg-magento2-module)

Add the following lines into your composer.json 
```
{
	"require": {
		"mundipagg/mundipagg-magento2-module":"2.*"
	}
}
```

or simply digit 
```
composer require 'mundipagg/mundipagg-magento2-module:2.*'
```
 
Then type the following commands from your Magento root:

```
composer update
./bin/magento setup:upgrade
./bin/magento setup:di:compile
```

## Upgrading to 2.x from 1.x and 2.x.x-beta

**Steps**

If you have an old module's version
`composer remove mundipagg/mundipagg-magento2-module`

As a precaution, clear the composer cache:
`composer clearcache`

Install the version:
`composer require 'mundipagg/mundipagg-magento2-module:2.*' -vvv`

Then run the following commands from your Magento root:

```
./bin/magento setup:upgrade
./bin/magento setup:di:compile
```

For the future versions, just run composer update
`composer update`




## Requirements
* PHP >= 7.1
* Magento >= 2.1
  
(This PHP version is the recommended one, but version 5.6 has been kept in Packagist/Composer for compatibility reasons.).

## Configuration

After installation has completed go to **Stores** > **Settings** > **Configuration** > **Sales** > **Payment Methods** > **Other Payment Methods** > **MundiPagg Payments**.

To learn more about how detailed configure the module, see our [wiki](https://github.com/mundipagg/magento2/wiki)

## Business/Technical Support

Please, send a e-mail to [suporte@mundipagg.com](mailto:suporte@mundipagg.com)

## How can I contribute?
Please, refer to [CONTRIBUTING](CONTRIBUTING.md)

## Found something strange or need a new feature?
Open a new Issue following our issue template [ISSUE-TEMPLATE](ISSUE-TEMPLATE.md)

## Changelog
See in [releases](https://github.com/mundipagg/magento2/releases)
