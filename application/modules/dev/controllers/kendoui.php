<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kendoui extends MY_Controller
{
    private $_limit   = 10;
    private $_id_city = 1;
    function __construct()
    {
        parent::__construct();
    }

    function ex1() {
        if ($this->input->is_ajax_request()) {
            $this->_process();
            return;
        }

        # View
        $this->data['limit'] = $this->_limit;
        $this->view          = 'kendoui/ex1';
    }

    function ex2() {
        if ($this->input->is_ajax_request()) {
            $this->_process();
            exit();
        }

        require_once APPPATH . 'libraries/kendoui/Kendo/Autoload.php';

        #--- Demo Datepicker
        $datepicker = new \Kendo\UI\DatePicker('datepicker');
        $datepicker->start('year')->format('MMMM yyyy');
        $this->data['datepicker'] = $datepicker->render();

        #--- Demo Grid
        // Reader
        #$endpoind = base_url('dev/kendoui/grid_read');
        $endpoind = current_url();
        $read = new \Kendo\Data\DataSourceTransportRead();
        $read->url($endpoind);
        $read->contentType('application/json');
        $read->type('POST');

        // Transport
        $transport = new \Kendo\Data\DataSourceTransport();
        $transport->read($read)->parameterMap('function(data) {
                          return kendo.stringify(data);
                        }');

        // Fields
        $idField = new \Kendo\Data\DataSourceSchemaModelField('id');
        $idField->type('string');
        $usernameField = new \Kendo\Data\DataSourceSchemaModelField('username');
        $usernameField->type('string');
        $emailField = new \Kendo\Data\DataSourceSchemaModelField('email');
        $emailField->type('string');
        $created_atField = new \Kendo\Data\DataSourceSchemaModelField('created_at');
        $created_atField->type('string');
        $updated_atField = new \Kendo\Data\DataSourceSchemaModelField('updated_at');
        $updated_atField->type('string');

        // Models
        $model = new \Kendo\Data\DataSourceSchemaModel();
        $model->addField($idField);
        $model->addField($created_atField);
        $model->addField($emailField);
        $model->addField($usernameField);
        $model->addField($updated_atField);

        // Schema
        $schema = new \Kendo\Data\DataSourceSchema();
        $schema->data('data');
        $schema->model($model);
        $schema->total('total');

        // DataSource
        $dataSource = new \Kendo\Data\DataSource();
        $dataSource->transport($transport);
        $dataSource->pageSize($this->_limit);
        $dataSource->schema($schema);
        $dataSource->serverFiltering(true);
        $dataSource->serverSorting(true);
        $dataSource->serverPaging(true);

        // Grid
        $grid   = new \Kendo\UI\Grid('grid');

        // Columns
        $username = new \Kendo\UI\GridColumn();
        $username->field('username');
        $username->width(220);
        $username->title('username');

        $email = new \Kendo\UI\GridColumn();
        $email->field('email');
        $email->filterable(false);
        $email->title('email');

        $created_at = new \Kendo\UI\GridColumn();
        $created_at->field('created_at');
        $created_at->width(170);
        $created_at->format('{0:MM/dd/yyyy}');
        $created_at->title('created_at');

        $updated_at = new \Kendo\UI\GridColumn();
        $updated_at->field('updated_at');
        $updated_at->width(170);
        $updated_at->format('{0:MM/dd/yyyy}');
        $updated_at->title('updated_at');

        $id = new \Kendo\UI\GridColumn();
        $id->field('id');
        $id->width(50);
        $id->title('id');

        $command = new \Kendo\UI\GridColumn();
        $command->addCommandItem('edit');
        $command->addCommandItem('destroy');
        $command->title('&nbsp;');
        $command->width(180);

        // Pageable
        $pageable = new \Kendo\UI\GridPageable();
        $pageable->pageSize($this->_limit);

        $grid->addColumn($id, $username, $email, $created_at, $updated_at, $command);
        $grid->dataSource($dataSource);
        $grid->columnMenu(true);
        $grid->reorderable(true);
        $grid->editable('popup');
        $grid->sortable(true);
        $grid->filterable(true);
        $grid->pageable($pageable);

        $this->data['grid'] = $grid->render();

        $window = new \Kendo\UI\Window('details');
        $window->title('Customer Details');
        $window->modal(true);
        $window->visible(false);
        $window->resizable(false);
        $window->width(300);
        $this->data['window'] = $window->render();

        #--- View
        $this->view = 'kendoui/ex2';
    }

    function _process() {
        # Header response as JSON
        header('Content-Type: application/json');

        # Init API server
        $this->rest->initialize(array('server' => config_item('api_web')));

        $api_param = json_decode(file_get_contents('php://input'), true);
        if (empty($api_param)) {
            $api_param = $_REQUEST;
        }

        $api_result = $this->rest->post('dev/kendoui/index', $api_param, 'json');
        $api_status = $this->rest->status();
        $api_result->request = $api_param;
        echo json_encode($api_result);
    }
}