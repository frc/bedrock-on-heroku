#!/usr/bin/env bash

mkdir -p $HEROKU_APP_DIR/app/uploads
if [[ ! "$CI" == "true" ]]; then
  chmod -R a-w $HEROKU_APP_DIR
  chmod -R u+w $HEROKU_APP_DIR/app/uploads
fi
