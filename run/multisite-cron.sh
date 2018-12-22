#!/bin/bash

cd web/wp
for URL in = $(wp site list --fields=url --format=csv)
do

	if [[ $URL == "http"* ]]; then
	    echo "running cron for $URL";
		wp cron event run --all --due-now --url="$URL"
	fi

done
