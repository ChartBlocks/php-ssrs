<?php

require_once('SSRS/Report.php');

class SSRS_ReportTest extends PHPUnit_Framework_TestCase {

    public function testPassCredentialsOnConstruct() {
        $options = array(
            'username' => 'bob',
            'password' => 'monkhouse'
        );

        $ssrs = new SSRS_Report('http://test', $options);

        $this->assertEquals($options['username'], $ssrs->getUsername());
        $this->assertEquals($options['password'], $ssrs->getPassword());
    }

    public function testGetSoapServiceReturnsNTLMByDefault() {
        $ssrs = new SSRS_Report('http://test');
        $soap = $ssrs->getSoapService(false);

        $this->assertInstanceOf('SSRS_Soap_NTLM', $soap);
        $this->assertEquals('http://test/ReportService2010.asmx', $soap->getUri());
    }

    public function testGetSoapExecutionReturnsNTLMByDefault() {
        $ssrs = new SSRS_Report('http://test');
        $soap = $ssrs->getSoapExecution(false);

        $this->assertInstanceOf('SSRS_Soap_NTLM', $soap);
        $this->assertEquals('http://test/ReportExecution2005.asmx', $soap->getUri());
    }

    public function testSetSessionId() {
        $sessionId = 't1mo0x45seatmr451xegqy55';

        $headerStr = sprintf('<ExecutionHeader xmlns="%s"><ExecutionID>%s</ExecutionID></ExecutionHeader>', 'http://schemas.microsoft.com/sqlserver/2005/06/30/reporting/reportingservices', $sessionId);
        $soapVar = new SoapVar($headerStr, XSD_ANYXML, null, null, null);
        $soapHeader = new SoapHeader('http://schemas.microsoft.com/sqlserver/2005/06/30/reporting/reportingservices', 'ExecutionHeader', $soapVar);

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockSession', '', array('__setSoapHeaders'));
        $soapMock->expects($this->any())
                ->method('__setSoapHeaders')
                ->with($this->equalTo(array($soapHeader)));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock);

        $result = $ssrs->setSessionId($sessionId);
        $this->assertEquals($ssrs, $result);
    }

    public function testLoadChildrenReturnsItemList() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportService2010.wsdl', 'SoapClientMockChildren');
        $catalogItem1 = new stdClass;
        $catalogItem1->ID = '1386fc6d-9c58-489f-adea-081146b62799';
        $catalogItem1->Name = 'Report Reference';
        $catalogItem1->Path = '/Reports/Report_Reference';
        $catalogItem1->TypeName = 'Report';
        $catalogItem1->Size = '234413';
        $catalogItem1->CreationDate = '2011-03-03T12:32:57.063';
        $catalogItem1->ModifiedDate = '2011-03-03T12:51:12.05';
        $catalogItem1->CreatedBy = 'MSSQL\WebAccount';
        $catalogItem1->ModifiedBy = 'MSSQL\WebAccount';

        $return = new stdClass;
        $return->CatalogItems = new stdClass;
        $return->CatalogItems->CatalogItem = array($catalogItem1);

        $soapMock->expects($this->any())
                ->method('ListChildren')
                ->with($this->equalTo(array('ItemPath' => '/Reports', 'Recursive' => true)))
                ->will($this->returnValue($return));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapService($soapMock);

        $result = $ssrs->listChildren('/Reports', true);
        $expected = new SSRS_Object_CatalogItems($return);

        $this->assertInstanceOf('SSRS_Object_CatalogItems', $result);
        $this->assertEquals($expected, $result);
    }

    public function testLoadChildrenCheckRecursiveParameterIsSetAndIsBoolean() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportService2010.wsdl', 'SoapClientMockChildren2');

        $recursiveParam = true;

        $soapMock->expects($this->any())
                ->method('ListChildren')
                ->with($this->equalTo(array('ItemPath' => '/Reports', 'Recursive' => true)));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapService($soapMock);

        $result = $ssrs->listChildren('/Reports', $recursiveParam);
    }

    public function testLoadItemDefinitionsReturnsXMLStringWithInStdClass() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportService2010.wsdl', 'SoapClientMockDefinitions');

        $soapMock->expects($this->any())
                ->method('getItemDefinition')
                ->with($this->equalTo(array('ItemPath' => '/Reports/Managed Account Performance')));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapService($soapMock);

        $result = $ssrs->getItemDefinition('/Reports/Managed Account Performance');
    }

    public function testLoadReportReturnsCorrectObject() {
        require(dirname(__FILE__) . '/ReportTest/LoadReportObject.php');

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockLoadReport');
        $soapMock->expects($this->any())
                ->method('loadReport')
                ->with($this->equalTo(array('Report' => '/Reports/Reference_Report', 'HistoryID' => null)))
                ->will($this->returnValue($testReport));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock);
        $expected = new SSRS_Object_Report($testReport);

        $result = $ssrs->loadReport('/Reports/Reference_Report');
        $this->assertEquals($expected, $result);
    }

    public function testSetExecutionParametersReturnsCorrectObject() {
        require(dirname(__FILE__) . '/ReportTest/SetExecutionParametersObject.php');
        $executionID = 'ybv45155dta00245nxlqfi55';

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockExecutionParams');
        $soapMock->expects($this->any())
                ->method('SetExecutionParameters')
                ->with($this->equalTo(array('Parameters' => $parameters->getParameterArrayForSoapCall(), 'ParameterLanguage' => 'en-us')))
                ->will($this->returnValue($returnExecParams));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock)
                ->setSessionId($executionID);

        $expected = new SSRS_Object_ExecutionInfo($returnExecParams);
        $result = $ssrs->setExecutionParameters($parameters);

        $this->assertInstanceOf('SSRS_Object_ExecutionInfo', $result);
        $this->assertEquals($expected, $result);
    }

    public function testRenderOutputsReport() {
        $executionID = 'ybv45155dta00245nxlqfi55';

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockRender');
        $soapMock->expects($this->any())->method('Render2')
                ->with($this->equalTo(array(
                            'Format' => 'HTML4.0',
                            'DeviceInfo' => '<DeviceInfo><Toolbar>False</Toolbar></DeviceInfo>',
                            'PaginationMode' => 'Estimate'
                        )));

        $ssrs = new SSRS_Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock)
                ->setSessionId($executionID);

        $result = $ssrs->render('HTML4.0', 'Estimate');
    }

}
