#!/usr/bin/env bash

if $(wp core is-installed --network); then
  ## Do multisite stuff
  for URL in $(wp site list --fields=url --format=csv); do
    if [[ $URL == "http"* ]]; then
        echo "running cron for $URL";
        wp cron event run --all --due-now --url="$URL"
    fi
  done

elif $(wp core is-installed); then
  ## Do normal stuff
  wp cron event run --all --due-now;
else
  ## Site is broken, SOS. Alert someone?
  ## Fallback to the old wp-cron code, without wp-cli?
  cd $HEROKU_APP_DIR/wp;
  php wp-cron.php

fi
