$(document).ready(function(){


    $(document).on('click','#sendFormFaq',function(){
        if ( $('#sendFormName').val().length == 0 || $('#sendFormEmail').val().length == 0 || $('#sendFormRubrics').val().length == 0 || $('#sendFormQuestion').val().length == 0  ){
            alert('Вы не заполнили поля!');
            return false;
        }
    });



});




