<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class ProductsController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
        $this->Authentication->allowUnauthenticated(['index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        // Always start with a query from DB
        $query = $this->Products->find();
        $products = $this->paginate($query);
        $this->set(compact('products'));
    }


    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, contain: []);
        $this->Authorization->authorize($product);
        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        $this->Authorization->authorize($product);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // --- Handle file upload ---
            $file = $this->request->getData('image'); // 'image' matches the form field name
            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                // Create a unique filename to avoid overwriting
                $filename = time() . '_' . $file->getClientFilename();

                // Define target path inside /webroot/img/products/
                $targetPath = WWW_ROOT . 'img' . DS . 'products' . DS . $filename;

                // Make sure the directory exists (create if not)
                if (!is_dir(WWW_ROOT . 'img' . DS . 'products')) {
                    mkdir(WWW_ROOT . 'img' . DS . 'products', 0775, true);
                }

                // Move uploaded file to target path
                $file->moveTo($targetPath);

                // Save relative path to database (e.g. "products/xxxx.jpg")
                $data['image_path'] = 'products/' . $filename;
            }

            // Patch entity with submitted data
            $product = $this->Products->patchEntity($product, $data);

            // Save product record
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            // Error message if save fails
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $this->set(compact('product'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, contain: []);
        $this->Authorization->authorize($product);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        $this->Authorization->authorize($product);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
