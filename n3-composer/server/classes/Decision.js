const fs = require('fs');


const ONT = '<http://diavgeia.gov.gr/ontology/>';
const ELI = '<http://data.europa.eu/eli/ontology#>';
const LEG = '<http://legislation.di.uoa.gr/eli/>';

class Decision {

  constructor(fields, iun, version, unitIds) {
    this.fields = fields;
    this.fields.iun = iun;
    this.fields.version = version;
    this.fields.unitIds = unitIds;
    this.decisionString = '';
  }

  _format_triplet(ontology, propertyName, propertyValue, propertyRange, stringGreek=true, lastTriplet=false) {
    var str = '\t'+ontology+':'+propertyName+' ';
    if (propertyRange === 'string' && stringGreek) {
      str += '"'+propertyValue+'"@el';
    } else if (propertyRange === 'string') {
      str += '"'+propertyValue+'"';
    } else if (propertyRange === 'number') {
      str += propertyValue;
    }
    if(lastTriplet)
      return str+'.\n';
    return str+';\n';
  }

  _writePrefixes() {
    const baseString = '@base <http://diavgeia.gov.gr/eli/decision/'+this.fields.iun+'/'+this.fields.version+'/>.\n';
    const ontString = '@prefix ont: '+ONT+'.\n';
    const eliString = '@prefix eli: '+ELI+'.\n';
    const legString = '@prefix leg: '+LEG+'.\n\n';
    this.decisionString = baseString + ontString + eliString + legString;
  }

  _writeGovernmentInstitutionsOptionalInfo() {
    if (this.fields.government_institution_general_administration)
      this.decisionString += this._format_triplet('ont', 'government_institution_general_administration', this.fields.government_institution_general_administration, 'string');
    if (this.fields.government_institution_department)
      this.decisionString += this._format_triplet('ont', 'government_institution_department', this.fields.government_institution_department, 'string');
    if (this.fields.government_institution_address)
      this.decisionString += this._format_triplet('ont', 'government_institution_address', this.fields.government_institution_address, 'string');
    if (this.fields.government_institution_postalcode)
      this.decisionString += this._format_triplet('ont', 'government_institution_postalcode', this.fields.government_institution_postalcode, 'string', false);
    if (this.fields.government_institution_phone)
      this.decisionString += this._format_triplet('ont', 'government_institution_phone', this.fields.government_institution_phone, 'string', false);
    if (this.fields.government_institution_fax)
      this.decisionString += this._format_triplet('ont', 'fax', this.fields.government_institution_fax, 'string', false);
    if (this.fields.government_institution_website)
      this.decisionString += this._format_triplet('ont', 'government_institution_website', this.fields.government_institution_website, 'string', false);
    if (this.fields.government_institution_email)
      this.decisionString += this._format_triplet('ont', 'government_institution_email', this.fields.government_institution_email, 'string', false);
    if (this.fields.government_institution_information)
      this.decisionString += this._format_triplet('ont', 'government_institution_information', this.fields.government_institution_information, 'string');
  }

  _writeGeneralInfo() {
    this.decisionString += '<> a ont:'+this.fields.decision_type+';\n';
    this.decisionString += this._format_triplet('ont', 'version', this.fields.version, 'string', false);
    this.decisionString += this._format_triplet('ont', 'iun', this.fields.iun, 'string');
    this.decisionString += this._format_triplet('eli', 'title', this.fields.title, 'string');
    this.decisionString += this._format_triplet('ont', 'government_institution_name', this.fields.government_institution_name, 'string');
    this.decisionString += this._format_triplet('ont', 'protocol_number', this.fields.protocol_number, 'string');
    this.fields.thematic_category.forEach((thematicCategory) => {
      this.decisionString += this._format_triplet('ont', 'thematic_category', thematicCategory, 'string', false);
    });
    this.fields.unitIds.forEach((unitId) => {
      this.decisionString += this._format_triplet('ont', 'unit_id', unitId, 'string', false);
    });

    var date = new Date();
    var dateString = date.toISOString();
    var submission_timestamp = date.getTime();
    this.decisionString += this._format_triplet('ont', 'submission_timestamp', submission_timestamp, 'string', false);
    dateString = dateString.substring(0, dateString.indexOf('T'));
    this.decisionString += '\teli:date_publication "'+dateString+'"^^<http://www.w3.org/2001/XMLSchema#date>.\n';
  }

  generateN3() {
    this._writePrefixes();
    this._writeGeneralInfo();
    fs.writeFileSync('testDecision.n3', this.decisionString, (err) => {
      if (err)
        return console.log(err);
      console.log('The decision was created');
    });
  }
}

module.exports = Decision;
