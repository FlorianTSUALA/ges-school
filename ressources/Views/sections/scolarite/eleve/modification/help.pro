<select id="pays" class="select2 js-example-programmatic form-control" name="pays" >
    <option value="" disabled>- Choissisez une nationalité -</option>
    <?php foreach($pays as $item){?>
            <option  <?= (($eleve['pays_id']??"") == $item['id'])?"selected":"" ?>  value="<?= $item['id']; ?>"><?= $item['value']; ?></option>
    <?php } ?>
</select>




<div class="col-5">
    <input name="sexe" id="sexe-01" type="radio" class="cke_button__radio_icon"  value="F" <?= (($eleve['sexe']??"") == 'F')?"checked":"" ?>>
    <label for="sexe-01" class="">Madame</label>
</div>


<input placeholder="fonction du personnel" type="text" class="form-control required"  value="<?= $eleve['fonction']??" " ?>" id="fonction" name="fonction"  />


<input type="file" class="inputfile" style="display: none;"  accept="image/*" name="photo" id="photo" onchange="readURL(this, '.photo');" />
<label for="photo" style="  display: block; margin-left: auto; margin-right: auto;">
    <figure>
        <img title="cliquer pour modifier une photo" width="200px" height="200px"  src="<?= URL::upload() ?>ressources/uploads/img/personnel/<?= $personnel['photo']??"no-photo.jpg" ?>" alt="" class="photo" class="center">
    </figure>
</label>


<input type="email" placeholder="Adresse email du personnel" class="form-control"  value="<?= $personnel['email']??"" ?>" id="email" name="email" />


<input type="date" class="form-control"  value="<?= Helpers::format($personnel['date_prise_service'])??date("Y-m-D") ?>" id="date_prise_service" name="date_prise_service" />

<textarea placeholder="Autres informations du personnel"  type="text" style="min-width: 100%;" class="form-control" id="autres" name="autres" ><?= $personnel['autres']??" " ?></textarea>
