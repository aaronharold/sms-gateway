# SMS Gateway Service

#### How to use

### Add Environment Variable to .env
```

SMS_CONNECTION=

M360_BASEURI=
M360_SENDER_ID=
M360_APP_SECRET=
M360_APP_KEY=

PROMOTEXTER_APIKEY=
PROMOTEXTER_APISECRET=
PROMOTEXTER_FROM=
PROMOTEXTER_BASEURI=

```

#### On root composer.json file, add repositories to json
```

    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "aaron-harold/sms-gateway",
                "version": "dev-main",
                "source": {
                    "url": "https://github.com/aaronharold/sms-gateway",
                    "type": "git",
                    "reference": "main"
                },
                "autoload": {
                    "psr-4": {
                        "AaronHarold\\SmsGateway\\": "src"
                    }
                }
            }
        }
    ],

```
or 

```

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/aaronharold/sms-gateway"
        }
    ],

```

#### On the same file (composer.json), now add the package on the require section
```

    "require": {
      "aaronharold/sms-gateway": "dev-main",
    },

```

or

```

 composer require aaronharold/sms-gateway:dev-main

```

#### Open terminal and run (optional)
```

composer update

```


### Publish Vendor
```

php artisan vendor:publish --provider=Aaronharold\SmsGateway\SmsGatewayProvider

```

