<?php

class ControllerModulePetForm extends Controller
{
    private $error = array();

    public function index()
    {


//      Так как задание тестовое, решил быстро подтянуть все языковые переменные
        $language_variable = $this->language->load('module/pet_form');
        foreach ($language_variable as $key => $value) {
            $data[$key] = $value;
        }
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('pet_form', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/pet_form', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('module/pet_form', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['pet_form_status'])) {
            $data['status'] = $this->request->post['pet_form_status'];
        } else {
            $data['status'] = $this->config->get('pet_form_status');
        }
        if (isset($this->request->post['pet_form_name'])) {
            $data['name'] = $this->request->post['pet_form_name'];
        } else {
            $data['name'] = $this->config->get('pet_form_name');
        }
        $data['success'] = isset($this->session->data['success']) ? $this->session->data['success'] : false;
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/pet_form.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/pet_form')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!strlen($this->request->post['pet_form_name'])) {
            $this->error['name'] = $this->language->get('error_name');
        }
        return !$this->error;
    }

    public function install()
    {
        $this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pet` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ");

        $this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pet_description` (
            `pet_id` INT(11) NOT NULL,
            `language_id` INT(11) NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`pet_id`,`language_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ");

        $this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pet_breed` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `pet_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ");

        $this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pet_breed_description` (
            `breed_id` INT(11) NOT NULL,
            `language_id` INT(11) NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`breed_id`,`language_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "pet` (`id`) VALUES (1), (2), (3), (4);");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "pet_description` (`pet_id`, `language_id`, `name`) VALUES 
    (1, 1, 'Черепаха'), (2, 1, 'Кошка'), (3, 1, 'Собака'), (4, 1, 'Рыбы'),
    (1, 2, 'Turtle'), (2, 2, 'Cat'), (3, 2, 'Dog'), (4, 2, 'Fish')
;");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "pet_breed` (`id`, `pet_id`) VALUES 
    (1, 1), (2, 1), (3, 1), (4, 2), (5, 2), (6, 2), (7, 3), (8, 3), (9, 3), (10, 4), (11, 4), (12, 4);");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "pet_breed_description` (`breed_id`, `language_id`, `name`) VALUES 
    (1, 2, 'Central Asian'), (2, 2, 'American Swamp'), (3, 2, 'Starred Land'),
    (4, 2, 'Abyssinian'), (5, 2, 'Australian Mist'), (6, 2, 'Asian'),
    (7, 2, 'Akita Inu'), (8, 2, 'Alabai'), (9, 2, 'Bernese Mountain Dog'),
    (10, 2, 'Rooster'), (11, 2, 'Angelfish'), (12, 2, 'Ancistrus'),

    (1, 1, 'Среднеазиатская сухопутная'), (2, 1, 'Американская болотная'), (3, 1, 'Звездчатая сухопутная'),
    (4, 1, 'Абиссинская'), (5, 1, 'Австралийский мист'), (6, 1, 'Азиатская'),
    (7, 1, 'Акита-ину'), (8, 1, 'Алабай'), (9, 1, 'Бернский зенненхунд'),
    (10, 1, 'Петушок'), (11, 1, 'Скалярия'), (12, 1, 'Анциструс')
;");

        $this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "customer_pets` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `pet_id` INT(11) NOT NULL,
            `breed_id` INT(11) NOT NULL,
            `gender` INT(1) DEFAULT NULL,
            `age` INT(11) NOT NULL,
            `customer_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ");
    }

    public function uninstall()
    {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "pet`");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "pet_description`");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "pet_breed`");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "pet_breed_description`");
    }
}
