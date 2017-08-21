gsoc17-diavgeia
===============

[View the project on Google Summer of Code website](https://summerofcode.withgoogle.com/projects/#6340447621349376).

You can see the detailed timeline [here](https://github.com/eellak/gsoc17-diavgeia/blob/master/gsoc_timeline.md).

Please pay a visit to the [project page](https://eellak.github.io/gsoc17-diavgeia/).

Synopsis
--------
Beginning October 1st, 2010, all government institutions are obliged to upload their acts and decisions on the Internet with special attention to issues of national security and sensitive personal data. Each document is digitally signed and assigned a unique Internet Uploading Number (IUN), certifying that the decision has been uploaded at the “Transparency Portal”. Following the latest legislative initiative (Law 4210/2013) of the Ministry of Administrative Reform and e-Governance, **administrative acts and decisions are not valid unless published online**.

The main objectives of the Program concern:

1. Safeguarding transparency of government actions.

2. Eliminating corruption by exposing it more easily when it takes place.

3. Observing legality and good administration.

4. Reinforcing citizens’ constitutional rights, such as the participation in the Information Society

5. Enhancing and modernizing existing publication systems of administrative acts and decisions.

6. Making of all administrative acts available in formats that are easy to access, navigate and comprehend, regardless of the citizen’s knowledge level of the inner processes of the administration.

Taking the view that the Greek crisis, including its economic manifestations, is also due to the non transparent relationship between the citizens and the state, the transparency program introduced **unprecedented levels of transparency** within all levels of Greek public administration and established a new “social contract” between the citizen and the state. This initiative has a **silent but profound impact on the way officials handle their executive power**. The direct accountability brought upon the administration by the radical transparency that the Transparency program introduces, leaves considerably less room for corruption, and exposes it much more easily when it takes place since any citizen and every interested party enjoy the widest possible access to questionable acts. Such a collective scrutiny can be extremely effective, since it allows citizens directly involved or concerned with an issue to scrutinize it in depth, rather than leaving public scrutiny to the media, whose choice of issues necessarily may be restricted and oriented towards sensational topics. [[source](https://diavgeia.gov.gr/en)]


Diavgeia on GSoC
----------------
During the Google Summer of Code, i aim to enhance even more the transparency of Diavgeia, reduce the disk-space needs of document storage and promote the notion of [Open Government](https://en.wikipedia.org/wiki/Open_government). First i describe the problems of the current implementation of Diavgeia and then i present solutions to these problems.


Problems
--------

### Disk-space needs - No representation of Decisions as Open Linked Data

1. By the time i write this documentation, Diavgeia hosts over 24.3 Million documents. That said, it is obvious that there is a great demand for space storage, as well as the fact that documents are stored as pdf files, eliminates our ability to extract statistical information. Extraction of statistical information is based on unreliable techniques (i.e. OCR) and thus we can not explore documents (that is pose queries) in an efficient way.

2. The majority of decisions, follow the model of ‘taking into consideration the law X - we decide’. We want to make sure, that these laws exist and link each decision with the laws that has taken into consideration. In order to achieve this, we should first express decisions as open linked data and then find a way to link them with a  current open data dataset of greek legislation.

### Diavgeia does not ensure that decisions remain immutable over time

As we said before, Diavgeia digitally signs the decisions and beginning 1st July 2017, all government institutions will be forced to digitally sign these decisions too. However, Diavgeia does not guarantee that decisions will remain immutable over time. Government may modify or completely remove a decision from Diavgeia and thus citizens and government institutions that have not downloaded this specific decision on their personal computers, have no way to prove its existence.

Solutions
--------

### Disk Space Decrease - Representation of Decisions as Open Linked Data

1. During the GSoC, i will implement a general decision “template”, which the current production code of Diavgeia can adopt, in order to express its decisions as RDF data. Thus, Diavgeia will store RDF triples (**Master Document**) which will be fully equivalent to the PDF representation (no pdf files will be stored on Diavgeia). We should state here, that during GSoC i will develop the RDF Schema and provide a sample RDF dataset including a set of decisions, that will indicate that our approach is feasible. During GSoC, i will not develop an automation tool that converts the already uploaded pdf decisions to the RDF dataset. Having expressed the decisions as RDF, citizens and government institutions will be able to pose SPARQL queries, explore Diavgeia in an efficient way and the storage requirements need will be significantly decreased.

2. In order to solve the problem of linking the decision with the greek laws which it considers, we will use [ΝΟΜΟΘΕΣΙ@](http://legislation.di.uoa.gr/). This is a project which has expressed  the greek legislation as RDF Data. Thus, government institutions can link their decisions to the greek legislation or to prior decisions of Diavgeia. Moreover, government institutions will be provided with the option to not link the decision with other open data, as there are decisions which have not yet been expressed as rdf.

This is a decision sample appointment, as uploaded on Diavgeia, which summarizes  1. , 2.:

![Equivalence of RDF-PDF](http://image.ibb.co/mPffU5/appointment_sample.png

You can find the full rdf decision (with its metadata) [here](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/Appointment/ΨΟΗΩ46ΨΖΣ4-Ι56.n3).

Almost all red letters denote the predicates of our ontology that can be used to correspond to the original PDF file. This figure also demonstrates the use of the rdf legislation dataset via the *considers* predicate, denoted with green letters.  Of course this is a simplified version of the rdf schema, as decisions can become a lot more complicated.

### Immutability of decisions based on the use of the Bitcoin Blockchain

In order to limit the time span in which a document can be altered (modified or removed), Diavgeia will be forced to store a log in the Bitcoin Network, at predefined time intervals. It is obvious that smaller time intervals imply more transparency, as the government keeps more logs. That said, let’s assume Diavgeia is forced to keep a log each day. The following happen:

1. Diavgeia gathers all RDF-documents (**Master**) that have not been included in the previous log. These documents are organized into a Merkle Tree.

2. Diavgeia gets the root of the Merkle tree and signs it. Diavgeia commits the signed root of the Merkle Tree as [proof](https://en.bitcoin.it/wiki/Proof_of_burn) of burn to the Bitcoin Network.

3. After the confirmation of the transaction, Diavgeia should also publish the following to its website:
  - The merkle tree (that is the order of the documents). This is crucial, because citizens should be able to verify that the root of the merkle tree is valid.
  - The Bitcoin Address / transaction.

Then, citizens and government institutions can verify their acts and be sure that their decisions will remain immutable over time.

An overview of this procedure can be visualized as following:

![Commit to Bitcoin Blockchain procedure](https://image.ibb.co/fH0Nca/Drawing_2.jpg)


GSoC Deliverables
------------

1. The RDF Schema of decisions [[link](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/decisions.owl)].
2. A set of existing decisions, expressed in Notation3 [[link](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples)].
3. A standalone nodejs application, which commits the RDF-data to the Bitcoin Blockchain Network [[link](https://github.com/eellak/gsoc17-diavgeia/tree/master/bitcoin)].
4. Visualizer: Application that visualizes .n3 decisions in the web browser [[link](https://github.com/eellak/gsoc17-diavgeia/tree/master/visualizer)].
5. RDF Store and Sparql Endpoint: Use of Jena Apache as RDF Store and Fuseki Sparql Server in order to provide citizens a User Interface to pose SPARQL queries [[link](https://github.com/eellak/gsoc17-diavgeia/tree/master/sparql_endpoint)].

Future Work
------------

There is still a lot work that may be done, in order to promote even more the transparency of Diavgeia! Please, feel free to pick an open issue and make a pull request to our repository. Some open issues are:

1. Bitcoin-Website Validator: Create a tool which ensures that all proof of burn blockchain transactions of Diavgeia are consistent with the merkle trees uploaded on Diavgeia's website.
2. Bitcoin-SPARQL Validator: Find an efficient way to prove that all decisions that have been commited to blockchain are also available from the SPARQL endpoint.
3. Improve Visualizer: Visualizer does not visualize rdf properties for each different decision type.
4. Study scalability of SPARQL endpoint: As it was stated, Diavgeia hosts millions of decisions. A benchmark of the scalability of the Apache Jena and Fuseki is crucial.

Production Ready tools
----------------------
1. Bitcoin Application.
2. RDF Schema (with the exception of the two decision types that have not been included (Law and PaymentFinalisation))
3. N3-Composer.
4. Visualizer (but it needs further improvement to visualize the specific decision properties, as stated in Future Work).
5. SPARQL Endpoint.

### Student
* Themis Beris

### GSoC Mentors

* Panagiotis Kranidiotis
* Theodoros Karounos
* Dionysis Zindros

### Organization :  [Open Technologies Alliance - GFOSS](https://summerofcode.withgoogle.com/organizations/4825634544025600/)