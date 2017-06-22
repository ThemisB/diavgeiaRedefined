RDF Schema
====

Why RDF ?
--------

1. By the time i write this documentation, Diavgeia hosts over 24.3 Million pdf documents. That said, it is obvious that there is a great demand for space storage, as well as the fact that documents are stored as pdf files, eliminates our ability to extract statistical information. Extraction of statistical information is based on unreliable techniques (i.e. OCR) and thus we can not explore documents in an efficient way (i.e. pose queries). In other words, we want to upgrade the currently stored [1 star-decisions to 5 stars-decisions](http://5stardata.info/en/) and save some disk space.

2. The majority of decisions, follow the model of `taking into consideration the law  X - we decide`. We want to make sure, that these laws exist and link each decision with the laws that has taken into consideration, or even with other decisions of Diavgeia. Ideally, the user would be able to just click a consideration of the decision and read the specific law of the greek legislation. That would greatly limit the time spend on navigating through the greek law.

The Schema
----------------

### Decision Types and Samples

Diavgeia currently hosts 34 different decision types and thus the implemented rdf schema should support all of them. Decisions share some common properties, but we should take care of the special properties each one may have. You can find some samples [here](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples) and explore the specific decision properties.

It follows a table which shows the match between the different types of decisions and the greek translation which are currently used in Diavgeia.


| RDF Decision Classes      |     Greek Translation     |
| --------------------------| :------------------------:|
| [AffiliatedInvestments](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/AffiliatedInvestments)     | ΠΡΑΞΗ ΥΠΑΓΩΓΗΣ ΕΠΕΝΔΥΣΕΩΝ |
| [Appointment](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Appointment)              | ΔΙΟΡΙΣΜΟΣ                 |
| [Award](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Award)                     | ΚΑΤΑΚΥΡΩΣΗ                |
| [BalanceAccount](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/BalanceAccount)            | ΙΣΟΛΟΓΙΣΜΟΣ - ΑΠΟΛΟΓΙΣΜΟΣ |
| [BudgetApproval](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/BudgetApproval)            | ΕΓΚΡΙΣΗ ΠΡΟΫΠΟΛΟΓΙΣΜΟΥ    |
| [Circular](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Circular)                  | ΕΓΚΥΚΛΙΟΣ                 |
| [CollegialBodyCommisionWorkingGroup](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/CollegialBodyCommisionWorkingGroup) | ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΣΥΛΛΟΓΙΚΟ ΟΡΓΑΝΟ - ΕΠΙΤΡΟΠΗ - ΟΜΑΔΑ ΕΡΓΑΣΙΑΣ - ΟΜΑΔΑ ΕΡΓΟΥ - ΜΕΛΗ ΣΥΛΛΟΓΙΚΟΥ ΟΡΓΑΝΟΥ                 |
| [CommisionWarrant](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/CommisionWarrant)          | ΕΠΙΤΡΟΠΙΚΟ ΕΝΤΑΛΜΑ        |
| [Contract](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Contract)                  | ΣΥΜΒΑΣΗ                   |
| [DeclarationSummary](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/DeclarationSummary)        | ΠΕΡΙΛΗΨΗ ΔΙΑΚΗΡΥΞΗΣ       |
| [DevelopmentLawContract](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/DevelopmentLawContract)    | ΣΥΜΒΑΣΗ - ΠΡΑΞΕΙΣ ΑΝΑΠΤΥΞΙΑΚΩΝ ΝΟΜΩΝ |
| [DisciplinaryAcquitance](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/DisciplinaryAcquitance)   | ΑΘΩΩΤΙΚΗ ΠΕΙΘΑΡΧΙΚΗ ΑΠΟΦΑΣΗ |
| [DonationGrant](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/DonationGrant)             | ΔΩΡΕΑ - ΕΠΙΧΟΡΗΓΗΣΗ       |
| [EvaluationReportOfLaw](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/EvaluationReportOfLaw)     | ΕΚΘΕΣΗ ΑΠΟΤΙΜΗΣΗΣ ΓΙΑ ΤΗΝ ΚΑΤΑΣΤΑΣΗ ΤΗΣ ΥΦΙΣΤΑΜΕΝΗΣ ΝΟΜΟΘΕΣΙΑΣ |
| [ExpenditureApproval](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/ExpenditureApproval)       | ΕΓΚΡΙΣΗ ΔΑΠΑΝΗΣ           |
| [GeneralSpecialSecretaryMonocraticBody](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/GeneralSpecialSecretaryMonocraticBody)       | ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΘΕΣΗ ΓΕΝΙΚΟΥ - ΕΙΔΙΚΟΥ ΓΡΑΜΜΑΤΕΑ - ΜΟΝΟΜΕΛΕΣ ΟΡΓΑΝΟ          |
| [InvestmentPlacing](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/InvestmentPlacing)         | ΠΡΑΞΗ ΥΠΑΓΩΓΗΣ ΕΠΕΝΔΥΣΕΩΝ |
| Law                       | ΝΟΜΟΣ                     |
| [LegislativeDecree](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/LegislativeDecree)         | ΠΡΑΞΗ ΝΟΜΟΘΕΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ (Σύνταγμα, άρθρο 44, παρ 1) |
| [Normative](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Normative)                 | ΚΑΝΟΝΙΣΤΙΚΗ ΠΡΑΞΗ         |
| [OccupationInvitation](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/OccupationInvitation)      | ΠΡΟΚΗΡΥΞΗ ΠΛΗΡΩΣΗΣ ΘΕΣΕΩΝ |
| [Opinion](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Opinion)                   | ΓΝΩΜΟΔΟΤΗΣΗ               |
| [OtherDecisions](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/OtherDecisions)            | ΛΟΙΠΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ|
| [OtherDevelopmentLaw](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/OtherDevelopmentLaw)       | ΑΛΛΗ ΠΡΑΞΗ ΑΝΑΠΤΥΞΙΑΚΟΥ ΝΟΜΟΥ|
| [OwnershipTransferOfAssets](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/OwnershipTransferOfAssets) | ΠΑΡΑΧΩΡΗΣΗ ΧΡΗΣΗΣ ΠΕΡΙΟΥΣΙΑΚΩΝ ΣΤΟΙΧΕΙΩΝ  |
| PaymentFinalisation     | ΟΡΙΣΤΙΚΟΠΟΙΗΣΗ ΠΛΗΡΩΜΗΣ   |
| [PublicPrototypeDocuments](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/PublicPrototypeDocuments)  | ΔΗΜΟΣΙΑ ΠΡΟΤΥΠΑ ΕΓΓΡΑΦΑ   |
| [Records](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Records)                   | ΠΡΑΚΤΙΚΑ (Νομικού Συμβουλίου του Κράτους)  |
| [ServiceChange](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/ServiceChange)             | ΥΠΗΡΕΣΙΑΚΗ ΜΕΤΑΒΟΛΗ       |
| [SpatialPlanningDecisions](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/SpatialPlanningDecisions)  | ΠΡΑΞΕΙΣ ΧΩΡΟΤΑΞΙΚΟΥ - ΠΟΛΕΟΔΟΜΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ |
| [StartProductionalFunctionOfInvestment](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/StartProductionalFunctionOfInvestment)  | ΑΠΟΦΑΣΗ ΕΝΑΡΞΗΣ ΠΑΡΑΓΩΓΙΚΗΣ ΛΕΙΤΟΥΡΓΙΑΣ ΕΠΕΝΔΥΣΗΣ |
| [SuccessfulAppointedRunnerUpList](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/SuccessfulAppointedRunnerUpList)        | ΠΙΝΑΚΕΣ ΕΠΙΤΥΧΟΝΤΩΝ, ΔΙΟΡΙΣΤΕΩΝ & ΕΠΙΛΑΧΟΝΤΩΝ     |
| [Undertaking](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Undertaking)               | ΑΝΑΛΗΨΗ ΥΠΟΧΡΕΩΣΗΣ|
| [WorkAssignmentSupplyServicesStudies](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/WorkAssignmentSupplyServicesStudies)| ΑΝΑΘΕΣΗ ΕΡΓΩΝ / ΠΡΟΜΗΘΕΙΩΝ / ΥΠΗΡΕΣΙΩΝ / ΜΕΛΕΤΩΝ      |

You can click on the RDF-Classes to see the samples, organized in directories. These directories may have 3 or 4 files inside. More specifically:
  1. There is a `.pdf` file, which is found in the current production website of Diavgeia and it can be downloaded from https://diavgeia.gov.gr/{IUN}
  2. A `metadata.json` file, which has the metadata that government institutions may fill during the procedure. Metadata is downloaded from https://diavgeia.gov.gr/luminapi/api/decisions/{IUN}
  3. Α `version_history.json` file, which corresponds to the history of a specific decision. This file is included only in the examples that alternate a decision (e.g. this [DonationGrant](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/DonationGrant/version_history.json))
  4. A `.n3` file, which is the decision expressed according to the rdf schema.

### URIs - ELI

  Recently, the European Council introduced the European Legislation Identifier ([ELI](http://www.eli.fr/en/)) as a new common framework that has to be adopted by the national legal publishing systems in order to unify and link national legislation with European legislation. Diavgeia's RDF Schema adopts the ELI URI Format, as follows:

  `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}`

  IUN (or ADA for Greeks) is the unique Internet Uploading Number (IUN) which a decision gets when it has been successfully uploaded to Diavgeia. However, IUN alone can not identify a decision, due to its possible alternations. There are two kinds of modifications that can occur in a decision:
  1. **Metadata Correction** : Government institutions correct only typos and wrong metadata of a decision, but the main concept of the decision remains unchanged. Then, new decisions hold the same IUN, but they are assigned a unique Version Identifier.
  2. **Decision Change** : Government institutions may completely change a decision (remove considerations, add more acts, etc) and when this is the case, Diavgeia gives a new IUN (and Version) to the document.

  Every different decision type is implemented as a subclass of `eli:LegalResource`. The `eli:repeals` object property links a decision with another decision when a correction happens. It is obvious that a `eli:repeals` which connects two entities that have the same IUN version, indicates a *Metadata Correction*, whereas in the case of decisions with different IUN, it indicates a *Decision Change*.

### Classes
  The ontology prefix of Diavgeia is `dvg` with value `http://diavgeia.gov.gr/ontology/`.

#### Consideration
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Consideration/{consideration_number}`

  *Description* : `Consideration` is the entity of a law/decision or any other source that has been considered, in order to decide an action.

  *Properties*
  - A `Decision(LegalResource)` uses the `dvg:has_considered` object property to connect the decision entity with its `Considerations`.
  - A `Consideration` uses the `dvg:considers` object property, in order to link to the [Greek Legislation Ontology](http://legislation.di.uoa.gr/), or to other decisions of Diavgeia. For instance the second consideration of [this legislative decree](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/LegislativeDecree/%CE%A9%CE%9F00%CE%98%CE%A9%CE%A0-%CE%A7%CE%94%CE%9D.n3), is expressed as `<http://diavgeia.gov.gr/eli/decision/ΩΟ00ΘΩΠ-ΧΔΝ/51c1bc5c-0eb8-4cb5-8204-3a48efef91bb/Consideration/2>`, it `dvg:considers` the *article 18 of law 3446/2006* and the last one can be found at  `<http://legislation.di.uoa.gr/eli/law/2006/3446/article/18>`.
  - `Considerations` also have `dvg:text` data type property which is the actual text that government institutions compose.

- - -

#### Decision
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Decision/{decision_number}`

  *Description* : `Decision` is the entity which describes everything that the government institution has decided.

  *Properties*
  - A `Decision(LegalResource)` uses the `dvg:has_decided` object property to connect the decision entity with its `Decisions`.
  - A `Decision` uses the `dvg:decision_relates` object property, in order to link to the [Greek Legislation Ontology](http://legislation.di.uoa.gr/), or to other decisions of Diavgeia. For instance the forth decision of [this legislative decree](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/LegislativeDecree/%CE%A9%CE%9F00%CE%98%CE%A9%CE%A0-%CE%A7%CE%94%CE%9D.n3), is expressed as `<http://diavgeia.gov.gr/eli/decision/ΩΟ00ΘΩΠ-ΧΔΝ/51c1bc5c-0eb8-4cb5-8204-3a48efef91bb/Decision/4>`, it  `dvg:decision_relates` the *second paragraph of article 18 of law 3446/2006* and the last one can be found at `<http://legislation.di.uoa.gr/eli/law/2006/3446/article/18/paragraph/2>`.
  - `Decisions` also have `dvg:has_text` data type property which is the actual text that government institutions compose (__Range__:**xsd:string**).

- - -

#### PreConsideration
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/PreConsideration`

  *Description* : `PreConsideration` is the entity which describes everything that the government institution wants to be included before the Consideration segment.

  *Properties*
  - A `Decision(LegalResource)` uses the `dvg:has_preconsideration` object property to connect the decision with its `PreConsideration`.
  - `PreConsideration` also has `dvg:has_text` data type property which is the actual text that government institutions compose (__Range__:**xsd:string**).

- - -

#### AfterDecision
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/AfterDecision`

  *Description* : `AfterDecision` is the entity which describes everything that the government institution wants to be included after the Decision segment.

  *Properties*
  - A `Decision(LegalResource)` uses the `dvg:has_afterdecision` object property to connect the decision with its `AfterDecision`.
  - `PreConsideration` also has `dvg:has_text` data type property which is the actual text that government institutions compose (__Range__:**xsd:string**).

- - -

#### Expense
  *Format*: `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Expense/{expense_number}`

  *Description* : `Expense` is a general entity which describes an expense between two individuals and is used in various decision types which include economic exchanges (e.g. `DonationGrant`, `WorkAssignmentSupplyServicesStudies`, etc).

  *Properties*
  - A `Decision(LegalResource)` uses the `dvg:has_expense` object property to connect the decision with its `Expense`.
  - An `Expense` has an optional `has_sponsored` object property which links to a `Sponsored` class and denotes the payment recipient.
  - An `Expense` has an optional `has_organization_sponsor` object property which links to a `OrganizationSponsor` class and denotes the payment sender.
  - `Expense` also has a number of datatype properties:
    1. **contract_start** : used only in `Contract` decisions and denote the start of the contract (__Range__:**xsd:date**).
    2. **contract_end** : similar to **contract_start** (__Range__:**xsd:date**).
    3. **expense_amount** : Amount of money spent on the `Expense` (__Range__:**xsd:string**).
    4. **expense_currency** : The currency of the *expense_amount* (__Range__:**xsd:string**).

- - -

#### ExpenseWithKae
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/ExpenseWithKae/{expense_with_kae_number}`

  *Description* : `ExpenseWithKae` is a general entity which describes an expense including kae between two individuals and is used in various decision types which include economic exchanges (e.g. `DonationGrant`, `WorkAssignmentSupplyServicesStudies`, etc). The only decisions which can make use of that class are the `CommisionWarrant` and `Undertaking`.

  *Properties*
  - A `CommisionWarrant` or an `Undertaking` uses the `dvg:has_expense_with_kae` object property to connect the decision with its `ExpenseWithKae`.
  - An `ExpenseWithKae` has the same object and datatype properties with `Expense` and in addition the following datatype properties:
    1. **kae** : The kae number of expense (__Range__:**xsd:string**).
    2. **kae_budget_remainder** : The budget remainder of expense (__Range__:**xsd:string**).
    3. **kae_credit_remainder** : The credit remainder of expense (__Range__:**xsd:string**).

- - -
#### OrganizationSponsor
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/OrganizationSponsor/{organization_sponsor_number}`

  *Description* : `OrganizationSponsor` is the organization that spends money on an `Expense` / `ExpenseWithKae`.

  *Properties* :
  - *afm* : The Tax Registration Number (TRN) (known as afm in Greece) (__Range__:**xsd:string**).
  - *afm_type* : The type of *afm* (__Range__:One of {*"Εθνικό"@el , "Εκτός Ε.Ε."@el, "Νομικό Πρόσωπο στην Ε.Ε."@el , "Φυσικό Πρόσωπο στην Ε.Ε."@el*}).
  - *name* : The name of the organization (__Range__:**xsd:string**).

- - -
#### Sponsored
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Sponsored/{sponsored_number}`

  *Description* : `Sponsored` is the individual / organization that receives the money of an `Expense` / `ExpenseWithKae`.

  *Properties* :
    The same properties as `OrganizationSponsor`.

- - -
#### Verification
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Verification/{verification_number}`

  *Description* : `Verification` represents an individual which authorizes the decision.

  For instance, [this undertaking](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/Undertaking/6%CE%A7%CE%99%CE%A5%CE%A9%CE%9A9-4%CE%91%CE%9F.n3) has been verified by "ΜΙΧΑΛΗΣ ΛΙΒΑΝΟΣ", which is the chief of the Financial Service of Monemvasia.

  *Properties* :
  - A `Decision(LegalResource)` uses the `dvg:has_verified` object property to declare a `Verification`.
  - A `Verification` is `dvg:verified_by` a `Signer`.
  - `Verification` uses the  `dvg:has_text` datatype property to declare the text of the verification (__Range__:**xsd:string**).

- - -

#### Signer
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Signer/{signer_number}`

  *Description* : `Signer` is a person which verifies a part of decision (as a part of `Verifier`) or signs the whole decision.

  *Properties* :
  - A `Decision(LegalResource)` uses the `dvg:has_signer` object property to declare a `Signer`.
  - A `Signer` has the following datatype properties:
    1. `signer_id` : A unique identifier that identifies a signer in Diavgeia (__Range__:**xsd:string**).
    2. `signer_job` : The job of the `Signer` (__Range__:**xsd:string**).
    3. `signer_name` : The name of the `Signer` (__Range__:**xsd:string**).

- - -
#### Present
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Verification/{verification_number}`

  *Description* : `Present` represents a person which was present when the decision was written (e.g. [this record](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/Records/%CE%A9%CE%A5%CE%9B%CE%A6%CE%9F%CE%A1%CE%A1%CE%95-%CE%97%CE%93%CE%98.n3)).

  *Properties* :
  - A `Decision(LegalResource)` uses the `dvg:has_present` object property to declare a `Present`.
  - A `Present` has the following datatype properties:
    1. `present_name` : The name of the person (__Range__:**xsd:string**).
    2. `present_title` : The role of the person (__Range__:**xsd:string**).

### Common Datatype Properties

These properties have as subject a `Decision(LegalResource)` entity and thus we can say they are common for all the different decision types.

1. **decision_call** : The text that is displayed between the considerations and decisions (__Range__: **xsd:string**).
2. **government_institution_name** : The name of the government institution. This can be used as a standalone property to declare smaller government institutions or it can be combined with *government_institution_general_administration* and *government_institution_department* to declare government institutions which have subdivisions (e.g. Ministries) (__Range__:**xsd:string**).
3. **government_institution_general_administration** : (__Range__:**xsd:string**).
4. **government_institution_department** : (__Range__:**xsd:string**).
5. **government_institution_email**: (__Range__:**xsd:string**).
6. **government_institution_address**: (__Range__:**xsd:string**).
7. **government_institution_phone**: (__Range__:**xsd:string**).
8. **government_institution_fax**: (__Range__:**xsd:string**).
9. **government_institution_postalcode**: (__Range__:**xsd:string**).
10. **government_institution_website**: (__Range__:**xsd:string**).
11. **government_institution_information** : The name of the person who is responsible for resolving issues related to this decision. (__Range__:**xsd:string**).
12. **has_private_data** : Whether a decision contains sensitive data (__Range__:**xsd:boolean**).
13. **iun** : The Internet Uploading Number (ADA) (__Range__:**xsd:string**).
14. **version** : The version of the decision (__Range__:**xsd:string**).
15. **protocol_number** : Every procedure that takes place in any greek public service takes a protocol number. (__Range__:**xsd:string**).
16. **recipient_for_action** : Government institutions or individuals that should take action after read this decision (__Range__:**xsd:string**).
17. **recipient_for_share** : Share this decision with other government institutions or individuals (__Range__:**xsd:string**).
18. **recipient** : Send this decision to other government_institutions or individuals (__Range__:**xsd:string**).
19. **internal_distribution** : Refers to bigger government institutions which want to internally distribute the decision (__Range__:**xsd:string**).
20. **thematic_category** : Every decision should have at least one thematic category. (__Range__:**{"AgricultureForestryFishery" , "BusinessCompetition" , "CommunicationEducation" , "EconomicActivity" , "EconomicTradeExchanges" , "Employment" , "Energy" , "Environment" , "EuropeanUnion" , "Fiscals" , "Geography" , "Industry" , "InternationalOrganizations" , "InternationalRelations" , "Laws" , "ManufactureTechnologyResearch" , "NutritionAgriculturalProducts" , "PoliticalLife" , "PublicAdministration" , "Science" , "SocialIssues" , "Transport"}**)
21. **unit_id** : Every decision should have at least one unit_id code, which is related to the units involved in signing the decision (__Range__:**xsd:string**).
22. **organization_id** : Every decision should have exactly one organization_id which is in fact the government institution code (__Range__:**xsd:string**).
23. **submission_timestamp** : Time of the upload, expressed in Unix Timestamp (Milliseconds from epoch) (__Range__:**xsd:string**).