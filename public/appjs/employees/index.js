var app_datatable;
var add_mode = false;

$(function() {
    app_datatable = $("#data_list").DataTable({
        processing: true,
        serverSide: true,
        ajax: urlRoot + '/employees/datatable',
        columnDefs: [
          {
            "targets": 0,
            "data": 'name',
          },
          {
            "targets": 1,
            "data": 'country',
          },
          {
            "targets": 2,
            "data": 'age',
          },
        ]
    });
});

$('a.btn_add').click(function() {
    // hide if already add mode
    if (add_mode) {
      $('form.form_add').parent('div').addClass('hidden');
    } else {
      // otherwise, show it
      clearInput();
      $('form.form_add').parent('div').removeClass('hidden');
    }

    add_mode = !add_mode;
})

function clearInput() {
    $('input[name=first_name]').val("");
    $('input[name=last_name]').val("");
    $('input[name=age]').val("");
    $('select[name=country_id]').val("");
}

$('form.form_add').submit(function() {
  var form_data = $(this).serialize();

  // remove all error marker and message
  $(this).find('.form-group.has-error').removeClass('has-error');
  $(this).find('[data-original-title]').each(function() {
    this.title = $(this).data('originalTitle');
  })

  $.post(urlRoot + '/employees', form_data)
   .done(function(data) {
    console.log(data);
    alert('Data saved');

    clearInput();

    // reload datatable
    app_datatable.ajax.reload();
   })
   .fail(function(jqXhr) {
     console.error(jqXhr);

     if (jqXhr.status == 422) {
      // set error element
      Object.keys(jqXhr.responseJSON).forEach(function(elm) {
        console.log(elm);
        $('[name="' + elm + '"]').closest('.form-group').addClass('has-error');
        $('[name="' + elm + '"]').data('originalTitle', $('[name="' + elm + '"]')[0].title);
        $('[name="' + elm + '"]')[0].title = jqXhr.responseJSON[elm][0];
      });

      alert('Please check your data!');
     } else {
      alert('Error saving data');
     }
  });
  return false;
});