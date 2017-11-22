#!/bin/sh
SPARQLSTOREDIR="$HOME/.sparqlstore"
mkdir -p ${SPARQLSTOREDIR}
mongod --fork --logpath /dev/null
cd sparql_endpoint/fuseki/ ; ./fuseki-server --update --loc $SPARQLSTOREDIR /decisions > /dev/null 2>&1 &