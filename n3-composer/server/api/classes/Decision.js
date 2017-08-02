const fs = require('fs');


const ONT = '<http://diavgeia.gov.gr/ontology/>';
const ELI = '<http://data.europa.eu/eli/ontology#>';
const LEG = '<http://legislation.di.uoa.gr/eli/>';

class Decision {

  constructor(fields, iun, version, unitIds, organizationId) {
    this.fields = fields
    this.fields.iun = iun
    this.fields.version = version
    this.fields.unitIds = unitIds
    this.fields.organizationId = organizationId
    this.decisionString = ''
  }

  _format_triplet(ontology, propertyName, propertyValue, propertyRange, stringGreek=true, lastTriplet=false) {
    var str = '\t' + ontology + ':' + propertyName + ' '
    if (propertyRange === 'string' && stringGreek) {
      str += '"' + propertyValue + '"@el'
    } else if (propertyRange === 'string') {
      str += '"' + propertyValue + '"'
    } else if (propertyRange === 'number' || propertyRange === 'boolean') {
      str += propertyValue
    } else if (propertyRange === 'entity') {
      str += '<' + propertyValue + '>'
    } else if (propertyRange === 'integer') {
      str += '"' + propertyValue + '"^^<http://www.w3.org/2001/XMLSchema#integer>'
    }
    if(lastTriplet)
      return str + '.\n\n'
    return str + ';\n'
  }

  _writePrefixes() {
    const baseString = '@base <http://diavgeia.gov.gr/eli/decision/'+this.fields.iun+'/'+this.fields.version+'/>.\n'
    const ontString = '@prefix ont: '+ONT+'.\n'
    const eliString = '@prefix eli: '+ELI+'.\n'
    const legString = '@prefix leg: '+LEG+'.\n\n'
    this.decisionString = baseString + ontString + eliString + legString
  }

  _writeGovernmentInstitutionsOptionalInfo() {
    if (this.fields.government_institution_general_administration)
      this.decisionString += this._format_triplet('ont', 'government_institution_general_administration', this.fields.government_institution_general_administration, 'string')
    if (this.fields.government_institution_department)
      this.decisionString += this._format_triplet('ont', 'government_institution_department', this.fields.government_institution_department, 'string')
    if (this.fields.government_institution_address)
      this.decisionString += this._format_triplet('ont', 'government_institution_address', this.fields.government_institution_address, 'string')
    if (this.fields.government_institution_postalcode)
      this.decisionString += this._format_triplet('ont', 'government_institution_postalcode', this.fields.government_institution_postalcode, 'string', false)
    if (this.fields.government_institution_phone)
      this.decisionString += this._format_triplet('ont', 'government_institution_phone', this.fields.government_institution_phone, 'string', false)
    if (this.fields.government_institution_fax)
      this.decisionString += this._format_triplet('ont', 'fax', this.fields.government_institution_fax, 'string', false)
    if (this.fields.government_institution_website)
      this.decisionString += this._format_triplet('ont', 'government_institution_website', this.fields.government_institution_website, 'string', false)
    if (this.fields.government_institution_email)
      this.decisionString += this._format_triplet('ont', 'government_institution_email', this.fields.government_institution_email, 'string', false)
    if (this.fields.government_institution_information)
      this.decisionString += this._format_triplet('ont', 'government_institution_information', this.fields.government_institution_information, 'string')
  }

  _writeSpecialProperties() {
    switch (this.fields.decision_type) {
      case 'Normative':
        this._writeNormativeType()
        if (this.fields.normative_number)
          this.decisionString += this._format_triplet('ont', 'normative_number', this.fields.normative_number, 'string', false)
        this._writeFek()
        break
      case 'Circular':
        if (this.fields.circular_number)
          this.decisionString += this._format_triplet('ont', 'circular_number', this.fields.circular_number, 'string', false)
        break
      case 'Appointment':
        if (this.fields.number_employees)
          this.decisionString += this._format_triplet('ont', 'number_employees', this.fields.number_employees, 'integer')
        if (this.fields.appointment_employer_org)
          this.decisionString += this._format_triplet('ont', 'appointment_employer_org', this.fields.appointment_employer_org, 'string', false)
        this._writeFek()
        break
      case 'Award':
        if (this.fields.expense_amount && this.fields.expense[0].afm) {
          this.decisionString += this._format_triplet('ont', 'has_expense', 'Expense/1', 'entity')
        }
        if (this.fields.has_related_declaration_summary) {
          // TODO This is not a valid decision format, as we miss the version.
          // The following approach should be followed:
          // Combine the current Diavgeia api (https://diavgeia.gov.gr/luminapi/api/decisions/{{IUN}}) with the rdf store.
          // This is the case, because IUN may refer to an old pdf decision or to a new .n3 decision.
          let version = ''
          let iun = this.fields.has_related_declaration_summary + '/'
          this.decisionString += '\tont:has_related_declaration_summary <http://diavgeia.gov.gr/eli/decision/' + iun + version + '>;\n'
        }
        break
    }
  }

  _writeFek() {
    if (this.fields.fek_number && this.fields.fek_issue && this.fields.fek_year) {
      this.decisionString += this._format_triplet('ont', 'fek_number', this.fields.fek_number, 'string', false)
      this.decisionString += this._format_triplet('ont', 'fek_issue', this.fields.fek_issue, 'string')
      this.decisionString += this._format_triplet('ont', 'fek_year', this.fields.fek_year, 'string', false)
    }
  }

  _writeNormativeType() {
    if (this.fields.normative_number)
      this.decisionString += this._format_triplet('ont', 'normative_type', this.fields.normative_type, 'string')
  }

  _writeGeneralInfo() {
    // General Information
    this.decisionString += '<> a ont:'+this.fields.decision_type+';\n'
    this.decisionString += this._format_triplet('ont', 'version', this.fields.version, 'string', false)
    this.decisionString += this._format_triplet('ont', 'iun', this.fields.iun, 'string')
    this.decisionString += this._format_triplet('eli', 'title', this.fields.title, 'string')
    this.decisionString += this._format_triplet('ont', 'has_private_data', Boolean(this.fields.has_private_data), 'boolean')
    this.decisionString += this._format_triplet('ont', 'government_institution_name', this.fields.government_institution_name, 'string')
    this.decisionString += this._format_triplet('ont', 'protocol_number', this.fields.protocol_number, 'string')
    this.decisionString += this._format_triplet('ont', 'decision_call', this.fields.decision_call, 'string')
    this.fields.thematic_category.forEach((thematicCategory) => {
      this.decisionString += this._format_triplet('ont', 'thematic_category', thematicCategory, 'string', false)
    });
    this.fields.unitIds.forEach((unitId) => {
      this.decisionString += this._format_triplet('ont', 'unit_id', unitId, 'string', false)
    });
    this.decisionString += this._format_triplet('ont', 'organization_id', this.fields.organizationId, 'string', false)
    // Link Decision with its PreConsideration, Considerations, Decisions and AfterDecision
    if (this.fields.preconsideration)
      this.decisionString += this._format_triplet('ont','has_preconsideration', 'Preconsideration', 'entity')

    this.fields.considerations.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'has_considered', 'Consideration/' + (i + 1) , 'entity')
    })

    this.fields.decisions.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'has_decided', 'Decision/' + (i + 1) , 'entity')
    })

    if (this.fields.afterconsideration)
      this.decisionString += this._format_triplet('ont', 'has_afterdecision', 'AfterDecision', 'entity')

    // Recipients
    this.fields.internal_distr.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'internal_distribution', v.name, 'string')
    })

    this.fields.recipient_for_share.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'recipient_for_share', v.name, 'string')
    })

    this.fields.recipient.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'recipient', v.name, 'string')
    })

    // Signers
    this.fields.signer.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'signed_by', 'Signer/' + (i + 1), 'entity')
    })

    // Present
    this.fields.present.forEach( (v, i) => {
      if (v.text)
        this.decisionString += this._format_triplet('ont', 'has_present', 'Present/' + (i + 1), 'entity')
    })

    this._writeSpecialProperties()

    // Dates
    var date = new Date()
    var dateString = date.toISOString()
    var submission_timestamp = date.getTime()
    this.decisionString += this._format_triplet('ont', 'submission_timestamp', submission_timestamp, 'string', false)
    dateString = dateString.substring(0, dateString.indexOf('T'))
    this.decisionString += '\teli:date_publication "'+dateString+'"^^<http://www.w3.org/2001/XMLSchema#date>.\n\n'
  }

  _format_linking(legislation) {
    if (legislation.type === 'dvg') {
      // TODO This is not a valid decision format, as we miss the version.
      // The following approach should be followed:
      // Combine the current Diavgeia api (https://diavgeia.gov.gr/luminapi/api/decisions/{{IUN}}) with the rdf store.
      // This is the case, because IUN may refer to an old pdf decision or to a new .n3 decision.
      let version = '';
      let iun = legislation.IUN + '/' ;
      return '\tont:considers <http://diavgeia.gov.gr/eli/decision/'+ iun + version + '>;\n'
    }

    let articleParagraph = ''
    if (legislation.article) {
      articleParagraph = '\\/' + legislation.article
      if (legislation.paragraph)
        articleParagraph += '\\/' + legislation.paragraph
    }
    return '\tont:considers leg:'+legislation.type + '\\/' + legislation.year + '\\/' + legislation.number + articleParagraph + ';\n'
  }

  _hasLegislationLinking(legislation) {
    let validDvgLinking = legislation.type === 'dvg' && legislation.IUN
    let validLegLinking = legislation.type && legislation.type != 'dvg' && legislation.year && legislation.number
    return (validLegLinking || validDvgLinking)
  }

  _writeDecisionBody() {
    // PreConsideration Body
    if (this.fields.preconsideration) {
      this.decisionString += '<PreConsideration> a ont:PreConsideration;\n'
      this.decisionString += this._format_triplet('ont', 'has_text', this.fields.preconsideration, 'string', true, true)
    }
    // Considerations Body
    this.fields.considerations.forEach( (legislation) => {
      if (legislation.text) {
        this.decisionString += '<Consideration/' + legislation.index + '> a ont:Consideration;\n'
        if (this._hasLegislationLinking(legislation)) {
          this.decisionString += this._format_linking(legislation)
        }
        this.decisionString += this._format_triplet('ont', 'has_text', legislation.text, 'string', true, true)
      }
    })
    // Decisions Body
    this.fields.decisions.forEach( (legislation) => {
      if (legislation.text) {
        this.decisionString += '<Decision/' + legislation.index + '> a ont:Decision;\n'
        if (this._hasLegislationLinking(legislation)) {
          this.decisionString += this._format_linking(legislation)
        }
        this.decisionString += this._format_triplet('ont', 'has_text', legislation.text, 'string', true, true)
      }
    })
    // AfterConsideration Body
    if(this.fields.afterconsideration) {
      this.decisionString += '<AfterConsideration> a ont:AfterConsideration;\n'
      this.decisionString += this._format_triplet('ont', 'has_text', this.fields.afterconsideration, 'string', true, true)
    }
  }

  _writeRestEntities() {
    // Signers
    this.fields.signer.forEach( (signer) => {
      if (signer.name) {
        this.decisionString += '<Signer/' + signer.index + '> a ont:Signer;\n'
        this.decisionString += this._format_triplet('ont', 'signer_name', signer.name, 'string')
        this.decisionString += this._format_triplet('ont', 'signer_job', signer.job, 'string', true , true)
      }
    });
    // Present
    this.fields.present.forEach( (present) => {
      if (present.name) {
        this.decisionString += '<Present/' + present.index + '> a ont:Present;\n'
        this.decisionString += this._format_triplet('ont', 'present_name', present.name, 'string')
        this.decisionString += this._format_triplet('ont', 'present_title', present.role, 'string', true, true)
      }
    })
    // Expenses
    switch (this.fields.decision_type) {
      case 'Award':
        if (this.fields.expense_amount && this.fields.expense[0].afm) {
          this.decisionString += '<Expense/1> a ont:Expense;\n'
          this.decisionString += this._format_triplet('ont', 'expense_amount', this.fields.expense_amount, 'string', false)
          this.fields.expense.forEach((expense, i) => {
            if (expense.afm) {
              this.decisionString += this._format_triplet('ont', 'has_sponsored', 'Sponsored/' + (i + 1), 'entity')
            }
          })
          this.decisionString += this._format_triplet('ont', 'expense_currency', this.fields.expense_currency, 'string', true, true)

          //Sponsored
          this.fields.expense.forEach((expense) => {
            this.decisionString += '<Sponsored/' + expense.index + '> a ont:Sponsored;\n'
            this.decisionString += this._format_triplet('ont', 'afm', expense.afm, 'string', false)
            this.decisionString += this._format_triplet('ont', 'afm_type', expense.afm_type, 'string')
            this.decisionString += this._format_triplet('ont', 'name', expense.name, 'string', true, true)
          })
        }
        break;
    }
  }

  generateN3() {
    this._writePrefixes()
    this._writeGeneralInfo()
    this._writeDecisionBody()
    this._writeRestEntities()
    console.log(this.decisionString)
    // fs.writeFileSync('testDecision.n3', this.decisionString, (err) => {
    //   if (err)
    //     return console.log(err);
    //   console.log('The decision was created');
    // });
  }
}

module.exports = Decision;
