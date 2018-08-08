# oz-ala-harvest
Harvest Atlas of Living Australia taxonomy

## Triples

Generate triples from ALA JSON.

```
curl http://127.0.0.1:5984/ala/_design/nt/_list/triples/triples > taxa.nt
```

May need to chunk the dump into smaller sizes using ```chunk.php```.

Upload to triple store:

```
curl http://127.0.0.1:9999/blazegraph/sparql -H 'Content-Type: text/rdf+n3' --data-binary '@taxa.nt'

```

Same but upload to a named graph:

```
curl http://127.0.0.1:9999/blazegraph/sparql?context-uri=https://bie.ala.org.au -H 'Content-Type: text/rdf+n3' --data-binary '@taxa.nt'
```

```
curl http://130.209.46.63/blazegraph/sparql?context-uri=https://bie.ala.org.au -H 'Content-Type: text/rdf+n3' --data-binary '@taxa.nt'
```

With progress bar, see https://stackoverflow.com/a/41860083/9684
```
curl http://130.209.46.63/blazegraph/sparql?context-uri=https://bie.ala.org.au -H 'Content-Type: text/rdf+n3' --data-binary '@taxa-1500000.nt' --progress-bar | tee /dev/null
```

## Elasticsearch

Dump Elasticsearch documents as JSONL:

```
curl http://127.0.0.1:5984/ala/_design/elastic/_list/jsonl/taxon > ala.jsonl
```


