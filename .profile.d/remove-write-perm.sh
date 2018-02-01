#!/usr/bin/env bash

mkdir -p $HOME/web/app/uploads
if [[ ! "$CI" == "true" ]]; then
  chmod -R a-w $HOME/web
  chmod -R u+w $HOME/web/app/uploads
fi
