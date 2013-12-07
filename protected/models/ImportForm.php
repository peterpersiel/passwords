<?php

class ImportForm extends CFormModel
{
    public $xml;


    public function rules()
    {
        return array(
            array('xml', 'required'),
            array('xml', 'file', 'types'=>'xml', 'allowEmpty' => true),
            array('xml', 'xmlValid')
        );
    }

    public function xmlValid($attribute, $params) {

        if ($this->hasErrors()) {
            return;
        }

        $dom = new DOMDocument();

        $dom->load($this->xml->getTempName());

        libxml_use_internal_errors(true);

        if (!$dom->schemaValidate('protected/data/' . $this->getScenario() . '.xsd')) {

            $errors = array();

            foreach (libxml_get_errors() as $error) {
                $errors[] = sprintf('XML error "%s" [%d] (Code %d) in %s on line %d column %d' . "\n",
                    $error->message, $error->level, $error->code, $error->file,
                    $error->line, $error->column);
            }

            libxml_clear_errors();

            $this->addError('xml', join("\n", $errors));
        }

    }
}