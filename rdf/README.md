Adoption of RDF in Diavgeia
====

Sections
-------
1. [Diavgeia Issues](#diavgeia-issues)
2. [The RDF Schema](#the-rdf-schema)
3. [Decision Types and Samples](#decision-types-and-samples)
4. [URIs - ELI](#uris---eli)
5. [General Schema Classes](#general-schema-classes)
    1. [Consideration](#consideration)
    2. [Decision](#decision)
    3. [PreConsideration](#preconsideration)
    4. [AfterDecision](#afterdecision)
    5. [Expense](#expense)
    6. [ExpenseWithKae](#expensewithkae)
    7. [OrganizationSponsor](#organizationsponsor)
    8. [Sponsored](#sponsored)
    9. [Verification](#verification)
    10. [Signer](#signer)
    11. [Present](#present)
6. [Common Data Properties](#common-data-properties)
7. [Decision specific Object and Data Properties](#decision-specific-object-and-data-properties)
    1. [Appointment](#appointment)
    2. [Award](#award)
    3. [BalanceAccount](#balanceaccount)
    4. [BudgetApproval](#budgetapproval)
    5. [Circular](#circular)
    6. [CollegialBodyCommisionWorkingGroup](#collegialbodycommisionworkinggroup)
    7. [CommisionWarrant](#commisionwarrant)
    8. [Contract](#contract)
    9. [DeclarationSummary](#declarationsummary)
    10. [DevelopmentLawContract](#developmentlawcontract)
    11. [DisciplinaryAcquitance](#disciplinaryacquitance)
    12. [DonationGrant](#donationgrant)
    13. [EvaluationReportOfLaw](#evaluationreportoflaw)
    14. [ExpenditureApproval](#expenditureapproval)
    15. [GeneralSpecialSecretaryMonocraticBody](#generalspecialsecretarymonocraticbody)
    16. [InvestmentPlacing](#investmentplacing)
    17. [LegislativeDecree](#legislativedecree)
    18. [Normative](#normative)
    19. [OccupationInvitation](#occupationinvitation)
    20. [Opinion](#opinion)
    21. [OtherDecisions](#otherdecisions)
    22. [OtherDevelopmentLaw](#otherdevelopmentlaw)
    23. [OwnershipTransferOfAssets](#ownershiptransferofassets)
    24. [PublicPrototypeDocuments](#publicprototypedocuments)
    25. [Records](#records)
    26. [ServiceChange](#servicechange)
    27. [SpatialPlanningDecisions](#spatialplanningdecisions)
    28. [StartProductionalFunctionOfInvestment](#startproductionalfunctionofinvestment)
    29. [SuccessfulAppointedRunnerUpList](#successfilappointedrunneruplist)
    30. [Undertaking](#undertaking)
    31. [WorkAssignmentSupplyServicesStudies](#workassignmentsupplyservicesstudies)
8. [Conclusions](#conclusions)

Diavgeia Issues
--------

1. By the time i write this documentation, Diavgeia hosts over 24.3 Million pdf documents. That said, it is obvious that there is a great demand for space storage, as well as the fact that documents are stored as pdf files, eliminates our ability to extract statistical information. Extraction of statistical information is based on unreliable techniques (i.e. OCR) and thus we can not explore documents in an efficient way (i.e. pose queries). In other words, we want to upgrade the currently stored [1 star-decisions to 5 stars-decisions](http://5stardata.info/en/) and save some disk space.

2. The majority of decisions, follow the model of `taking into consideration the law  X - we decide`. We want to make sure, that these laws exist and link each decision with the laws that has taken into consideration, or even with other decisions of Diavgeia. Ideally, the user would be able to just click a consideration of the decision and read the specific law of the greek legislation. That would greatly limit the time spend on navigating through the greek law.

## The RDF Schema

We will solve the aforementioned issues, by expressing decisions using a RDF Schema. A "side-effect" of this work is to promote the [Open Linked Data movement](https://en.wikipedia.org/wiki/Linked_data#Linked_open_data) and more generally the [open governance](https://en.wikipedia.org/wiki/Open_government).

### Decision Types and Samples

Diavgeia currently hosts 34 different decision types and thus the implemented rdf schema should support all of them. Decisions share some common properties, but we should take care of the special properties each one may have. You can find some samples [here](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples) and explore the specific decision properties.

It follows a table which shows the match between the different types of decisions and the greek translation which are currently used in Diavgeia.


| RDF Decision Classes      |     Greek Translation     |
| --------------------------| :------------------------:|
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

## URIs - ELI

  Recently, the European Council introduced the European Legislation Identifier ([ELI](http://www.eli.fr/en/)) as a new common framework that has to be adopted by the national legal publishing systems in order to unify and link national legislation with European legislation. Diavgeia's RDF Schema adopts the ELI URI Format, as follows:

  `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}`

  IUN (or ADA for Greeks) is the unique Internet Uploading Number (IUN) which a decision gets when it has been successfully uploaded to Diavgeia. However, IUN alone can not identify a decision, due to its possible alternations. There are two kinds of modifications that can occur in a decision:
  1. **Metadata Correction** : Government institutions correct only typos and wrong metadata of a decision, but the main concept of the decision remains unchanged. Then, new decisions hold the same IUN, but they are assigned a unique Version Identifier.
  2. **Decision Change** : Government institutions may completely change a decision (remove considerations, add more acts, etc) and when this is the case, Diavgeia gives a new IUN (and Version) to the document.

  Every different decision type is implemented as a subclass of `eli:LegalResource`. The `eli:repeals` object property links a decision with another decision when a correction happens. It is obvious that a `eli:repeals` which connects two entities that have the same IUN version, indicates a *Metadata Correction*, whereas in the case of decisions with different IUN, it indicates a *Decision Change*.

### General Schema Classes
  The ontology prefix of Diavgeia is `dvg` with value `http://diavgeia.gov.gr/ontology/`. In the following sections we will refer to `Decision(LegalResource)` as the Class which contains all the different decision types of Diavgeia and is in fact the eli:LegalResource class.

#### Consideration
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Consideration/{consideration_number}`

  *Description* : [Consideration](consideration) is the entity of a law/decision or any other source that has been considered, in order to decide an action.

  *Properties*
  - A `Decision(LegalResource)` uses the **dvg:has_considered** object property to connect the decision entity with its [Considerations](#consideration) |`Range → dvg:LegalResource`|.
  - A [Consideration](consideration) uses the **dvg:considers** object property, in order to link to the [Greek Legislation Ontology](http://legislation.di.uoa.gr/), or to other decisions of Diavgeia. For instance the second consideration of [this legislative decree](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/LegislativeDecree/%CE%A9%CE%9F00%CE%98%CE%A9%CE%A0-%CE%A7%CE%94%CE%9D.n3), is expressed as `<http://diavgeia.gov.gr/eli/decision/ΩΟ00ΘΩΠ-ΧΔΝ/51c1bc5c-0eb8-4cb5-8204-3a48efef91bb/Consideration/2>`, it **dvg:considers** the *article 18 of law 3446/2006* and the last one can be found at  `<http://legislation.di.uoa.gr/eli/law/2006/3446/article/18>`. |`Range → dvg:LegalResource or ontology:LegalResource`|
  - [Considerations](#consideration) also have **dvg:text** data property which is the actual text that government institutions write. |`Range → xsd:string`|

- - -

#### Decision
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Decision/{decision_number}`

  *Description* : [Decision](#decision) is the entity which describes everything that the government institution has decided.

  *Properties*
  - A `Decision(LegalResource)` uses the **dvg:has_decided** object property to connect the decision entity with its [Decisions](#decision).
  - A [Decision](#decision) uses the **dvg:decision_relates** object property, in order to link to the [Greek Legislation Ontology](http://legislation.di.uoa.gr/), or to other decisions of Diavgeia. For instance the forth decision of [this legislative decree](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/LegislativeDecree/%CE%A9%CE%9F00%CE%98%CE%A9%CE%A0-%CE%A7%CE%94%CE%9D.n3), is expressed as `<http://diavgeia.gov.gr/eli/decision/ΩΟ00ΘΩΠ-ΧΔΝ/51c1bc5c-0eb8-4cb5-8204-3a48efef91bb/Decision/4>`, it  **dvg:decision_relates** the *second paragraph of article 18 of law 3446/2006* and the last one can be found at `<http://legislation.di.uoa.gr/eli/law/2006/3446/article/18/paragraph/2>`. |`Range → dvg:LegalResource or ontology:LegalResource`|
  - [Decisions](#decision) also have **dvg:has_text** data property which is the actual text that government institutions write. |`Range → xsd:string`|

- - -

#### PreConsideration
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/PreConsideration`

  *Description* : `PreConsideration` is the entity which describes everything that the government institution wants to be included before the Consideration segment.

  *Properties*
  - A `Decision(LegalResource)` uses the **dvg:has_preconsideration** object property to connect the decision with its [PreConsideration](#preconsideration).|`Range → dvg:PreConsideration`|
  - `PreConsideration` also has **dvg:has_text** data property which is the actual text that government institutions write. |`Range → xsd:string`|

- - -

#### AfterDecision
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/AfterDecision`

  *Description* : `AfterDecision` is the entity which describes everything that the government institution wants to be included after the Decision segment.

  *Properties*
  - A `Decision(LegalResource)` uses the **dvg:has_afterdecision** object property to connect the decision with its [AfterDecision](#afterdecision). |`Range → xsd:AfterDecision`|
  - [PreConsideration](#preconsideration) also has **dvg:has_text** data type property which is the actual text that government institutions write. |`Range → xsd:string`|

- - -

#### Expense
  *Format*: `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Expense/{expense_number}`

  *Description* : `Expense` is a general entity which describes an expense between two individuals and is used in various decision types which include economic exchanges.

  *Properties*
  - An [Award](#award), [Contract](#contract), [DeclarationSummary](#declarationsummary), [DonationGrant](#donationgrant), [ExpenditureApproval](#expenditureapproval), [GeneralSpecialSecretaryMonocraticBody](#generalspecialsecretarymonocraticbody), [Undertaking](#undertaking),  [WorkAssignmentSupplyServicesStudies](#workassignmentsupplyservicesstudies), [OwnershipTransferOfAssets](#ownershiptransferofassets) may use the **dvg:has_expense** object property to connect the decision entity with its [Expense](#expense). |`Range → dvg:Expense`|
  - An [Expense](#expense) has an optional **dvg:has_sponsored** object property which links to a [Sponsored](#sponsored) class and denotes the payment recipient. |`Range → dvg:Sponsored`|
  - An [Expense](#expense) has an optional **dvg:has_organization_sponsor** object property which links to a [OrganizationSponsor](#organizationsponsor) class and denotes the payment sender. |`Range → dvg:OrganizationSponsor`|
  - [Expense](#expense) also has a number of data properties:
    1. **dvg:expense_amount** : Amount of money spent on the [Expense](#expense). |`Range → xsd:string`|
    2. **dvg:expense_currency** : The currency of the *expense_amount*. |`Range → xsd:string`|

    *Note* : The use of **dvg:has_organization_sponsor**, **dvg:has_sponsored** and **dvg:expense_amount/currency** is closely related to the decision type. For example, an [ExpenditureApproval](#expenditureapproval) must have all of these properties, whereas an [OwnershipTransferOfAssets](#ownershiptransferofassets) has only the **dvg:has_organization_sponsor** and **dvg:has_sponsored** object properties, because no money are exchanged.

- - -

#### ExpenseWithKae
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/ExpenseWithKae/{expense_with_kae_number}`

  *Description* : [ExpenseWithKae](#expensewithkae) is a general entity which describes an expense including kae between two individuals and is used in various decision types which include economic exchanges.

  *Properties*
  - A [CommisionWarrant](#commisionwarrant) or an [Undertaking](#undertaking) uses the **dvg:has_expense_with_kae** object property to connect the decision with its [ExpenseWithKae](#expensewithkae). |`Range → dvg:ExpenseWithKae`|
  - An [ExpenseWithKae](#expensewithkae) has the same object and data properties with [Expense](#expense) and in addition the following data properties:
    1. **kae** : The kae number of expense. |`Range → xsd:string`|
    2. **kae_budget_remainder** : The budget remainder of expense. |`Range → xsd:string`|
    3. **kae_credit_remainder** : The credit remainder of expense. |`Range → xsd:string`|

- - -
#### OrganizationSponsor
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/OrganizationSponsor/{organization_sponsor_number}`

  *Description* : [OrganizationSponsor](#organizationsponsor) is the organization that spends money on an [Expense](#expense) / [ExpenseWithKae](#expensewithkae).

  *Properties* :
  - **afm** : The Tax Registration Number (TRN) (known as afm in Greece). |`Range → xsd:string`|
  - **afm_type** : The type of *afm*. |`Range → OneOf{*"Εθνικό"@el , "Εκτός Ε.Ε."@el, "Νομικό Πρόσωπο στην Ε.Ε."@el , "Φυσικό Πρόσωπο στην Ε.Ε."@el*}`|
  - **name** : The name of the organization. |`Range → xsd:string`|

- - -
#### Sponsored
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Sponsored/{sponsored_number}`

  *Description* : [Sponsored](#sponsored) is the individual / organization that receives the money of an [Expense](#expense) / [ExpenseWithKae](#expensewithkae).

  *Properties* :
    The same properties as [OrganizationSponsor](#organizationsponsor).

- - -
#### Verification
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Verification/{verification_number}`

  *Description* : [Verification](#verification) represents an individual which authorizes the decision.

  For instance, [this undertaking](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/Undertaking/6%CE%A7%CE%99%CE%A5%CE%A9%CE%9A9-4%CE%91%CE%9F.n3) has been verified by "ΜΙΧΑΛΗΣ ΛΙΒΑΝΟΣ", which is the chief of the Financial Service of Monemvasia.

  *Properties* :
  - A `Decision(LegalResource)` uses the **dvg:has_verified** object property to declare a [Verification](#verification). |`Range → dvg:Verification`|
  - A [Verification](#verification) is **dvg:verified_by** a [Signer](#signer). |`Range → dvg:Signer`|
  - [Verification](#verification) uses the  **dvg:has_text** data property to declare the text of the verification. |`Range → xsd:string`|

- - -

#### Signer
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Signer/{signer_number}`

  *Description* : [Signer](#signer) is a person which verifies a part of decision (as a part of [Verification](#verification)) or signs the whole decision.

  *Properties* :
  - A `Decision(LegalResource)` uses the **dvg:has_signer** object property to declare a [Signer](#signer).
  - A [Signer](#signer) has the following data properties:
    1. **signer_id** : A unique identifier that identifies a signer in Diavgeia. |`Range → xsd:string`|
    2. **signer_job** : The job of the [Signer](#signer). |`Range → xsd:string`|
    3. **signer_name** : The name of the [Signer](#signer). |`Range → xsd:string`|

- - -
#### Present
  *Format* : `http://diavgeia.gov.gr/eli/decision/{IUN}/{Version}/Verification/{verification_number}`

  *Description* : [Present](#present) represents a person which was present when the decision was written (e.g. [this record](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/Records/%CE%A9%CE%A5%CE%9B%CE%A6%CE%9F%CE%A1%CE%A1%CE%95-%CE%97%CE%93%CE%98.n3)).

  *Properties* :
  - A `Decision(LegalResource)` uses the **dvg:has_present** object property to declare a [Present](#present).
  - A [Present](#present) has the following data properties:
    1. **present_name** : The name of the person. |`Range → xsd:string`|
    2. **present_title** : The role of the person. |`Range → xsd:string`|

## Common Data Properties

These properties have as subject a `Decision(LegalResource)` entity and thus we can say they are common for all the different decision types.

1. **decision_call** : The text that is displayed between the considerations and decisions. |`Range → xsd:string`|
2. **government_institution_name** : The name of the government institution. This can be used as a standalone property to declare smaller government institutions or it can be combined with *government_institution_general_administration* and *government_institution_department* to declare government institutions which have subdivisions (e.g. Ministries). |`Range → xsd:string`|
3. **government_institution_general_administration** : |`Range → xsd:string`|.
4. **government_institution_department** : |`Range → xsd:string`|.
5. **government_institution_email**: |`Range → xsd:string`|.
6. **government_institution_address**: |`Range → xsd:string`|.
7. **government_institution_phone**: |`Range → xsd:string`|.
8. **government_institution_fax**: |`Range → xsd:string`|.
9. **government_institution_postalcode**: |`Range → xsd:string`|.
10. **government_institution_website**: |`Range → xsd:string`|.
11. **government_institution_information** : The name of the person who is responsible for resolving issues related to this decision. |`Range → xsd:string`|
12. **has_private_data** : Whether a decision contains sensitive data. |`Range → xsd:string`|
13. **iun** : The Internet Uploading Number (ADA). |`Range → xsd:string`|
14. **version** : The version of the decision. |`Range → xsd:string`|
15. **protocol_number** : Every procedure that takes place in any greek public service takes a protocol number. |`Range → xsd:string`|
16. **recipient_for_action** : Government institutions or individuals that should take action after read this decision. |`Range → xsd:string`|
17. **recipient_for_share** : Share this decision with other government institutions or individuals. |`Range → xsd:string`|
18. **recipient** : Send this decision to other government_institutions or individuals. |`Range → xsd:string`|
19. **internal_distribution** : Refers to bigger government institutions which want to internally distribute the decision. |`Range → xsd:string`|
20. **thematic_category** : Every decision should have at least one thematic category. |`Range → {OneOf{"AgricultureForestryFishery" , "BusinessCompetition" , "CommunicationEducation" , "EconomicActivity" , "EconomicTradeExchanges" , "Employment" , "Energy" , "Environment" , "EuropeanUnion" , "Fiscals" , "Geography" , "Industry" , "InternationalOrganizations" , "InternationalRelations" , "Laws" , "ManufactureTechnologyResearch" , "NutritionAgriculturalProducts" , "PoliticalLife" , "PublicAdministration" , "Science" , "SocialIssues" , "Transport"}}`|
21. **unit_id** : Every decision should have at least one unit_id code, which is related to the units involved in signing the decision. |`Range → xsd:string`|
22. **organization_id** : Every decision should have exactly one organization_id which is in fact the government institution code. |`Range → xsd:string`|
23. **submission_timestamp** : Time of the upload, expressed in Unix Timestamp (Milliseconds from epoch). |`Range → xsd:string`|

## Decision Specific Object and Data Properties

As it was previously mentioned, Diavgeia hosts 34 different decision types. This means that the rdf schema should include decision-specific object and data properties which are presented here.

### Appointment

**Greek Translation** : ΔΙΟΡΙΣΜΟΣ

**Data Properties**
  - **appointment_employer_org** : The organization id of the government institution that is responsible for the appointment. |`Range → xsd:string`|
  - **fek_issue** : Relates the Appointment with the fek issue. |`Range → OneOf {"Α"@el , "Α.Α.Π."@el , "Α.Ε.Δ."@el , "Α.Π.Σ."@el , "Α.Σ.Ε.Π."@el , "Β"@el , "Γ"@el , "Δ"@el , "Δ.Δ.Σ."@el , "Ε.Β.Ι"@el , "Ν.Π.Δ.Δ."@el , "Ο.Π.Κ."@el , "ΠΑΡΑΡΤΗΜΑ"@el}`|
  - **fek_number** : |`Range → xsd:string`|
  - **fek_year** : |`Range → xsd:string`|
  - **number_employees** : Number of employees of the appointment. |`Range → xsd:string`|
- - -
### Award

**Greek Translation** : ΚΑΤΑΚΥΡΩΣΗ

**Object Properties**
  - **has_related_declaration_summary** : An optional object property which relates an [Award](#award) with a [DeclarationSummary](#declarationsummary). |`Range → dvg:DeclarationSummary`|

- - -
### BalanceAccount

**Greek Translation** : ΙΣΟΛΟΓΙΣΜΟΣ - ΑΠΟΛΟΓΙΣΜΟΣ

**Data Properties**
  - **balance_account_type** : |`Range → OneOf{"Απολογισμός"@el , "Ισολογισμός"@el , "Ισολογισμός και Απολογισμός"@el}`|
  - **balance_account_time_period** : |`Range → OneOf{"Έτος"@el , "Εξάμηνο"@el , "Τρίμηνο"@el}`|
  - **financial_year** : |`Range → xsd:string`|
  - **has_related_institution** : |`Range → xsd:string`|
  - **is_balance_account_approval_for_org** : True if a third government institutuion should approve this balance account. |`Range → xsd:boolean`|

- - -
### BudgetApproval

**Greek Translation** : ΕΓΚΡΙΣΗ ΠΡΟΫΠΟΛΟΓΙΣΜΟΥ

**Data Properties**
  - **budget_type** : |`Range → OneOf{"Κρατικός"@el, "Φορέα"@el}`|
  - **budget_category** : |`Range → OneOf{"Ίδια Έσοδα"@el, "Πρόγραμμα Δημοσίων Επενδύσεων"@el, "Τακτικός Προϋπολογισμός"@el}`|
  - **is_budget_approval_for_org** : Similar to [BalanceAccount](#balanceaccount).
  - **financial_year** : Similar to [BalanceAccount](#balanceaccount).
  - **has_related_institution** : Similar to [BalanceAccount](#balanceaccount).

- - -
### Circular

**Greek Translation** : ΕΓΚΥΚΛΙΟΣ

**Data Properties**
  - **circular_number** : |`Range → xsd:string`|

- - -

### CollegialBodyCommisionWorkingGroup

**Greek Translation** : ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΣΥΛΛΟΓΙΚΟ ΟΡΓΑΝΟ - ΕΠΙΤΡΟΠΗ - ΟΜΑΔΑ ΕΡΓΑΣΙΑΣ - ΟΜΑΔΑ ΕΡΓΟΥ - ΜΕΛΗ ΣΥΛΛΟΓΙΚΟΥ ΟΡΓΑΝΟΥ

**Data Properties**
  - **collegial_body_decision_type** : (__Range__:**OneOf{"Αποδοχή Παραίτησης Μέλους"@el , "Καθορισμός Αμοιβής - Αποζημίωσης"@el , "Παύση - Αντικατάσταση μέλους"@el , "Συγκρότηση"@el}**).
  - **collegial_body_party_type** : (__Range__:**OneOf{"Όργανο Γνωμοδοτικής Αρμοδιότητας"@el , "Όργανο άλλης αρμοδιότητας"@el , "Επιτροπή"@el , "Ομάδα έργου"@el , "Ομάδα εργασίας"@el , "Συλλογικό όργανο Διοίκησης"@el}**).
  - **fek/fek_issue/fek_year** : Similar to [Appointment](#appointment).

- - -
### CommisionWarrant

**Greek Translation** : ΕΠΙΤΡΟΠΙΚΟ ΕΝΤΑΛΜΑ

**Data Properties**
  - **primary_officer** : |`Range → xsd:string`|
  - **secondary_officer** : |`Range → xsd:string`|
  - **budget_category** : Similar to [BudgetApproval](#budgetapproval).
  - **financial_year** : Similar to [BalanceAccount](#balanceaccount).

- - -

### Contract

**Greek Translation** : ΣΥΜΒΑΣΗ

**Object Properties**
  - **has_expense** : the [expense](#expense) of the [Contract](#contract). |`Range → dvg:Expense`|

**Data Properties**
  - **contract_decision_type** : |`Range → OneOf{"Σύμβαση Έργου"@el , "Σύμβαση Ιδιωτικού Δικαίου Αορίστου Χρόνου"@el , "Σύμβαση Ιδιωτικού Δικαίου Ορισμένου Χρόνου"@el}`|
  - **number_employees** : Similar to [Appointment](#appointment)
  - **contract_start** : Start of the Contract |`Range → xsd:date`|
  - **contract_end** : End of the Contract |`Range → xsd:date`|
  - **contract_is_co_funded** : True if the contact is co-funded |`Range → xsd:boolean`|

- - -

### DeclarationSummary

**Greek Translation** : ΠΕΡΙΛΗΨΗ ΔΙΑΚΗΡΥΞΗΣ

**Object Properties**
  - **has_related_undertaking** : relates a [DeclarationSummary](#declarationsummary) with an [Undertaking](#undertaking). |`Range → dvg:Undertaking`|
  - **has_expense** : the [expense](#expense) of the [DeclarationSummary](#declarationsummary). |`Range → dvg:Expense`|

**Data Properties**
  - **contract_type** : |`Range → OneOf{"Έργα"@el , "Μελέτες"@el , "Προμήθειες"@el , "Υπηρεσίες"@el`|
  - **selection_criterion** : |`Range → OneOf{"Συμφερότερη από οικονομικής άποψης"@el , "Χαμηλότερη Τιμή"@el}`|
  - **tendering_procedure** : |`Range → OneOf{"Ανοικτός"@el , "Κλειστός"@el , "Πρόχειρος"@el}`|
  - **government_institution_budget_code** : |`Range → OneOf{"Πρόγραμμα Δημοσίων Επενδύσεων"@el , "Συγχρηματοδοτούμενο Έργο"@el , "Τακτικός Προϋπολογισμός"@el}`|

- - -

### DevelopmentLawContract

**Greek Translation** : ΣΥΜΒΑΣΗ - ΠΡΑΞΕΙΣ ΑΝΑΠΤΥΞΙΑΚΩΝ ΝΟΜΩΝ

This type of decision does not have any specific object or data properties.

- - -

### DisciplinaryAcquitance

**Greek Translation** : ΑΘΩΩΤΙΚΗ ΠΕΙΘΑΡΧΙΚΗ ΑΠΟΦΑΣΗ

This type of decision does not have any specific object or data properties.

- - -

### DonationGrant

**Greek Translation** : ΔΩΡΕΑ - ΕΠΙΧΟΡΗΓΗΣΗ

**Object Properties**
  - **has_expense** : the [expense](#expense) of the [DonationGrant](#donationgrant). |`Range → dvg:Expense`|

**Data Properties**
  - **kae** : The kae number of [DonationGrant](#donationgrant). This is not related to [ExpenseWithKae](#expensewithkae). |`Range → xsd:string`|
  - **donation_type** : |`Range → OneOf{"Αποδοχή Δωρεάς"@el , "Δωρεά(προς τρίτους)@el" , "Επιχορήγηση"@el , "Σύμβαση Πολιτιστικής Χορηγίας"@el}`|

- - -

### EvaluationReportOfLaw

**Greek Translation** : ΕΚΘΕΣΗ ΑΠΟΤΙΜΗΣΗΣ ΓΙΑ ΤΗΝ ΚΑΤΑΣΤΑΣΗ ΤΗΣ ΥΦΙΣΤΑΜΕΝΗΣ ΝΟΜΟΘΕΣΙΑΣ

This type of decision does not have any specific object or data properties.

- - -

### ExpenditureApproval

**Greek Translation** : ΕΓΚΡΙΣΗ ΔΑΠΑΝΗΣ

**Object Properties**
  - **has_related_undertaking** :relates a [ExpenditureApproval](#expenditureapproval) with an [Undertaking](#undertaking). |`Range → dvg:Undertaking`|
  - **has_expense** : the [expense](#expense) of the [DeclarationSummary](#declarationsummary). |`Range → dvg:Expense`|

**Data Properties**
  - **kae** :  The kae number of [ExpenditureApproval](#expenditureapproval). This is not related to [ExpenseWithKae](#expensewithkae). |`Range → xsd:string`|

- - -

### GeneralSpecialSecretaryMonocraticBody

**Greek Translation** : ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΘΕΣΗ ΓΕΝΙΚΟΥ - ΕΙΔΙΚΟΥ ΓΡΑΜΜΑΤΕΑ - ΜΟΝΟΜΕΛΕΣ ΟΡΓΑΝΟ

**Object Properties**
  - **has_expense** : the [expense](#expense) of the [GeneralSpecialSecretaryMonocraticBody](#generalspecialsecretarymonocraticbody). |`Range → dvg:Expense`|

**Data Properties**
  - **position** : |`Range → OneOf{"Γενικός Γραμματέας Αποκεντρωμένης Διοίκησης"@el , "Γενικός Γραμματέας Υπουργείου"@el , "Ειδικός Γραμματέας Υπουργείου"@el , "Μονομελές Όργανο"@el}`|
  - **position_org** : The government institution which the  position applies to. |`Range → xsd:string`|
  - **position_decision_type** : |`Range → OneOf{"Αθωωτική Πειθαρχική Απόφαση"@el , "Αντικατάσταση"@el , "Αποδοχή Παραίτησης"@el , "Διορισμός"@el , "Καθορισμός Αμοιβής - Αποζημίωσης"@el , "Παύση"@el}`|

- - -

### InvestmentPlacing

**Greek Translation** : ΠΡΑΞΗ ΥΠΑΓΩΓΗΣ ΕΠΕΝΔΥΣΕΩΝ

This type of decision does not have any specific object or data properties.

- - -

### LegislativeDecree

**Greek Translation** : ΠΡΑΞΗ ΝΟΜΟΘΕΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ (Σύνταγμα, άρθρο 44, παρ 1)

**Data Properties**
  - **legislative_decree_number** : |`Range → xsd:string`|
  - **fek/fek_issue/fek_year** : Similar to [Appointment](#appointment).

- - -

### Normative

**Greek Translation** : ΚΑΝΟΝΙΣΤΙΚΗ ΠΡΑΞΗ

**Data Properties**
  - **normative_number** : |`Range → xsd:string`|
  - **normative_type** : |`Range → OneOf{"Κοινή Υπουργική Απόφαση"@el , "Πράξη Ανεξάρτητης Αρχής"@el , "Πράξη Γενικού / Ειδικού Γραμματέα Υπουργείου"@el , "Πράξη Γενικού Γραμματέα Αποκεντρωμένης Διοίκησης"@el , "Πράξη Οργάνου Διοίκησης Ν.Π.Δ.Δ."@el , "Πράξη Οργάνου Διοίκησης ΟΤΑ Α' και Β' Βαθμού (και εποπτευόμενων φορέων τους)"@el , "Πράξη Οργάνου Διοίκησης Φορέων Ευρύτερου Δημοσίου Τομέα"@el , "Πράξη Προέδρου της Δημοκρατίας"@el , "Πράξη Πρωθυπουργού"@el , "Πράξη Υπουργικού Συμβουλίου"@el , "Προεδρικό Διάταγμα"@el , "Υπουργική Απόφαση"@el, "Πράξη Ρυθμιστικής Αρχής"@el, "Πράξη Συλλογικού Κυβερνητικού Οργάνου"@el, "Διϋπουργική Απόφαση(ΔΕΕΑ)"@el, "Πράξη Υπουργού, Αναπληρωτή Υπουργού, Υφυπουργού"@el}`|
  - **fek/fek_issue/fek_year** : Similar to [Appointment](#appointment).

- - -

### OccupationInvitation

**Greek Translation** : ΠΡΟΚΗΡΥΞΗ ΠΛΗΡΩΣΗΣ ΘΕΣΕΩΝ

**Object Properties**
  - **has_related_undertaking** : relates a [OccupationInvitation](#declarationsummary) with an [Undertaking](#undertaking). |`Range → dvg:Undertaking`|

**Data Properties**
  - **vacancy_opening_type** : |`Range → OneOf{"Προκήρυξη Εξετάσεων Άμισθων Υποθηκοφυλάκων"@el , "Προκήρυξη Εξετάσεων Συμβολαιγράφων"@el , "Προκήρυξη Εξετάσεων Υποψήφιων Δικηγόρων"@el , "Προκήρυξη Πλήρωσης Θέσεων Διδακτικού Ερευνητικού Προσωπικού (ΔΕΠ) Πανεπιστημιακού τομέα"@el , "Προκήρυξη Πλήρωσης Θέσεων Εκπαιδευτικού Προσωπικού (ΕΠ) Τεχνολογικού τομέα της Ανώτατης Εκπαίδευσης"@el , "Προκήρυξη Πλήρωσης Θέσεων με διαγωνισμό ή επιλογή στις οποίες περιλαμβάνονται και οι προκηρύξεις για επιλογή και πλήρωση θέσεων διευθυντικών στελεχών των ΝΠΔΔ, φορέων του ευρύτερου δημόσιου τομέα, και των επιχειρήσεων και φορέων του ΟΤΑ 'Α & Β΄βαθμού"@el}`|

- - -

### Opinion

**Greek Translation** : ΓΝΩΜΟΔΟΤΗΣΗ

*Note* : Opinion's format differentiates from other decisions, but it is quite specific. You can consider [this opinion sample](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples/Opinion).

**Data Properties**
  - **opinion_question_number** : Opinions have a specific question number which is used for reference. |`Range → xsd:string`|
  - **opinion_question_summary** : The summary of the question |`Range → xsd:string`|
  - **opinion_history** : The historical background of the question |`Range → xsd:string`|
  - **opinion_analysis** : Based on the [Considerations](#consideration) which were quoted, *opinion_analysis* proceeds to in depth analysis and gives answers to the question. |`Range → xsd:string`|
  - **opinion_conclusion** : It sums up *opinion_analysis* and simply states the answers of the question. |`Range → xsd:string`|
  - **opinion_government_institution_type** : |`Range → {"Ανεξάρτητη Αρχή"@el, "ΝΣΚ"@el}`|

- - -

### OtherDecisions

**Greek Translation** : ΛΟΙΠΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ

**Data Properties**
  - **publish_via** : |`Range → OneOf{"Ημερήσιο Τύπο"@el, "Ιστοσελίδα του φορέα"@el, "Κατάστημα της υπηρεσίας"@el, "ΦΕΚ"@el}`|
  - **normative_type** : Similar to [Normative](#normative).
  - **fek/fek_issue/fek_year** : Similar to [Appointment](#appointment).

- - -

### OtherDevelopmentLaw

**Greek Translation** : ΑΛΛΗ ΠΡΑΞΗ ΑΝΑΠΤΥΞΙΑΚΟΥ ΝΟΜΟΥ

**Data Properties**
  - **publish_via** : |`Range → OneOf{"Ημερήσιο Τύπο"@el, "Ιστοσελίδα του φορέα"@el, "Κατάστημα της υπηρεσίας"@el, "ΦΕΚ"@el}`|
  - **normative_type** : Similar to [Normative](#normative).
  - **fek/fek_issue/fek_year** : Similar to [Appointment](#appointment).

- - -

### OwnershipTransferOfAssets

**Greek Translation** : ΠΑΡΑΧΩΡΗΣΗ ΧΡΗΣΗΣ ΠΕΡΙΟΥΣΙΑΚΩΝ ΣΤΟΙΧΕΙΩΝ

**Object Properties**
  - **has_expense** : expressing the transfer as  [expense](#expense) of the [OwnershipTransferOfAssets](#ownershiptransferofassets). |`Range → dvg:Expense`|

**Data Properties**
  - **asset_name** : The name of the asset that will be transferred.

- - -

### PublicPrototypeDocuments

**Greek Translation** : ΔΗΜΟΣΙΑ ΠΡΟΤΥΠΑ ΕΓΓΡΑΦΑ

This type of decision does not have any specific object or data properties.

- - -

### Records

**Greek Translation** : ΠΡΑΚΤΙΚΑ (Νομικού Συμβουλίου του Κράτους)

**Data Properties**
  - **record_number** : |`Range → xsd:string`|
  - **record_subject** : |`Range → xsd:string`|

- - -

### ServiceChange

**Greek Translation** : ΥΠΗΡΕΣΙΑΚΗ ΜΕΤΑΒΟΛΗ

**Data Properties**
  - **service_change_decision_type** : |`Range → OneOf{"Αποδοχή Παραίτησης"@el, "Διαθεσιμότητα"@el, "Λύση Υπαλληλικής Σχέσης"@el, "Μετάταξη"@el, "Υποβιβασμός"@el}`|
  - **fek/fek_issue/fek_year** : Similar to [Appointment](#appointment).

- - -

### SpatialPlanningDecisions

**Greek Translation** : ΠΡΑΞΕΙΣ ΧΩΡΟΤΑΞΙΚΟΥ - ΠΟΛΕΟΔΟΜΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ

**Data Properties**
  - **municipality** : The name of the municipality which this decision has effect on. |`Range → xsd:string`|
  - **spatial_planning_decision_type** : |`Range → OneOf{"Έγκριση - τροποποίηση χωροταξικών και ρυμοτομικών σχεδίων"@el , "Αλλαγή χρήσης γης κοινόχρηστου κτήματος"@el , "Καθορισμός - τροποποίηση όρων δόμησης"@el , "Καθορισμός αιγιαλού, παραλίας, λιμνών, ποταμών, ρεμάτων και χειμάρων"@el , "Καθορισμός αρχαιολογικών χώρων"@el , "Καθορισμός βιομηχανικών ζωνών"@el , "Καθορισμός γης παραχωρούμενου δημόσιου κτήματος"@el , "Καθορισμός εθνικών δρυμών, δασών και δασικών εκτάσεων"@el , "Καθορισμός λατομικών ζωνών"@el , "Παραχώρηση δημόσιων και δημοτικών κτημάτων"@el , "Προσδιορισμός - τροποποίηση ορίων οικισμού και έγκριση μεταφοράς αυτόυ"@el , "Σύνταξη - έγκριση ζωνών οικιστικού ελέγχου (ΖΟΕ)"@el , "Σύνταξη - έγκριση πολεοδομικών μελετών και γενικού πολεοδομικού σχεδίου"@el , "Χαρακτηρισμός εκτάσεων ως αναδασωτέων"@el , "Χαρακτηρισμός κτιρίων ως διατηρητέων και αποχαρακτηρισμός αυτών"@el , "Χορήγηση - αναστολή - τροποποίηση οικοδομικών αδειών"@el , "Χωροθέτηση"@el}`|

- - -

### StartProductionalFunctionOfInvestment

**Greek Translation** : ΑΠΟΦΑΣΗ ΕΝΑΡΞΗΣ ΠΑΡΑΓΩΓΙΚΗΣ ΛΕΙΤΟΥΡΓΙΑΣ ΕΠΕΝΔΥΣΗΣ

This type of decision does not have any specific object or data properties.

- - -

### SuccessfulAppointedRunnerUpList

**Greek Translation** : ΠΙΝΑΚΕΣ ΕΠΙΤΥΧΟΝΤΩΝ, ΔΙΟΡΙΣΤΕΩΝ & ΕΠΙΛΑΧΟΝΤΩΝ

**Object Properties**
  - **has_related_occupation_invitation** : An optional object property which relates a [SuccessfulAppointedRunnerUpList](#successfilappointedrunneruplist) with an [OccupationInvitation](#occupationinvitation). |`Range → dvg:OccupationInvitation`|

- - -

### Undertaking

**Greek Translation** : ΑΝΑΛΗΨΗ ΥΠΟΧΡΕΩΣΗΣ

**Object Properties**
  - **has_expense_with_kae** : expressing the expense as  [ExpenseWithKae](#expensewithkae) |`Range → dvg:ExpenseWithKae`|
  - **has_expense** : expressing the expense as [Expense](#expense). |`Range → dvg:Expense`|

**Data Properties**
  - **partialead** : True if this is a partial undertaking. |`Range → xsd:boolean`|
  - **entry_number** : |`Range → xsd:string`|
  - **recalled_expense** : True if this undertaking has a recall role. |`Range → xsd:boolean`|
  - **budget_category** : Similar to [BudgetApproval](#budgetapproval).
  - **financial_year** : Similar to [BalanceAccount](#balanceaccount).

- - -

### WorkAssignmentSupplyServicesStudies

**Greek Translation** : ΑΝΑΘΕΣΗ ΕΡΓΩΝ / ΠΡΟΜΗΘΕΙΩΝ / ΥΠΗΡΕΣΙΩΝ / ΜΕΛΕΤΩΝ

**Object Properties**
  - **has_expense** : expressing the expense as [Expense](#expense). |`Range → dvg:Expense`|

**Data Properties**
  - **work_assignment_etc_category** : |`Range → OneOf{"Έργα"@el , "Μελέτες"@el , "Προμήθειες"@el , "Υπηρεσίες"@el}`|

Conclusions
-----------

The proposed rdf schema solves all the aforementioned problems. As far as the disk space is concerned, `.pdf` [samples](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples) take up 7.1MB (without the extra metadata of `metadata.json` files), while the compressed `.n3` samples (that is `.n3.bz2` files) take up 72ΚΒ and include the information of `metadata.json` files.

Moreover, we have linked the `decisions.owl` to the [Greek Legislation Ontology](http://legislation.di.uoa.gr/) and by adopting ELI, we unified and linked our ontology with European legislation.