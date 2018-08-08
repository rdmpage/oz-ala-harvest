#!/bin/sh

echo 'ala-50000.json'
curl http://130.209.46.63/_bulk -XPOST --data-binary '@ala-50000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-100000.json'
curl http://130.209.46.63/_bulk -XPOST --data-binary '@ala-100000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-150000.json'
curl http://130.209.46.63/_bulk -XPOST --data-binary '@ala-150000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-200000.json'
curl http://130.209.46.63/_bulk -XPOST --data-binary '@ala-200000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-203653.json'
curl http://130.209.46.63/_bulk -XPOST --data-binary '@ala-203653.json'  --progress-bar | tee /dev/null
echo ''
