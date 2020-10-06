<?php
namespace Courses\Controller;
use Courses\Form\JpositionForm;
use Courses\Model\Jposition;
use Courses\Model\JpositionTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class JpositionController extends AbstractActionController
{

    private $table;
    //
    public function __construct(JpositionTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'jpositions' => $this->table->fetchAll(),
        ]);
    }
    public function addAction()
    {
		$form = new JpositionForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $jposition = new Jposition();
        $form->setInputFilter($jposition->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $jposition->exchangeArray($form->getData());
        $this->table->saveJposition($jposition);
        return $this->redirect()->toRoute('jposition');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('jposition', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $jposition = $this->table->getJposition($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('jposition', ['action' => 'index']);
        }

        $form = new JpositionForm();
        $form->bind($jposition);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($jposition->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveJposition($jposition);

        // Redirect to album list
        return $this->redirect()->toRoute('jposition', ['action' => 'index']);
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('jposition');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteJposition($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('jposition');
    }
		return [
            'id'    => $id,
            'jposition' => $this->table->getJposition($id),
        ];
    }
}