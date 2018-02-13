Web Editor
==========

The web editor is used exclusively by public sector authorities. It is a well-structured HTML form that government institutions can use in order to write their decisions. The HTML elements of the form are associated with the properties and classes of [Diavgeia ontology](https://github.com/ThemisB/diavgeiaRedefined/blob/master/rdf/diavgeia.owl). By submitting the form, the decision is stored both as a compressed Notation3 file in the filesystem of Diavgeia and in Jena Apache's triple store.

Configuration
-------------

```json
{
  "decisionsSaveDir": "~/diavgeiaN3Decisions",
  "isDecisionsSaveDirHome": true,
  "sparqlEndpointUrl": "http://localhost:3030",
  "sparqlStoreDir": "/mydir/.sparqlstore",
  "dataset": "decisions",
  "SOH_post_executable": "../sparql_endpoint/fuseki/bin/s-post",
  "mongoDBName": "diavgeiaRedefinedMongoDB",
  "mongoPort": "27017",
  "mongoURL": "localhost"
}
```

**decisionsSaveDir** : The directory in which compressed Notation3 decisions will be stored.

**isDecisionsSaveDirHome** : True if *decisionsSaveDir* contains a home directory.

**sparqlEndpointUrl** : The Fuseki/SPARQL endpoint url.

**sparqlStoreDir** : The directory in which Fuseki will store its data.

**dataset** : The name of the dataset used in Fuseki.

**SOH_post_executable** : The place where SOH s-post resides. You usually have to leave it as it is.

**mongoDBName** : The name of the Mongo database.

**mongoPort** : The port of the mongo.

**mongoURL** : The url used on the mongo connection.

**NOTE** : After configuring your `.json` file, you have to export the *NODE_ENV* according to the configuration file name. For instance, if you have named your configuration file `development.json` you have to `export NODE_ENV=development`. Please read more about this, [here](https://github.com/lorenwest/node-config/wiki/Environment-Variables)