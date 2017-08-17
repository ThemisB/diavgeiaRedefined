const N3 = require('n3')
const parser = N3.Parser()
const N3Util = N3.Util
const fs = require('fs')
const express = require('express')
const app = express()
const path = require('path')

const DECISIONS_DIRECTORY = path.resolve('../rdf/samples')

const RDFS = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'
const ELI = 'http://data.europa.eu/eli/ontology#'
const ONT = 'http://diavgeia.gov.gr/ontology/'
const DVG_ELI = 'http://diavgeia.gov.gr/eli/decision/'

app.use(express.static('public'))
app.set('views', './views')
app.set('view engine', 'pug')

app.get('/vizualize', function (req, res) {
  if (req.query.decisionFolder && req.query.iun) {
    var decisionFolder = path.normalize(req.query.decisionFolder).replace(/^(\.\.[\/\\])+/, '')
    var iun = path.normalize(req.query.iun).replace(/^(\.\.[\/\\])+/, '')
    var rdfStream = undefined
    rdfStream = fs.createReadStream(DECISIONS_DIRECTORY + '/' + decisionFolder + '/' + iun + '.n3')
    rdfStream.on('error', () => {
      console.error('N3 file ' + DECISIONS_DIRECTORY + '/' + decisionFolder + '/' + iun + '.n3' + ' does not exist')
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
    var decisionIunVersion = {}
    for (var subject in array) {
      array[subject].forEach(predicatePair => {
        this._findPredicateValue(subject, 'eli', 'title', predicatePair)
        this._findPredicateValue(subject, 'eli', 'date_publication', predicatePair)
        let iun = this._findPredicateValue(subject, 'ont', 'iun', predicatePair)
        if (iun)
          decisionIunVersion['iun'] = iun
        let version = this._findPredicateValue(subject, 'ont', 'version', predicatePair)
        if (version)
          decisionIunVersion['version'] = version
        this._findPredicateValue(subject, 'ont', 'protocol_number', predicatePair)
        this._findPredicateValue(subject, 'ont', 'thematic_category', predicatePair)
        this._findPredicateValue(subject, 'ont', 'has_private_data', predicatePair)
        this._findPredicateValue(subject, 'rdfs', 'type', predicatePair)
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
    /* A second iteration is necessary here, because in the future n3 generator may change
     * (e.g. Considerations and Decisions entities may be parsed first). Thus we should guarantee
     * that we have found iun and version in order to recognize the rest entities.
     */
    var decisionPrefix = DVG_ELI + decisionIunVersion['iun'] + '/' + decisionIunVersion['version'] + '/'
    for (var subject in array) {
      console.log(subject, 'VS', decisionPrefix + 'PreConsideration')
      if (subject === (decisionPrefix + 'AfterDecision')) {
        array[subject].forEach(predicatePair => {
          this._findPredicateValue('AfterDecision', 'ont', 'has_text', predicatePair)
        })
      } else if (subject === (decisionPrefix + 'PreConsideration')) {
        array[subject].forEach(predicatePair => {
          this._findPredicateValue('PreConsideration', 'ont', 'has_text', predicatePair)
        })
      }
    }
  }

  _findPredicateValue(subject, ontology, predicateSearch, predicatePair) {
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
      if (subject === 'AfterDecision') {
        this.generalProperties['AfterDecision'] = N3Util.getLiteralValue(value)
      } else if (subject === 'PreConsideration') {
        this.generalProperties['PreConsideration'] = N3Util.getLiteralValue(value)
      }
      else if (predicateSearch === 'date_publication') {
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
        if (!this.generalProperties[predicateSearch])
          this.generalProperties[predicateSearch] = [thematicCategoriesTranslation[N3Util.getLiteralValue(value)]]
        else
          this.generalProperties[predicateSearch].push(thematicCategoriesTranslation[N3Util.getLiteralValue(value)])
      } else if (predicateSearch === 'type') {
          let decisionType = this._findDecisionType(value)
          if (decisionType)
            this.generalProperties['decision_type'] = decisionType
          return decisionType
      } else {
        let literalValue = N3Util.getLiteralValue(value)
        this.generalProperties[predicateSearch] = literalValue
        return literalValue
      }
      return null
    }
  }

  _findDecisionType(value) {
    var translations = {}
    translations[ONT + 'Law'] = 'Νόμος'
    translations[ONT + 'LegislativeDecree'] = 'Πράξη Νομοθετικού Περιεχομένου'
    translations[ONT + 'Normative'] = 'Κανονιστική Πράξη'
    translations[ONT + 'Circular'] = 'Εγκύκλιος'
    translations[ONT + 'Records'] = 'Πρακτικά'
    translations[ONT + 'EvaluationReportOfLaw'] = 'Έκθεση Αποτίμησης για την κατάσταση της υφιστάμενης νομοθεσίας'
    translations[ONT + 'Opinion'] = 'Γνωμοδότηση'
    translations[ONT + 'BudgetApproval'] = 'Έγκριση Προϋπολογισμού'
    translations[ONT + 'Undertaking'] = 'Ανάληψη Υποχρέωσης'
    translations[ONT + 'ExpenditureApproval'] = 'Έγκριση Δαπάνης'
    translations[ONT + 'PaymentFinalisation'] = 'Οριστικοποίηση Πληρωμής'
    translations[ONT + 'CommisionWarrant'] = 'Επιτροπικό Ένταλμα'
    translations[ONT + 'BalanceAccount'] = 'Ισολογισμός - Απολογισμός'
    translations[ONT + 'DonationGrant'] = 'Δωρεά - Επιχορήγηση'
    translations[ONT + 'OwnershipTransferOfAssets'] = 'Παραχώρηση Χρήσης Περιουσιακών Στοιχείων'
    translations[ONT + 'Appointment'] = 'Διορισμός'
    translations[ONT + 'SuccessfulAppointedRunnerUpList'] = 'Πίνακες Επιτυχόντων, Διοριστέων & Επιλαχόντων'
    translations[ONT + 'GeneralSpecialSecretaryMonocraticBody'] = 'Πράξη που αφορά σε θέση γενικού - ειδικού γραμματέα - μονομελές όργανο'
    translations[ONT + 'CollegialBodyCommisionWorkingGroup'] = 'Πράξη που αφορά σε συλλογικό όργανο - επιτροπή - ομάδα εργασίας - ομάδα έργου - μέλη συλλογικού οργάνου'
    translations[ONT + 'OccupationInvitation'] = 'Προκήρυξη Πλήρωσης Θέσεων'
    translations[ONT + 'Contract'] = 'Σύμβαση'
    translations[ONT + 'ServiceChange'] = 'Υπηρεσιακή Μεταβολή'
    translations[ONT + 'DisciplinaryAcquitance'] = 'Αθωωτικη Πειθαρχική Απόφαση'
    translations[ONT + 'StartProductionalFunctionOfInvestment'] = 'Απόφαση Έναρξης Παραγωγικής Λειτουργίας Επένδυσης'
    translations[ONT + 'InvestmentPlacing'] = 'Πράξη Υπαγωγής Επενδύσεων'
    translations[ONT + 'DevelopmentLawContract'] = 'Σύμβαση - Πράξεις Αναπτυξιακών Νόμων'
    translations[ONT + 'OtherDevelopmentLaw'] = 'Άλλη πράξη αναπτυξιακού νόμου'
    translations[ONT + 'WorkAssignmentSupplyServicesStudies'] = 'Ανάθεση Έργων / Προμηθειών / Υπηρεσιών / Μελετών'
    translations[ONT + 'Award'] = 'Κατακύρωση'
    translations[ONT + 'DeclarationSummary'] = 'Περίληψη Διακήρυξης'
    translations[ONT + 'OtherDecisions'] = 'Λοιπές Ατομικές Διοικητικές Πράξεις'
    translations[ONT + 'PublicPrototypeDocuments'] = 'Δημόσια Πρότυπα Έγγραφα'
    translations[ONT + 'SpatialPlanningDecisions'] = 'Πράξεις Χωροταξικού - Πολεοδομικού Περιεχομένου'
    return translations[value]
  }
}
