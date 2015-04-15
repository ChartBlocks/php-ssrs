<?php

namespace SSRSTest;

use SSRS\Report;
use SSRS\Object\CatalogItems;
use SSRS\Object\ReportOutput;
use SoapVar;
use SoapHeader;

class ReportTest extends \PHPUnit_Framework_TestCase {

    public function testPassCredentialsOnConstruct() {
        $options = array(
            'username' => 'bob',
            'password' => 'monkhouse'
        );

        $ssrs = new Report('http://test', $options);

        $this->assertEquals($options['username'], $ssrs->getUsername());
        $this->assertEquals($options['password'], $ssrs->getPassword());
        $this->assertArrayNotHasKey('password', $ssrs->options, 'Password should not remain in options');
    }

    public function testSetOptions() {
        $options = array(
            'cache_wsdl_path' => '/opt/test',
        );

        $ssrs = new Report('http://test', $options);
        $this->assertEquals('/opt/test', $ssrs->options['cache_wsdl_path']);

        $ssrs->setOptions(array());
        $this->assertEquals(null, $ssrs->options['cache_wsdl_path']);
    }

    public function testGetSoapServiceReturnsNTLMByDefault() {
        $ssrs = new Report('http://test');
        $soap = $ssrs->getSoapService(false);

        $this->assertInstanceOf('\SSRS\Soap\NTLM', $soap);
        $this->assertEquals('http://test/ReportService2010.asmx', $soap->getUri());
    }

    public function testGetSoapExecutionReturnsNTLMByDefault() {
        $ssrs = new Report('http://test');
        $soap = $ssrs->getSoapExecution(false);

        $this->assertInstanceOf('SSRS\Soap\NTLM', $soap);
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

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock);

        $result = $ssrs->setSessionId($sessionId);
        $this->assertEquals($ssrs, $result);
    }

    public function testLoadChildrenReturnsItemList() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportService2010.wsdl', 'SoapClientMockChildren');
        $catalogItem1 = new \stdClass;
        $catalogItem1->ID = '1386fc6d-9c58-489f-adea-081146b62799';
        $catalogItem1->Name = 'Report Reference';
        $catalogItem1->Path = '/Reports/Report_Reference';
        $catalogItem1->TypeName = 'Report';
        $catalogItem1->Size = '234413';
        $catalogItem1->CreationDate = '2011-03-03T12:32:57.063';
        $catalogItem1->ModifiedDate = '2011-03-03T12:51:12.05';
        $catalogItem1->CreatedBy = 'MSSQL\WebAccount';
        $catalogItem1->ModifiedBy = 'MSSQL\WebAccount';

        $return = new \stdClass;
        $return->CatalogItems = new \stdClass;
        $return->CatalogItems->CatalogItem = array($catalogItem1);

        $soapMock->expects($this->any())
                ->method('ListChildren')
                ->with($this->equalTo(array('ItemPath' => '/Reports', 'Recursive' => true)))
                ->will($this->returnValue($return));

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapService($soapMock);

        $result = $ssrs->listChildren('/Reports', true);
        $expected = new CatalogItems($return);

        $this->assertInstanceOf('\SSRS\Object\CatalogItems', $result);
        $this->assertEquals($expected, $result);
    }

    public function testLoadChildrenCheckRecursiveParameterIsSetAndIsBoolean() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportService2010.wsdl', 'SoapClientMockChildren2');

        $recursiveParam = true;

        $soapMock->expects($this->any())
                ->method('ListChildren')
                ->with($this->equalTo(array('ItemPath' => '/Reports', 'Recursive' => true)));

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapService($soapMock);

        $result = $ssrs->listChildren('/Reports', $recursiveParam);
    }

    public function testLoadItemDefinitionsReturnsXMLStringWithInStdClass() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportService2010.wsdl', 'SoapClientMockDefinitions');

        $soapMock->expects($this->any())
                ->method('getItemDefinition')
                ->with($this->equalTo(array('ItemPath' => '/Reports/Managed Account Performance')));

        $ssrs = new Report('http://test/ReportServer');
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

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock);
        $expected = new \SSRS\Object\ExecutionInfo($testReport);

        $result = $ssrs->loadReport('/Reports/Reference_Report');
        $this->assertEquals($expected, $result);
    }

    public function testRenderOutputsReport() {
        $executionID = 'ybv45155dta00245nxlqfi55';

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockRender');
        $soapMock->expects($this->any())->method('Render2')
                ->with($this->equalTo(array(
                            'Format' => 'HTML4.0',
                            'DeviceInfo' => '<DeviceInfo></DeviceInfo>',
                            'PaginationMode' => 'Estimate'
        )));

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock)
                ->setSessionId($executionID);

        $result = $ssrs->render('HTML4.0');
    }

    public function testRenderConvertsDeviceInfo() {
        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockRender2');
        $soapMock->expects($this->any())->method('Render2')
                ->with($this->equalTo(array(
                            'Format' => 'CSV',
                            'DeviceInfo' => '<DeviceInfo><Toolbar>true</Toolbar><Recurse><Test>works</Test></Recurse></DeviceInfo>',
                            'PaginationMode' => 'Another'
        )));

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock)
                ->setSessionId('test');

        $result = $ssrs->render('CSV', array('Toolbar' => true, 'Recurse' => array('Test' => 'works')), 'Another');
    }

    public function testSetExecutionParametersAsArray() {
        $params = array(
            'page' => 1
        );

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockRender2');
        $soapMock->expects($this->once())
                ->method('SetExecutionParameters')
                ->with($this->equalTo(array(
                            'Parameters' => array(
                                array('Name' => 'page', 'Value' => 1),
                            ),
                            'ParameterLanguage' => 'en-us',
        )));

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock)
                ->setSessionId('test');

        $ssrs->setExecutionParameters($params);
    }

    public function testSetExecutionParametersAsClass() {
        $params = new \SSRS\Object\ExecutionParameters(array(
            'page' => 1
        ));

        $soapMock = $this->getMockFromWsdl(dirname(__FILE__) . '/ReportTest/ReportExecution2005.wsdl', 'SoapClientMockRender2');
        $soapMock->expects($this->once())
                ->method('SetExecutionParameters')
                ->with($this->equalTo(array(
                            'Parameters' => array(
                                array('Name' => 'page', 'Value' => 1),
                            ),
                            'ParameterLanguage' => 'en-us',
        )));

        $ssrs = new Report('http://test/ReportServer');
        $ssrs->setSoapExecution($soapMock)
                ->setSessionId('test');

        $ssrs->setExecutionParameters($params);
    }

}
