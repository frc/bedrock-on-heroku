# [Bedrock](https://roots.io/bedrock/)
[![Build Status](https://travis-ci.org/frc/bedrock-on-heroku.svg)](https://travis-ci.org/frc/bedrock-on-heroku)

Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

Much of the philosophy behind Bedrock is inspired by the [Twelve-Factor App](http://12factor.net/) methodology including the [WordPress specific version](https://roots.io/twelve-factor-wordpress/).

## Features

* Better folder structure
* Dependency management with [Composer](http://getcomposer.org)
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
* Autoloader for mu-plugins (use regular plugins as mu-plugins)
* Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))
* Multi site support

Use [Trellis](https://github.com/roots/trellis) for additional features:

* Easy development environments with [Vagrant](http://www.vagrantup.com/)
* Easy server provisioning with [Ansible](http://www.ansible.com/) (Ubuntu 14.04, PHP 5.6 or HHVM, MariaDB)
* One-command deploys

See a complete working example in the [roots-example-project.com repo](https://github.com/roots/roots-example-project.com).

## Requirements

* PHP >= 5.5
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

1. Clone the git repo - `git clone https://github.com/roots/bedrock.git`
2. Run `composer install`
3. Copy `.env.example` to `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
  * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT` - Generate with [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command) or from the [WordPress Salt Generator](https://api.wordpress.org/secret-key/1.1/salt/)
  * `WP_ALLOW_MULTISITE` - *true* if want to start using multi site (should be *false* unless explicitly needed)
  * `WP_MULTISITE_MAIN_DOMAIN` - Master domain name for multi site (do not set before enabling network from WP admin)
4. Add theme(s) in `web/app/themes` as you would for a normal WordPress site.
5. Set your site vhost document root to `/path/to/site/web/` (`/path/to/site/current/web/` if using deploys)
6. Access WP admin at `http://example.com/wp/wp-admin`

*Note!* If you plan to run your multisite on multiple domains, you need to change DOMAIN_CURRENT_SITE-setting in config/application.php, instructions can be found there. WordPress can't handle login cookies with different domains otherwise.

## Deploys

There are two methods to deploy Bedrock sites out of the box:

* [Trellis](https://github.com/roots/trellis)
* [bedrock-capistrano](https://github.com/roots/bedrock-capistrano)

Any other deployment method can be used as well with one requirement:

`composer install` must be run as part of the deploy process.

## Local development

You can use `heroku local` to start local development. By default the web server is started on [localhost:5000](http://localhost:5000). Please note that the `heroku local` needs an nginx configured with *realip* -module, which can be easily installed with the following commands (also doing some cleanup, as the local configuration is not needed anymore):

```
# Unload nginx running the default configuration
$ launchctl unload ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist

# Uninstall existing nginx
$ brew uninstall --force nginx
Uninstalling nginx... (23 files, 2,7M)

# Cleanup (backup legacy nginx configurations if you need those in future)
$ sudo rm -rf /usr/local/etc/nginx /usr/local/Library/Formula/nginx.rb \
    /usr/local/var/log/nginx* /usr/local/var/run/nginx*

# Install nginx with realip module
$ brew tap homebrew/nginx
$ brew install nginx-full --with-realip
```

*Note!* If you want to install `heroku local` to existing Bedrock installations, you may just add the following to your *composer.json* -file:

```sh
  "require-dev": {
    "heroku/heroku-buildpack-php": "dev-master"
  },
```

If using multi site, you need also to install a *reverse proxy* (any other reverse proxy will also suffice):

```sh
$ npm install -g reverse-proxy-js
```

You can then start the proxy by giving command (sudo is needed for restricted ports):

```sh
$ sudo reverse-proxy --port 80 --target 5000
```

## Documentation

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).

## Contributing

Contributions are welcome from everyone. We have [contributing guidelines](CONTRIBUTING.md) to help you get started.

## Community

Keep track of development and community news.

* Participate on the [Roots Discourse](https://discourse.roots.io/)
* Follow [@rootswp on Twitter](https://twitter.com/rootswp)
* Read and subscribe to the [Roots Blog](https://roots.io/blog/)
* Subscribe to the [Roots Newsletter](https://roots.io/subscribe/)
