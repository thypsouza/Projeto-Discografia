
  $(document).ready(function() {
    M.updateTextFields();

    $('.modal').modal({
      dismissible: true
    });


    $('.excluir').click(function(){
       let id = $(this).data('id-album');
       $('.modal-del').attr('data-album-id',id);
    });

    $('.modal-del').click(function(){
        let id = $(this).data('album-id');
        let url = "cadastro_album.php?del_album="+id;
        console.log(url);
        $(this).attr('href', url);
    })
  });


