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
      const generalPropertiesFormatter = new GeneralPropertiesFormatter()
      generalPropertiesFormatter.formatGeneralProperties(array)
      res.render('index', generalPropertiesFormatter.properties)
    })
  } else {
    res.status(404).send('Not found');
  }
})

app.listen(3333, function () {
  console.log('Visualizer listening on port 3333!')
})

class GeneralPropertiesFormatter {

  constructor() {
    this.generalProperties = {}
  }

  get properties() {
    return this.generalProperties
  }

  formatGeneralProperties(array) {
    for (var subject in array) {
      array[subject].forEach(predicatePair => {
        this._findPredicateValue(subject, 'eli', 'title', predicatePair)
        this._findPredicateValue(subject, 'eli', 'date_publication', predicatePair)
        this._findPredicateValue(subject, 'ont', 'iun', predicatePair)
        this._findPredicateValue(subject, 'ont', 'version', predicatePair)
        this._findPredicateValue(subject, 'ont', 'protocol_number', predicatePair)
        this._findPredicateValue(subject, 'ont', 'thematic_category', predicatePair)
        // findPredicateValue(subject, 'rdfs', 'type', predicatePair)
        // Government Institution Details
        this._findPredicateValue(subject, 'ont', 'government_institution_name', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_general_administration', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_department', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_address', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_postalcode', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_phone', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_fax', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_email', predicatePair)
        this._findPredicateValue(subject, 'ont', 'government_institution_information', predicatePair)
      })
    }
  }

  _findPredicateValue(subject, ontology, predicateSearch, predicatePair) {
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
    if(fullPredicate === predicate) {
      if (predicateSearch === 'date_publication') {
        var dateLiteral = N3Util.getLiteralValue(value)
        dateLiteral = dateLiteral.split('-')
        dateLiteral = dateLiteral[2] + '/' + dateLiteral[1] + '/' +dateLiteral[0]
        this.generalProperties[predicateSearch] = dateLiteral
      } else if (predicateSearch === 'thematic_category') {
        const thematicCategoriesTranslation = {
          Employment: 'ΑΠΑΣΧΟΛΗΣΗ ΚΑΙ ΕΡΓΑΣΙΑ',
          Industry: 'BIOMHXANIA',
          AgricultureForestryFishery: 'ΓΕΩΡΓΙΑ, ΔΑΣΟΚΟΜΙΑ ΚΑΙ ΑΛΙΕΙΑ',
          Geography: 'ΓΕΩΓΡΑΦΙΑ',
          Fiscals: 'ΔΗΜΟΣΙΟΝΟΜΙΚΑ',
          NutritionAgriculturalProducts: 'ΔΙΑΤΡΟΦΗ ΚΑΙ ΓΕΩΡΓΙΚΑ ΠΡΟΪΟΝΤΑ',
          InternationalOrganizations: 'ΔΙΕΘΝΕΙΣ ΟΡΓΑΝΙΣΜΟΙ',
          InternationalRelations: 'ΔΙΕΘΝΕΙΣ ΣΧΕΣΕΙΣ',
          Laws: 'ΔΙΚΑΙΟ',
          Energy: 'ΕΝΕΡΓΕΙΑ',
          CommunicationEducation: 'ΕΠΙΚΟΙΝΩΝΙΑ ΚΑΙ ΜΟΡΦΩΣΗ',
          Science: 'ΕΠΙΣΤΗΜΕΣ',
          BusinessCompetition: 'ΕΠΙΧΕΙΡΗΣΕΙΣ ΚΑΙ ΑΝΤΑΓΩΝΙΣΜΟΣ',
          EuropeanUnion: 'ΕΥΡΩΠΑΪΚΗ ΕΝΩΣΗ',
          SocialIssues: 'ΚΟΙΝΩΝΙΚΑ ΘΕΜΑΤΑ',
          Transport: 'ΜΕΤΑΦΟΡΕΣ',
          EconomicTradeExchanges: 'ΟΙΚΟΝΟΜΙΚΕΣ ΚΑΙ ΕΜΠΟΡΙΚΕΣ ΣΥΝΑΛΛΑΓΕΣ',
          EconomicActivity: 'ΟΙΚΟΝΟΜΙΚΗ ΖΩΗ',
          ManufactureTechnologyResearch: 'ΠΑΡΑΓΩΓΗ, ΤΕΧΝΟΛΟΓΙΑ ΚΑΙ ΕΡΕΥΝΑ',
          Environment: 'ΠΕΡΙΒΑΛΛΟΝ',
          PoliticalLife: 'ΠΟΛΙΤΙΚΗ ΖΩΗ',
          PublicAdministration: 'ΔΗΜΟΣΙΑ ΔΙΟΙΚΗΣΗ'
        }
        if (!this.generalProperties[predicateSearch]) {
          this.generalProperties[predicateSearch] = [thematicCategoriesTranslation[N3Util.getLiteralValue(value)]]
        }
        else
          this.generalProperties[predicateSearch].push(thematicCategoriesTranslation[N3Util.getLiteralValue(value)])
      } else {
        this.generalProperties[predicateSearch] = N3Util.getLiteralValue(value)
      }
    }
  }
}
