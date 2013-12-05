<?php

$param1 = new stdClass;
$param1->Name = 'Validation';
$param1->Type = 'String';
$param1->Nullable = null;
$param1->AllowBlank = null;
$param1->MultiValue = null;
$param1->QueryParameter = 1;
$param1->Prompt = null;
$param1->PromptUser = 1;
$param1->ValidValuesQueryBased = null;
$param1->DefaultValuesQueryBased = null;
$param1->DefaultValues = new stdClass;
$param1->DefaultValues->Value = '0';
$param1->State = 'HasValidValue';

$param2 = new stdClass;
$param2->Name = 'Validation';
$param2->Type = 'portfolio';
$param2->Nullable = null;
$param2->AllowBlank = 1;
$param2->MultiValue = 1;
$param2->QueryParameter = 1;
$param2->Prompt = null;
$param2->PromptUser = 1;
$param2->ValidValuesQueryBased = null;
$param2->DefaultValuesQueryBased = null;
$param2->DefaultValues = new stdClass;
$param2->DefaultValues->Value =
        Array(1, 3, 5, 7, 9, 11, 13, 17, 19, 21, 23, 25, 27, 29, 31, 33, 35, 37, 39, 41, 43, 45, 47, 49, 51, 53, 55, 57, 59, 61);
$param2->State = 'HasValidValue';

$param3Value1 = new stdClass;
$param3Value1->Label = 'Item 1';
$param3Value1->Value = 29;

$param3Value2 = new stdClass;
$param3Value2->Label = 'Item 2';
$param3Value2->Value = 31;

$param3Values = array($param3Value1, $param3Value2,);

$param3 = new stdClass;
$param3->Name = 'portfolio';
$param3->Type = 'string';
$param3->Nullable = null;
$param3->AllowBlank = 1;
$param3->MultiValue = 1;
$param3->QueryParameter = 1;
$param3->Prompt = null;
$param3->PromptUser = 1;
$param3->Dependencies = new stdClass;
$param3->Dependencies->Dependency = array('Validation', 'portfolio');
$param3->ValidValuesQueryBased = null;
$param3->ValidValues = new stdClass;
$param3->ValidValues->ValidValue = $param3Values;
$param3->DefaultValuesQueryBased = null;
$param3->DefaultValues = new stdClass;
$param3->DefaultValues->Value = Array(29, 31, 33, 35, 37, 39, 41, 43, 49, 61);
$param3->State = 'HasValidValue';


$param4value1 = new stdClass;
$param4value1->Label = 0;
$param4value1->Value = 0;

$param4value2 = new stdClass;
$param4value2->Label = 1;
$param4value2->Value = 1;

$param4values = array($param4value1, $param4value2);

$param4 = new stdClass;
$param4->Name = 'visibility';
$param4->Type = 'String';
$param4->Nullable = null;
$param4->AllowBlank = 1;
$param4->MultiValue = null;
$param4->QueryParameter = null;
$param4->Prompt = null;
$param4->PromptUser = 1;
$param4->ValidValuesQueryBased = 1;
$param4->ValidValues = new stdClass;
$param4->ValidValues->ValidValue = $param4values;
$param4->DefaultValuesQueryBased = 1;
$param4->DefaultValues = new stdClass;
$param4->DefaultValues->Value = '0';
$param4->State = 'HasValidValue';

$param5value1 = new stdClass;
$param5value1->Label = '2011-02-25';
$param5value1->Value = '2011-02-25';

$param5value2 = new stdClass;
$param5value2->Label = '2011-02-18';
$param5value2->Value = '2011-02-18';

$param5values = array($param5value1, $param5value2);

$param5 = new stdClass;
$param5->Name = 'eff_date2';
$param5->Type = 'String';
$param5->Nullable = null;
$param5->AllowBlank = 1;
$param5->MultiValue = null;
$param5->QueryParameter = 1;
$param5->Prompt = 'Date:';
$param5->PromptUser = 1;
$param5->Dependencies = new stdClass;
$param5->Dependencies->Dependency = array('managedaccount', 'validation');
$param5->ValidValuesQueryBased = 1;
$param5->ValidValues = new stdClass;
$param5->ValidValues->ValidValue = $param5values;
$param5->DefaultValuesQueryBased = 1;
$param5->DefaultValues = new stdClass;
$param5->DefaultValues->Value = '2011-02-25';
$param5->State = 'HasValidValue';

$paramArray = array(
    $param1,
    $param2,
    $param3,
    $param4,
    $param5
);

$testReport = new stdClass;
$testReport->executionInfo = new stdClass;
$testReport->executionInfo->HasSnapshot = null;
$testReport->executionInfo->NeedsProcessing = 1;
$testReport->executionInfo->AllowQueryExecution = 1;
$testReport->executionInfo->CredentialsRequired = null;
$testReport->executionInfo->ParametersRequired = null;
$testReport->executionInfo->ExpirationDateTime = '2011-03-08T10:49:43.2934062Z';
$testReport->executionInfo->ExecutionDateTime = '0001-01-01T00:00:00';
$testReport->executionInfo->NumPages = 0;
$testReport->executionInfo->Parameters = new stdClass;
$testReport->executionInfo->Parameters->ReportParameter = $paramArray;
$testReport->DataSourcePrompts = new stdClass;
$testReport->HasDocumentMap = null;
$testReport->ExecutionID = 't1mo0x45seatmr451xegqy55';
$testReport->ReportPath = '/Reports/Reference_Report';
$testReport->ReportPageSetting = new stdClass;
$testReport->ReportPageSetting->PaperSize = new stdClass;
$testReport->ReportPageSetting->PaperSize->Height = '210';
$testReport->ReportPageSetting->PaperSize->Width = '277.00000762939';
$testReport->ReportPageSetting->Margins = new stdClass;
$testReport->ReportPageSetting->Margins->Top = '10';
$testReport->ReportPageSetting->Margins->Bottom = '10';
$testReport->ReportPageSetting->Margins->Left = '5';
$testReport->ReportPageSetting->Margins->Right = '5';
$testReport->AutoRefreshInterval = 0;