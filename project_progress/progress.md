### GSoC 2017:  Project Progress Report

**Week 11 (12 August - 21 August)**

- Adopt Jena Apache and Fuseki Server as rdf store and SPARQL Endpoint Server respectively. [link](https://github.com/eellak/gsoc17-diavgeia/tree/master/sparql_endpoint)
- Complete visualizer for general decision properties. [link](https://github.com/eellak/gsoc17-diavgeia/tree/master/visualizer)
- Create project website! [link](https://eellak.github.io/gsoc17-diavgeia/)
- Rewrite documentation and add some installation instructions (Future Work, Production Ready tools, etc).

The repo is now ready for the final submission.

**Week 10 (5 August - 11 August)**
- Complete n3 generation! [n3-composer](https://github.com/eellak/gsoc17-diavgeia/tree/master/n3-composer) covers all the different decision types of Diavgeia that are expressed in the rdf schema.

That means that all the deliverables have been implemented and are ready for the final project submission.

But we still have two weeks until the final project submission. Thus, i will try to import the n3 decisions to a RDF Store (most possibly Apache Jena), create some sample "interesting" queries that examine the transparency of Diavgeia and if time permits, i will make a visualization for some decision types.

**Week 9 (29 July - 4 August)**
- Support n3 generation of 24 out of 31 decision types.

The following week, i will add support for the remaining decision types.

**Week 8 (22 July - 28 July)**
- Complete [n3-composer](https://github.com/eellak/gsoc17-diavgeia/tree/master/n3-composer) basic implementation. n3-composer covers almost all of the general properties that a decision may have.
- Provide [deployment scripts for development and production](https://github.com/eellak/gsoc17-diavgeia/blob/master/n3-composer/README.md).
- Test the blockchain implementation on the bitcoin mainnet.

The following week, i will add support for more decision-specific rdf properties.

**Week 7 (15 July - 21 July)**

- Finish `.n3` compression. I achieved a **100x** disk space reduction (PDF files: 7.1MB **vs** .n3 files: 72KB)!
- Start implementation of [n3-composer](https://github.com/eellak/gsoc17-diavgeia/tree/master/n3-composer). N3-composer is a HTML form that government institutions will use in order to compose their decisions and generate `.n3` decisions. Thus, Diavgeia will be able to replace PDF files with the afformentioned generated `.n3` files.

**Week 6 (8 July - 14 July)**

- Document blockchain (what does blockchain technology offers, installation, configuration, usage, test and disclaimer). You can find the link [here](https://github.com/eellak/gsoc17-diavgeia/blob/master/bitcoin/README.md).
- Generate JSDoc for the application. You can find the html generated documentation [here](https://github.com/eellak/gsoc17-diavgeia/tree/master/bitcoin/jsdoc).
- Further RDF Disk space optimizations (applied to 16 out of 32 samples). These optimizations include the use of `@prefix` and `@base` in order to shorten big URIs. Moreover, decisions are now bzip2-compressed.

**Week 5 (1 July - 7 July)**

- Merkle Tree Construction based on Diavgeia's decisions
- Implement methods to create Proof of Burn transactions.
- Commit transactions to BTC network and state to Diavgeia what should be published to the website (Master Public Key, the Merkle Tree, Bitcoin transaction id).
- Complete blockchain!

**Week 4 (24 June - 30 June)**

- Meetup for first evaluations, discussion about project progress and second month-project planning.
- We decided to give priority to the blockchain implementation during the second month coding period.
- I will use [bcoin](http://bcoin.io/) as a node-js bitcoin library. This week i have:
  1. Familiarize myself even more with bitcoin concepts and bcoin library.
  2. Implemented Diavgeia's wallet and added some helpful functions regarding the configuration of application. You can find the code [here](https://github.com/eellak/gsoc17-diavgeia/tree/master/bitcoin)

**Week 3 (17 June - 23 June)**

- Complete the rdf schema with the remaining decisions and create the relevant [samples](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples).
- I wrote an extensive rdf documentation that can be found [here](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/README.md). The documentation explains in depth the following topics:
  1. Current Diavgeia Issues
  2. The RDF Schema
  3. Decision Types and Samples
  4. URIs - ELI
  5. General Schema Classes
  6. Common Data Properties
  7. Decision specific Object and Data Properties
  8. The impact of RDF usage on Diavgeia infrastructure (Conclusions)

**Week 2 (9 June - 16 June)**

- Extend the rdf schema, in order to support 24 out of 33 decision types.
- Create [samples](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples) for each currently supported decision type. Every directory of the given link corresponds to a decision type. These directories may have 3 or 4 files inside. More specifically:
  1. There is a `.pdf` file, which is found in the current production website of Diavgeia and it can be downloaded from https://diavgeia.gov.gr/{IUN}
  2. A `metadata.json` file, which has the metadata that government institutions may fill during the procedure. Metadata is downloaded from https://diavgeia.gov.gr/luminapi/api/decisions/{IUN}
  3. Α `version_history.json` file, which corresponds to the history of a specific decision. This file is included only in the examples that alternate a decision (e.g. this [DonationGrant](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/DonationGrant/version_history.json))
  4. A `.n3` file, which is the decision expressed according to the rdf schema.
- By exploring the `.n3` files, it is fairly simple to understand the rdf schema. There are various examples, in which you can see the way:
  1. An economic transaction among government institution and individuals.
  2. Alternations of decision.
  3. Government institutions express their personal info (e.g. address, telephone, etc).
  4. Linking of a decision with another decision or with the [greek legislation ontology](http://legislation.di.uoa.gr/).
  5. A lot of decision specific details expressed in rdf (a more thorough documentation for each decision will be available in the following two weeks).

**Week 1 (1 June - 8 June)**

- Finalize project description.
- Make myself familiar with the different types of decisions and greek legislation.
- Implement a first version of the decisions rdf schema. More specifically:
1. The rdf schema includes all possible types of decisions that can be uploaded by the government institutions.
2. Decisions extend the [ELI](http://www.eli.fr/en/), as a way to unify them with other EU and Member States' legal systems. Thus, decisions have the following format:
`http://diavgeia.gov.gr/eli/decision/{IUN}/{version}`.
**IUN** :  Internet Uploading Number (greeks know it as ADA)
**version** : When a decision is altered (that is a *RepeatToCorrect* or a *MetadataCorrection*), a new version is generated but the IUN is not changed.
3. The problem of "taking into consideration the law X - we decide" is solved by linking decisions with the [greek legislation ontology](http://legislation.di.uoa.gr/) or by linking to other decisions of our ontology.
4. I created a sample [.n3 file](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/6%CE%96%CE%9E74653%CE%A0%CE%A9-7%CE%9AM.n3) which is equivalent to the decision [pdf file](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/6%CE%96%CE%9E74653%CE%A0%CE%A9-7%CE%9A%CE%9C.pdf). As expected, the size of the .n3 file has size 5.18KB, whereas the .pdf file's size is 419KB (about 81 times smaller in size). This seems to be really promising and provides a solution to the hard disk space needs of Diavgeia. Moreover, .n3 file includes metadata which is not included in the original pdf file.
5. I have enriched the rdf-schema with specialized metadata of BudgetApproval Decision and i aim to cover more decision types in the next weeks.