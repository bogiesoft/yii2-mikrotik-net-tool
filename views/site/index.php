<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Network Tools';
?>
<div class="body-content">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?= $this->render('_form_action', ['model' => $model]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div id="result"></div>
            <div id="bt-test-desc"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 graph-result">

        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div  class="text-center" style="margin-bottom: 10px;"><strong>Processing Request</strong></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">Loading</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
$url_get = \yii\helpers\Url::to(['ajax/fetch-interface']);
$JS = <<<JS

var btWrap = $('#btWrap');
var actionVal = $('input[name="ActionForm[action]"]');
var btDirection = $('input[name="ActionForm[bt_direction]"]:checked');
var hostGraph = $('input[name="ActionForm[router]"][type="radio"]');

btWrap.hide();

if($('input[name="ActionForm[action]"]:checked').val() == "bt"){
    btWrap.show();
}

actionVal.click(function(){
    if($(this).val()=="bt"){
        btWrap.show();
    }else{
        btWrap.hide();
    }
});

hostGraph.change(function(){
    var hv = $(this).val();

    if(hv!=''){
        $.ajax({
            method : 'GET',
            url : '{$url_get}',
            data : { host: hv},
            success : function(data){
                $('.graph-result').html(data);
            },
            error : function(data){
                $('.graph-result').html('<pre>Error processing graph request.</pre>');
            },

        })
    }

});



$('#runAction').on('beforeSubmit',function(e){
    $('#loadingModal').modal({backdrop:'static',keyboard:false});
    var form = $(this);

    $.post(
        form.attr('action'),
        form.serialize()
    ) .done( function(result) {
        if(result != undefined){
            $('#loadingModal').modal('hide');
            if($('input[name="ActionForm[action]"]:checked').val() == "bt"){
                $('#result').html(result);
            }else{
                console.log('test');
                $('#result').html(result);
            }
        }else{
            $('#loadingModal').modal('hide');
            $('#result').html('<pre>Error processing request.</pre>');
        }   
    }) .fail( function() {
        $('#loadingModal').modal('hide');
        $('#result').html('<pre>Error processing request.</pre>');
    });

    return false;

});

JS;

$this->registerJs($JS);
?>