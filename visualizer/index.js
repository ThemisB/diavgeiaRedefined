const N3 = require('n3')
const parser = N3.Parser()
const N3Util = N3.Util
const fs = require('fs')
const express = require('express')
const app = express()
const path = require('path')

const DECISIONS_DIRECTORY = path.resolve('../rdf/samples')
app.use(express.static('public'))
app.set('views', './views')
app.set('view engine', 'pug')

var generalProperties = {}

app.get('/vizualize', function (req, res) {
  if (req.query.decisionFolder && req.query.decisionName) {
    var decisionFolder = path.normalize(req.query.decisionFolder).replace(/^(\.\.[\/\\])+/, '')
    var decisionName = path.normalize(req.query.decisionName).replace(/^(\.\.[\/\\])+/, '')
    var rdfStream = undefined
    rdfStream = fs.createReadStream(DECISIONS_DIRECTORY + '/' + decisionFolder + '/' + decisionName + '.n3')
    rdfStream.on('error', () => {
      console.error('N3 file ' + DECISIONS_DIRECTORY + '/' + decisionFolder + '/' + decisionName + '.n3' + ' does not exist')
      res.status(404).send('Not found');
    })

    var array = {}
    rdfStream.on('open', () => {
      parser.parse(rdfStream, (err, triple, prefixes) => {
        if (triple) {
          // console.log(triple.predicate)
          var predicateAndObject = [triple.predicate, triple.object]
          if (!array[triple.subject]) {
            array[triple.subject] = [predicateAndObject]
          } else {
            array[triple.subject].push(predicateAndObject)
          }
        }
      })
    })
    rdfStream.on('end', function() {
      var generalProperties = formatGeneralProperties(array)
      res.render('index', generalProperties)
    })
  } else {
    res.status(404).send('Not found');
  }
})

app.listen(3333, function () {
  console.log('Visualizer listening on port 3333!')
})

function findPredicateValue(subject, ontology, predicateSearch, predicatePair) {

  const RDFS = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'
  const ELI = 'http://data.europa.eu/eli/ontology#'
  const ONT = 'http://diavgeia.gov.gr/ontology/'
  var predicate = predicatePair[0]
  var value = predicatePair[1]

  var fullPredicate = undefined
  switch (ontology) {
    case 'ont':
      fullPredicate = ONT
    break
    case 'eli':
      fullPredicate = ELI
    break
    case 'rdfs':
      fullPredicate = RDFS
    break
  }
  fullPredicate += predicateSearch
  if(fullPredicate == predicate) {
    generalProperties[predicateSearch] = N3Util.getLiteralValue(value)
  }
}

function formatGeneralProperties(array) {
  for (var subject in array) {
    array[subject].forEach(predicatePair => {
      findPredicateValue(subject, 'eli', 'title', predicatePair)
      findPredicateValue(subject, 'eli', 'date_publication', predicatePair)
      findPredicateValue(subject, 'ont', 'iun', predicatePair)
      findPredicateValue(subject, 'ont', 'version', predicatePair)
      findPredicateValue(subject, 'ont', 'protocol_number', predicatePair)
      // Government Institution Details
      findPredicateValue(subject, 'ont', 'government_institution_name', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_general_administration', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_department', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_address', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_postalcode', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_phone', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_fax', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_email', predicatePair)
      findPredicateValue(subject, 'ont', 'government_institution_information', predicatePair)
    })
  }
  return generalProperties
}

