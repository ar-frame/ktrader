#!/bin/bash
cmd=$1
if [ $cmd = "stop" ]
then
	echo "st"
else
	cmd="start -d"
fi
echo $cmd

pairs=(btc eth eos)
for pair in "${pairs[@]}"
do
	echo $pair
        exec_cmd="php aw_websocket.php ${cmd} ${pair}"
	echo $exec_cmd
	$exec_cmd

done
