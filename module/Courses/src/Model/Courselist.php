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
use Laminas\Filter\ToFloat;
class Courselist implements InputFilterAwareInterface
{
    public $id;
    public $strCourseDescription;
    public $curCourseCost;
    public $intCourseDurationYears;
    public $memNotes;
	private $inputFilter;
	
    public function exchangeArray(array $data)
    {
        $this->id   = isset($data['id']) ? $data['id'] : null;
        $this->strCourseDescription = isset($data['strCourseDescription']) ? $data['strCourseDescription'] : null;
        $this->curCourseCost  = isset($data['curCourseCost']) ? $data['curCourseCost'] : null;
        $this->intCourseDurationYears     = isset($data['intCourseDurationYears']) ? $data['intCourseDurationYears'] : null;
        $this->memNotes = isset($data['memNotes']) ? $data['memNotes'] : null;
       
    }
	
	 public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'strCourseDescription' => $this->strCourseDescription,
            'curCourseCost'  => $this->curCourseCost,
            'intCourseDurationYears'  => $this->intCourseDurationYears,
            'memNotes'  => $this->memNotes,
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
            'name' => 'strCourseDescription',
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
        $inputFilter->add([
            'name' => 'curCourseCost',
            'required' => true,
            'filters' => [
                ['name' => ToFloat::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'intCourseDurationYears',
            'required' => true,
            'filters' => [
                ['name' => Toint::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'memNotes',
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