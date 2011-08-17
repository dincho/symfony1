#!/bin/bash
NUM_MAIL_INSTANCES=5
NUM_MATCH_INSTANCES=5

MY_DIR=`dirname "$0"`
SCRIPTS_PATH="$MY_DIR"
MAIL_QUEUE="$SCRIPTS_PATH/MailQueue_Send.php"
MATCH_STRAIGHT="$SCRIPTS_PATH/MatchQueue_Straight.php"
MATCH_REVERSE="$SCRIPTS_PATH/MatchQueue_Reverse.php"

PHP=`which php`
NOHUP=`which nohup`

run_in_background()
{
    if [ -e $1 ] && [ -f $1 ] && [ -r $1 ]
        then
            CMD="$NOHUP $PHP $1"
            $CMD &
        else
            echo "Unable to run because of permissions problem: $1"
    fi
}

function start()
{
    for (( i=1; i<=$NUM_MAIL_INSTANCES; i++))
    do
        run_in_background $MAIL_QUEUE
    done

    for (( i=1; i<=$NUM_MATCH_INSTANCES; i++))
    do
        run_in_background $MATCH_STRAIGHT
        run_in_background $MATCH_REVERSE
    done
}

function stop()
{
    `/bin/ps -e | egrep "MailQueue_Send.php|MatchQueue_Straight.php|MatchQueue_Reverse.php" | grep -v "grep" | awk '{print $1}' | xargs kill -15`
}



#parse params from command line and do what's needed
if [ $# -lt 1 ]
    then
    echo "Usage: `(basename $0)` start|stop"
    exit 1
fi

case "$1" in
    start)  echo "Starting workers..."
        start
        echo "done."
        ;;
    stop)  echo  "Stopping workers"
        stop
        echo "done."
        ;;
    *) echo "Unknown command: $1"
       ;;
esac

exit 0