<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Client;
use Cake\Mailer\Mailer;
use Cake\Log\Log;

/**
 * ContactUs Controller
 *
 * @property \App\Model\Table\ContactUsTable $ContactUs
 */
class ContactUsController extends AppController
{
    public function beforeFilter(EventInterface|\App\Controller\EventInterface $event): void
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
        $this->viewBuilder()->setLayout('admin');

        $this->Authorization->skipAuthorization();
        $query = $this->ContactUs->find()
            ->order(['created' => 'DESC']);
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
    public function view(?string $id = null)
    {
        $this->viewBuilder()->setLayout('admin');
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
            $secret = (string)Configure::read('Recaptcha.secret');

            $http = new Client();
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
                // send email (with safe fallbacks)
                $to   = Configure::read('EnquiryMailer.to');
                $from = Configure::read('EnquiryMailer.from') ?: Configure::read('Email.default.from');

                if ($to) {
                    $mailer = new Mailer('default');
                    $mailer->setEmailFormat('html')
                        ->setSubject('New enquiry received')
                        ->setTo($to)
                        ->setFrom($from)
                        ->setReplyTo([$contactU->email => $contactU->full_name ?: null])
                        ->viewBuilder()->setTemplate('contact');

                    $mailer->setViewVars([
                        'content'   => $contactU->description,
                        'full_name' => $contactU->full_name,
                        'email'     => $contactU->email,
                        'created'   => $contactU->created,
                        'id'        => $contactU->id,
                    ]);

                    try {
                        $mailer->deliver();
                    } catch (\Throwable $e) {
                        Log::error('Mailer deliver failed: ' . $e->getMessage());
                    }
                } else {
                    Log::error('EnquiryMailer.to is not configured.');
                }

                $this->Flash->success(__('The enquiry has been saved.'));
                return $this->redirect(['controller' => 'ContactUs', 'action' => 'add']);
            }

            Log::debug('ContactUs save errors: ' . json_encode($contactU->getErrors(), JSON_UNESCAPED_SLASHES));
            $this->Flash->error(__('The enquiry could not be saved. Please, try again.'));
        }

        $this->set(compact('contactU'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact U id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->viewBuilder()->setLayout('admin');

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
