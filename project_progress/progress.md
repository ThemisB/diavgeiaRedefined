### GSoC 2017:  Project Progress Report 

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