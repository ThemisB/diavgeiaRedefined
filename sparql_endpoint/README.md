SPARQL Endpoint
===============

By default the service runs on port **3030**.


By employing the Fuseki Server, we enable the formulation of complex queries over decisions of Diavgeia. Semantic queries promote the inclusion of all citizens or other interested parties in the scrutiny of the public sector, leaving considerably less room for governance corruption. We present some interesting queries one can pose. The `gag` prefix refers to the [Kallikratis dataset](linkedopendata.gr/dataset/greek-administrative-geography).

```sql
SELECT ?decision WHERE {
  ?decision diavgeia:has_expense ?expense;
            eli:date_publication ?date.
  ?expense diavgeia:expense_amount ?amount.
  FILTER (?date >= "2017-01-01"^^xsd:date &&
  ?date <= "2017-12-31"^^xsd:date)
} ORDER BY DESC(?amount) LIMIT 5
```

This first query empowers citizens or other interested parties to find the decisions with the 5 highest government expenses of 2017. The queries which consider government expenses are of crucial importance, since they enable the tracking of economic transactions and promote the transparency in the financial sector. This query can be limited to certain thematic categories with the use of the `diavgeia:thematic_category` property. Thus, interested parties (e.g. a researcher) can search for the highest expenses based on their interest (e.g. the thematic category of `Science`).

```sql
SELECT DISTINCT ?decision WHERE {
  ?signatory foaf:name "I.Stournaras".
  ?nomothesiaLegislation eli:passed_by ?signatory.
  ?reference eli:cites ?nomothesiaLegislation.
  {?decision diavgeia:has_concluded ?reference} UNION
  {?decision diavgeia:has_considered ?reference}
}
```

The second query enables interested parties to search decisions which refer to greek legislative documents that have been signed by a particular politician. By employing [Nomothesia](legislation.di.uoa.gr), we are able to obtain the legislative documents of a specific signatory. Those types of queries are also important, because interested parties can see if a politician signs legislative documents which are not widely used by the majority of the public authorities. Legislative documents which are only used by an extremely small subset of the public authorities might be an indication of corruption between a politician and a public authority.

```sql
SELECT ?organizationId ?sponsoredVatNumber
(COUNT(*) as ?timesPreferred) SUM(?expenseAmount) WHERE {
  ?decision a diavgeia:Award;
            diavgeia:has_expense ?awardExpense;
            diavgeia:organization_id ?organizationId.

  ?awardExpense diavgeia:expense_amount ?expenseAmount;
                diavgeia:expense_currency "EUR";
                diavgeia:has_sponsored ?sponsored.

  ?sponsored diavgeia:afm ?sponsoredVatNumber.
  FILTER (?expenseAmount > 100000)
} GROUP BY ?organizationId ?sponsoredVatNumber
  ORDER BY DESC(?timesPreferred)
```

The above query of retrieves the public administrations which fund certain individuals for expensive public works, it calculates the sum of the related expenses and orders the results based on the times that the public administration funded the certain individual. This is another query which tries to track the corruption in the financial sector. The Greek public authorities often create a call for contests regarding public works. If a public authority assigns multiple works to a certain individual, that may also be an indication for a non-meritocratic selection process.

```sql
SELECT ?decision WHERE {
  ?municipality gag:has_official_name "MUNICIPALITY OF CHANIA".

  ?decision diavgeia:has_municipality ?municipality;
            diavgeia:thematic_category "Energy";
            eli:date_publication ?date;
            diavgeia:spatial_planning_decision_type
              "ConcessionOfPublicLandProperty".

  FILTER(?date >= "2018-01-01"^^xsd:date)
}
```

The forth query presents the exploratory capabilities that Linked Data offer. Consider an individual which lives in the municipality of Chania, located in the island of Crete. The individual is interested in the renewable energy, trying to find land which will enable him to build his own solar panels. By posing the aforementioned query, the individual is able to retrieve the decisions which are published after 2018 and concede public land property for energy related issues. The interlinking of Diavgeia with the Kallikratis dataset enables interested parties to pose such queries with significant geographical importance.

```sql
SELECT (COUNT(DISTINCT ?fekIun) as ?numberFekDecisions)
       (COUNT(DISTINCT ?iun) as ?numberTotalDecisions)
       ( xsd:float(?numberFekDecisions)/
       xsd:float(?numberTotalDecisions) AS
       ?averageOfPrintedDecision )
       WHERE {
         ?fekDecisions diavgeia:fek_issue ?fekIssue;
                       diavgeia:iun ?fekIun.
         ?decisions diavgeia:iun ?iun.
       }
```

The Greek government can also pose SPARQL queries similar to the last one to measure a wide range of statistical information or to supervise the public authorities. The last query empowers the Greek government to calculate the average amount of the decisions which are uploaded on Diavgeia and also printed by the National Printing House of Greece. Another query that may be also posed by the government is the measurement of the work which has been carried out by the different Greek public authorities to load balance the work among them.