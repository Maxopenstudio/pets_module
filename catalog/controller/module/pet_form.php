<?php
class ControllerModulePetForm extends Controller {
    private $error=array();
	public function index() {

        if(!$this->customer->isLogged()){
            return ;
        }

        $this->load->language('module/pet_form');
		$this->load->model('module/pet_form');
        $model = "model_module_pet_form";

        $data['pets']=array();
        $data['pets_customer']=array();
        $pets = $this->{$model}->getPets();
        $pets_customer = $this->{$model}->getPetsByCustomer($this->customer->getId());

        foreach ($pets as $pet){
            $data['pets'][]=array(
                'pet_id'=>$pet['id'],
                'name'=>$pet['name']
            );
        }

        foreach ($pets_customer as $pet){
            $pet_info = $this->{$model}->getPetInfo($pet);
            $data['pets_customer'][]=array(
                'pet_id'=>$pet['id'],
                'name'=>$pet_info['pet_name'],
                'breed_name'=>$pet_info['breed_name'],
                'age'=>$pet['age'],
                'gender'=>$pet['gender'],
            );
        }
        $data['text_pets'] = $this->language->get('text_pets');
        $data['text_month'] = $this->language->get('text_month');
        $data['text_delete'] = $this->language->get('text_delete');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_select_pet'] = $this->language->get('text_select_pet');
        $data['text_select_breed'] = $this->language->get('text_select_breed');
        $data['text_select_gender'] = $this->language->get('text_select_gender');
        $data['text_insert_age'] = $this->language->get('text_insert_age');
        $data['text_man'] = $this->language->get('text_man');
        $data['text_woman'] = $this->language->get('text_woman');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pet_form.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/pet_form.tpl', $data);
		} else {
			return $this->load->view('default/template/module/pet_form.tpl', $data);
		}

	}

    public function getBreedById(){
        if(!$this->customer->isLogged()){
            return ;
        }
        $pet_id = $this->request->post['pet_id'];
        $model = "model_module_pet_form";
        $this->load->model('module/pet_form');
        $breeds = $this->{$model}->getBreedByPet($pet_id);
        $result = array();
        foreach ($breeds as $breed){
            $result[]=array(
                'breed_id'=>$breed['id'],
                'name'=>$breed['name'],
            );
        }

        echo json_encode($result,JSON_UNESCAPED_UNICODE);

    }

    public function addPetsToCustomer(){
        if(!$this->customer->isLogged()){
            return ;
        }
        $model = "model_module_pet_form";
        $this->load->model('module/pet_form');
        $data=array();
        if($this->validate()){

        $data['pet_id']= $this->request->post['pet_id'];
        $data['breed_id']= $this->request->post['breed_id'];
        $data['gender']= isset($this->request->post['gender']) ? $this->request->post['gender'] : 0;
        $data['age']= $this->request->post['age'];
        $data['customer_id']= $this->customer->getId();
        $this->{$model}->addPetsToCustomer($data);
        $this->error['errors'] =false;
            echo json_encode($this->error,JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode($this->error,JSON_UNESCAPED_UNICODE);
        }
    }
    public function deletePetByCustomer(){
        if(!$this->customer->isLogged()){
            return ;
        }
        $pet_id = $this->request->post['pet_id'];
        $model = "model_module_pet_form";
        $this->load->model('module/pet_form');
        $this->{$model}->deletePetByIdOnCustomer($pet_id);

    }


    public function validate(){
        $this->load->language('module/pet_form');

        if(!isset($this->request->post['pet_id']) || !$this->request->post['pet_id']){
            $this->error['errors']['pet_id']=$this->language->get('error_pet');
        }
        if(!isset($this->request->post['breed_id']) || !$this->request->post['breed_id']){
            $this->error['errors']['breed_id']=$this->language->get('error_breed');
        }
        if(!isset($this->request->post['age']) || !$this->request->post['age']){
            $this->error['errors']['age']=$this->language->get('error_age');
        }
        if(!isset($this->request->post['gender']) || !$this->request->post['gender']){
            $this->error['errors']['gender']=$this->language->get('error_gender');
        }
        return !$this->error;
    }


}
