# SPARQL Endpoint

> This project uses Apache Jena as rdf store and Fuseki Server as a way to provide a User Interface to citizens to pose SPARQL queries.

## Installation Instructions

``` bash
# One line setup
cd fuseki && mkdir -p SparqlStoreDir && ./fuseki-server --update --loc=SparqlStoreDir /dataset

# SparqlStoreDir: The Directory that you want to rdf store to store decisions
# /dataset: The dataset name for storing decisions. This should be the same with dataset config value of n3-composer.
```