<?php

namespace SSRS\Form\Adapter;

use SSRS\Object\ExecutionInfo;
use SSRS\Object\ReportParameter;
use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\View\Renderer\PhpRenderer;

class ZendFramework2 extends AbstractAdapter {

    /**
     *
     * @var Form
     */
    protected $form;

    public function __construct(ExecutionInfo $executionInfo) {
        if (false === class_exists('\Zend\Form\Form')) {
            throw new \RuntimeException('zendframework/zend-form not found, add to composer.json?');
        }

        parent::__construct($executionInfo);
    }

    public function setExecutionInfo(ExecutionInfo $executionInfo) {
        parent::setExecutionInfo($executionInfo);
        $this->buildForm();
        return $this;
    }

    public function getHTML() {
        $this->checkForGetHTMLZendDependencies();
        $html = null;

        $renderer = new PhpRenderer();
        $formHelperConfig = new \Zend\Form\View\HelperConfig();
        $formHelperConfig->configureServiceManager($renderer->getHelperPluginManager());

        $formRenderer = new \Zend\Form\View\Helper\Form();
        $html .= $formRenderer->openTag($this->form);

        $formRow = new \Zend\Form\View\Helper\FormRow();
        $formRow->setView($renderer);

        foreach ($this->form->getElements() as $key => $element) {
            $html .= '<div id="' . $key . '" class="element">';
            $html .= $formRow->render($element);
            $html .= '</div>' . PHP_EOL;
        }

        $html .= $formRenderer->closeTag();

        return $html;
    }

    public function validate($data) {
        $this->form->setData($data);
        $isValid = $this->form->isValid();
        $normalized = $this->form->getData();
        unset($normalized['ViewReportControl']);

        $validated = new \SSRS\Form\ValidateResult();
        $validated->isValid = $isValid;
        $validated->parameters = $normalized;

        return $validated;
    }

    protected function buildForm() {
        $form = new Form();

        $parameters = $this->getUserParameters();

        // add the elements to the form
        foreach ($parameters as $parameter) {
            $element = $this->buildElement($parameter);
            $form->add($element);
        }

        // modify the input filter
        foreach ($parameters as $parameter) {
            $filter = $form->getInputFilter()->get($parameter->name);
            $filter->setAllowEmpty($parameter->isAllowBlank());
        }

        $submit = new \Zend\Form\Element\Submit('ViewReportControl');
        $submit->setValue('View Report');
        $form->add($submit);

        $this->form = $form;
        return $this;
    }

    public function addCSRFElement($name, $value) {
        $csrf = new \Zend\Form\Element\Hidden($name);
        $csrf->setValue($value);

        $this->form->add($csrf);
        return $this;
    }

    public function getUserParameters() {
        return array_filter($this->executionInfo->getReportParameters(), function(ReportParameter $parameter) {
            return ($parameter->data['PromptUser'] && false === empty($parameter->data['Prompt']));
        });
    }

    protected function buildElement(ReportParameter $parameter) {
        $type = $parameter->getType();
        if (false === in_array($type, array('Integer', 'String', 'Float', 'Boolean', 'DateTime'))) {
            throw new \RuntimeException("Unknown report parameter type '$type'");
        }

        if ($parameter->isSelect()) {
            $element = $this->buildSelect($parameter);
        } else {
            $element = $this->buildText($parameter);
        }

        // set the element label
        $element->setLabel($parameter->data['Prompt']);
        // set the value that ssrs suggests
        $defaults = $parameter->getDefaultValue();
        $default = $parameter->isMultiValue() ? $defaults : (string) array_shift($defaults);
        $element->setValue($default);

        return $element;
    }

    protected function buildText(ReportParameter $parameter) {
        $element = new Text($parameter->name);
        return $element;
    }

    /**
     * 
     * @param ReportParameter $parameter
     * @return \Zend\Form\Element\Select
     */
    protected function buildSelect(ReportParameter $parameter) {
        $element = new Select($parameter->name);

        if ($parameter->isMultiValue()) {
            $element->setAttribute('multiple', true);
        }

        $multiOptions = array();
        foreach ($parameter->getValidValues() as $value) {
            $multiOptions[$value->Value] = $value->Label;
        }

        $element->setValueOptions($multiOptions);

        return $element;
    }

    protected function checkForGetHTMLZendDependencies() {
        if (false === class_exists('\Zend\View\View')) {
            throw new \RuntimeException('zendframework/zend-view not found, add to composer.json?');
        }

        if (false === class_exists('\Zend\ServiceManager\AbstractPluginManager')) {
            throw new \RuntimeException('zendframework/zend-servicemanager not found, add to composer.json?');
        }

        if (false === class_exists('\Zend\I18n\View\Helper\AbstractTranslatorHelper')) {
            throw new \RuntimeException('zendframework/zend-i18n not found, add to composer.json?');
        }

        if (false === class_exists('\Zend\Escaper\Escaper')) {
            throw new \RuntimeException('zendframework/zend-escaper not found, add to composer.json?');
        }
    }

}
