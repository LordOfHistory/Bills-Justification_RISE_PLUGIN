<div id="form-title" style="text-align:center">
    <h2 style="color:#304FC6">JUSTIFICACIÓN DE GASTOS</h2>
</div>
<div class="clearfix">
    <div class="row">
        <label for="name" class="col-md-2"><?php echo app_lang('title'); ?></label>
        <div class="form-group col-md-10">
            <?php
            echo form_input(array(
                "id" => "name",
                "name" => "name",
                "class" => "form-control",
                "placeholder" => "Name",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <label for="location" class="col-md-2"><?php echo app_lang('location'); ?></label>
        <div class="form-group col-md-10">
            <?php
            echo form_input(array(
                "id" => "location",
                "name" => "location",
                "class" => "form-control",
                "placeholder" => "City, country",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>   
    </div>
    <div class="row">
        <label for="project-code" class="col-md-2"><?php echo app_lang('code'); ?></label>
        <div class="form-group col-md-2">
            <?php
            echo form_input(array(
                "id" => "project-code",
                "name" => "project-code",
                "class" => "form-control",
                "placeholder" => "Code",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>

        <label for="start_date" class="col-md-2"><?php echo app_lang('start_date'); ?></label>
        <div class="form-group col-md-2">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "class" => "form-control datepicker",
                "placeholder" => "MM/DD/YYYY",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required")
            ));
            ?>
        </div>

        <label for="end_date" class="col-md-2"><?php echo app_lang('end_date'); ?></label>
        <div class="form-group col-md-2">
            <?php
            echo form_input(array(
                "id" => "end_date",
                "name" => "end_date",
                "class" => "form-control datepicker",
                "placeholder" => "MM/DD/YYYY",
                "autocomplete" => "off",
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
                "data-rule-greaterThanOrEqual" => "#start_date",
                "data-msg-greaterThanOrEqual" => app_lang("end_date_must_be_equal_or_greater_than_start_date")
            ));
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "class" => "form-control",
                "placeholder" => app_lang('description'),
                "required" => "true",
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
            ));
            ?>
        </div>
    </div>
</div>

<div id="form2-title">
    <h4 style="color:#304FC6">Añadir gastos</h4>
</div>
<div class="form-group" id="insert-zone">
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <?php
            echo form_input(array(
                "id" => "expenses_adder",
                "name" => "expenses_adder",
                "class" => "form-control",
                "placeholder" => app_lang('type')
            ));
            ?>
        </div>
        <div class="col-md-3">
            <input class="btn btn-primary" type="button" value="+" title="<?php echo(app_lang("add"))?>" onclick="add_input()"/>
        </div>
    </div>
</div>

<div id="form2-title">
    <h4 style="color:#304FC6">Total</h4>
</div>
<div class="form-group">
    <div class="row">
        <label for="total" class="col-md-3">Total expense justified</label>
        <div class="col-md-3">
            <span id="total-value">0.00</span> €
        </div>
    </div>
</div>

<script type="text/javascript">
    "use strict";
    var continuousid;
    var costedelkm = 0.2;

    $(document).ready(function () {
        continuousid = 0;
        $("#expenses_adder").select2({
            minimumResultsForSearch: 5,
            multiple: false,
            data: <?php 
                $input_categories = array(
                    array("id" => "0", "text" => app_lang("comida")),
                    array("id" => "1", "text" => app_lang("transporte-publico")),
                    array("id" => "2", "text" => app_lang("kilometraje")),
                    array("id" => "3", "text" => app_lang("alojamiento")),
                    array("id" => "4", "text" => app_lang("otros")),
                );
            echo (json_encode($input_categories)); ?>
        });
    });

    function add_input(){
        var inputvalue = document.getElementById("expenses_adder").value;
        if (inputvalue == ""){
            appAlert.success('<?php echo app_lang("exjus_selecttype")?>', {duration: 5000});
        }
        else{
            var zona = document.getElementById("insert-zone");
            const div = document.createElement("div");
            continuousid += 1;
            div.setAttribute("id","card-container-"+continuousid);
            div.setAttribute("class","card-container");
            div.setAttribute("style","padding:20px")
        
            
            switch (inputvalue){
                case ("1"):
                    div.innerHTML = getTransportChunk(inputvalue, continuousid);
                    zona.appendChild(div);
                    break;
                case ("2"):
                    div.innerHTML = getKilometrageChunk(inputvalue, continuousid);
                    zona.appendChild(div);
                    break;
                default:
                    div.innerHTML = getGeneralChunk(inputvalue, continuousid);
                    zona.appendChild(div);
                    break;
            }
            $(".datepicker").datepicker({
            orientation: "bottom left"});

            $(".textarea").each(function () {
                this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
            }).on("input", function () {
                this.style.height = 0;
                this.style.height = (this.scrollHeight) + "px";
            });
        }
    }

    function sumaValores(){
        var total = parseFloat("0");
        var gastos = document.getElementsByClassName("money-input");
        for (var i = 0; i<gastos.length; i++){
            if (gastos[i].value != "" && gastos[i].value != null)
                total += parseFloat(gastos[i].value);
        }
        var totalelement = document.getElementById("total-value");
        totalelement.innerText = total.toFixed(2)==NaN?total:total.toFixed(2);
    }

    function removeInputField(id){
        var chunks = id.split("-");
        var elementid = "card-container-"+chunks[2];
        var element = document.getElementById(elementid);
        element.parentNode.removeChild(element);
        sumaValores();
    }

    function calculaKm(kms, blockid){
        var money = parseFloat(kms)*parseFloat(costedelkm);
        var inputid = "price-"+blockid.split("-")[1];
        var textid = "kmcost-"+blockid.split("-")[1];
        document.getElementById(inputid).value = money.toFixed(2)==NaN?money:money.toFixed(2);
        document.getElementById(textid).innerText = money.toFixed(2)==NaN?money:money.toFixed(2);
        sumaValores();
    }

    function cambiaCocheAlquilado(id){
        var value = document.getElementById("rentacar-"+id).checked;
        var textosino = document.getElementById("si-no-text-"+id);
        var inputmoney = document.getElementById("carprice-"+id);
        var costext = document.getElementById("coste-text-"+id);
        var eurotext = document.getElementById("euro-text-"+id);
        if (value){
            inputmoney.style.visibility = "visible";
            costext.style.visibility = "visible";
            eurotext.style.visibility = "visible";
            textosino.innerText = " <?php echo app_lang("yes");?>";
        }
        else{
            inputmoney.value= 0;
            inputmoney.style.visibility = "hidden";
            costext.style.visibility = "hidden";
            eurotext.style.visibility = "hidden";
            textosino.innerText = " <?php echo app_lang("no");?>";
            sumaValores();
        }
    }

    function getKilometrageChunk(tipeid,id){
        

        var app_lang = Array("<?php echo app_lang("comida")?>",
                             "<?php echo app_lang("transporte-publico")?>",
                             "<?php echo app_lang("kilometraje")?>",
                             "<?php echo app_lang("alojamiento")?>",
                             "<?php echo app_lang("otros")?>");

        var htmlcode = `
        <input type="hidden" name="category-`+id+`" value="`+tipeid+`" />
        <div class="cardrow">
            <div style="width:80%" class="cardrow">
                <h5 class="item">`+app_lang[tipeid]+`</h5>
            </div>
            <div style="width:20%; text-align:right">
                <a href="#" id="rem-button-`+id+`" style="margin-right:10px; font-size: 20px" onclick="removeInputField(this.id)">x</a>
            </div>
        </div>
        <div class="form-group">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="name-`+id+`" class="item"><?php echo app_lang('title'); ?>: </label>
                </div>
                <div class="col-md-10">
                    <input type="text" name="name-`+id+`" id="name-`+id+`" class="form-control" placeholder="<?php echo app_lang("title")?>" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido." hidden/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="from-`+id+`" class="item"><?php echo app_lang('from'); ?>: </label>
                </div>
                <div class="col-md-3">
                    <input type="text" name="from-`+id+`" id="from-`+id+`" class="form-control" placeholder="City, country" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
                <div class="col-md-1">
                    <label for="to-`+id+`" class="item"><?php echo app_lang('to'); ?>: </label>
                </div>
                <div class="col-md-3">
                    <input type="text" name="to-`+id+`" id="to-`+id+`" class="form-control" placeholder="City, country" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
                <div class="col-md-1">
                    <label for="date-`+id+`" class="item"><?php echo app_lang('date'); ?>: </label>
                </div>
                <div class="col-md-2">
                    <input type="text" name="date-`+id+`" id="date-`+id+`" class="form-control datepicker" placeholder="MM/DD/YYYY" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="rentacar-`+id+`" class="item"><?php echo app_lang('rented-car'); ?>: </label>
                </div>
                <div class="col-md-3" style="padding-top:14px">
                    <input type="checkbox" onchange="cambiaCocheAlquilado(this.id.split('-')[1])" value="true" name="rentacar-`+id+`" id="rentacar-`+id+`"/> 
                    <span id="si-no-text-`+id+`"> <?php echo app_lang("no")?></span>
                </div>
                <div class="col-md-1"/>
                    <p id="coste-text-`+id+`" class="item" style="visibility:hidden"><?php echo app_lang("expense")?>:</p>
                </div>
                <div class="col-md-3">
                    <input type="number" style="visibility:hidden; text-align:right" step="0.01" name="carprice-`+id+`" id="carprice-`+id+`" class="form-control money-input" placeholder="0,00" onchange="sumaValores()" autocomplete="off"/>
                </div>
                <div class="col-md-1" style="padding-top:10px"/>
                    <p id="euro-text-`+id+`" style="visibility:hidden">€</p>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="km-`+id+`" class="item"><?php echo app_lang('kilometers'); ?>: </label>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" style="text-align:right;" name="km-`+id+`" id="km-`+id+`" class="form-control" onchange="calculaKm(this.value,this.id)" placeholder="0,00" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                    <input type="hidden" class="money-input" value="0" id="price-`+id+`" name="price-`+id+`"/>
                </div>
                <div class="col-md-4">
                    <label for="km-`+id+`" class="item" style="margin-top:10px">km <?php echo app_lang("paid-at")?> `+costedelkm+`€/km.</label>
                </div>
                <div class="col-md-1">
                    <label for="date-`+id+`" class="item"><?php echo app_lang('total'); ?> <?php echo strtolower(app_lang('kilometraje'))?>: </label>
                </div>
                <div class="col-md-2">
                    <span id="kmcost-`+id+`">0</span> €
                </div>   
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="description-`+id+`" class="item"><?php echo app_lang('description'); ?>: </label>
                </div>
                <div class="col-md-10" >
                    <textarea name="description-`+id+`" cols="40" rows="10" class="form-control textarea" placeholder="Descripción" required="false"  style="height:73px;overflow-y:hidden;"></textarea>
                </div>
            </div>

            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label class="item" for="files-`+id+`" class="col-md-3"><?php echo app_lang('files'); ?>: </label>
                </div>
                <div class="col-md-10">
                    <input type="file" id="file-`+id+`" name="files-`+id+`[]" multiple required="true" onchange="preview('file-`+id+`','display-file-`+id+`')"/>
                </div>
            </div>
            <div class="row" id="display-file-`+id+`" style="padding:10px">
            </div>  
        </div>
               
        `;
        return htmlcode;
    }

    function getTransportChunk(tipeid,id){
        var app_lang = Array("<?php echo app_lang("comida")?>",
                             "<?php echo app_lang("transporte-publico")?>",
                             "<?php echo app_lang("kilometraje")?>",
                             "<?php echo app_lang("alojamiento")?>",
                             "<?php echo app_lang("otros")?>");

        var htmlcode = `
        <input type="hidden" name="category-`+id+`" value="`+tipeid+`" />
        <div class="cardrow">
            <div style="width:80%" class="cardrow">
                <h5 class="item">`+app_lang[tipeid]+`</h5>
            </div>
            <div style="width:20%; text-align:right">
                <a href="#" id="rem-button-`+id+`" style="margin-right:10px; font-size: 20px" onclick="removeInputField(this.id)">x</a>
            </div>
        </div>
        <div class="form-group">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="name-`+id+`" class="item"><?php echo app_lang('title'); ?>: </label>
                </div>
                <div class="col-md-10">
                    <input type="text" name="name-`+id+`" id="name-`+id+`" class="form-control" placeholder="<?php echo app_lang("title")?>" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="from-`+id+`" class="item"><?php echo app_lang('from'); ?>: </label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="from-`+id+`" id="from-`+id+`" class="form-control" placeholder="City, country" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
                <div class="col-md-1">
                    <p> </p>
                </div>
                <div class="col-md-1">
                    <label for="to-`+id+`" class="item"><?php echo app_lang('to'); ?>: </label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="to-`+id+`" id="to-`+id+`" class="form-control" placeholder="City, country" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="price-`+id+`" class="item"><?php echo app_lang('expense'); ?>: </label>
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" style="text-align:right;" name="price-`+id+`" id="price-`+id+`" onchange="sumaValores()" class="money-input form-control" placeholder="0,00" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
                <div class="col-md-1">
                    <label for="price-`+id+`" class="item" style="margin-top:10px">€</label>
                </div>
                <div class="col-md-1">
                    <label for="date-`+id+`" class="item"><?php echo app_lang('date'); ?>: </label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="date-`+id+`" id="date-`+id+`" class="form-control datepicker" placeholder="MM/DD/YYYY" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="description-`+id+`" class="item"><?php echo app_lang('description'); ?>: </label>
                </div>
                <div class="col-md-10" >
                    <textarea name="description-`+id+`" cols="40" rows="10" class="form-control textarea" placeholder="Descripción" required="false"  style="height:73px;overflow-y:hidden;"></textarea>
                </div>
            </div>

            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label class="item" for="files-`+id+`" class="col-md-3"><?php echo app_lang('files'); ?>: </label>
                </div>
                <div class="col-md-10">
                    <input type="file" id="file-`+id+`" name="files-`+id+`[]" multiple required="true" onchange="preview('file-`+id+`','display-file-`+id+`')"/>
                </div>
            </div>
            <div class="row" id="display-file-`+id+`" style="padding:10px">
            </div>  
        </div>
               
        `;
        return htmlcode;
    }

    function  getGeneralChunk(tipeid,id){
        var app_lang = Array("<?php echo app_lang("comida")?>",
                             "<?php echo app_lang("transporte-publico")?>",
                             "<?php echo app_lang("kilometraje")?>",
                             "<?php echo app_lang("alojamiento")?>",
                             "<?php echo app_lang("otros")?>");
    
        var htmlcode = `
        
        <input type="hidden" name="category-`+id+`" value="`+tipeid+`" />
        <div class="cardrow">
            <div style="width:80%" class="cardrow">
                <h5 class="item">`+app_lang[tipeid]+`</h5>
            </div>
            <div style="width:20%; text-align:right">
                <a href="#" id="rem-button-`+id+`" style="margin-right:10px; font-size: 20px" onclick="removeInputField(this.id)">x</a>
            </div>
        </div>
        <div class="form-group">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="name-`+id+`" class="item"><?php echo app_lang('title'); ?>: </label>
                </div>
                <div class="col-md-10">
                    <input type="text" name="name-`+id+`" id="name-`+id+`" class="form-control" placeholder="<?php echo app_lang("title")?>" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="price-`+id+`" class="item"><?php echo app_lang('expense'); ?>: </label>
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" style="text-align:right;" name="price-`+id+`" id="price-`+id+`" class="money-input form-control" onchange="sumaValores()" placeholder="0,00" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
                <div class="col-md-1">
                    <label for="price-`+id+`" class="item" style="margin-top:10px">€</label>
                </div>
                <div class="col-md-1">
                    <label for="date-`+id+`" class="item"><?php echo app_lang('date'); ?>: </label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="date-`+id+`" id="date-`+id+`" class="form-control datepicker" placeholder="MM/DD/YYYY" autocomplete="off" required="true" data-rule-required="1" data-msg-required="Este campo es requerido."/>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label for="description-`+id+`" class="item"><?php echo app_lang('description'); ?>: </label>
                </div>
                <div class="col-md-10" >
                    <textarea name="description-`+id+`" cols="40" rows="10" class="form-control textarea" placeholder="Descripción" required="false"  style="height:73px;overflow-y:hidden;"></textarea>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-1">
                    <label class="item" for="files-`+id+`" class="col-md-3"><?php echo app_lang('files'); ?>: </label>
                </div>
                <div class="col-md-10">
                    <input type="file" id="file-`+id+`" name="files-`+id+`[]" multiple required="true" onchange="preview('file-`+id+`','display-file-`+id+`')"/>
                </div>
            </div>
            <div class="row" id="display-file-`+id+`" style="padding:10px">
            </div>  
        </div>
               
        `;
        return htmlcode;
    }
</script>

<style>
 .card-container{
    border: 2px solid #2E86C1;
    background-color: white;
    margin-bottom: 10px;
    border-radius: 7px;
 }
 .cardrow{
    display:flex;
    justify-content:start;
    flex-wrap: wrap;
 }
 .item{
    margin-left: 10px;
 }
 </style>