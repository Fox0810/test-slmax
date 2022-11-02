</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
</body>
<script>
  // предусматриваем валидность ввода даты
  $("#date").mask("9999-99-99", {placeholder: "гггг.мм.дд" });

  // JavaScript для удаления cdtltybq
  $(document).on('click', '.delete-object', function()
  {
      const id = $(this).attr('delete-id');
      //использование bootbox сообщений
      bootbox.confirm({
          message: "<h4>Вы уверены?</h4>",
          buttons: {
              confirm: {
                  label: '<span class="glyphicon glyphicon-ok"></span> Да',
                  className: 'btn-danger'
              },
              cancel: {
                  label: '<span class="glyphicon glyphicon-remove"></span> Нет',
                  className: 'btn-primary'
              }
          },
          // Использование AJAX в случае подтверждения удаления
          callback: function (result)
          {
              if (result == true) {
                  $.post('delete_person.php', {
                      object_id: id
                  }, function(data){
                      location.reload();
                  }).fail(function() {
                      alert('Невозможно удалить.');
                  });
              }
          }
      });

      return false;
  });
</script>
</html>
