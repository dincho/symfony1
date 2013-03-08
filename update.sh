#!/bin/bash
PHP=`/usr/bin/which php`
GIT=`/usr/bin/which git`
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
SYMFONY=$DIR/symfony
ENV="stag"

die () {
    echo >&2 "$@"
    exit 1
}

update () {
    echo -e "Updating...\n"

    cd $DIR
    $GIT pull

    $SYMFONY disable frontend $ENV
    $SYMFONY disable backend $ENV
    rm -rf $DIR/web/cache/*
    $SYMFONY clear-cache
    $SYMFONY propel-build-model
    $SYMFONY migrate frontend:$ENV
    $SYMFONY enable frontend $ENV
    $SYMFONY enable backend $ENV
}

[ "$#" -eq 1 ] || die "Please provide environment as argument"
update #all fine, let's update