#!/bin/bash
NUM_MAIL_INSTANCES=5

MY_DIR=`dirname "$0"`
SCRIPTS_PATH="$MY_DIR"
MAIL_QUEUE="$SCRIPTS_PATH/MailQueue_Send.php"

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
    echo "Starting workers..."
    
    for (( i=1; i<=$NUM_MAIL_INSTANCES; i++))
    do
        run_in_background $MAIL_QUEUE
    done
    
    echo "done."
}

function stop()
{
    echo  "Stopping workers"
    `/bin/ps xa | egrep "MailQueue_Send.php" | grep -v "grep" | awk '{print $1}' | xargs kill -15`
    echo "done."
}



#parse params from command line and do what's needed
if [ $# -lt 1 ]
    then
    echo "Usage: `(basename $0)` start|stop"
    exit 1
fi

case "$1" in
    start)  
        start
        ;;
    stop)  
        stop
        ;;
    restart)
        stop
        start
        ;;
    *) echo "Unknown command: $1"
       ;;
esac

exit 0