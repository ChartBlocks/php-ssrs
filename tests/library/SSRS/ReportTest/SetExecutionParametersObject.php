<?php

$execParams1 = new stdClass;
$execParams1->Name = 'Validation';
$execParams1->Type = 'String';
$execParams1->Nullable = null;
$execParams1->AllowBlank = null;
$execParams1->MultiValue = null;
$execParams1->QueryParameter = 1;
$execParams1->Prompt = null;
$execParams1->PromptUser = 1;
$execParams1->ValidValuesQueryBased = null;
$execParams1->DefaultValuesQueryBased = null;
$execParams1->DefaultValues->Value = 0;
$execParams1->State = 'HasValidValue';

$execParams2 = new stdClass;
$execParams2->name = 'portfolio';
$execParams2->Type = 'String';
$execParams2->Nullable = null;
$execParams2->AllowBlank = 1;
$execParams2->MultiValue = 1;
$execParams2->QueryParameter = 1;
$execParams2->Prompt = null;
$execParams2->PromptUser = 1;
$execParams2->ValidValuesQueryBased = null;
$execParams2->DefaultValuesQueryBased = null;
$execParams2->DefaultValues->Value = 61;
$execParams2->State = 'HasValidValue';

$execParams3 = new stdClass;
$execParams3->name = 'managedaccount';
$execParams3->Type = 'String';
$execParams3->Nullable = null;
$execParams3->AllowBlank = null;
$execParams3->MultiValue = 1;
$execParams3->QueryParameter = 1;
$execParams3->Prompt = 'Portfolio:';
$execParams3->PromptUser = 1;
$execParams3->Dependencies->Dependency = array('Validation', 'portfolio');
$execParams3->ValidValuesQueryBased = 1;
$execParams3->ValidValues->ValidValue->Label = 'Label 1';
$execParams3->ValidValues->ValidValue->Value = '61';
$execParams3->DefaultValuesQueryBased = 1;
$execParams3->DefaultValues->Value = 61;
$execParams3->State = 'HasValidValue';

$execParams4value1 = new stdClass;
$execParams4value1->Label = 0;
$execParams4value1->Value = 0;

$execParams4value2 = new stdClass;
$execParams4value2->Label = 1;
$execParams4value2->Value = 1;

$execParams4value = array($execParams4value1, $execParams4value2);

$execParams4 = new stdClass;
$execParams4->name = 'visibility';
$execParams4->Type = 'String';
$execParams4->Nullable = null;
$execParams4->AllowBlank = 1;
$execParams4->MultiValue = null;
$execParams4->QueryParameter = null;
$execParams4->Prompt = null;
$execParams4->PromptUser = 1;
$execParams4->ValidValuesQueryBased = 1;
$execParams4->ValidValues->ValidValue = $execParams4value;
$execParams4->DefaultValuesQueryBased = 1;
$execParams4->DefaultValues->Value = 0;
$execParams4->State = 'HasValidValue';


$execParams5value1 = new stdClass;
$execParams5value1->Label = '2011-02-25';
$execParams5value1->Value = '2011-02-25';

$execParams5value2 = new stdClass;
$execParams5value2->Label = '2011-02-18';
$execParams5value2->Value = '2011-02-18';

$execParams5values = array($execParams5value1, $execParams5value2);

$execParams5 = new stdClass;
$execParams5->Name = 'eff_date2';
$execParams5->Type = 'String';
$execParams5->Nullable = null;
$execParams5->AllowBlank = 1;
$execParams5->MultiValue = null;
$execParams5->QueryParameter = 1;
$execParams5->Prompt = 'Date:';
$execParams5->PromptUser = 1;
$execParams5->Dependencies->Dependency = array('managedaccount', 'validation');
$execParams5->ValidValuesQueryBased = 1;
$execParams5->ValidValues->ValidValue = $execParams5values;
$execParams5->DefaultValuesQueryBased = 1;
$execParams5->DefaultValues->Value = '2011-01-21';
$execParams5->State = 'HasValidValue';

$execParams = array($execParams1, $execParams2, $execParams3, $execParams4, $execParams5);

$returnExecParams = new stdClass;
$returnExecParams->executionInfo->HasSnapshot = null;
$returnExecParams->executionInfo->NeedsProcessing = 1;
$returnExecParams->executionInfo->CredentialsRequired = null;
$returnExecParams->executionInfo->ParametersRequired = null;
$returnExecParams->executionInfo->ExpirationDateTime = '2011-03-08T14:40:17.383Z';
$returnExecParams->executionInfo->ExecutionDateTime = '0001-01-01T00:00:00';
$returnExecParams->executionInfo->NumPages = 0;
$returnExecParams->executionInfo->Parameters->ReportParameter = $execParams;
$returnExecParams->executionInfo->DataSourcePrompts = new stdClass;
$returnExecParams->executionInfo->HasDocumentMap = null;
$returnExecParams->executionInfo->ExecutionID = 'ybv45155dta00245nxlqfi55';
$returnExecParams->executionInfo->ReportPath = '/Reports/Reference_Report';
$returnExecParams->executionInfo->ReportPageSettings->PaperSize->Height = '210';
$returnExecParams->executionInfo->ReportPageSettings->PaperSize->Width = '277.00000762939';
$returnExecParams->executionInfo->ReportPageSettings->Margins->Top = '10';
$returnExecParams->executionInfo->ReportPageSettings->Margins->Bottom = '10';
$returnExecParams->executionInfo->ReportPageSettings->Margins->Left = '5';
$returnExecParams->executionInfo->ReportPageSettings->Margins->Right = '5';
$returnExecParams->executionInfo->AutoRefreshInterval = 0;

$parameters = new SSRS_Object_ExecutionParameters(new SSRS_Object_ReportParameters(array(
                    'Parameters' => array(
                        new SSRS_Object_ExecutionParameter(array(
                            'Name' => 'Validation',
                            'Value' => '0'
                        )),
                        array(
                            'Name' => 'portfolio',
                            'Value' => '61'
                        ),
                        array(
                            'Name' => 'managedaccount',
                            'Value' => '61'
                        ),
                        array(
                            'Name' => 'visibility',
                            'Value' => '0'
                        ),
                        array(
                            'Name' => 'eff_date2',
                            'Value' => '2011-01-21'
                        ),
                    )
                )));
