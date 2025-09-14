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
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');

        // Public catalog page stays public
        $this->Authentication->allowUnauthenticated(['index']);
    }

    /**
     * Public catalog listing (/products or /products/index)
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $query    = $this->Products->find();
        $products = $this->paginate($query);
        $this->set(compact('products'));
    }

    /**
     * Admin dashboard list (/products/dashboard)
     * Renders templates/Products/dashboard.php
     */
    public function dashboard()
    {
        $this->Authorization->skipAuthorization();

        // simple search by name / sku
        $q = trim((string)$this->request->getQuery('q', ''));
        $conditions = [];
        if ($q !== '') {
            $conditions['OR'] = [
                'Products.name LIKE' => "%{$q}%",
                'Products.sku LIKE'  => "%{$q}%",
            ];
        }

        $this->paginate = [
            'order' => ['Products.created' => 'DESC', 'Products.id' => 'DESC'],
            'limit' => 10,
        ];

        $query    = $this->Products->find()->where($conditions);
        $products = $this->paginate($query);

        $this->set(compact('products', 'q'));
        $this->viewBuilder()->setTemplate('dashboard');
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $product = $this->Products->get($id, contain: []);
        $this->Authorization->authorize($product);
        $this->set(compact('product'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        $this->Authorization->authorize($product);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Handle file upload (field name: image)
            $file = $this->request->getData('image');
            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $filename   = time() . '_' . $file->getClientFilename();
                $dir        = WWW_ROOT . 'img' . DS . 'products';
                $targetPath = $dir . DS . $filename;

                if (!is_dir($dir)) {
                    mkdir($dir, 0775, true);
                }
                $file->moveTo($targetPath);
                $data['image_path'] = 'products/' . $filename;
            }

            $product = $this->Products->patchEntity($product, $data);

            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'dashboard']);
            }

            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $this->set(compact('product'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, contain: []);
        $this->Authorization->authorize($product);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());

            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'dashboard']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $this->set(compact('product'));
    }

    /**
     * Delete method
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

        return $this->redirect(['action' => 'dashboard']);
    }
}
