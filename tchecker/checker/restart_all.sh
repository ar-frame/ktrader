#!/bin/bash
BASE_PATH=$(cd $(dirname "${BASH_SOURCE[0]}") && pwd)
cd BASE_PATH

loops=("ETH" "EOS" "BTC" "LTC" "GT" "HT")

for pair in ${loops[@]} ;do

	pair_l=$(echo $pair | tr '[A-Z]' '[a-z]')
    echo $pair_l
    sciprt_name="aw_websocket_${pair_l}.php"
    exec_script="php ${sciprt_name} restart -d ${pair_l}"
    ${exec_script}
    echo ${exec_script} exec succ
done
