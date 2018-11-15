var app_datatable;

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
