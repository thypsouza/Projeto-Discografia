
  $(document).ready(function() {
    M.updateTextFields();

    $('select').formSelect();

    $('.modal').modal({
      dismissible: true
    });


    $('.excluir').click(function(){
       let id = $(this).data('id-faixa');
       $('.modal-del').attr('data-faixa-id',id);
    });

    $('.modal-del').click(function(){
        let id = $(this).data('faixa-id');
        let url = "cadastro_faixa.php?del_faixa="+id;
        console.log(url);
        $(this).attr('href', url);
    })
  });







