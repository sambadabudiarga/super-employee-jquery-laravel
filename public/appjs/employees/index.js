var app_datatable;
var add_mode = false;

$(function() {
    app_datatable = $("#data_list").DataTable({
        processing: true,
        serverSide: true,
        createdRow: function(row, data, dataIndex) {
          $(row).css('cursor', 'pointer');
        },
        rowId: function(a) {
          return 'rowId_' + a.id;
        },
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
  $('.form_view').addClass('hidden');

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
  $('input[name=avatar]').val("");
  $('a.btn_upload_pp').find('img').remove();
  $('a.btn_upload_pp').find('i.fa').remove();
  $('a.btn_upload_pp').append('<i class="fa fa-user" style="font-size: 120px"></i>');
  $('input[name=first_name]').val("");
  $('input[name=last_name]').val("");
  $('input[name=age]').val("");
  $('select[name=country_id]').val("");
}

$('form.form_add').submit(function(e) {
  e.preventDefault();

  // remove all error marker and message
  $(this).find('.form-group.has-error').removeClass('has-error');
  $(this).find('[data-original-title]').each(function() {
    this.title = $(this).data('originalTitle');
  })

  $.ajax({
    url: urlRoot + '/employees', 
    type: 'post',
    data: new FormData($('#form_add')[0]),
    processData: false,
    contentType: false,
  })
   .done(function(data) {
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
        $('[name="' + elm + '"]').closest('.form-group').addClass('has-error');
        $('[name="' + elm + '"]').data('originalTitle', $('[name="' + elm + '"]')[0].title);
        $('[name="' + elm + '"]')[0].title = jqXhr.responseJSON[elm][0];
      });

      alert('Please check your data!');
     } else {
      alert('Error saving data');
     }
  });
});

$('.btn_upload_pp').click(function() {
  $('input[name=avatar]').click();
  return false;
});

$('input[name=avatar]').change(function(e) {
  // remove fa and image (if any)
  $(this).closest('div').find('a.btn_upload_pp').find('i.fa').remove();
  $(this).closest('div').find('a.btn_upload_pp').find('img').remove();

  // ganti dengan image
  $(this).closest('div').find('a.btn_upload_pp').append('<img src="' + URL.createObjectURL(e.target.files[0]) + '" style="width: 50%; border-radius: 50%;">');
});

$("table tbody").on('click', 'tr', function() {
  var data_id = this.id.replace(/rowId_/, '');
  loadData(data_id);
});

function loadData(id) {
  var form_view = $('div.form_view');

  $('form.form_add').parent('div').addClass('hidden');
  add_mode = false;

  $.get(urlRoot + '/employees/' + id)
   .done(function(data) {
      // set image
      if (data.avatar == 'dft-employee.jpg') {
        $('i.img_pp').removeClass('hidden');
        $('img.img_pp').addClass('hidden');
        $('img.img_pp')[0].src = "";
      } else {
        $('i.img_pp').addClass('hidden');
        $('img.img_pp').removeClass('hidden');
        $('img.img_pp')[0].src = urlAsset + '/images/employees/' + data.avatar;
      }

      delete data.avatar;

      // set all properties according to name
      Object.keys(data).forEach(function(elm) {
        form_view.find('[name="' + elm + '_val"]').text(data[elm]);
      });

      form_view.removeClass('hidden');
   })
   .fail(function(jqXhr) {
     if (jqXhr.status == 404) {
      alert('Data not found');
      app_datatable.ajax.reload();
     } else {
      console.log(jqXhr);
      alert('Failed getting data');
     }
   })
}