DiavgeiaRedefined: Diavgeia using Semantic Web technologies and Permissionless Blockchains
===============

## DiavgeiaRedefined in a nutshell

DiavgeiaRedefined is a re-engineering of Diavgeia, the Greek government
portal for open and transparent public administration. This repository studies how decisions of Greek government institutions can be modeled using
ontologies expressed in OWL ([Diavgeia ontology](https://github.com/ThemisB/diavgeiaRedefined/blob/master/rdf/diavgeia.owl)). The [Web editor](https://github.com/ThemisB/diavgeiaRedefined/tree/master/web-editor) is a tool which enables Greek government institutions to author their decisions inside a web browser and transparently publish these decisions expressed in RDF. The [Visualizer](https://github.com/ThemisB/diavgeiaRedefined/tree/master/visualizer) tool can be used by any interested party in order to visualize any RDF decision of Diavgeia online, on their web browser. The bitcoin blockchain enables government decisions to remain immutable ([Stamper](https://github.com/ThemisB/diavgeiaRedefined/tree/master/stamper)). Any interested party can verify the integrity of the uploaded decisions, by using the [Consistency Verifier](https://github.com/ThemisB/diavgeiaRedefined/tree/master/consistency-verifier) tool. Finally, the [SPARQL endpoint](https://github.com/ThemisB/diavgeiaRedefined/tree/master/sparql_endpoint) empowers citizens to more easy explore decisions and detect possible government corruption in a Semantic query-like fashion.

## Installation & Usage

As a minimum requirement, you have to install on your system a NodeJS version >= 8.0 ([download link]([https://nodejs.org/en/download/current/])). It also requires a running MongoDB instance.

Having successfully installed NodeJS >= 8.0, you have to also install the related dependencies (node_modules), simply by running `node install_dependencies.js` on the root of the project folder.

After that you have to edit the related configuration files, as explained to the README files of the corresponding components (see [web-editor](https://github.com/ThemisB/diavgeiaRedefined/tree/master/web-editor/README.md), [stamper](https://github.com/ThemisB/diavgeiaRedefined/blob/master/stamper/README.md) and [consistency-verifier](https://github.com/ThemisB/diavgeiaRedefined/tree/master/consistency-verifier/README.md)))

In order to start all the services of the project, simply run `npm start` on the root of the project.

In order to stop all the services kill the running npm process and then type `npm stop`.

## Components of DiavgeiaRedefined

In order to better understand the goal of this project, please pay a visit to the links of the components of DiavgeiaRedefined, as provided below. The README files explain in great detail their functionality and benefits.

* The *Diavgeia ontology* and related RDF topics (see the following  [README](https://github.com/ThemisB/diavgeiaRedefined/tree/master/rdf/README.md))

* See some [SPARQL queries](https://github.com/ThemisB/diavgeiaRedefined/tree/master/sparql_endpoint) one may pose to scrutinize the public sector.

* The Web Editor component (see the following [README](https://github.com/ThemisB/diavgeiaRedefined/tree/master/web-editor/README.md))

* Visualizer (see the following [README](https://github.com/ThemisB/diavgeiaRedefined/tree/master/visualizer/README.md))

* Stamper (see the following [README](https://github.com/ThemisB/diavgeiaRedefined/tree/master/stamper/README.md))

* The Consistency Verifier tool (see the [README](https://github.com/ThemisB/diavgeiaRedefined/tree/master/consistency-verifier/README.md))