<?php
namespace Courses\Form;

use Laminas\Form\Form;

class CourselistForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('courselist');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'strCourseDescription',
            'type' => 'text',
            'options' => [
                'label' => 'Descripcion',
            ],
        ]);
        $this->add([
            'name' => 'curCourseCost',
            'type' => 'text',
            'options' => [
                'label' => 'costo del curso',
            ],
        ]);
        $this->add([
            'name' => 'intCourseDurationYears',
            'type' => 'text',
            'options' => [
                'label' => 'duracion del curso',
            ],
        ]);
        $this->add([
            'name' => 'memNotes',
            'type' => 'text',
            'options' => [
                'label' => 'Notas',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}