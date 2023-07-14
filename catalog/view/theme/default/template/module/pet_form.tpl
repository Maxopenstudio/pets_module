
<div class="pets">
    <? if(!empty($pets_customer)) { ?>
    <h2><?=$text_pets;?></h2>

    <? foreach($pets_customer as $pet){ ?>
    <div class="pet_row">
        <span><?php echo $pet['name']; ?> <?php echo $pet['breed_name']; ?> <?php echo $pet['age']; ?> <?=$text_month;?></span>
        <button class="btn-danger btn delete-button" data-id="<?php echo $pet['pet_id']; ?>"><?=$text_delete;?></button>
    </div>
    <? } ?>


<? } ?>
</div>


<form id="pet-form" method="POST" action="index.php?route=module/pet_form/addPetsToCustomer">
    <h2><?=$text_add;?></h2>
    <select class="form-control" name="pet_id" id="pet-select">
        <option value=""><?=$text_select_pet;?></option>
        <? foreach($pets as $pet){ ?>
        <option value="<?=$pet['pet_id'];?>"><?=$pet['name'];?></option>
        <? } ?>
    </select>
    <br>
    <select disabled class="form-control" name="breed_id"  id="breed-select">
        <option value=""><?=$text_select_breed;?></option>
    </select>
    <br>
    <select disabled class="form-control" name="gender" id="gender-select">
        <option value="0"><?=$text_select_gender;?></option>
        <option value="1"><?=$text_man;?></option>
        <option value="2"><?=$text_woman;?></option>
    </select>
    <br>
    <input class="form-control required" required  type="number" name="age" id="age-input" placeholder="<?=$text_insert_age;?>">
    <br>
    <input class="form-control"  type="submit" id="submit-button" value="<?=$text_add;?>">
</form>


<script>
    $(document).on('change','#pet-select',function(){
        let pet_id = $(this).val();
        $.ajax({
            url:"index.php?route=module/pet_form/getBreedById",
            method:"POST",
            data:{pet_id:pet_id},
            success:function (data){
                let breeds = JSON.parse(data);
                $('#breed-select').html(`<option value=""><?=$text_select_breed;?></option>`);
                $('#breed-select').removeAttr('disabled');
                breeds.forEach(e=>{
                    let breed_id = e.breed_id;
                    let name = e.name;
                    $('#breed-select').append(`<option value="${breed_id}">${name}</option>`);
                });

                // pet_id = 4 Это РЫБЫ
                if(pet_id!=4){
                    $('#gender-select').removeAttr('disabled');
                }else{
                    $('#gender-select option[value="0"]').prop('selected',true);
                    $('#gender-select').attr('disabled','disabled');
                }


            }
        });
    });
    $('#pet-form').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                $('.error').remove();
               let result = JSON.parse(data);
               if(result.errors){
                   Object.keys(result.errors).forEach(function(key) {
                       let value = result.errors[key];
                       $(`select[name="${key}"],input[name="${key}"]`).after(`<span class="error text-danger">${value}</span>`);
                       console.log("Key: " + key + ", Value: " + value);
                   });
               }else{
                   $('.pets').load('/ .pets');
               }

            }
        });
    });


    $(document).on('click','.delete-button',function() {
        let pet_id = $(this).data('id');
        $.ajax({
            url:"index.php?route=module/pet_form/deletePetByCustomer",
            method:"POST",
            data:{pet_id:pet_id},
            success:function (data){
                $('.pets').load('/ .pets');
            }
        });
    });

</script>

<style>
    .pet_row {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #ddd;
        align-items: center;
        padding-bottom: 20px;
        padding-top: 20px;
    }
</style>

