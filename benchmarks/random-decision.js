exports.generate = () => {
  const crypto = require('crypto')
  const randomInt = require('random-int')

  let randomDecision = {}
  let governmentInfo = {
    government_institution_general_administration: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    government_institution_department: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    government_institution_address: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    government_institution_postalcode: crypto.randomBytes(5).toString('hex'),
    government_institution_phone: crypto.randomBytes(10).toString('hex'),
    government_institution_fax: crypto.randomBytes(10).toString('hex'),
    government_institution_website: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    government_institution_email: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    government_institution_information: crypto.randomBytes(randomInt(10, 20)).toString('hex')
  }

  let decisionTypes = ['Normative', 'Circular', 'Appointment', 'Award', 'LegislativeDecree', 'OtherDecisionsGeneral', 'ServiceChange', 'OccupationInvitation', 'Records', 'BalanceAccount', 'BudgetApproval', 'CollegialBodyCommisionWorkingGroup', 'CommisionWarrant', 'Contract', 'DeclarationSummary', 'DonationGrant', 'SpatialPlanningDecisions', 'ExpenditureApproval', 'GeneralSpecialSecretaryMonocraticBody', 'OwnershipTransferOfAssets', 'SuccessfulAppointedRunnerUpList', 'Undertaking', 'WorkAssignmentSupplyServicesStudies', 'Opinion', 'DevelopmentLawContract', 'DisciplinaryAcquitance', 'EvaluationReportOfLaw', 'InvestmentPlacing', 'PublicPrototypeDocuments', 'StartProductionalFunctionOfInvestment']

  let thematicCategories = ['Employment', 'Industry', 'AgricultureForestryFishery', 'Geography', 'PublicAdministration', 'Fiscals', 'NutritionAgriculturalProducts', 'InternationalOrganizations', 'InternationalRelations', 'Laws', 'Energy', 'CommunicationEducation', 'Science', 'BusinessCompetition', 'EuropeanUnion', 'SocialIssues', 'Transport', 'EconomicTradeExchanges', 'EconomicActivity', 'ManufactureTechnologyResearch', 'Environment', 'PoliticalLife']

  let randomThematicCategories = []
  for (let i = 0; i < randomInt(1, 3); i++) {
    let index = randomInt(thematicCategories.length - 1)
    randomThematicCategories.push(thematicCategories[index])
    thematicCategories.splice(index, 1)
  }
  let obligatoryFields = {
    title: crypto.randomBytes(randomInt(25, 50)).toString('hex'),
    protocol_number: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    government_institution_name: crypto.randomBytes(randomInt(10, 20)).toString('hex'),
    decision_type: decisionTypes[randomInt(decisionTypes.length - 1)],
    thematic_category: randomThematicCategories
  }

  let optionalFields = {
    decision_call: crypto.randomBytes(randomInt(10, 30)).toString('hex')
  }

  let considerations = []
  let decisions = []
  for (let index = 1; index < randomInt(7, 17); index++) {
    considerations.push({text: crypto.randomBytes(randomInt(150, 350)).toString('hex'), index})
  }
  for (let index = 1; index < randomInt(7, 17); index++) {
    decisions.push({text: crypto.randomBytes(randomInt(150, 350)).toString('hex'), index})
  }
  Object.assign(randomDecision, governmentInfo, obligatoryFields, optionalFields, {decisions, considerations})
  return randomDecision
}
