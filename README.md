gsoc17-diavgeia
===============

[View the project on Google Summer of Code website](https://summerofcode.withgoogle.com/projects/#6340447621349376).

You can see the detailed timeline [here](https://github.com/eellak/gsoc17-diavgeia/blob/master/gsoc_timeline.md).

Synopsis
--------

Diavgeia is the [open governance](https://en.wikipedia.org/wiki/Open_government) initiative which forces greek public administrative units to publish their acts and
decisions online.

This repository is part of [GSoC 2017: Diavgeia Project](https://summerofcode.withgoogle.com/projects/6340447621349376), and aims to enhance Diavgeias' transparency  in the following ways:

1. Through the use of the Bitcoin blockchain, we force government data
to remain immutable. While decisions and actions are currently signed, citizens or even the government institutions, who do not own an
<i>immediate</i> signed document (that is a short time after the document
was uploaded), have no guarantee that this document was not
altered some time after the upload. Thus, in order to limit the time span in which a document can be altered,
Diavgeia is forced to store a log in Bitcoin Blockchain, at predefined
time intervals.

2. The current production code of Diavgeia is proprietary. That is completely contradictory to the open government movement. Thus, we adopt the [old open source production code](https://github.com/eellak/gsoc17-diavgeia/tree/master/old_diavgeia) and we refactor it, using the Laravel Framework.

3. [Diavgeia](https://diavgeia.gov.gr/) currently hosts over 24.1 million acts and decisions, which have some metadata (that is information which the uploader must also fill, during the document-upload process). Diavgeia will provide an API (JSON-XML responses) which can be used to explore these documents.

Deliverables
------------

1. A standalone node.js app, which will put data of Diavgeia on the Bitcoin Network.
2. Refactored code of the old production code of Diavgeia, using the Laravel Framework.
3. Diavgeia API, using Laravel Formatter.

### GSoC Mentors

* Panagiotis Kranidiotis
* Theodoros Karounos
* Dionysis Zindros

### Student
* Themis Beris

### Organization :  [Open Technologies Alliance - GFOSS](https://summerofcode.withgoogle.com/organizations/4825634544025600/)