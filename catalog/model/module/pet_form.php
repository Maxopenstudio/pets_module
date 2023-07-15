<?php

class ModelModulePetForm extends Model
{

    public function getPets()
    {
        $language_id = $this->config->get('config_language_id');
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pet p LEFT JOIN " . DB_PREFIX . "pet_description pd ON(p.id=pd.pet_id) WHERE pd.language_id=" . (int)$language_id);
        return $query->rows;
    }

    public function getBreedByPet($pet_id)
    {
        $language_id = $this->config->get('config_language_id');
        $query = $this->db->query("SELECT pb.id, pbd.name FROM " . DB_PREFIX . "pet_breed pb JOIN " . DB_PREFIX . "pet_breed_description pbd ON pb.id=pbd.breed_id WHERE pbd.language_id='" . (int)$language_id . "' AND pb.pet_id='" . (int)$pet_id . "'");
        return $query->rows;
    }

    public function addPetsToCustomer($data)
    {
        $this->db->query("
    INSERT INTO " . DB_PREFIX . "customer_pets 
    SET pet_id = " . (int)$data['pet_id'] . ",
        breed_id = " . (int)$data['breed_id'] . ",
        gender = " . (int)$data['gender'] . ",
        age = " . (int)$data['age'] . ",
        customer_id = " . (int)$data['customer_id'] . "
");
    }

    public function deletePetByIdOnCustomer($customer_pet_id){
        $this->db->query("DELETE FROM `" . DB_PREFIX . "customer_pets` WHERE `id` = ".(int)$customer_pet_id."");
    }
    public function getPetsByCustomer($customer_id) {
        $query = $this->db->query("SELECT * FROM `".DB_PREFIX."customer_pets` cp WHERE customer_id = '" . (int)$customer_id . "'");
        return $query->rows;
    }
    public function getPetInfo($data){
        $language_id = $this->config->get('config_language_id');
        $result = array();

        $result['pet_name'] = $this->db->query("SELECT name FROM `" . DB_PREFIX . "pet_description` WHERE pet_id=" . (int)$data['pet_id'] . " AND language_id=" . (int)$language_id)->row['name'];
        $result['breed_name'] = $this->db->query("SELECT name FROM `" . DB_PREFIX . "pet_breed_description` WHERE breed_id=" . (int)$data['breed_id'] . " AND language_id=" . (int)$language_id)->row['name'];

        return $result;
    }

}
