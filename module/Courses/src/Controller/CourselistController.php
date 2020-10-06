<?php
namespace Courses\Controller;
use Courses\Form\CourselistForm;
use Courses\Model\Courselist;
use Courses\Model\CourselistTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class CourselistController extends AbstractActionController
{

    private $table;
    //
    public function __construct(CourselistTable $table)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
        return new ViewModel([
            'courselists' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
		$form = new CourselistForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $courselist = new Courselist();
        $form->setInputFilter($courselist->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $courselist->exchangeArray($form->getData());
        $this->table->saveCourselist($courselist);
        return $this->redirect()->toRoute('courselist');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('courselist', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $courselist = $this->table->getCourselist($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('courselist', ['action' => 'index']);
        }

        $form = new CourselistForm();
        $form->bind($courselist);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($courselist->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveCourselist($courselist);

        // Redirect to album list
        return $this->redirect()->toRoute('courselist', ['action' => 'index']);
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('courselist');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCourselist($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('courselist');
    }
		return [
            'id'    => $id,
            'courselist' => $this->table->getCourselist($id),
        ];
    }
}