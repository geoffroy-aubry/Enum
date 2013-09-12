#!/bin/bash

##
# Example:
# $ tests/benchmark.sh 1000 100
#
# Number of iterations: 1000
#     1× DayEnum::buildInstances():          0.436 ms
#   100× DayEnum with magic static calls:    3.469 ms
#   100× DayEnum with constants:             0.407 ms
#   100× with classic constants:             0.360 ms
#

set -o errexit
set -o nounset
set -o pipefail

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
I=${1:-10}
N=${2:-100}

echo "Number of iterations: $I"
read a b c d < <( \
    for i in $(seq $I); do
        php "$DIR/inc/benchmark.php" $N
    done \
    | awk -F ';' '
        {for(i=1; i<=NF; i++){sum[i]+=$i}}
        END {for(i=1; i<=NF; i++){printf sum[i]/NR "\t"} print "\n"}
    ' \
)

printf "%5s× DayEnum::buildInstances():       %' '8.3f ms\n" 1 $a
printf "%5s× DayEnum with magic static calls: %' '8.3f ms\n" $N $b
printf "%5s× DayEnum with constants:          %' '8.3f ms\n" $N $c
printf "%5s× with classic constants:          %' '8.3f ms\n" $N $d
