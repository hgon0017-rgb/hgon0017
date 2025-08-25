<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Http\Client;


/**
 * ContactUs Controller
 *
 * @property \App\Model\Table\ContactUsTable $ContactUs
 */
class ContactUsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Allow the homepage/landing page
        $this->Authentication->addUnauthenticatedActions(['add']);
        $this->Authorization->skipAuthorization();

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ContactUs->find();
        $contactUs = $this->paginate($query);

        $this->set(compact('contactUs'));
    }

    /**
     * View method
     *
     * @param string|null $id Contact U id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contactU = $this->ContactUs->get($id, contain: []);
        $this->set(compact('contactU'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $contactU = $this->ContactUs->newEmptyEntity();
        if ($this->request->is('post')) {

            // --- reCAPTCHA verify (keep everything else as-is) ---
            $token  = (string)$this->request->getData('g-recaptcha-response');
            $secret = (string)\Cake\Core\Configure::read('Recaptcha.secret');

            $http = new \Cake\Http\Client();
            $resp = $http->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secret,
                'response' => $token,
                'remoteip' => $this->request->clientIp(),
            ]);
            $data = (array)$resp->getJson();

            if (empty($data['success'])) {
                $this->Flash->error(__('Please verify you are not a robot.'));
                return $this->redirect($this->referer());
            }
// --- end reCAPTCHA ---

            $contactU = $this->ContactUs->patchEntity($contactU, $this->request->getData());
            if ($this->ContactUs->save($contactU)) {
                //send email
                $mailer = new Mailer('default');
                // set up email params
                $mailer
                    ->setEmailFormat('html')
                    ->setSubject('New enquiry received')
                    ->setTo(Configure::read('EnquiryMailer.to'))
                    ->setFrom(Configure::read('EnquiryMailer.from'))
                    ->viewBuilder()
                    ->setTemplate('contact');

                //send data to email template
                $mailer->setViewVars([
                    'content'   => $contactU->body,
                    'full_name' => $contactU->full_name,
                    'email'     => $contactU->email,
                    'created'   => $contactU->created,
                    'id'        => $contactU->id
                ]);
                //send email
                $email_result = $mailer->deliver();

                $this->Flash->success(__('The enquiry has been saved.'));
                //redirects users to home page after submission instead of the view page
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);

            }
            $this->Flash->error(__('The enquiry could not be saved. Please, try again.'));
        }
        $this->set(compact('contactU'));
    }

    /**
     * Mark as sent method
     *
     * @param string|null $id Contact U id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function mark($id = null)
    {
        $contactU = $this->ContactUs->get($id);
        if ($contactU->email_sent) {
            $this->Flash->error(__('This enquiry is already marked as sent.'));
        }else{
            $contactU->email_sent = true;
            if($this->ContactUs->save($contactU)){
                $this->Flash->success(__('The enquiry has been saved.'));
            }else{
                $this->Flash->error(__('The enquiry could not be saved. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact U id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contactU = $this->ContactUs->get($id);
        if ($this->ContactUs->delete($contactU)) {
            $this->Flash->success(__('The enquiry has been deleted.'));
        } else {
            $this->Flash->error(__('The enquiry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}
