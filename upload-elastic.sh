#!/bin/sh

echo 'ala-20000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-20000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-40000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-40000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-60000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-60000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-80000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-80000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-100000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-100000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-120000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-120000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-140000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-140000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-160000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-160000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-180000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-180000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-200000.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-200000.json'  --progress-bar | tee /dev/null
echo ''
echo 'ala-203653.json'
curl http://user:7WbQZedlAvzQ@35.204.73.93/elasticsearch/ala/_bulk -H 'Content-Type: application/x-ndjson' -XPOST --data-binary '@ala-203653.json'  --progress-bar | tee /dev/null
echo ''
