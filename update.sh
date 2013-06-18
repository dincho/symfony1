#!/bin/bash
PHP=`/usr/bin/which php`
GIT=`/usr/bin/which git`
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
SYMFONY=$DIR/symfony
DEFAULT_BRANCH="origin/master"
BRANCH=${2:-$DEFAULT_BRANCH}

function die () {
    echo >&2 "$@"
    exit 1
}

function update () {
    ENV=$1 #better naming
    echo -e "Updating...\n"

    cd $DIR
    $GIT fetch --all
    $GIT reset --hard $BRANCH

    $SYMFONY disable frontend $ENV
    $SYMFONY disable backend $ENV
    rm -rf $DIR/web/cache/*
    $SYMFONY clear-cache
    $SYMFONY propel-build-model
    $SYMFONY migrate frontend:$ENV
    $SYMFONY enable frontend $ENV
    $SYMFONY enable backend $ENV
}

[ "$#" -gt 0 ] || die "Please provide environment as argument"
update $1 #all fine, let's update