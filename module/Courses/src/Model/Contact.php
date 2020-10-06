<?php      
namespace Courses\Model;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Contact implements InputFilterAwareInterface
{
    public $id;
    public $strContactType;
   
	private $inputFilter;
	
    public function exchangeArray(array $data)
    {
        $this->id   = isset($data['id']) ? $data['id'] : null;
        $this->strContactType = isset($data['strContactType']) ? $data['strContactType'] : null;
       
    }
	
	 public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'strContactType' => $this->strContactType,
            
        ];
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        $inputFilter->add([
            'name' => 'strContactType',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 80,
                    ],
                ],
            ],
        ]);
       

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
	}
}
?>